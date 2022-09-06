<?php

namespace App\Controller;

use App\Entity\Coordonnees;
use App\Entity\User;
use App\Form\RepresentativeType;
use App\Form\UpdateRepresentativeType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[IsGranted('ROLE_OWNER')]
class RepresentativeController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/mandataire/{page?1}/{nb?10}', name: 'mandataire')]
    public function index(UserRepository $userRepository, $page, $nb): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $nbMandataire = count($userRepository->findByRoleMandataire(null, null));
        $nbPage = ceil($nbMandataire / $nb);
        $mandataires = $userRepository->findByRoleMandataire($nb, ($page - 1) * $nb);
        return $this->render('owner/mandataire/index.html.twig', [
            'mandataire' => $mandataires,
            'total' => $nbMandataire,
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nb' => $nb,
        ]);
    }

    #[Route('/ajouter-mandataire', name: 'ajout_mandataire')]
    public function ajout(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = new User();
        $coordonnees = new Coordonnees();
        $coordonnees->setRepresentative($user);
        $faker = Factory::create('fr_FR');
        $form = $this->createForm(RepresentativeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($faker->password());

            $user->setRoles(['ROLE_REPRESENTATIVE']);

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('aleksandar.milenkovicfr@gmail.com', 'Gestion de locations'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')->context([
                        'username' => $user->getEmail(),
                        'password' => $user->getPassword(),
                    ])
            );

            $hash = $userPasswordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $coordonnees = $form->getData();

            $entityManager->persist($user);
            $entityManager->persist($coordonnees);
            $entityManager->flush();

            return $this->redirectToRoute('mandataire');
        }

        return $this->render('owner/mandataire/ajoutMandataire.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('login');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/modif-mandataire/{id}', name: 'show_mandataire')]
    public function showMandataire(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, int $id): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $bienMandataire = $userRepository->findByResidence($user);

        $form = $this->createForm(UpdateRepresentativeType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();

            $user = $form->getData();

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('mandataire', [
                'id' => $user->getId()]);
        }

        return $this->render('owner/mandataire/update-mandataire.html.twig', [
            'form' => $form->createView(),
            'bien' => $bienMandataire,
            'user' => $user,
        ]);
    }
}

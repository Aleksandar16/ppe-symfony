<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LocataireType;
use App\Entity\Informations;
use App\Form\ModifLocataireType;
use App\Repository\RentRepository;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Polyfill\Intl\Idn\Info;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[IsGranted('ROLE_OWNER')]
class TenantController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/locataires/{page?1}/{nb?10}', name: 'locataires')]
    public function index(RentRepository $rentRepository,UserRepository $userRepository, $page, $nb): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $nbLocataire = count($userRepository->findByRoleLocataire(null, null));
        $nbPage = ceil($nbLocataire / $nb);
        $locataires = $userRepository->findByRoleLocataire($nb, ($page - 1) * $nb);
        return $this->render('owner/locataires/index.html.twig', [
            'locataires' => $locataires,
            'total' => $nbLocataire,
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nb' => $nb,
        ]);

    }

    #[Route('/ajout-locataires', name: 'ajout_locataires')]
    public function ajoutLocataires(ValidatorInterface $validator, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $faker = Factory::create('fr_FR');

        $user = new User();
        $info = new Informations();
        $user->setPassword($faker->password());
        $user->setRoles(['ROLE_TENANT']);
        $info->setTenant($user);
        $form = $this->createForm(LocataireType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('aleksandar.milenkovicfr@gmail.com', 'Gestion de locations'))
                    ->to($user->getEmail())
                    ->subject('Veuillez confirmer votre adresse email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')->context([
                        'username' => $user->getEmail(),
                        'password' => $user->getPassword(),
                    ])
            );

            $hash = $userPasswordHasher->hashPassword($user, $user->getPassword());

            $user->setPassword($hash);

            $info = $form->getData();

            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            }

            $errors = $validator->validate($info);

            if (count($errors) > 0) {
                $errorsString = (string) $errors;
                return new Response($errorsString);
            }

            $entityManager->persist($user);
            $entityManager->persist($info);
            $entityManager->flush();

            $this->addFlash('success', 'Locataire ajouté avec succès');

            return $this->redirectToRoute('locataires');
        }

        return $this->render('owner/locataires/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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

    #[Route('/modif-locataires/{id}/{page?1}/{nb?5}', name: 'show_locataires')]
    public function upLocataire(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, RentRepository $rentRepository, int $id, $page, $nb): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $nbRent = count($userRepository->findRent($user, null, null));
        $nbPage = ceil($nbRent / $nb);
        $rentLocataire = $userRepository->findRent($user, $nb, ($page - 1) * $nb);

        $form = $this->createForm(ModifLocataireType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $doctrine->getManager();

            $user = $form->getData();

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute('locataires', [
                'id' => $user->getId()]);
        }

        return $this->render('owner/locataires/modif-locataires.html.twig', [
            'form' => $form->createView(),
            'rent' => $rentLocataire,
            'total' => $nbRent,
            'user' => $user,
            'isPaginated' => true,
            'nbPage' => $nbPage,
            'page' => $page,
            'nb' => $nb,
        ]);
    }

}

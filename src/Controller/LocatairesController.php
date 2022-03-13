<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Rent;
use App\Form\RegistrationFormType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Form\LocataireType;
use SymfonyCasts\Bundle\VerifyEmail;
use App\Security\EmailVerifier;
use App\Repository\UserRepository;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LocatairesController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    public function index(RentRepository $rentRepository,UserRepository $userRepository): Response
    {
        return $this->render('locataires/index.html.twig', [
            'locataires' => $userRepository->findByRoleLocataire(),
        ]);
    }

   

    public function ajoutLocataires(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //return $this->render('locataires/ajout.html.twig');
        $user = new User();
        $form = $this->createForm(LocataireType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_TENANT']);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('shakeel.jeerooburkhan995@gmail.com', 'BOT'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')->context([
                        'username' => $user->getEmail(),
                        'password' => $form->get('plainPassword')->getData(),
                    ])
            );

            return $this->redirectToRoute('locataires');
        }

        return $this->render('locataires/ajout.html.twig', [
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

    public function showLocataires(Request $request, ManagerRegistry $doctrine, UserRepository $userRepository, RentRepository $rentRepository, int $id): Response
    {
        $user = $userRepository->find($id);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $bienMandataire = $userRepository->findByResidence($user);

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

        return $this->render('locataires/modif-locataires.html.twig', [
            'form' => $form->createView(),
            'bien' => $bienMandataire,
            'user' => $user,
        ]);
    }
}

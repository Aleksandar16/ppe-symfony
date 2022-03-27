<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    public function index(): Response
    {

        return $this->render('location/index.html.twig', [
            'controller_name' => 'LocationController',
        ]);
    }

    public function ajoutLocation(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
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
}

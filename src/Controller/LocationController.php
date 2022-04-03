<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\LocationLocataireEndType;
use App\Form\LocationLocataireType;
use App\Form\LocationMandataireEndType;
use App\Form\LocationMandataireType;
use App\Form\RentLocataireType;
use App\Form\RentResidenceType;
use App\Repository\RentRepository;
use App\Repository\ResidenceRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class LocationController extends AbstractController
{
    private $security;

    #[Route('/ajout-location-residence/{id}', name: 'ajout_location_residence')]
    public function ajoutLocationResidence(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, ResidenceRepository $residenceRepository, int $id): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentResidenceType::class, $rent);
        $form->handleRequest($request);

        $bien = $residenceRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {

            $rent->setResidence($bien);

            $doc = $form->get('inventory_file')->getData();

            if ($doc) {
                $originalFilename = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $doc->guessExtension();

                try {
                    $doc->move(
                        $this->getParameter('bien_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $rent->SetInventoryFile($newFilename);
            }

            $entityManager = $doctrine->getManager();

            $rent = $form->getData();

            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('bien');
        }

        return $this->render('location/ajoutLocationResidence.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/ajout-location-locataire/{id}', name: 'ajout_location_locataire')]
    public function addLocationLocataires(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, UserRepository $userRepository, int $id): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentLocataireType::class, $rent);
        $form->handleRequest($request);

        $user = $userRepository->find($id);

        $rents = $userRepository->findRent($user);

        if ($form->isSubmitted() && $form->isValid()) {

            $rent->setTenant($user);

            $doc = $form->get('inventory_file')->getData();

            if ($doc) {
                $originalFilename = pathinfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $doc->guessExtension();

                try {
                    $doc->move(
                        $this->getParameter('bien_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $rent->SetInventoryFile($newFilename);
            }

            $entityManager = $doctrine->getManager();

            $rent = $form->getData();

            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('locataires');
        }

        return $this->render('location/ajoutLocationLocataire.html.twig', [
            'form' => $form->createView(),
            'rent' => $rents,
            'user' => $user,
        ]);
    }

    #[Route('/show-location/{id}', name: 'show_location')]
    public function showLocation(Security $security, Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, RentRepository $rentRepository, int $id): Response
    {
        $this->security = $security;

        $user = $this->security->getUser()->getRoles();
        
        if ($user[0] == "ROLE_TENANT") {
            $rent = $rentRepository->find($id);
            if ($rent->getTenantSignature() != null) {
                $form = $this->createForm(LocationLocataireEndType::class, $rent);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $entityManager = $doctrine->getManager();

                    $date = new \DateTime('@'.strtotime('now'));

                    $rent->setTenantValidatedAtEnd($date);

                    $rent = $form->getData();

                    $entityManager->persist($rent);

                    $entityManager->flush();

                    return $this->redirectToRoute('app_home');
                }

                return $this->render('location/showLocation.html.twig', [
                    'formTenantEnd' => $form->createView(),
                    'rent' => $rent,
                ]);
            }
            else
            $form = $this->createForm(LocationLocataireType::class, $rent);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $doctrine->getManager();

                $date = new \DateTime('@'.strtotime('now'));

                $rent->setTenantValidatedAt($date);

                $rent = $form->getData();

                $entityManager->persist($rent);

                $entityManager->flush();

                return $this->redirectToRoute('app_home');
            }

            return $this->render('location/showLocation.html.twig', [
                'formTenant' => $form->createView(),
                'rent' => $rent,
            ]);

        }
        elseif ($user[0] == "ROLE_REPRESENTATIVE") {
            $rent = $rentRepository->find($id);
            if ($rent->getRepresentativeSignature() != null) {
                $form = $this->createForm(LocationMandataireEndType::class, $rent);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $entityManager = $doctrine->getManager();

                    $date = new \DateTime('@'.strtotime('now'));

                    $rent->setRepresentativeValidatedAtEnd($date);

                    $rent = $form->getData();

                    $entityManager->persist($rent);

                    $entityManager->flush();

                    return $this->redirectToRoute('app_home');
                }

                return $this->render('location/showLocation.html.twig', [
                    'formTenantEnd' => $form->createView(),
                    'rent' => $rent,
                ]);
            }
            else {
                $form = $this->createForm(LocationMandataireType::class, $rent);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $entityManager = $doctrine->getManager();

                    $date = new \DateTime('@' . strtotime('now'));

                    $rent->setRepresentativeValidatedAt($date);

                    $rent = $form->getData();

                    $entityManager->persist($rent);

                    $entityManager->flush();

                    return $this->redirectToRoute('app_home');
                }

                return $this->render('location/showLocation.html.twig', [
                    'formRepresentative' => $form->createView(),
                    'rent' => $rent,
                ]);
            }
        }
        else
            $rent = $rentRepository->find($id);
            return $this->render('location/showLocation.html.twig', [
                'rent' => $rent,
            ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\RentLocataireType;
use App\Form\RentResidenceType;
use App\Repository\ResidenceRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class LocationController extends AbstractController
{

    #[Route('/ajout-location/{id}', name: 'ajout_location_locataire')]
    public function ajoutLocationLocataire(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, UserRepository $userRepository, int $id): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentLocataireType::class, $rent);
        $form->handleRequest($request);

        $user = $userRepository->find($id);

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
        ]);
    }

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
}

<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Entity\Residence;
use App\Form\BienType;
use App\Repository\RentRepository;
use App\Repository\ResidenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class BienController extends AbstractController
{
    #[Route('/bien', name: 'bien')]
    public function index(ResidenceRepository $residenceRepository): Response
    {
        return $this->render('bien/index.html.twig', [
            'bien' => $residenceRepository->findAll(),
        ]);
    }

    #[Route('/create-bien', name: 'create_bien')]
    public function create(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $bien = new Residence();

        $form = $this->createForm(BienType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

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

                $bien->SetInventoryFile($newFilename);
            }

            $screen = $form->get('photo')->getData();

            if ($screen) {
                $originalFilename = pathinfo($screen->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newScreen = $safeFilename.'-'.uniqid().'.'.$screen->guessExtension();

                try {
                    $screen->move(
                        $this->getParameter('bien_directory'),
                        $newScreen
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $bien->setPhoto($newScreen);
            }

            $entityManager = $doctrine->getManager();

            $bien = $form->getData();

            $entityManager->persist($bien);

            $entityManager->flush();

            return $this->redirectToRoute('bien');
        }

        return $this->render('bien/create-bien.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update-bien/{id}', name: 'update_bien')]
    public function update(RentRepository $rentRepository, ResidenceRepository $residenceRepository, Request $request, ManagerRegistry $doctrine, int $id, SluggerInterface $slugger): Response
    {
        $bien = $residenceRepository->find($id);

        if (null === $bien) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $rentResidence = $residenceRepository->findByResidence($bien);

        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('inventory_file')->getData();

            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                try {
                    $brochureFile->move(
                        $this->getParameter('bien_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $bien->setInventoryFile($newFilename);

            }

            $screen = $form->get('photo')->getData();

            if ($screen) {
                $originalFilename = pathinfo($screen->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newScreen = $safeFilename.'-'.uniqid().'.'.$screen->guessExtension();

                try {
                    $screen->move(
                        $this->getParameter('bien_directory'),
                        $newScreen
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $bien->setPhoto($newScreen);
            }

            $entityManager = $doctrine->getManager();

            $bien = $form->getData();

            $entityManager->persist($bien);

            $entityManager->flush();

            return $this->redirectToRoute('bien', [
                'id' => $bien->getId()]);
        }

        return $this->render('bien/update-bien.html.twig', [
            'form' => $form->createView(),
            'rent' => $rentResidence,
            'bien' => $bien,
        ]);
    }
}

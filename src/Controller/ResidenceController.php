<?php

namespace App\Controller;

use App\Entity\Residence;
use App\Form\ResidenceType;
use App\Repository\RentRepository;
use App\Repository\ResidenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ResidenceController extends AbstractController
{
    private $security;

    #[Route('bien/{page?1}/{nb?10}', name: 'bien')]
    public function index(ResidenceRepository $residenceRepository, Security $security, $page, $nb): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->security = $security;

        $user = $this->security->getUser()->getRoles();

        if ($user[0] == "ROLE_OWNER") {
            $nbResidence = count($residenceRepository->findAll());
            $nbPage = ceil($nbResidence / $nb);
            $bien = $residenceRepository->findBy([], [], $nb, ($page - 1) * $nb);
            return $this->render('owner/bien/index.html.twig', [
                'bien' => $bien,
                'total' => $nbResidence,
                'isPaginated' => true,
                'nbPage' => $nbPage,
                'page' => $page,
                'nb' => $nb,
            ]);
        }
        elseif ($user[0] == "ROLE_REPRESENTATIVE") {
            $id = $this->security->getUser()->getUserId();
            $nbResidence = count($residenceRepository->findBy(['representative' => $id]));
            $nbPage = ceil($nbResidence / $nb);
            $bien = $residenceRepository->findBy(['representative' => $id], ['id' => 'ASC'], $nb, ($page - 1) * $nb);
            return $this->render('representative/bien/index.html.twig', [
                'bien' => $bien,
                'total' => $nbResidence,
                'isPaginated' => true,
                'nbPage' => $nbPage,
                'page' => $page,
                'nb' => $nb,
            ]);
        }

        else
            return  $this->render('base.html.twig');
    }

    #[IsGranted('ROLE_OWNER')]
    #[Route('/create-bien', name: 'create_bien')]
    public function create(ValidatorInterface $validator, Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $bien = new Residence();

        $form = $this->createForm(ResidenceType::class, $bien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $doc = $form->get('inventoryFile')->getData();

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

        return $this->render('owner/bien/create-bien.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/update-bien/{id}', name: 'update_bien')]
    public function update(RentRepository $rentRepository, ResidenceRepository $residenceRepository, Request $request, ManagerRegistry $doctrine, int $id, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $bien = $residenceRepository->find($id);

        if (null === $bien) {
            throw new NotFoundHttpException(sprintf('The techno with id %s was not found.', $id));
        }

        $rentResidence = $residenceRepository->findByResidence($bien);

        $form = $this->createForm(ResidenceType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $brochureFile = $form->get('inventoryFile')->getData();

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

        return $this->render('owner/bien/update-bien.html.twig', [
            'form' => $form->createView(),
            'rent' => $rentResidence,
            'bien' => $bien,
        ]);
    }

    #[IsGranted('ROLE_OWNER')]
    #[Route('/ajout-location/{id}', name: 'ajout_locationbien')]
    public function ajoutLocation(ResidenceRepository $residenceRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $bien = $residenceRepository->findAll();

        return $this->render('owner/bien/index.html.twig', [
            'bien' => $bien,
        ]);
    }
}

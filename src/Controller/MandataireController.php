<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MandataireController extends AbstractController
{
    #[Route('/mandataire', name: 'mandataire')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('mandataire/index.html.twig', [
            'mandataire' => $userRepository->findByRoleMandataire(),
        ]);
    }

    #[Route('/ajouter-mandataire', name: 'ajout_mandataire')]
    public function ajout(): Response
    {
        return $this->render('mandataire/ajoutMandataire.html.twig');
    }

    #[Route('/modif-mandataire/{id}', name: 'show_mandataire')]
    public function showMandataire(UserRepository $userRepository, int $id): Response
    {
        $mandataire = $userRepository->find($id);

        if (null === $mandataire) {
            throw new NotFoundHttpException(sprintf("Mandataire innexistant", $id));
        }

        return $this->render('mandataire/mandataire.html.twig', ['mandataire' => $mandataire]);
    }
}

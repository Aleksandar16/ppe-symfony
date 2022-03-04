<?php

namespace App\Controller;

// use App\Entity\User;
// use App\Entity\Rent;
use App\Repository\UserRepository;
use App\Repository\RentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LocatairesController extends AbstractController
{
    public function index(RentRepository $rentRepository,UserRepository $userRepository): Response
    {
        return $this->render('locataires/index.html.twig', [
            'locataires' => $userRepository->findByRoleLocataire(),
        ]);
    }
}

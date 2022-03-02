<?php

namespace App\Controller;

// use App\Entity\User;
// use App\Entity\Rent;
// use App\Repository\RentRepository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LocatairesController extends AbstractController
{
    public function index(RentRepository $rentRepository): Response
    {
        return $this->render('locataires/index.html.twig', [
            'locataires' => $userRepository->findBy(array(), array('id' => 'DESC') ,array('roles' => 'ROLE_TENANT')),
        ]);
    }
}

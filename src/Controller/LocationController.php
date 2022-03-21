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
}

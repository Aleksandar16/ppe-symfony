<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocatairesController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('locataires/index.html.twig');
    }

    // public function show()
    // {
    //     $queryBuilder = $this->createQueryBuilder('article');
    //     $queryBuilder
    //         ->where('article.author = :author')
    //         ->orderBy('article.date', 'DESC')
    //         ->setMaxResults($limit)
    //         ->setParameter('author', $author)
    //     ;

    //     return $queryBuilder->getQuery()->execute();
    // }
}

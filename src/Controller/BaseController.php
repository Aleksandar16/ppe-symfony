<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Entity\Residence;
use App\Entity\User;
use App\Repository\RentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BaseController extends AbstractController
{
    private $security;

    #[Route('/', name: 'app_home')]
    public function index(RentRepository $rentRepository, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->security = $security;

        $user = $this->security->getUser()->getRoles();

        if ($user[0] == "ROLE_TENANT") {
            $id = $this->security->getUser()->getUserId();
            $rent = $rentRepository->findRentTenant($id);
            return $this->render('base.html.twig', [
                'rent' => $rent,
            ]);
        }

        else
            return $this->render('base.html.twig');
    }

    #[Route('/profil', name: 'profil')]
    public function profil(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('profil.html.twig');
    }

    #[Route('/delete-user', name: 'delete_user')]
    public function deleteUser(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($this->getUser());
        $entityManager->flush();
        return $this->render('login/index.html.twig');
    }
}

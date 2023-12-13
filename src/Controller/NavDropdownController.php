<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavDropdownController extends AbstractController
{
    #[Route('/nav/dropdown', name: 'app_nav_dropdown')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([], ['nom' => 'ASC']); //get all categories

        return $this->render('nav_dropdown/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}

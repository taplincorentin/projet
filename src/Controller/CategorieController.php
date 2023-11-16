<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findBy([], ['nom' => 'ASC']); //get all categories
        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie = null): Response {
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){ //check that categorie isn't walk or session category (aren't accessible this way)
            return $this->render('categorie/show.html.twig', [
                'categorie' => $categorie
            ]);
        }
        else {
            return $this->redirectToRoute('app_categorie');
        }
    }

}

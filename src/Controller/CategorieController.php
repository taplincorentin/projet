<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository, TopicRepository $topicRepository, PostRepository $postRepository): Response
    {
        $categories = $categorieRepository->findBy([], ['nom' => 'ASC']); //get all categories

        $latestTopics = $topicRepository->getLatestTopics();

        $nbPostsParTopic = [];
        foreach ($latestTopics as $topic) {
            $nbPosts = $postRepository->nbPostsDansTopic($topic);
            $nbPostsParTopic[$topic->getId()] = $nbPosts;
        }
        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'latestTopics' => $latestTopics,
            'nbPostsParTopic' => $nbPostsParTopic,
        ]);
    }


    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie = null): Response {

        //check that categorie isn't walk or session category (aren't accessible this way)
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){ 


            return $this->render('categorie/show.html.twig', [
                'categorie' => $categorie
            ]);
        }
        
        return $this->redirectToRoute('app_categorie');
    }

}

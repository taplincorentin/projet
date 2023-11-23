<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Categorie;
use App\Form\TopicFormType;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(Categorie $categorie = null, Topic $topic = null, Request $request, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository, PostRepository $postRepository): Response {

        //check that categorie isn't walk or session category (aren't accessible this way)
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){
            
            //get all categories for menu 
            $categories = $categorieRepository->findBy([], ['nom' => 'ASC']); 

            //part that gets post number in a topic
            $categoryTopics = $categorie->getTopics();

            $nbPostsParTopic = [];
            foreach ($categoryTopics as $topic) {
                $nbPosts = $postRepository->nbPostsDansTopic($topic);
                $nbPostsParTopic[$topic->getId()] = $nbPosts;
            }


            //part that handles the new topic form
            $topic = new Topic();
            
            $form = $this->createForm(TopicFormType::class, $topic);

            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid
    
                //get form data (titre)
                $topic = $form->getData();              
                
                //set topic category
                $topic->setCategorie($categorie);       
    
                //get current datetime to set 'lastModified'
                $now = new \DateTime();
                $topic->setDateCreation($now);
    
                //set current user as topic creator
                $auteur = $this->getUser();
                $topic->setAuteur($auteur);
    
                $entityManager->persist($topic); //prepare
                $entityManager->flush(); //execute
    
                //redirect to created topic
                return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]);
    
            }


            return $this->render('categorie/show.html.twig', [
                'categorie' => $categorie,
                'formAddTopic' => $form,
                'nbPostsParTopic' => $nbPostsParTopic,
                'categories' => $categories,
            ]);
        }
        
        return $this->redirectToRoute('app_categorie');
    }

}

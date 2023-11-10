<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }


    #[Route('/topic/new', name: 'new_topic')]
    #[Route('/topic/{id}/edit', name: 'edit_topic')]
    public function new(Topic $topic = null, Request $request, EntityManagerInterface $entityManager): Response {

        if(!$topic) { //condition if no stagiaire create new one otherwise it's an edit of the existing one
            $topic = new Topic();
        }

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid
            $topic = $form->getData();
            $entityManager->persist($topic); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('app_topic'); //redirect to topicList

        }

        return $this->render('topic/new.html.twig', [
            'formAddTopic' => $form,
        ]);

    }


    #[Route('/topic/{id}/delete', name: 'delete_topic')]

    public function delete(Topic $topic, EntityManagerInterface $entityManager) {

        $categorie=$topic->getCategorie();      //récupération de la catégorie pour la redirection
        
        $entityManager->remove($topic);
        $entityManager->flush();

        return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]);; //redirection page categorie du topic supprimé
    }



    #[Route('/topic/{id}', name: 'show_topic')]
    public function show(Topic $topic = null): Response {
        if($topic){
            return $this->render('topic/show.html.twig', [
                'topic' => $topic
            ]);
        }
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

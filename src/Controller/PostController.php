<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    // #[Route('/post', name: 'app_post')]
    // public function index(): Response
    // {
    //     return $this->render('post/index.html.twig', [
    //         'controller_name' => 'PostController',
    //     ]);
    // }

    #[Route('/{topic_id}/post/new', name: 'new_post')]
    #[Route('/{topic_id}/post/{id}/edit', name: 'edit_post')]
    public function new_edit(Post $post = null, int $topic_id, Request $request, EntityManagerInterface $entityManager): Response {

        if(!$post) { //condition if no post create new one otherwise it's an edit of the existing one
            $post = new Post();
        }
        $topic = $entityManager->getRepository(Topic::class)->findOneBy(['id'=>$topic_id]);

        
        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid

            $post = $form->getData();              //get form data (contenu)
            $post->setTopic($topic);                //add topic to data

            //ajout de la date et heure de la modification du post
            $now = new \DateTime();
            $post->setDateCreation($now);

            $auteur = $this->getUser();
            $post->setAuteur($auteur);

            $entityManager->persist($post); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);; //redirection topic du post créé/édité

        }

        return $this->render('post/new.html.twig', [
            'formAddPost' => $form,
        ]);

    }


    #[Route('/post/{id}/delete', name: 'delete_post')]

    public function delete(Post $post, EntityManagerInterface $entityManager) {

        $topic=$post->getTopic();      //récupération du topic pour la redirection
        
        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);; //redirection page topic du post supprimé
    }

}

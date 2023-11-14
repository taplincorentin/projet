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

            //get form data (contenu)
            $post = $form->getData();
            
            //set post topic
            $post->setTopic($topic);                

            //get current datetime to set 'lastModified'
            $now = new \DateTime();
            $post->setDateCreation($now);

            //set current user as post creator
            $auteur = $this->getUser();
            $post->setAuteur($auteur);
            
            //prepare execute
            $entityManager->persist($post);
            $entityManager->flush();

            //redirect to created post's topic
            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);; //redirection topic du post créé/édité

        }

        return $this->render('post/new.html.twig', [
            'formAddPost' => $form,
        ]);

    }


    #[Route('/post/{id}/delete', name: 'delete_post')]

    public function delete(Post $post, EntityManagerInterface $entityManager) {

        //get current user and post creator
        $user = $this->getUser();
        $personne = $post->getAuteur();

        //check that the current user is the post's creator or an admin
        if ($personne == $user || $verficationRole->verificationAdmin() ){
            //get topic for redirection
            $topic=$post->getTopic();
        
            //prepare execute
            $entityManager->remove($post);
            $entityManager->flush();

            //redirect to post's topic
            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
        }
        
        return $this->redirectToRoute('app_home');
    }

}

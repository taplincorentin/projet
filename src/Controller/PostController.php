<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostFormType;
use App\Form\EditPostFormType;
use App\Service\VerificationRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/{topic_id}/post/{id}/edit', name: 'edit_post')]
    public function edit(Post $post = null, int $topic_id, Request $request, EntityManagerInterface $entityManager): Response {
        
        //get post author and current user
        $auteur = $post->getAuteur();
        $user = $this->getUser();

        //check that post author and current user are the same person
        if($auteur == $user ){

            $topic = $entityManager->getRepository(Topic::class)->findOneBy(['id'=>$topic_id]);
        
            $form = $this->createForm(EditPostFormType::class, $post);

            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid

                //get form data (contenu)
                $post = $form->getData();               

                //get current datetime to set 'lastModified'
                $now = new \DateTime();
                $post->setLastModified($now);
                
                //prepare execute
                $entityManager->persist($post);
                $entityManager->flush();

                $this->addFlash('success', "Post had been edited !");

                //redirect to edited post's topic
                return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);

            }

            return $this->render('post/edit.html.twig', [
                'formAddPost' => $form,
            ]);

        }
        
        return $this->redirectToRoute('app_home');
    }


    #[Route('/post/{id}/delete', name: 'delete_post')]

    public function delete(Post $post, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) {

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

            $this->addFlash('success', "Post has been deleted !");

            //redirect to post's topic
            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
        }
        
        return $this->redirectToRoute('app_home');
    }

}

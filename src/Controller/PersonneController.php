<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{
    // #[Route('/personne', name: 'app_personne')]
    // public function index(): Response
    // {
    //     return $this->render('personne/index.html.twig', [
    //         'controller_name' => 'PersonneController',
    //     ]);
    // }
    

    #[Route('/personne/{id}/edit', name: 'edit_personne')]
    public function edit(Personne $personne = null, Request $request, EntityManagerInterface $entityManager): Response {
        
        $form = $this->createForm(PersonneFormType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $personne = $form->getData();

            $entityManager->persist($personne); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]); //redirection profil de l'utilisateur

        }
        return $this->render('personne/edit.html.twig', [
            'formAddPersonne' => $form,
        ]);

    }

    #[Route('/personne/{id}/delete', name: 'delete_personne')]
    public function delete(personne $personne, EntityManagerInterface $entityManager) {

        //récupération des topics et posts de l'utilisateur
        $posts = $personne->getPosts();
        $topics = $personne->getTopics();


        // Pour chaque post/topic l'auteur = null
        foreach ($posts as $post) {
            $post->setAuteur(null);
            $entityManager->persist($post);
        }

        foreach ($topics as $topic) {
            $topic->setAuteur(null);
            $entityManager->persist($topic);
        }

        $entityManager->remove($personne);
        $entityManager->flush();

        $session = new Session;
        $session->invalidate();

        return $this->redirectToRoute('app_logout');
    }

    #[Route('/personne/{id}', name: 'show_personne')]
    public function show(Personne $personne = null): Response {
        if($personne){
            return $this->render('personne/show.html.twig', [
                'personne' => $personne
            ]);
        }
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

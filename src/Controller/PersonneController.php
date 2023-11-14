<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneFormType;
use App\Service\VerificationRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
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
        
        $user = $this->getUser();

        //check that the person who's info is getting edited is the current user
        if($user == $personne){
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

        return $this->redirectToRoute('app_home');

    }

    #[Route('/personne/{id}/delete', name: 'delete_personne')]
    public function delete(Personne $personne, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) {

       //get current user
        $user = $this->getUser();                                                                       

        //check that the current user is the person that is getting deleted or an admin
        if ($personne == $user || $verficationRole->verificationAdmin() ){
            
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

            //prepare execute
            $entityManager->remove($personne);
            $entityManager->flush();


            //si la personne était un admin redirection à l'acceuil
            if ($verficationRole->verificationAdmin() ){
                return $this->redirectToRoute('app_home');
            }

            //sinon suppression de la session en cours et redirection 'logout'
            else {
            
                $session = new Session;
                $session->invalidate();

                return $this->redirectToRoute('app_logout');
            }

        }

        return $this->redirectToRoute('app_home');
    }

    //Assign the ROLE_SUPER_ADMIN role
    #[Route(path: 'personne/{id}/sadmin', name: 'make_super_admin')]
    public function makeSuperAdmin(Personne $personne, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) :Response {
        
        //get current user
        $user = $this->getUser();                                                                       

        //check that the current user is a super admin
        if ($verficationRole->verificationSuperAdmin() ){
            $personne->setRoles(['ROLE_SUPER_ADMIN']); 
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]); //redirection profil de la personne dont le rôle a été modifié
        }
        
        return $this->redirectToRoute('app_home');
    }

    //Assign the ROLE_ADMIN role
    #[Route(path: 'personne/{id}/admin', name: 'make_admin')]
    public function makeAdmin(Personne $personne, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) :Response {
        
        //get current user
        $user = $this->getUser();                                                                       

        //check that the current user is a super admin
        if ($verficationRole->verificationSuperAdmin() ){
            $personne->setRoles(['ROLE_ADMIN']); 
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]); //redirection profil de la personne dont le rôle a été modifié
        }

        return $this->redirectToRoute('app_home');
 
    }

    //Assign the ROLE_USER role
    #[Route(path: 'personne/{id}/user', name: 'make_user')]
    public function makeUser(Personne $personne, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) :Response {
        
        //get current user
        $user = $this->getUser();                                                                       

        //check that the current user is a super admin
        if ($verficationRole->verificationSuperAdmin() ){
            $personne->setRoles(['ROLE_USER']); 
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]); //redirection profil de la personne dont le rôle a été modifié
        }

        return $this->redirectToRoute('app_home');
 
    }


    #[Route('/personne/{id}', name: 'show_personne')]
    public function show(Personne $personne = null): Response {
        
        //check if person exists
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

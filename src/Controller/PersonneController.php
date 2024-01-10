<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneFormType;
use App\Repository\TopicRepository;
use App\Repository\PersonneRepository;
use App\Service\VerificationRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonneController extends AbstractController
{

    #[Route('/personne/{id}/edit', name: 'edit_personne')]
    public function edit(Personne $personne = null, Request $request, EntityManagerInterface $entityManager): Response {
        
        $user = $this->getUser();

        //check that the person who's info is getting edited is the current user
        if($user == $personne){
            $form = $this->createForm(PersonneFormType::class, $personne);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                //dd($form->get('imageProfil')->getData());
                $personne = $form->getData();


                //Take care of profile picture
                $fichierImageProfil = $form->get('imageProfil')->getData();
                // dd($personne);
                //If a new profile picture file was added to form
                if ($fichierImageProfil) {
                    
                    //Delete old profile picture if it exists
                    //get old profile picture name
                    $ancienneImageProfil = $user->getNomImageProfil();
                    if ($ancienneImageProfil) {
                        unlink($this->getParameter('profile_picture_directory') . '/' .$ancienneImageProfil);

                    }
                        
                    //create unique picture name
                    $nouveauNomFichier = 'profile_picture_' . uniqid() . '.' . $fichierImageProfil->guessExtension();



                    // Move the uploaded file to directory (see parameters services.yaml)
                    $fichierImageProfil->move(
                        $this->getParameter('profile_picture_directory'), $nouveauNomFichier);
                    
                    
                    
                    //set picture name to current user (current user == $personne)
                    $personne->setNomImageProfil($nouveauNomFichier);
                }

                $entityManager->persist($personne); //prepare
                $entityManager->flush(); //execute

                $this->addFlash('success', "User information updated !");

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

            $this->addFlash('success', "Account deleted !");

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

            $this->addFlash('success', "User role changed to 'super admin' !");

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

            $this->addFlash('success', "User role changed to 'admin' !");

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

            $this->addFlash('success', "User role changed to 'user' !");

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]); //redirection profil de la personne dont le rôle a été modifié
        }

        return $this->redirectToRoute('app_home');
 
    }


    #[Route('/personne/{id}', name: 'show_personne')]
    public function show(Personne $personne = null, TopicRepository $topicRepository): Response {
        
        //check if person exists
        if($personne){

            //get user 3 latest topics
            $latestTopics = $topicRepository->getUserLatestTopics($personne);

            //return person + 3 latest topics data to view
            return $this->render('personne/show.html.twig', [
                'personne' => $personne,
                'latestTopics' => $latestTopics
            ]);
        }
        //if not redirect to HomePage
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

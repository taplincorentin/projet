<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Categorie;
use App\Form\TopicFormType;
use App\Service\VerificationRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/{categorie_id}/topic/new', name: 'new_topic')]
    public function new(Topic $topic = null, int $categorie_id, Request $request, EntityManagerInterface $entityManager): Response {

        $topic = new Topic();

        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['id'=>$categorie_id]);

        //security check that the categorie isn't the walk or session categorie (can't create a topic in it this way only by creating a walk/session)
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){
            
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
                return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
    
            }
            
            return $this->render('topic/new.html.twig', [
                'formAddTopic' => $form,
            ]);
        
        }

        return $this->redirectToRoute('app_home'); 
    }


    #[Route('/{categorie_id}/topic/{id}/edit', name: 'edit_topic')]
    public function edit(Topic $topic = null, int $categorie_id, Request $request, EntityManagerInterface $entityManager): Response {

        //get topic author and current user
        $auteur = $topic->getAuteur();
        $user = $this->getUser();

        //check that topic author and current user are the same person
        if($auteur == $user ){

            $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['id'=>$categorie_id]);
        
            $form = $this->createForm(TopicFormType::class, $topic);

            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid

                //get form data (titre)
                $topic = $form->getData();                     

                //get current datetime to set 'lastModified'
                $now = new \DateTime();
                $topic->setDateCreation($now);

                $entityManager->persist($topic); //prepare
                $entityManager->flush(); //execute

                //redirect to edited topic
                return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);

            }

            return $this->render('topic/new.html.twig', [
                'formAddTopic' => $form,
            ]);
        }

        return $this->redirectToRoute('app_home');
    }


    #[Route('/topic/{id}/delete', name: 'delete_topic')]

    public function delete(Topic $topic, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) {
        
        //get current user and topic creator
        $user = $this->getUser();
        $personne = $topic->getAuteur();
        //get category for redirection an check
        $categorie=$topic->getCategorie(); 
        
        //security check that the categorie isn't the walk or session categorie (can't cdelete a topic in it this way only by deleting a walk/session)
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){
            
            
            //check that the current user is the topic's creator or an admin
            if ($personne == $user || $verficationRole->verificationAdmin() ){
            
                //prepare execute
                $entityManager->remove($topic);
                $entityManager->flush();

                //redirect to topic's category
                return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]); 
            }
            
        }
        //redirect to home if misses a test
        return $this->redirectToRoute('app_home');
    }



    #[Route('/topic/{id}', name: 'show_topic')]
    public function show(Topic $topic = null): Response {

        //check topic exists
        if($topic){

            //get current user for check
            $user = $this->getUser();

            //if it's a walk's topic
            if(!empty($topic->getBalade())){
                
                //check user is walk organiser
                if ($user == $topic->getSeance()->getOrganisateur()){
                    
                    //return topic view if it's the case
                    return $this->render('topic/show.html.twig', [
                    'topic' => $topic
                    ]);
                }

                //get walk participants
                $participants = $topic->getBalade()->getPersonnes();
                //check that the user is a participant
                foreach ($participants as $participant) {
                    if ($user == $participant){
                        
                        //return topic view if it's the case
                        return $this->render('topic/show.html.twig', [
                            'topic' => $topic
                        ]);
                    }
                }

                //if not organiser or participant redirect to home
                return $this->redirectToRoute('app_home');

            }

            //else if it's a session's topic
            elseif (!empty($topic->getSeance())){
                
                
                //check user is session organiser
                if ($user == $topic->getSeance()->getOrganisateur()){
                    
                    //return topic view if it's the case
                    return $this->render('topic/show.html.twig', [
                        'topic' => $topic
                    ]);
                }
                
                //get session participants
                $participants = $topic->getSeance()->getParticipants();
                //check that the user is a participant
                foreach ($participants as $participant) {
                    if ($user == $participant){
                        
                        //return topic view if it's the case
                        return $this->render('topic/show.html.twig', [
                            'topic' => $topic
                        ]);
                    }
                    
                }

                //if not organiser or participant redirect to home
                return $this->redirectToRoute('app_home');
            }

            //if topic exist and isn't a session or walk associated topic go to topic view
            else{

                return $this->render('topic/show.html.twig', [
                    'topic' => $topic
                ]);
            }
     
        }

        //if topic doesn't exist back to homepage
        return $this->redirectToRoute('app_home');
    }


}
<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Personne;
use App\Form\SeanceFormType;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeanceController extends AbstractController
{
    //get session list
    #[Route('/seance', name: 'app_seance')]
    public function index(SeanceRepository $seanceRepository, EntityManagerInterface $entityManager): Response
    {
        //get all sessions sorted by startDateTime
        $seances = $seanceRepository->findBy([], ["dateHeureDepart" => "ASC"]); 
        

        //Before returning session list get list of future sessions
        $seancesFutures = $entityManager->getRepository(Seance::class)->getSeancesFutures();      

        return $this->render('seance/index.html.twig', [
            'seances' => $seances,
            'seancesFutures' => $seancesFutures
        ]);
    }

    #[Route('/seance/new', name: 'new_seance')]
    #[Route('/seance/{id}/edit', name: 'edit_seance')]
    public function new_edit(Seance $seance = null, Request $request, EntityManagerInterface $entityManager): Response {
        

        $personne = $this->getUser();                       //get user that is ctrying to create session
        
        if($personne->isIsEducateur()){                     //check that user is a dog trainer 
            
            if(!$seance) {                                  //condition if no seance create new one otherwise it's an edit of the existing one
                $seance = new Seance();
            }
    
            $form = $this->createForm(SeanceFormType::class, $seance);
    
    
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $seance = $form->getData();                 //get submitted data
    
                
                $seance->setOrganisateur($personne);        //add user as seance organiser
    
                $entityManager->persist($seance);           //prepare
                $entityManager->flush();                    //execute
    
                return $this->redirectToRoute('show_seance', ['id' => $seance->getId()]);; //redirection page d'info de la seance
    
            }

            return $this->render('seance/new.html.twig', [
                'formAddSeance' => $form,
            ]);
        }

        else {
            return $this->redirectToRoute('app_home');
        }

    }


    #[Route('/seance/{id}/delete', name: 'delete_seance')]

    public function delete(seance $seance, EntityManagerInterface $entityManager) {
        
        $entityManager->remove($seance);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');      //redirection page d'accueil
    }

    //remove person from session
    #[Route('/seance/{seance_id}/{personne_id}/remove', name: 'remove_personne_seance')]
    public function removePersonneFromSeance(Seance $seance_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $seance = $entityManager->getRepository(Seance::class)->findOneBy(['id'=>$seance_id]);          //get seance
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);    //get person that is going to be removed
        $user = $this->getUser();                                                                       //get current user
        $organisateur = $seance->getOrganisateur();                                                     //get session creator

         //check that the user and the removed person are the same or that user is the session organiser
        if ($personne == $user || $user == $organisateur){                                                                       
            
            $seance->removeParticipant($personne);
            
            $entityManager->persist($seance);
            $entityManager->flush();
            

            return $this->redirectToRoute('show_seance', ['id' => $seance->getId()]);
        }                                                                        
        
    }

    //enlist to session
    #[Route('/seance/{seance_id}/{personne_id}/move', name: 'enlist_personne_seance')]
    public function movePersonneToseance(Seance $seance_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $seance = $entityManager->getRepository(Seance::class)->findOneBy(['id'=>$seance_id]);          //get seance
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);    //get person that is enlisting
        $user = $this->getUser();                                                                       //get current user
        $organisateur = $seance->getOrganisateur();                                                     //get seance organiser

        if( $personne == $user && $personne != $organisateur ) {                                        //check current user and person that is getting enlisted for walk are the same and that the person isn't the walk's organiser                                                            
            
            $seance->addParticipant($personne);

            $entityManager->persist($seance);
            $entityManager->flush();

            return $this->redirectToRoute('show_seance', ['id' => $seance->getId()]);
        }

        else {
            return $this->redirectToRoute('app_home');
        }
        
    }


    #[Route('/seance/{id}', name: 'show_seance')]
    public function show(seance $seance = null): Response {
        if($seance){
            return $this->render('seance/show.html.twig', [
                'seance' => $seance
            ]);
        }
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

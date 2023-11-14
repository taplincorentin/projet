<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Entity\ChienRace;
use App\Form\ChienFormType;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChienController extends AbstractController
{
    // #[Route('/chien', name: 'app_chien')]
    // public function index(): Response
    // {
    //     return $this->render('chien/index.html.twig', [
    //         'controller_name' => 'ChienController',
    //     ]);
    // }

    #[Route('/chien/new', name: 'new_chien')]
    #[Route('/chien/{id}/edit', name: 'edit_chien')]
    public function new_edit(Chien $chien = null, Request $request, EntityManagerInterface $entityManager, CallApiService $callApiService): Response {
        
        if(!$chien) { //condition if no chien create new one otherwise it's an edit of the existing one
            $chien = new Chien();
        }

        //create dog form with breedList from API to build select input
        $form = $this->createForm(ChienFormType::class, $chien, ['breedList' => $callApiService->getBreedList()]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //get form data
            $chien = $form->getData();

            //get current datetime to set 'lastModified'
            $now = new \DateTime();
            $chien->setDateActualisation($now);

            //set current user as dog owner
            $personne = $this->getUser();
            $chien->setPersonne($personne);

            $entityManager->persist($chien); //prepare
            $entityManager->flush(); //execute



            $races = $form->get('races')->getData(); //get races form data
            
            foreach($races as $race) {
                $chienRace = new ChienRace();       //new Chien/Race

                //link race to dog
                $chienRace->setNomRace($race);
                $chienRace->setChien($chien);

                //prepare execute
                $entityManager->persist($chienRace); 
                $entityManager->flush();
            }

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);; //redirection profil de l'utilisateur

        }

        return $this->render('chien/new.html.twig', [
            'formAddChien' => $form,
        ]);

    }

    #[Route('/chien/{id}/delete', name: 'delete_chien')]
    public function delete(Chien $chien, EntityManagerInterface $entityManager) {

        //get current user
        $user = $this->getUser();                                                                       
        //get dog owner for condition and redirection
        $personne = $chien->getPersonne();

        //check that the current user is the dog's owner
        if ($personne == $user){
            
            //prepare execute
            $entityManager->remove($chien);
            $entityManager->flush();

            //redirect to user profile
            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);; 
        }

        return $this->redirectToRoute('app_home');
        
        
        
    }
}

<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Form\ChienFormType;
use App\Service\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChienController extends AbstractController
{
    
    //create new dog
    #[Route('/chien/new', name: 'new_chien')]
    public function new(Chien $chien = null, Request $request, EntityManagerInterface $entityManager, CallApiService $callApiService): Response {
        
        $chien = new Chien();

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

            //prepare execute
            $entityManager->persist($chien); 
            $entityManager->flush();

            $this->addFlash('success', "New dog has been added !");

            //redirection profil de l'utilisateur
            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);

        }

        return $this->render('chien/new.html.twig', [
            'formAddChien' => $form,
        ]);

    }


    //edit dog info
    #[Route('/chien/{id}/edit', name: 'edit_chien')]
    public function edit(Chien $chien = null, Request $request, EntityManagerInterface $entityManager, CallApiService $callApiService): Response {

        $personne = $this->getUser();
        $proprietaire = $chien->getPersonne();

        //check current user is the dog's owner
        if($personne == $proprietaire){
            //create dog form with breedList from API to build select input
            $form = $this->createForm(ChienFormType::class, $chien, ['breedList' => $callApiService->getBreedList()]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
            
                //get form data
                $chien = $form->getData();

                //get current datetime to set 'lastModified'
                $now = new \DateTime();
                $chien->setDateActualisation($now);

                //prepare execute
                $entityManager->persist($chien); 
                $entityManager->flush();

                $this->addFlash('success', "Dog information updated !");

                //redirection profil de l'utilisateur
                return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);

            }

            return $this->render('chien/new.html.twig', [
                'formAddChien' => $form,
            ]);

            }

            return $this->redirectToRoute('app_home');        

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

            $this->addFlash('success', "Dog has been deleted !");

            //redirect to user profile
            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);; 
        }

        return $this->redirectToRoute('app_home');
        
    }
}

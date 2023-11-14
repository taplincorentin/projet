<?php

namespace App\Controller;

use App\Entity\Balade;
use App\Entity\Personne;
use App\Form\BaladeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaladeController extends AbstractController
{
    #[Route('/balade', name: 'app_balade')]
    public function index(): Response
    {

        return $this->render('balade/index.html.twig', [
            'controller_name' => 'BaladeController',
        ]);
    }

    #[Route('/balade/new', name: 'new_balade')]
    #[Route('/balade/{id}/edit', name: 'edit_balade')]
    public function new_edit(Balade $balade = null, Request $request, EntityManagerInterface $entityManager): Response {
        
        if(!$balade) {                                  //condition if no balade create new one otherwise it's an edit of the existing one
            $balade = new Balade();
        }

        $form = $this->createForm(BaladeFormType::class, $balade);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $balade = $form->getData();                 //get submitted data

            $personne = $this->getUser();               //get user that is creating balade
            $balade->setOrganisateur($personne);        //add user as balade organiser

            $entityManager->persist($balade);           //prepare
            $entityManager->flush();                    //execute

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);; //redirection page d'info de la balade

        }
        return $this->render('balade/new.html.twig', [
            'formAddBalade' => $form,
        ]);

    }


    #[Route('/balade/{id}/delete', name: 'delete_balade')]

    public function delete(Balade $balade, EntityManagerInterface $entityManager) {
        
        $personne = $this->getUser();                   //get user that is deleting balade
        $organiser = $balade->getOrganisateur();        //get walk organiser

        if ($personne == $organiser){                   //check organiser and current user are the same    

            $entityManager->remove($balade);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');  //redirect homepage
        }

        return $this->redirectToRoute('app_home');      //redirect homepage
        
    }

    #[Route('/balade/{balade_id}/{personne_id}/remove', name: 'remove_personne_balade')]
    public function removePersonneFromBalade(Balade $balade_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);    //get person that is going to be removed
        $user = $this->getUser();                                                                       //get current user

        if ($personne == $user){                                                                        //check that the user and the removed person are the same
            
            $balade->removeStagiaire($personne);
            
            $entityManager->persist($balade);
            $entityManager->flush();
            
            if(empty($balade->getPersonnes())){                                                         //check if walk still as participants
                return $this->redirectToRoute('delete_balade', ['id' => $balade->getId()]);             //if not, delete walk
            }

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);
        }                                                                        
        
    }

    #[Route('/balade/{balade_id}/{personne_id}/move', name: 'enlist_personne_balade')]
    public function movePersonneToBalade(Balade $balade_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);
        $user = $this->getUser();

        if( $personne == $user ) {                                  //check current user and person that is getting enlisted for walk are the same                                                               
            $balade->addPersonne($personne);

            $entityManager->persist($balade);
            $entityManager->flush();

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);
        }

        else {
            return $this->redirectToRoute('app_home');
        }
        
    }



    #[Route('/balade/{id}', name: 'show_balade')]
    public function show(Balade $balade = null): Response {
        if($balade){
            return $this->render('balade/show.html.twig', [
                'balade' => $balade
            ]);
        }
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

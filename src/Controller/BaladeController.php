<?php

namespace App\Controller;

use App\Entity\Balade;
use App\Entity\Personne;
use App\Form\BaladeFormType;
use App\Repository\BaladeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaladeController extends AbstractController
{
    //get walk list
    #[Route('/balade', name: 'app_balade')]
    public function index(BaladeRepository $baladeRepository, EntityManagerInterface $entityManager): Response
    {
        //get all walks sorted by startDateTime
        $balades = $baladeRepository->findBy([], ["dateHeureDepart" => "ASC"]); 

        
        //Before returning walk list get list of future walks
        $baladesFutures = $entityManager->getRepository(Balade::class)->getBaladesFutures();      

        return $this->render('balade/index.html.twig', [
            'balades' => $balades,
            'baladesFutures' => $baladesFutures
        ]);
    }

    //add/edit a walk
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


    //delete a walk
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

    //remove person from walk
    #[Route('/balade/{balade_id}/{personne_id}/remove', name: 'remove_personne_balade')]
    public function removePersonneFromBalade(Balade $balade_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $balade = $entityManager->getRepository(Balade::class)->findOneBy(['id'=>$balade_id]);          //get walk
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);    //get person that is going to be removed
        $user = $this->getUser();                                                                       //get current user
        $organisateur = $balade->getOrganisateur();                                                     //get walk organiser

        //check that the user and the removed person are the same or that user is walk organiser
        if ($personne == $user || $user == $organisateur){                                                                        
            
            $balade->removePersonne($personne);
            
            $entityManager->persist($balade);
            $entityManager->flush();
            

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);
        }                                                                        
        
    }

    //enlist to walk
    #[Route('/balade/{balade_id}/{personne_id}/move', name: 'enlist_personne_balade')]
    public function movePersonneToBalade(Balade $balade_id, int $personne_id, EntityManagerInterface $entityManager) {
        
        $balade = $entityManager->getRepository(Balade::class)->findOneBy(['id'=>$balade_id]);          //get balade
        $personne = $entityManager->getRepository(Personne::class)->findOneBy(['id'=>$personne_id]);
        $user = $this->getUser();
        $organisateur = $balade->getOrganisateur();

        if( $personne == $user && $personne != $organisateur ) {                                        //check current user and person that is getting enlisted for walk are the same and that the person isn't the walk's organiser                                                            
            
            $balade->addPersonne($personne);

            $entityManager->persist($balade);
            $entityManager->flush();

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);
        }

        else {
            return $this->redirectToRoute('app_home');
        }
        
    }


    //go to walk info page
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

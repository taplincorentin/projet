<?php

namespace App\Controller;

use App\Entity\Balade;
use App\Form\BaladeFormType;
// use App\Service\VilleApiService;
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
    public function new_edit(Balade $balade = null, Request $request, EntityManagerInterface $entityManager/*, VilleApiService $villeApiService*/): Response {
        
        if(!$balade) { //condition if no balade create new one otherwise it's an edit of the existing one
            $balade = new Balade();
        }

    $form = $this->createForm(BaladeFormType::class, $balade/*, ['villeListe' => $villeApiService->getVilleListe()]*/);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $balade = $form->getData();

            $entityManager->persist($balade); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('show_balade', ['id' => $balade->getId()]);; //redirection profil de l'utilisateur

        }
        return $this->render('balade/new.html.twig', [
            'formAddBalade' => $form,
        ]);

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

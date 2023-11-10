<?php

namespace App\Controller;

use App\Entity\Chien;
use App\Form\ChienFormType;
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
    public function new_edit(Chien $chien = null, Request $request, EntityManagerInterface $entityManager): Response {
        
        if(!$chien) { //condition if no chien create new one otherwise it's an edit of the existing one
            $chien = new Chien();
        }

        $form = $this->createForm(ChienFormType::class, $chien);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $this->getUser();
            dd($form);
            $chien = $form->getData();
            $now = new \DateTime();
            
            $chien->setDateActualisation($now);
            $chien->setPersonne($personne);

            $entityManager->persist($chien); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);; //redirection profil de l'utilisateur

        }
        return $this->render('chien/new.html.twig', [
            'formAddChien' => $form,
        ]);

    }

    #[Route('/chien/{id}/delete', name: 'delete_chien')]
    public function delete(Chien $chien, EntityManagerInterface $entityManager) {

        $personne= $this->getUser(); //pour la redirection
        
        $entityManager->remove($chien);
        $entityManager->flush();

        return $this->redirectToRoute('show_personne', ['id' => $personne->getId()]);; //redirection profil de l'utilisateur
    }
}

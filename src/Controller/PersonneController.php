<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneController extends AbstractController
{
    // #[Route('/personne', name: 'app_personne')]
    // public function index(): Response
    // {
    //     return $this->render('personne/index.html.twig', [
    //         'controller_name' => 'PersonneController',
    //     ]);
    // }

    #[Route('/personne/{id}', name: 'show_personne')]
    public function show(Personne $personne = null): Response {
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

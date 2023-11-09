<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/topic/{id}', name: 'show_topic')]
    public function show(Topic $topic = null): Response {
        if($topic){
            return $this->render('topic/show.html.twig', [
                'topic' => $topic
            ]);
        }
        else {
            return $this->redirectToRoute('app_topic');
        }
    }
}

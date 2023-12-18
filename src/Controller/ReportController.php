<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Report;
use App\Form\ReportFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    //create new report
    #[Route('/{post_id}/report/new', name: 'new_report')]
    public function new(Report $report = null, int $post_id, Request $request, EntityManagerInterface $entityManager): Response {
        
        $report = new Report();
        $post = $entityManager->getRepository(Post::class)->findOneBy(['id'=>$post_id]);

        //create dog form with breedList from API to build select input
        $form = $this->createForm(ReportFormType::class, $report);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            //get form data (report reason)
            $report = $form->getData();

            //get current datetime to set 'lastModified'
            $now = new \DateTime();
            $report->setDate($now);

            //set reported post
            $report->setPost($post);

            //set current user as report creator
            $user = $this->getUser();
            $report->setReporter($user);

            //prepare execute
            $entityManager->persist($report); 
            $entityManager->flush();

            $this->addFlash('success', "Post has been reported !");

            //redirection profil de l'utilisateur
            return $this->redirectToRoute('app_home');

        }

        return $this->render('report/new.html.twig', [
            'formAddReport' => $form,
        ]);

    }
}

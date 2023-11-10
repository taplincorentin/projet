<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Categorie;
use App\Form\TopicFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    // #[Route('/topic', name: 'app_topic')]
    // public function index(): Response
    // {
    //     return $this->redirectToRoute('app_home');
    // }


    #[Route('/{categorie_id}/topic/new', name: 'new_topic')]
    #[Route('/{categorie_id}/topic/{id}/edit', name: 'edit_topic')]
    public function new_edit(Topic $topic = null, int $categorie_id, Request $request, EntityManagerInterface $entityManager): Response {

        if(!$topic) { //condition if no topic create new one otherwise it's an edit of the existing one
            $topic = new Topic();
        }
        $categorie = $entityManager->getRepository(Categorie::class)->findOneBy(['id'=>$categorie_id]);

        
        $form = $this->createForm(TopicFormType::class, $topic);

        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid

            $topic = $form->getData();              //get form data (titre)
            $topic->setCategorie($categorie);       //add categorie to data

            //ajout de la date et heure de la modification du topic
            $now = new \DateTime();
            $topic->setDateCreation($now);

            $auteur = $this->getUser();
            $topic->setAuteur($auteur);

            $entityManager->persist($topic); //prepare
            $entityManager->flush(); //execute

            return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);; //redirection page topic créé/édité

        }

        return $this->render('topic/new.html.twig', [
            'formAddTopic' => $form,
        ]);

    }


    #[Route('/topic/{id}/delete', name: 'delete_topic')]

    public function delete(Topic $topic, EntityManagerInterface $entityManager) {

        $categorie=$topic->getCategorie();      //récupération de la catégorie pour la redirection
        
        $entityManager->remove($topic);
        $entityManager->flush();

        return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]);; //redirection page categorie du topic supprimé
    }



    #[Route('/topic/{id}', name: 'show_topic')]
    public function show(Topic $topic = null): Response {
        if($topic){
            return $this->render('topic/show.html.twig', [
                'topic' => $topic
            ]);
        }
        else {
            return $this->redirectToRoute('app_home');
        }
    }
}

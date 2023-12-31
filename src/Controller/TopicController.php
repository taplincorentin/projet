<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\Categorie;
use App\Form\PostFormType;
use App\Form\TopicFormType;
use App\Form\EditPostFormType;
use App\Repository\PostRepository;
use App\Repository\CategorieRepository;
use App\Service\VerificationRoleService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{

    #[Route('/topic/{id}/delete', name: 'delete_topic')]

    public function delete(Topic $topic, EntityManagerInterface $entityManager, VerificationRoleService $verficationRole) {
        
        //get current user and topic creator
        $user = $this->getUser();
        $personne = $topic->getAuteur();
        //get category for redirection an check
        $categorie=$topic->getCategorie(); 
        
        //security check that the categorie isn't the walk or session categorie (can't cdelete a topic in it this way only by deleting a walk/session)
        if($categorie->getNom() != 'Walks' && $categorie->getNom() != 'Sessions'){
            
            
            //check that the current user is the topic's creator or an admin
            if ($personne == $user || $verficationRole->verificationAdmin() ){
            
                //prepare execute
                $entityManager->remove($topic);
                $entityManager->flush();

                $this->addFlash('success', "Topic deleted !");

                //redirect to topic's category
                return $this->redirectToRoute('show_categorie', ['id' => $categorie->getId()]); 
            }
            
        }
        //redirect to home if misses a test
        return $this->redirectToRoute('app_home');
    }



    #[Route('/topic/{id}', name: 'show_topic')]
    public function show(Topic $topic = null, Post $post = null, Request $request, EntityManagerInterface $entityManager, CategorieRepository $categorieRepository, PostRepository $postRepository, FormFactoryInterface $formFactory, PaginatorInterface $paginator): Response {

        //check topic exists
        if($topic){
        
            //get topic posts
            $posts = $topic->getPosts();

            //get topic author and current user
            $auteur = $topic->getAuteur();
            $user = $this->getUser();
        
            //EDIT TOPIC FORM RENDERING & SUBMISSION
            
            $formT = $this->createForm(TopicFormType::class, $topic);

            $formT->handleRequest($request); 
 
            if ($formT->isSubmitted() && $formT->isValid()) {

                //check that topic author and current user are the same person
                if($auteur == $user ){

                    //get form data (titre)      
                    $topic = $formT->getData();  
                                
                    //get current datetime to set 'lastModified'
                    $now = new \DateTime();
                    $topic->setLastModified($now);
                            
                    $entityManager->persist($topic); //prepare
                    $entityManager->flush(); //execute

                    $this->addFlash('success', "Topic updated !");

                    //redirect to edited topic page
                    return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
                }

            }
            

            //EDIT POST FORM RENDERRING & SUBMISSION
            $postForms = [];
 
            foreach ($posts as $post2) {
                
                //get post author
                $postAuteur = $post2->getAuteur();
                
                
                $postId = $post2->getId();
        
                //create associated topic
                $formP = $formFactory->createNamed('editPost'.$postId, EditPostFormType::class, $post2);
                    
                //store associated post form
                $postForms[$post2->getId()] = $formP->createView();


                $formP->handleRequest($request); 

                if ($formP->isSubmitted() && $formP->isValid()) { //if form submitted and valid
                        
                    //check that topic author and current user are the same person
                    if($postAuteur == $user){

                    //get form data (contenu)
                    $editedPost = $formP->getData();               
                        
                    //get current datetime to set 'lastModified'
                    $now = new \DateTime();
                    $editedPost->setLastModified($now);
                
                    //prepare execute
                    $entityManager->persist($editedPost);
                    $entityManager->flush();

                    $this->addFlash('success', "Post updated !");

                    //redirect to edited post's topic
                    return $this->redirectToRoute('show_topic', ['id' => $topic->getId()]);
            
                    }
                }

                    
            }        

            //get all categories for menu 
            $categories = $categorieRepository->findBy([], ['nom' => 'ASC']); 

            //transorm postList for paging
            $postsPaginate = $paginator->paginate(
                                        $posts, // Requête contenant les données à paginer (ici nos articles)
                                        $request->query->getInt('page', 1), // current page number
                                                                10 // number of results per page
                                        );  

            //get total number of posts by post author
            $nbPostsTotalAuteur = [];
            foreach ($posts as $post) {
                $nbPostsAuteur = $postRepository->nbPostsAuteur($post->getAuteur());
                $nbPostsTotalAuteur[$post->getId()] = $nbPostsAuteur;
            }

            //NEW POST FORM RENDERING AND SUBMISSION
            $post = new Post();
                    
            $form = $this->createForm(PostFormType::class, $post);

            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) { //if form submitted and valid
                    
                //get form data (contenu)
                $post = $form->getData();
                        
                //set post topic
                $post->setTopic($topic);                

                //get current datetime to set 'lastModified'
                $now = new \DateTime();
                $post->setDateCreation($now);

                //set current user as post creator
                $auteur = $this->getUser();
                $post->setAuteur($auteur);
                        
                //prepare execute
                $entityManager->persist($post);
                $entityManager->flush();

                $this->addFlash('success', "Post created !");

                //redirect to created topic
                return $this->redirectToRoute('show_topic', ['id' => $post->getTopic()->getId()]);
            }

            //if it's a walk's topic
            if(!empty($topic->getBalade())){
                
                //check user is walk organiser
                if ($user == $topic->getBalade()->getOrganisateur()){
                    

                    //return topic view if it's the case
                    return $this->render('topic/show.html.twig', [
                    'topic' => $topic,
                    'postsPaginate' => $postsPaginate,
                    'formAddPost' => $form,
                    'categories' => $categories,
                    'nbPostsTotalAuteur' => $nbPostsTotalAuteur,
                    'formAddTopic' => $formT,
                    'postForms' => $postForms,
                    ]);
                }

                //get walk participants
                $participants = $topic->getBalade()->getPersonnes();
                //check that the user is a participant
                foreach ($participants as $participant) {
                    if ($user == $participant){
                        
                        //return topic view if it's the case
                        return $this->render('topic/show.html.twig', [
                            'topic' => $topic,
                            'postsPaginate' => $postsPaginate,
                            'formAddPost' => $form,
                            'categories' => $categories,
                            'nbPostsTotalAuteur' => $nbPostsTotalAuteur,
                            'formAddTopic' => $formT,
                            'postForms' => $postForms,
                        ]);
                    }
                }

                //if not organiser or participant redirect to home
                return $this->redirectToRoute('app_home');

            }

            //else if it's a session's topic
            elseif (!empty($topic->getSeance())){
                
                
                //check user is session organiser
                if ($user == $topic->getSeance()->getOrganisateur()){
                    
                    //return topic view if it's the case
                    return $this->render('topic/show.html.twig', [
                        'topic' => $topic,
                        'postsPaginate' => $postsPaginate,
                        'formAddPost' => $form,
                        'categories' => $categories,
                        'nbPostsTotalAuteur' => $nbPostsTotalAuteur,
                        'formAddTopic' => $formT,
                        'postForms' => $postForms,
                    ]);
                    
                }
                
                //get session participants
                $participants = $topic->getSeance()->getParticipants();
                //check that the user is a participant
                foreach ($participants as $participant) {
                    if ($user == $participant){
                        
                        //return topic view if it's the case
                        return $this->render('topic/show.html.twig', [
                            'topic' => $topic,
                            'postsPaginate' => $postsPaginate,
                            'formAddPost' => $form,
                            'categories' => $categories,
                            'nbPostsTotalAuteur' => $nbPostsTotalAuteur,
                            'formAddTopic' => $formT,
                            'postForms' => $postForms,
                    ]);
                        
                    }
                    
                }

                //if not organiser or participant redirect to home
                return $this->redirectToRoute('app_home');
            }

            //if topic exist and isn't a session or walk associated topic go to topic view
            else{

                return $this->render('topic/show.html.twig', [
                    'topic' => $topic,
                    'postsPaginate' => $postsPaginate,
                    'formAddPost' => $form,
                    'categories' => $categories,
                    'nbPostsTotalAuteur' => $nbPostsTotalAuteur,
                    'formAddTopic' => $formT,
                    'postForms' => $postForms,
                    ]);
            }
     
        }

        //if topic doesn't exist back to homepage
        return $this->redirectToRoute('app_home');
    }


}
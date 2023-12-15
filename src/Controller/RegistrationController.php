<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Security\AppAuthenticator;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator,EntityManagerInterface $entityManager): Response
    {
        $user = new Personne();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encodage du mot de passe
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //ajout de la date et heure de la création du compte utilisateur
            $now = new \DateTime();
            $user->setDateCreation($now);
            
            //set default profile picture
            $user->setNomImageProfil('profile_picture_default.jpg');
            
            $entityManager->persist($user);
            $entityManager->flush();
            
            $this->addFlash('success', "Registraion successful !");

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
           
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

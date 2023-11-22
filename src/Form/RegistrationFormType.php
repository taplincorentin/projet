<?php

namespace App\Form;

use App\Entity\Personne;
use App\Validator\Constraints\RegexMdp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email :'])
            ->add('pseudo', TextType::class, ['label' => 'Username : '])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'passwords need to be the same',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => 'Password : '],
                'second_options' => ['label' => 'Confirm password : '],
                'constraints' => [
                    new RegexMdp(),
                ],
            ])
            ->add("isEducateur", CheckboxType::class, [
                'required' => false,                                                                                
                'label' => "Sign up as a dog trainer"
            ])
            ->add("agreeTerms", CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "can't sign up without accepting the conditions of use",
                    ]),
                ],
                'label' => "Agree to terms and condition of use"
                
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Sign up",
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}

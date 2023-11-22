<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville', TextType::class, [
                'label' => 'Search by City/Town',
 
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Dog walks' => 'balades',
                    'Training sessions' => 'seances',
                ],
                'expanded' => true,
                'multiple' => false,
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Search',
            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

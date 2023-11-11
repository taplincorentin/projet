<?php

namespace App\Form;

use App\Entity\Chien;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ChienFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Name :'])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Birthday :'
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,  
                'label' => 'picture :'
                ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Tell us about you dog :'
                ])
            
            ->add('races', ChoiceType::class, [
                'mapped' => false,
                'choices'  => $options['breedList'],
                'expanded' => false,
                'multiple' => true,
                'attr' => [
                    'class' => 'select-breeds'
                ]
            ])

            ->add('submit', SubmitType::class, [
                'label' => "Add dog",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chien::class,
            'breedList' => [], // array vide par défaut
        ]);
    }
}

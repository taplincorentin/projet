<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SeanceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDepart', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'When?'
            ])
            ->add('ville', TextType::class)
            ->add('theme', EntityType::class,[
                'class' => Theme::class,
                'required' => false,
                'placeholder' => 'You can choose a theme for your session',
                'empty_data' => null
                ])
            ->add('description')
            ->add('submit', SubmitType::class, [
                'label' => "Add session",
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}

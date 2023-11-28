<?php

namespace App\Form;

use App\Entity\Theme;
use App\Entity\Seance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SeanceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Title : '
            ])
            ->add('dateHeureDepart', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date and Time : '
            ])
            ->add('ville', TextType::class, [
                'label' => 'City/Town : '
            ])
            ->add('theme', EntityType::class,[
                'class' => Theme::class,
                'required' => false,
                'placeholder' => 'You can choose a theme for your training session',
                'empty_data' => null
                ])
            ->add('description', TextareaType::class, [
                'label' => 'Additional Information : ',
                'required' => false,
            ])
            ->add('pointLatitude', NumberType::class, [
                'required' => false,
            ])
            ->add('pointLongitude', NumberType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Confirm Training Session Information",
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Seance::class,
        ]);
    }
}

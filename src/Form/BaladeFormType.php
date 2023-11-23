<?php

namespace App\Form;

use App\Entity\Balade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BaladeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Title : '
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Additional Information : '
            ])
            ->add('ville', TextType::class, [
                'label' => 'City/Town : '
            ])
            ->add('dateHeureDepart', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date and Time : '
            ])
            ->add('pointLatitude', NumberType::class, [
                'required' => false,
            ])
            ->add('pointLongitude', NumberType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Confirm Walk Information",
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Balade::class,
        ]);
    }
}

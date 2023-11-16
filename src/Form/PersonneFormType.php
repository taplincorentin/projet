<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PersonneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('pseudo')
            ->add('description')
            ->add('imageProfil', FileType::class, [
                'label' => 'Profile Picture',
                'mapped' => false, // This field is not directly mapped to an entity property
                'required' => false, //the picture isn't mandatory
            ])
            ->add('isEducateur')
            ->add('descriptionEducateur')
            ->add('submit', SubmitType::class, [
                'label' => "edit my info",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}

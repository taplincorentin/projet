<?php

namespace App\Form;

use App\Entity\Topic;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HomeTopicFormType extends AbstractType
{
    private $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Topic title",
                'required'   => true,
                'constraints' => [
                    new Regex('/[0-9][a-zA-Z]{100,}/')
                ],
            ])
            ->add('categorie', EntityType::class,[
                'class' => Categorie::class,
                'choices' => $this->categorieRepository->getAuthorizedCategories(),
                'required' => true,
                'placeholder' => '-- Select Category --',
             ])
            ->add('submit', SubmitType::class, [
                'attr' => ['data-label' => 'confirm topic creation']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}

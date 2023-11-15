<?php

namespace App\Controller\Admin;

use App\Entity\Topic;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TopicCrudController extends AbstractCrudController
{
    use Trait\RemoveNewTrait;
    public static function getEntityFqcn(): string
    {
        return Topic::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            AssociationField::new('auteur'),
            DateTimeField::new('dateCreation'),
            AssociationField::new('posts')
                ->onlyOnIndex(),
            ArrayField::new('posts')
                ->onlyOnDetail(),
            
        ];
    }

}

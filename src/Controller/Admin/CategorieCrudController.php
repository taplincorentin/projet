<?php

namespace App\Controller\Admin;

use App\Entity\Categorie;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorieCrudController extends AbstractCrudController
{   
    use Trait\AddInfoTrait;
    public static function getEntityFqcn(): string
    {
        return Categorie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('topics')
                ->onlyOnIndex(),
            ArrayField::new('topics')
                ->onlyOnDetail(),
        ];
    }

}

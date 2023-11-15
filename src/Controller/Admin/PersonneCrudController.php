<?php

namespace App\Controller\Admin;

use App\Entity\Personne;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PersonneCrudController extends AbstractCrudController
{
    use Trait\RemoveNewTrait;
    public static function getEntityFqcn(): string
    {
        return Personne::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('pseudo')
                ->hideOnDetail(),
            BooleanField::new('isEducateur')->renderAsSwitch(false),
            AssociationField::new('chiens')
                ->onlyOnIndex(),
            ArrayField::new('chiens')
                ->onlyOnDetail(),
            DateTimeField::new('lastLogin'),
            AssociationField::new('topics')
                ->onlyOnIndex(),
            ArrayField::new('topics')
                ->onlyOnDetail(),
            AssociationField::new('posts')
                ->onlyOnIndex(),
            ArrayField::new('posts')
                ->onlyOnDetail(),
        ];
    }

}

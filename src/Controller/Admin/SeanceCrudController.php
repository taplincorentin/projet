<?php

namespace App\Controller\Admin;

use App\Entity\Seance;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SeanceCrudController extends AbstractCrudController
{
    use Trait\RemoveNewTrait;
    public static function getEntityFqcn(): string
    {
        return Seance::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom')
                ->hideOnDetail(),
            AssociationField::new('organisateur'),
            TextField::new('ville'),
            DateTimeField::new('dateHeureDepart'),
            AssociationField::new('participants')
                ->onlyOnIndex(),
            ArrayField::new('participants')
                ->onlyOnDetail(),
        ];
    }

}

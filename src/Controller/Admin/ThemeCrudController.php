<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ThemeCrudController extends AbstractCrudController
{
    use Trait\AddInfoTrait;
    public static function getEntityFqcn(): string
    {
        return Theme::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('seances')
                ->onlyOnIndex(),
            ArrayField::new('seances')
                ->onlyOnDetail(),
        ];
    }
    
}

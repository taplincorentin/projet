<?php

namespace App\Controller\Admin;

use App\Entity\Report;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReportCrudController extends AbstractCrudController
{
    use Trait\PersonneTrait;
    public static function getEntityFqcn(): string
    {
        return Report::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reason'),
            AssociationField::new('reporter'),
            AssociationField::new('post'),
        ];
    }

}
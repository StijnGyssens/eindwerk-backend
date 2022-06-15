<?php

namespace App\Controller\Admin;

use App\Entity\Timeperiode;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TimeperiodeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Timeperiode::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

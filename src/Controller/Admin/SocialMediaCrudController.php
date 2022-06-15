<?php

namespace App\Controller\Admin;

use App\Entity\SocialMedia;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SocialMediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SocialMedia::class;
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

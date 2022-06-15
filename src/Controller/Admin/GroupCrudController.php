<?php

namespace App\Controller\Admin;

use App\Entity\Group;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Group::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('location'),
            AssociationField::new('fightingStyle'),
            AssociationField::new('historicalRegion'),
            AssociationField::new('timeperiode'),
            AssociationField::new('events')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
            AssociationField::new('members')
                ->autocomplete()
                ->setFormTypeOption('by_reference', false),
            CollectionField::new('socials')
                ->allowAdd()
                ->allowDelete()
                ->renderExpanded()
                ->setEntryIsComplex(true)
        ];
    }

}

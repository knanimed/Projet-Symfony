<?php

namespace App\Controller\Admin;

use App\Entity\Borrowing;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class BorrowingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Borrowing::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        $crud = Crud::new();
        return $crud 
            ->setPaginatorPageSize(10)
            ->setPaginatorRangeSize(4)
        ;
    }
        

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('dateborrowed'),
            BooleanField::new('bookreturned'),
            AssociationField::new('student') 
                ->autocomplete() 
                ->setRequired(true),
            AssociationField::new('book') 
                ->autocomplete() 
                ->setRequired(true),
        ];
    }
    
}

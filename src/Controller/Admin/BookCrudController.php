<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Repository\BookauthorRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        $bookauthors_c = BookauthorRepository::findOneBy(['book_id' => $this->book]);
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextField::new('author')->setLabel('Author'),
        ];
    }
    */
}

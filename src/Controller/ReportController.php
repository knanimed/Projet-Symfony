<?php

namespace App\Controller;

use App\Entity\BookSearch;
use App\Repository\BrrowingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BookSearchType;

class ReportController extends AbstractController
{
    #[Route('/most-popular-book', name: 'most_popular_book')]
    public function index(BrrowingRepository $repository): Response
    {
        #$books = $repository->findMostPopularBooks();
        #$books = $repository->findMostPopularBooksQb();
        $books = $repository->findMostPopularBooksDql();
        return $this->render('report/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/BorrowingBook', name: 'BorrowingBook')]
    public function BorrowingBook(Request $request, BrrowingRepository $repository) {
        $bookSearch = new BookSearch();
        $form = $this->createForm(BookSearchType::class,$bookSearch);
        $form->handleRequest($request);
        $borrowings= [];
        if($form->isSubmitted() && $form->isValid()) {
        $book = $bookSearch->getBook();
        if ($book!="")
        $borrowings=$repository->findBy( array('book' => $book) ); 
        else
        $borrowings= $repository->findAll();
        }
        return $this->render('report/BorrowingBook.html.twig',
        ['form' => $form->createView(),'borrowings' => $borrowings]);
    }        
}

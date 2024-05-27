<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Repository\BookauthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AuthorRepository $authorRepository, BookauthorRepository $bookauthorRepository ,EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($book);
            $entityManager->flush();
            $authorId = $request->get('author');
            //dd($authorId);
            $author = $authorRepository->find($authorId);
            $bookauthorRepository->save($book,$author);
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
            'authors'=>$authorRepository->findAll(),
            'autor_c'=>null
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book, BookauthorRepository $bookauthorRepository,): Response
    {
        $bookAuthors = $bookauthorRepository->findBy(['book_id' => $book]);
        $authors = [];
    
        foreach ($bookAuthors as $bookAuthor) {
            $authors[] = $bookAuthor->getAuthorId();
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
            'authors'=> $authors
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, AuthorRepository $authorRepository, BookauthorRepository $bookauthorRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        $bookauthors_c = $bookauthorRepository->findOneBy(['book_id' => $book]);
        //dd($bookauthors_c->getAuthorId()->getId());
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $authorId = $request->get('author');
            if($authorId){
                $author = $authorRepository->find($authorId);

                $bookauthorRepository->deleteByBookId($book);
                $bookauthorRepository->save($book,$author);  
            }
            

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
            'authors'=>$authorRepository->findAll(),
            'autor_c'=>$bookauthors_c->getAuthorId()->getId()
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Entity\Borrowing;
use App\Form\BorrowingType;
use App\Repository\BookRepository;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/borrowing')]
class BorrowingController extends AbstractController
{
    #[Route('/', name: 'app_borrowing_index', methods: ['GET'])]
    public function index(Request $request,BorrowingRepository $borrowingRepository , BookRepository $bookRepository): Response
    {
        $borrowings=$borrowingRepository->findAll();
        $search = $request->query->get('search');
        if($search != "null" && $search){
            $borrowings= $borrowingRepository->findByBookTitle($search);
        }
        $popular=$borrowingRepository->findMostPopularBooksDql();
        return $this->render('borrowing/index.html.twig', [
            'borrowings' => $borrowings,
            'books' => $bookRepository->findAll(),
            'search' => $search,
            'popular'=>$popular
        ]);
    }

    #[Route('/new', name: 'app_borrowing_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrowing);
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowing/new.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowing_show', methods: ['GET'])]
    public function show(Borrowing $borrowing): Response
    {
        return $this->render('borrowing/show.html.twig', [
            'borrowing' => $borrowing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrowing_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowing/edit.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowing_delete', methods: ['POST'])]
    public function delete(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrowing->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }
}

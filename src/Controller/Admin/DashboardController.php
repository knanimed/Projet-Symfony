<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Student;
use App\Entity\Borrowing;
use App\Entity\Bookauthor;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\StudentCrudController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\BrrowingCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController( StudentCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureMenuItems(): iterable
    {
    yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
    yield MenuItem::linkToCrud('Student', 'fas fa-chalkboard-teacher', Student::class);
    yield MenuItem::linkToCrud('Borrowing', 'fas fa-book-reader', Borrowing::class);
    yield MenuItem::linkToCrud('Book', 'fas fa-book', Book::class);
    yield MenuItem::linkToCrud('Author', 'fas fa-user', Author::class);

    }
    
    public function configureDashboard(): Dashboard
    {
    return Dashboard::new()
    ->setTitle('<img src="assets/book.jpg" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%;"><h2 class="mt-3 fw-bold text-white 
    text-center">Librarian</h2>')
    ->renderContentMaximized();
    }
    
        public function index2(): Response
        {
            $routeBuilder = $this->container->get(AdminUrlGenerator::class);
            $url = $routeBuilder->setController(BorrowingCrudController::class)->generateUrl();
            return $this->redirect($url);
            // return parent::index();
        }
}

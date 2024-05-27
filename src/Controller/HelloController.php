<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelloController extends AbstractController
{
    private array $messages = ["Mohamed Knani   &&&   Aymen Youssfi"];

    #[Route('/hello/{name}', name: 'app_hello')]
    public function index1($name): Response
    {
        return $this->render('hello/index.html.twig', [
        'name' => $name,
        ]);
    }
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $messages = ["Mohamed Knani et Aymen Youssfi"];

        return $this->render('hello/index.html.twig', [
            'messages' => $messages,
            'name' => $messages[0],

        ]);
    }

    #[Route('/messages/{id}', name: 'app_show_one')]
    public function showOne($id): Response
    {
        return new Response($this->messages[$id]);
    }


}

<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class LoginiController extends AbstractController
{
#[Route('/login', name: 'login')]
public function index(AuthenticationUtils $authenticationUtils): Response
{
// get the login error if there is one 
$error = $authenticationUtils->getLastAuthenticationError();
// last username entered by the user
$lastUsername = $authenticationUtils->getLastUsername();
return $this->render('logini/index.html.twig', [
'controller_name' => 'LoginController',
'last_username' => $lastUsername,
'error' => $error
]);
}
}

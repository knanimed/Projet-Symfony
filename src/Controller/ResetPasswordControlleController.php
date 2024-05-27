<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Service\MailService;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordControlleController extends AbstractController
{
    private $entityManager;
    private $mailService;

    public function __construct(EntityManagerInterface $entityManager , MailService $mailService)
    {
        $this->entityManager = $entityManager;
        $this->mailService = $mailService;
    }

    #[Route('/forgot-password', name: 'reset_password')]
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_borrowing_index');
        }
        if ($request->get('email')) {
            //dd($request->get('email'));
            $user = $this->entityManager->getRepository(User::class)->findOneByUsername($request->get('email'));
            //dd($user);
            if ($user) {
                //1- Save in the database the request reset of password
                $resetPassword = new ResetPassword();
                $resetPassword->setUser($user)->setToken(uniqid())->setCreateAt(new DateTimeImmutable());
                $this->entityManager->persist($resetPassword);
                $this->entityManager->flush();
                //2- Send an email to the user with a link to update the password
                $url= $this->generateUrl('update_password',['token'=>$resetPassword->getToken()]);
                $content ="Hello ".$user->getUsername()."<br> In order to reset 
                your password, please click on the following link :<br> ";
                $content .="<a href='".$url."'>Reset your password</a>."; 
                $this->mailService->send($user->getUsername(), null, 'Reset your password', $content);
                $this->addFlash("notice", "An email has been sent to you !");
            }
                 

        }
            
        return $this->render('reset_password_controlle/index.html.twig');
    }

    #[Route('/update-password/{token}', name: 'update_password')]
    public function reset($token, Request $request, UserPasswordHasherInterface $encoder)
    {
        //dd($token);
        $resetPassword = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if (!$resetPassword) {
            return $this->redirectToRoute('reset_password');
        } 
        else {
            $now = new \DateTime();
            if ($resetPassword->getCreateAt()->modify('+ 30 minute') < $now) {
                $this->addFlash('notice', 'Your password request has expired. Please renew it');
                return $this->redirectToRoute('reset_password');
            }
            else{
                $form = $this->createForm(ResetPasswordType::class);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $newPassword = $form->get('new_password')->getData();
                    $resetPassword->getUser()->setPassword(
                        $encoder->hashPassword($resetPassword->getUser(),$newPassword)
                    );
                    $this->entityManager->flush();
                    $this->addFlash('notice', 'Your password has been updated !');
                    return $this->redirectToRoute('login');

                } 
                return $this->render('reset_password_controlle/reset.html.twig', [
                    'form' => $form->createView()
                ]);

            }
        }
        //dump($now);
        //dump($resetPassword->getCreateAt()->modify('+ 30 minute'));
        //dd($resetPassword);

    }



}

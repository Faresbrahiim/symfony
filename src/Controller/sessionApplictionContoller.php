<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


final class sessionApplictionContoller extends AbstractController
{
 #[Route("/",name :"home" , methods: ['GET'])]
 public function login(): Response
    {
        return $this->render('home/login.html.twig', [
            'controller_name' => 'sessionApplictionContoller',
        ]);
    }
 #[Route("/login",name :"login" , methods: ['POST'])]

    public function Checklogin(): Response
    {
        $passwod  = "124" ;
        $username = "ifares" ;
        if( $_POST['username'] ===  $username  && $_POST['password'] ===  $passwod ){
            $session = new SessionInterface();
            $session->set('user', $username);
        } else {
            return $this->render('home/login.html.twig', [
                'error' => 'Invalid credentials',
                'status' => 401,
            ]);
        }
        return $this->render('home/loginDone.html.twig', [
            'controller_name' => 'sessionApplictionContoller',
            'status' => 200,
        ]);
    }
}

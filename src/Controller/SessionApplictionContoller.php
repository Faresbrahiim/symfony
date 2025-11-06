<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

final class SessionApplictionContoller extends AbstractController
{
    // define the route for the login page and  the method to handle login
    #[Route("/", name: "home", methods: ['GET'])]
    public function login(): Response
    {
        // when requested render the login form with controller name but it is not necessary we can send other data if needed
        return $this->render('home/login.html.twig');
    }
    // the object request is used to get the form data we can use it to get query parameters too and read cookies  , files , method type  , host , url , and ip address
    // for session we use the SessionInterface to store data in session , it a contract that defines the methods that a session class must implement
    #[Route("/login", name: "login", methods: ['POST'])]
    public function checkLogin(Request $request, SessionInterface $session): Response
    {
        $password = "124";
        $username = "ifares";

        // Read form fields safely
        $inputUsername = $request->request->get('username');
        $inputPassword = $request->request->get('password');

        if ($inputUsername === $username && $inputPassword === $password) {
            // Store data in session
            $session->set('user', $username);

            return $this->render('home/loginDone.html.twig', [
                'username' => $username,
                'status' => 200,
            ]);
        }

        // Invalid login
        return $this->render('home/login.html.twig', [
            'error' => 'Invalid credentials',
            'status' => 401,
        ]);
    }

    #[Route("/profile", name: "profile", methods: ['GET'])]
    public function profile(SessionInterface $session): Response
    {
        // get the session data , null is the default value if the key does not exist
        $username = $session->get('user', null);
        // if no user in session redirect to home page
        if (!$username) {
            return $this->redirectToRoute('home');
        }
        // if we're working with frontend we can render a profile template and pass the username to it or jsust return a json response
        return $this->render('home/loginDone.html.twig', [
            'username' => $username,
            'status' => 200,
        ]);
    }

    #[Route("/logout", name: "logout", methods: ['GET'])]
    public function logout(SessionInterface $session): Response
    {
        $session->clear(); // remove all session data
        return $this->redirectToRoute('home');
    }
}

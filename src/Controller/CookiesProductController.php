<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

final class CookiesProductController extends AbstractController
{
    // Show the form to add a product
    #[Route("/products", name: "products", methods: ['GET'])]
    public function addProducts(): Response
    {
        return $this->render('home/AddProducts.html.twig');
    }

    // Handle form submission and set cookie
    #[Route("/addProduct", name: "add_product", methods: ['POST'])]
    public function addCookieProduct(Request $request): Response
    {
        $productName = $request->request->get('product_name');
        $productPrice = $request->request->get('price');
        // dd( $productName,$productPrice);
        if ($productName!= "" && $productPrice != "") {
            // Render template first
            $response = $this->render('home/Added.html.twig', [
                'product_name' => $productName,
                'product_price' => $productPrice,
            ]);

            // Create and attach cookie (expires in 1 hour)
            $cookieProduct = Cookie::create('product', $productName, time() + 3600);
            $response->headers->setCookie($cookieProduct);

            return $response;
        }

        return new Response('Product data missing!', 400);
    }

    // Show the stored product from cookie
    #[Route("/seeCookie", name: "seeCookie", methods: ['GET'])]
    public function seeCookie(Request $request): Response
    {
        $productName = $request->cookies->get('product', null);

        return $this->render('home/seeCookie.html.twig', [
            'product_name' => $productName,
        ]);
    }

    // Delete the product cookie
    #[Route("/deleteCookie", name: "delete_cookie", methods: ['GET'])]
    public function deleteCookie(): Response
    {
        $response = new Response('Product cookie deleted!');
        $response->headers->clearCookie('product');

        return $response;
    }
}

// some questions :
// when we use private members or methods in symfony controllers ?
// why we don't specify time on session set method ?
// what is the best practice to handle authentication and authorization in symfony applications ?
// what is getPOST() method in request object ?
// does render method stop the execution of the controller after returning the response ?

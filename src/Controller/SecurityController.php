<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login", name="auth_login")
     * @return Response
     */
    public function login(): Response
    {
        return $this->render('auth/login.html.twig', []);
    }

    /**
     * @Route("/register", name="auth_register")
     * @return Response
     */
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', []);
    }

    /**
     * @Route("/logout", name="auth_logout")
     */
    public function logout()
    {

    }
}
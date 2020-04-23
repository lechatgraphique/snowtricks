<?php


namespace App\Controller;


use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{

    /**
     * @Route("/password/new", name="auth_password_reset")
     * @return Response
     */
    public function reset(): Response
    {
        return $this->render('auth/password_reset.html.twig', []);
    }

}
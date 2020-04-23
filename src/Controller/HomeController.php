<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('trick/index.html.twig', []);
    }

    /**
     * @Route("/trick", name="home_show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('trick/show.html.twig', []);
    }
}

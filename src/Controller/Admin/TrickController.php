<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/admin/trick", name="trick_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/trick/index.html.twig', []);
    }

    /**
     * @Route("/admin/trick/new", name="trick_new")
     * @return Response
     */
    public function edit(): Response
    {
        return $this->render('admin/trick/new.html.twig', []);
    }
}

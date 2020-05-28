<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    /**
     * @Route("/admin/tricks", name="admin.tricks.index")
     * @return Response
     */
    public function index(): Response
    {
        $focus = "tricks";

        return $this->render('admin/index.html.twig', [
            "focus" => $focus
        ]);
    }

    /**
     * @Route("/admin/trick/new", name="admin.trick.new")
     * @return Response
     */
    public function edit(): Response
    {
        return $this->render('admin/trick/new.html.twig', []);
    }
}

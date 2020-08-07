<?php

namespace App\Controller;

use App\Entity\Trick;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/", name="home.index")
     * @return Response
     */
    public function index(): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');
        $tricks = $objectManager->findBy([], ['createdAt' => 'DESC'], 50, 0);

        return $this->render('trick/index.html.twig', [
            "tricks" => $tricks
        ]);
    }

    /**
     * @Route("/trick", name="home.show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->render('trick/show.html.twig', []);
    }
}

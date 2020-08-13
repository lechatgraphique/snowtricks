<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use App\Service\Pagination;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private ObjectManager $objectManager;
    private Pagination $pagination;

    public function __construct(ObjectManager $objectManager, Pagination $pagination)
    {
        $this->objectManager = $objectManager;
        $this->pagination = $pagination;
    }

    /**
     * @Route("/", name="home.index")
     * @param Request $request
     * @param TrickRepository $trickRepository
     * @return Response
     */
    public function index(Request $request, TrickRepository $trickRepository): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');

        $maxPerPage = 6;
        $page = (int) $request->query->get ('page', 1);

        $tricksCount = count($objectManager->findAll());

        $pages = ceil($tricksCount/$maxPerPage);



        /** @var Trick [] */
        $tricks = $trickRepository->findAllForPaginateAndSort($page, $maxPerPage);



        $paginationLinks = $this->pagination->getUrl($page, $pages);


        return $this->render('trick/index.html.twig', [
            "tricks" => $tricks,
            "paginationLinks" => $paginationLinks
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

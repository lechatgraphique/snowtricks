<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Service\Pagination;
use App\Service\UploadPicture;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
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
     * @Route("/trick/{slug}", name="trick.show")
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function show(Trick $trick, Request $request, ObjectManager $manager, CommentRepository $commentRepository): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');
        $trick = $objectManager->find($trick->getId());

        $objectManager =  $this->getDoctrine()->getRepository('App:Comment');
        $comments = $objectManager->findAll();

        $maxPerPage = 10;
        $page = (int) $request->query->get ('page', 1);

        $commentsCount = count($commentRepository->findAll());
        $pages = ceil($commentsCount/$maxPerPage);

        /** @var Trick [] */
        $comments = $commentRepository->findAllCommentsForPaginateAndSort($trick, $page, $maxPerPage);

        dd($comments);
        $paginationLinks = $this->pagination->getCommentUrl($page, $pages, $trick->getSlug());


        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime());
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire a bien été enregistré !'
            );

            return $this->redirectToRoute('trick.show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'form' => $form->createView(),
            'paginationLinks' => $paginationLinks,
            'slug' => $trick->getSlug()
        ]);
    }

    /**
     * @Route("/trick/create", name="trick.create")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UploadPicture $uploadPicture
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, UploadPicture $uploadPicture, ObjectManager $manager): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $mainPicture = $trick->getMainPicture();

            $mainPicture->setTrick($trick);

            $mainPicture = $uploadPicture->saveImage($mainPicture);

            $manager->persist($mainPicture);

            foreach($trick->getPictures() as $picture)
            {
                $picture->setTrick($trick);
                $picture = $uploadPicture->saveImage($picture);

                $manager->persist($picture);
            }
            $trick->setDisabled(1);
            $trick->setCreatedAt(new \DateTime());
            $trick->setUpdatedAt(new \DateTime());
            $trick->setUser($this->getUser());

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le trick {$trick->getName()} a bien été enregistré !"
            );

            return $this->redirectToRoute('trick.show', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/trick/edit/{slug}", name="trick.edit")
     * @IsGranted("ROLE_USER")
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @param UploadPicture $uploadPicture
     * @return Response
     */
    public function edit(Trick $trick, Request $request, ObjectManager $manager, UploadPicture $uploadPicture): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');
        $trick = $objectManager->find($trick->getId());

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($trick->getPictures() as $picture)
            {
                $picture->setTrick($trick);
                $picture = $uploadPicture->saveImage($picture);

                $manager->persist($picture);
            }

            $trick->setUpdatedAt(new \DateTime());

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le trick {$trick->getName()} a bien été modifié !"
            );

            return $this->redirectToRoute('home.index', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/edit.html.twig', [
            'form' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * @Route("/trick/delete/{slug}", name="trick.delete")
     * @IsGranted("ROLE_USER")
     * @param Trick $trick
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Trick $trick, ObjectManager $manager): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');
        $trick = $objectManager->find($trick->getId());

        $fileSystem = new Filesystem();

        foreach($trick->getPictures() as $picture)
        {
            $fileSystem->remove($picture->getPath() . '/' . $picture->getName());
        }

        $manager->remove($trick);
        $manager->flush();

        $this->addflash(
            'success',
            "Le trick {$trick->getName()} a été supprimé avec succès !"
        );

        return $this->redirectToRoute('home.index');
    }
}


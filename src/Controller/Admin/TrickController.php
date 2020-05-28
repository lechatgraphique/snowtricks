<?php


namespace App\Controller\Admin;

use App\Entity\Trick;
use App\Entity\User;
use App\Form\NewTrickType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    private ObjectManager $objectManager;
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }
    /**
     * @Route("/admin/tricks", name="admin.tricks.index")
     * @return Response
     */
    public function index(): Response
    {
        $objectManager =  $this->getDoctrine()->getRepository('App:Trick');
        $tricks = $objectManager->findAll();

        return $this->render('admin/index.html.twig', [
            'tricks' => $tricks
        ]);
    }

    /**
     * @Route("/admin/trick/new", name="admin.trick.new")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {

        /** @var User $user */
        $user = $this->getUser();

        $trick = New Trick();

        $form = $this->createForm(NewTrickType::class, $trick)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $trick
                ->setAuthor($user->getFirstName() . ' ' . $user->getLastName())
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setSlug(str_replace(' ', '-', strtolower($trick->getTitle())));

            $mainPictureFile = $form->get('mainPicture')->getData();

            if ($mainPictureFile) {

                $filename = uniqid() . '.' . $mainPictureFile->guessExtension();

                try {
                    $mainPictureFile->move(
                        $this->getParameter('trick_directory'),
                        $filename
                    );
                } catch (FileException $e) { }
                $trick->setMainPicture($filename);
            }


            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture)
            {

                if ($picture) {

                    $filename = uniqid() . '.' . $picture->getFile()->guessExtension();

                    try {
                        $picture->getFile()->move(
                            $this->getParameter('trick_directory'),
                            $filename
                        );
                    } catch (FileException $e) { }
                    $picture->setPath($filename);
                    $picture->setTrick($trick);
                }
            }

            $this->getDoctrine()->getManager()->persist($trick);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'le Trick à bien été ajoutée');

            return $this->redirectToRoute("admin.tricks.index");
        }

        return $this->render('admin/trick/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/tricks/{slug}/edit", name="admin.trick.edit")
     * @param Trick $trick
     * @param Request $request
     * @return Response
     */
    public function edit(Trick $trick, Request $request): Response
    {
        $form = $this->createForm(NewTrickType::class, $trick)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Le Trick à bien été mis à jours !');

            return  $this->redirectToRoute('admin.tricks.index');
        }

        return $this->render('admin/trick/edit.html.twig', [
            'form' => $form->createView(),
            'link' => $trick->getMainPicture()
        ]);
    }

    /**
     * @Route("admin/tricks/{id}/delete", name="admin.trick.delete")
     * @param Trick $trick
     * @return Response
     */
    public function delete(Trick $trick): Response
    {
        $this->objectManager->remove($trick);
        $this->objectManager->flush();

        $this->addFlash('success','Trick supprimée');

        return $this->redirectToRoute('admin.tricks.index');
    }
}

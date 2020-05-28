<?php


namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\EditCategoryType;
use App\Form\EditPasswordType;
use App\Form\NewCategoryType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/admin/categories", name="admin.categories.index")
     * @return Response
     */
    public function index(): Response
    {
        $focus = "categories";

        $objectManager =  $this->getDoctrine()->getRepository('App:Category');
        $categories = $objectManager->findAll();

        return $this->render('admin/index.html.twig', [
            'categories' => $categories,
            'focus' => $focus
        ]);
    }

    /**
     * @Route("/admin/categories/new", name="admin.category.new")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(NewCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $objectManager =  $this->getDoctrine()->getRepository(Category::class);
            $categories = $objectManager->findAll();

            foreach ($categories as $value)
            {
                if($form->get('name')->getData() === $value->getName()) {
                    $this->addFlash('danger', 'La Catégorie existe déjà');
                    return $this->redirectToRoute('admin.category.new');
                }
            }

            $name = strtolower($category->getName());
            $slug = str_replace(' ', '-', $name);

            $category->setName($category->getName());
            $category->setSlug($slug);

            $this->objectManager->persist($category);
            $this->objectManager->flush();

            $this->addFlash('success', 'La catégorie à bien été ajouté !');

            return  $this->redirectToRoute('admin.categories.index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/categories/{slug}/edit", name="admin.category.edit")
     * @param Category $category
     * @param Request $request
     * @return Response
     */
    public function edit(Category $category, Request $request): Response
    {
        $form = $this->createForm(EditCategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $name = strtolower($category->getName());
            $slug = str_replace(' ', '-', $name);

            $category->setSlug($slug);

            $this->objectManager->flush();

            $this->addFlash('success', 'La catégorie à bien été mis à jours !');

            return  $this->redirectToRoute('admin.categories.index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/categories/{id}/delete", name="admin.category.delete")
     * @param Category $category
     * @return Response
     */
    public function delete(Category $category): Response
    {
        $this->objectManager->remove($category);
        $this->objectManager->flush();

        $this->addFlash('success','Catégorie supprimée');

        return $this->redirectToRoute('admin.categories.index');
    }
}

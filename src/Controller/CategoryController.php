<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category", name="category")
     */
    public function category(CategoryRepository $videoRepository)
    {
        return $this->render( 'category/index.html.twig', [
            'videos' => $videoRepository->findAll(),

        ]);
    }

    /**
     * @Route("/", name="list_categories")
     *
     */
    public function categories(CategoryRepository $videoRepository)
    {
        return $this->render( 'category/index.html.twig', [
            'videos' => $videoRepository->findAll(),

        ]);
    }



    /**
     * @Route("/categories/{id}", name="details_categories")
     */
    public function details(int $id, categoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        return $this->render( 'category/detail.html.twig', [
            'category' => $category,


        ]);
    }

    /** @Route("/user/remove/{id}", name="remove_category")
     *  @ParamConverter("category", options={"mapping"={"id"="id"}})
     */
    public function remove(category $category, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($category);
        $entityManager ->flush();
        return $this->redirectToRoute('list_categories');
    }

    /**
     * @Route("/categories/edit/{id}", name="edit_category")
     * @ParamConverter("category", options={"mapping"={"id"="id"}})
     */
    public function update(Request $request, category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('notice', 'Your category is update!');
            return $this->redirectToRoute('list_categories');
        }
        return $this->render('category/edit.html.twig', array(
            'form' => $form->createView(),
            'category' => $category,
        ));
    }
}

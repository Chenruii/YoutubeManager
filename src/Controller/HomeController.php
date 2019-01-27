<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(Request $request, AuthenticationUtils $authenticationUtils)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/user", name="user_id")
     */
    public function users(Request $request,User $user)
    {
        return $this->render('home/index.html.twig', [
            'user' => 'user_id',
        ]);
    }


    /**
     * @Route("/user", name="user")
     */
    public function user(UserRepository $userRepository)
    {
        return $this->render( 'home/index.html.twig', [
            'users' => $userRepository->findAll(),

        ]);
    }

    /**
     * @Route("/category", name="category")
     */
    public function category(CategoryRepository $videoRepository)
    {
        return $this->render( 'category/index.html.twig', [
            'categories' => $videoRepository->findAll(),

        ]);
    }

    /**
     * @Route("/", name="list_categories")
     *
     */
    public function categories(CategoryRepository $videoRepository)
    {
        return $this->render( 'category/index.html.twig', [
            'categories' => $videoRepository->findAll(),

        ]);
    }

}

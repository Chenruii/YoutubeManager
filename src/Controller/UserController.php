<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user  = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);    // file attente
            $entityManager->flush();            // execute file attente
            // type can be anything, for example : notice, warning, error...
            $this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('home');
        }

        $users = $userRepository->findAll() ;

        return $this->render('user/index.html.twig', array(
            'form' => $form->createView(),
            'users' =>$users,
        ));
    }

    /**
     * @Route("/user", name="list_user")
     */
    public function liste(UserRepository $userRepository,User $user)
    {
        return $this->render( 'home/index.html.twig',array(
            'users' => $userRepository->findAll(),
        ));
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     *
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user)
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/user/remove/{id}", name="remove_user")
     */
    public function remove(User $user, EntityManager $entityManager)
    {
        $videos = $user->getVideos();
        foreach ($videos as $video){
            $video->setUser(null);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }
}

<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request,UserRepository $userRepository)
    {

        $user = new User();

        $form = $this->createForm(UserType::class ,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
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
     * @Route("/user", name="liste_user")
     */
    public function liste(UserRepository $userRepository)
    {
        return $this->render( 'home/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user)
    {
        return $this->render('home/index.html.twig');
    }
}

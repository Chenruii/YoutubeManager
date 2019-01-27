<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginUserType;
use App\Form\ProfileUserType;
use App\Form\RegisterUserType;
use App\Form\VideoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('notice', 'Register valited');
            return $this->redirectToRoute('login');

//            return $this->redirectToRoute('register');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $user = new User();

        $form = $this->createForm(LoginUserType::class, $user);
        return $this->render('security/login.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request,EntityManagerInterface $entityManager,UserRepository $userRepository)
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('home');   }
        return $this->render('security/profile.html.twig', [
            'form' => $form->createView(),
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }
        $user->setFirstname('New Video title!');
        $entityManager->flush();
        $form = $this->createForm(VideoType::class, $user);
        return $this->redirectToRoute('user_view', [
            'form' => $form->createView(),
            'id' => $user->getId()
        ]);
    }


}

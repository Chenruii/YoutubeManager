<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\UserType;
use App\Form\VideoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



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
            //$this->addFlash('notice', 'Your changes were saved!');
            return $this->redirectToRoute('home');
        }

        $users = $userRepository->findAll() ;
        return $this->render('user/index.html.twig', array(
            'form' => $form->createView(),
            'users' =>$users,
        ));
    }

    /**
     * @Route("/user", name="user")
     */
    public function user(UserRepository $userRepository)
    {
        return $this->render( 'video/index.html.twig', [
            'videos' => $userRepository->findAll(),

        ]);
    }

    /**
     * @Route("/", name="list_users")
     *
     */
    public function users(UserRepository $userRepository)
    {
        return $this->render( 'video/index.html.twig', [
            'videos' => $userRepository->findAll(),

        ]);
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
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
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
        return $this->redirectToRoute('list_videos');
    }

    /**
     * @Route("/videos/edit/{id}", name="edit_video")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */
    public function update(Request $request, Video $video)
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            $this->addFlash('notice', 'Your video is update!');
            return $this->redirectToRoute('list_videos');
        }
        return $this->render('video/edit_video.html.twig', array(
            'form' => $form->createView(),
            'video' => $video,
        ));
    }
}

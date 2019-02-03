<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use App\Form\UserType;
use App\Form\VideoType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class UserController
 * @package App\Controller
 *
 *  User can see /create video/user
 *  edit video / user
 *  remove video
 */

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $user = new User();

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

        $users = $userRepository->findAll();
        return $this->render('user/video.html.twig', array(
            'form' => $form->createView(),
            'users' => $users,
        ));
    }

    /**
     * @Route("/user", name="user")
     */
    public function user(UserRepository $userRepository)
    {
        return $this->render('video/video.html.twig', [
            'videos' => $userRepository->findAll(),

        ]);
    }

    /**
     * @Route("/", name="list_users")
     *
     */
    public function users(UserRepository $userRepository)
    {
        return $this->render('video/video.html.twig', [
            'videos' => $userRepository->findAll(),

        ]);
    }


    /**
     * @Route("/user", name="list_user")
     */
    public function liste(Request $request, EntityManager $entityManager)
    {
        $user = $this->getUser();
        $videos = $this->getDoctrine()->getRepository(Video::class)->findBy(array('user' => $user));

        return $this->render('home/video.html.twig', array(
            'videos' => $videos,
        ));
    }

    /**
     * @Route("/user/{byFirstname}", name="user_firstname")
     * @ParamConverter("user", options={"mapping"={"byFirstname"="firstname"}})
     *
     */
    public function firstname(Request $request, UserRepository $userRepository, User $user)
    {
        return $this->render('home/video.html.twig');
    }

    /**
     * @Route("/user/remove/{id}", name="remove_user")
     */
    public function remove(User $user, EntityManager $entityManager)
    {
        $videos = $user->getVideos();
        foreach ($videos as $video) {
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
    public function update(Request $request, Video $video, EntityManager $entityManager, LoggerInterface $logger)
    {
        if ($video->getUser() === $this->getUser()) {
            $user = $this->getUser();

            $form = $this->createForm(VideoType::class, $video);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
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
}

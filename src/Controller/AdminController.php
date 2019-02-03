<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Video;
use App\Form\CategoryType;
use App\Form\ProfileUserType;
use App\Form\VideoType;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/*
 *  @Security("has_role('ROLE_ADMIN')")
 *  Admin can see all user/category and create
 *  edit user/video/category
 *  remove user/video/category
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * list all user and video
     */
    public function user()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        return $this->render('admin/user.html.twig', [
            'users'=>$users,
            'videos'=>$videos,
        ]);
    }

    /**
     * @Route("/admin/user/profile-{byId}", name="update_profile")
     * @ParamConverter("user", options={"mapping"={"byId"="id"}})
     */
    public function updateUser(Request $request, User $user, EntityManagerInterface $entityManager){
        $form = $this->createForm(ProfileUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'User updated !');
            return $this->redirectToRoute('admin_users');
        }
        return $this->render('security/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/user/remove/{id}", name="remove_user")
     * @ParamConverter("user", options={"mapping"={"id"="id"}})
     */
    public function removeUser(User $user, EntityManagerInterface $entityManager)
    {
        $videos = $user->getVideos();
        foreach ($videos as $video){
            $video->setUser(null);
        }
        $entityManager->remove($user);
        $entityManager ->flush();
        $this->addFlash('success', 'User removed!');
        return $this->redirectToRoute('home');
    }



    /**
     * @Route("/admin/category", name="category")
     */
    public function category()
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('admin/category.html.twig', [
            'category'=>$category,
        ]);
    }

    /**
     * @Route("/admin/category/create", name="create_category")
     */
    public function createCategory(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Category created !');
// $this->redirectToRoute(‘register_sucess’);
        }
        return $this->render('admin/create_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /*
     *  edit category
     */
    public function updateCategory(Category $category, Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Category updated !');
            $this->redirectToRoute('admin_category');
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /*
     * Remove category
     */
    public function removeCategory(Category $category, EntityManagerInterface $entityManager, Video $video)
    {
        $videos = $category->getVideos();
        $entityManager->remove($category);
        $entityManager ->flush();
        $this->addFlash('success', 'Category removed!');
        return $this->redirectToRoute('home');
    }


    /**
     * @Route("/admin/videos", name="admin_videos")
     */
    public function videos()
    {
        $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        return $this->render('admin/video.html.twig', [
            'videos'=>$videos,
        ]);
    }

    /**
     * @Route("/admin/video/profile-{byId}", name="video_profile_update")
     * @ParamConverter("video", options={"mapping"={"byId"="id"}})
     */
    public function updateVideo(Video $video, Request $request, EntityManagerInterface $entityManager, LoggerInterface $logger){
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $video->getUrl();
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
                $embed = $matches[1];
                $video->setUrl('https://www.youtube.com/embed/' . $embed);
                $entityManager->persist($video);
                $entityManager->flush();
                $this->addFlash('success', 'Video updated !');
                $logger->info('Video updated ! User email :' . $this->getUser()->getEmail() . ', title :' . $video->getTitle() . ', id :' . $video->getId());
                $this->redirectToRoute('admin_users');
            }
            else{
                $this->addFlash('error', 'Wrong URL !');
            }
        }
        return $this->render('video/video.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("admin/video/remove/{id}", name="admin_video_remove")
     * @ParamConverter("video", options={"mapping"={"id"="id"}})
     */
    public function removeVideo
    (Video $article, EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $entityManager ->remove($article);
        $entityManager ->flush();
        $logger->info('Video removed ! User email :'.$this->getUser()->getEmail().', title :'.$article->getTitle().', id :'.$article->getId());
        $this->addFlash('success', 'Video removed !');
        return $this->redirectToRoute( 'home');
    }
}

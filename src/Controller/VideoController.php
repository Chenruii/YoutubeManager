<?php

namespace App\Controller;



use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();

        // get all entities from Video table
        $videos = $em->getRepository(Video:: class)->findAll();

        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
            'videos' => '$videos',

        ]);
    }

    /**
     * @Route("/video", name="video")
     */
    public function video(VideoRepository $videoRepository)
    {
        return $this->render( 'video/index.html.twig', [
            'videos' => $videoRepository->findAll(),

        ]);
    }

    /**
     * @Route("/", name="list_videos")
     *
     */
    public function videos(VideoRepository $videoRepository)
    {
        return $this->render( 'video/index.html.twig', [
            'videos' => $videoRepository->findAll(),

        ]);
    }


    /**
     * @Route("/videos/{id}", name="details_videos")
     */
    public function details(int $id, VideoRepository $videoRepository)
    {
        $video = $videoRepository->find($id);
        return $this->render( 'video/detail_video.html.twig', [
            'video' => $video,


        ]);
    }

    /** @Route("/user/remove/{id}", name="remove_video")
     *  @ParamConverter("video", options={"mapping"={"id"="id"}})
     */
    public function remove(Video $video, EntityManagerInterface $entityManager)
    {

        $entityManager->remove($video);
        $entityManager ->flush();
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

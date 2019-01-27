<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request,UserRepository $userRepository,VideoRepository $videoRepository)
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
            'videos' => $videoRepository->findAll(),
        ]);
    }
}

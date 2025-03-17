<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')] // Vérifie que l'utilisateur est connecté
    public function index(): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté
        return $this->render('home.html.twig', [
            'user' => $user,
        ]);
    }
}


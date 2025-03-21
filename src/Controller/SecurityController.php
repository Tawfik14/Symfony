<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: "/login", name: "app_login")]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        // Debugging : Vérifier les données envoyées
        dump($request->request->all());

        // Récupération des erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername ?? '', // Empêche NULL
            'error' => $error
        ]);
    }

    #[Route(path: "/logout", name: "app_logout")]
    public function logout(): void
    {
        // Symfony gère la déconnexion automatiquement
        throw new \Exception('Ce point de sortie ne devrait jamais être atteint !');
    }
}


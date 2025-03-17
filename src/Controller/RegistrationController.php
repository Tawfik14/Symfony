<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        dump($request->request->all()); // 🔥 Vérifie si le formulaire est soumis
        // die(); // Décommente pour tester si cette ligne s'affiche bien

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Vérifier si l'email existe déjà
                $existingUserByEmail = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
                if ($existingUserByEmail) {
                    $this->addFlash('error', 'Cet email est déjà utilisé. Veuillez en choisir un autre.');
                } else {
                    // Vérifier si le pseudo existe déjà
                    $existingUserByPseudo = $entityManager->getRepository(User::class)->findOneBy(['pseudo' => $user->getPseudo()]);
                    if ($existingUserByPseudo) {
                        $this->addFlash('error', 'Ce pseudo est déjà pris. Veuillez en choisir un autre.');
                    } else {
                        // Hasher le mot de passe
                        $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
                        $user->setPassword($hashedPassword);

                        // Enregistrer l'utilisateur
                        $entityManager->persist($user);
                        $entityManager->flush();

                        // Message de succès et redirection
                        $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
                        return $this->redirectToRoute('app_login');
                    }
                }
            } else {
                $this->addFlash('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}


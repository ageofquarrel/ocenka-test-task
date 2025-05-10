<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Контроллер аутентификации.
 */
class AuthController extends AbstractController
{
    /**
     * Аутентификация.
     */
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authUtils): Response
    {
        $form = $this->createForm(LoginType::class, null, [
            'action' => $this->generateUrl('app_login'),
            'method' => 'POST',
            'csrf_protection' => true,
            'csrf_token_id' => 'authenticate',
            'csrf_field_name' => '_csrf_token',
            'attr' => ['id' => 'login-form'],
        ]);

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * Выход из системы.
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
    }
}
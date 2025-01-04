<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request $request,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $jwtManager,
        UserPasswordHasherInterface $passwordHasher,
        RefreshTokenManagerInterface $refreshTokenManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validation des données d'entrée
        if (!isset($data['email'], $data['password'])) {
            return new JsonResponse(['message' => 'Email et mot de passe requis.'], 400);
        }

        // Recherche de l'utilisateur
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['message' => 'Identifiants invalides.'], 401);
        }

        // Génération du token JWT
        $token = $jwtManager->create($user);

        // Génération ou récupération du refresh token
        $refreshToken = $refreshTokenManager->getLastFromUsername($user->getEmail());
        if (!$refreshToken) {
            $refreshToken = new RefreshToken();
            $refreshToken->setRefreshToken(bin2hex(random_bytes(32)));
            $refreshToken->setUsername($user->getEmail());
            $refreshToken->setValid((new \DateTime())->modify('+30 days'));
            $refreshTokenManager->save($refreshToken);
        }

        // Réponse avec le token JWT et le refresh token
        return new JsonResponse([
            'message' => 'Login successful',
            'token' => $token,
            'refresh_token' => $refreshToken->getRefreshToken(),
            'user' => [
                'customId' => $user->getCustomId(),
                'email' => $user->getEmail(),
                'roleName' => $user->getRoleName(),
                'first_name' => $user->getFirstName(),
            ],
        ]);
    }

    #[Route('/check-token', name: 'check_token', methods: ['GET'])]
    public function checkToken(): JsonResponse
    {
        return new JsonResponse(['message' => 'Token valide'], 200);
    }
}

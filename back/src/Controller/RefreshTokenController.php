<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Gesdinet\JWTRefreshTokenBundle\Service\RefreshToken;

class RefreshTokenController
{
    #[Route('/api/token/refresh', name: 'refresh_token', methods: ['POST'])]
    public function refresh(Request $request, RefreshToken $refreshTokenService): JsonResponse
    {
        $refreshToken = $request->get('refresh_token');

        if (!$refreshToken) {
            return new JsonResponse(['error' => 'Missing refresh token'], 400);
        }

        try {
            $token = $refreshTokenService->refresh($refreshToken);
            return new JsonResponse(['token' => $token], 200);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Invalid refresh token'], 401);
        }
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController
{
    #[Route('/{reactRouting}', name: 'frontend', requirements: ['reactRouting' => '^(?!api).*'], defaults: ['vueRouting' => null])]
    public function index(): Response
    {
        $path = __DIR__.'/../../public/dist/index.html';

        if (!file_exists($path)) {
            return new Response('Frontend build not found.', Response::HTTP_NOT_FOUND);
        }
        return new Response(file_get_contents($path));
    }
}

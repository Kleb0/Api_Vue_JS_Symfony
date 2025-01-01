<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController
{
    #[Route('/{vueRouting}', name: 'app_frontend', requirements: ['vueRouting' => '^(?!api).*'], defaults: ['vueRouting' => null])]
    public function index(): Response
    {
        return new Response(file_get_contents(__DIR__.'/../../public/dist/index.html'));
    }
}

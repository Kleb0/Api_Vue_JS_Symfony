<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;

class DebugController extends AbstractController
{
    #[Route('/routes', name: 'api_routes', methods: ['GET'])]
    public function listRoutes(RouterInterface $router): JsonResponse
    {
        $routes = [];
        foreach ($router->getRouteCollection() as $name => $route) {
            $routes[] = [
                'name' => $name,
                'path' => $route->getPath(),
                'methods' => $route->getMethods(),
            ];
        }

        return new JsonResponse($routes);
    }
}

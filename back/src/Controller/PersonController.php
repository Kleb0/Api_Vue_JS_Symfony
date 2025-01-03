<?php

namespace App\Controller;

use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends AbstractController
{
    #[Route('/persons', name: 'api_persons', methods: ['GET'])]
    public function getPersons(PersonRepository $personRepository): JsonResponse
    {
        dd('API called');
        $persons = $personRepository->findAll();

        $data = [];
        foreach ($persons as $person) {
            $data[] = [
                'id' => $person->getId(),
                'first_name' => $person->getFirstName(),
                'lastname' => $person->getLastname(),
            ];
        }

        return $this->json($data, Response::HTTP_OK, [], []);
    }
}

<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserManagementController extends AbstractController
{
    #[Route('/users', name: 'api_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $entityManager): JsonResponse
    {
        $userRepository = $entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        $data = array_map(function ($user) {
            return [
                'customId' => $user->getCustomId(),
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'roleName' => $user->getRoleName(),
            ];
        }, $users);

        return new JsonResponse($data, 200);
    }

    #[Route('/users/{customId}', name: 'update_user_role', methods: ['PATCH'])]
        public function updateUserRole(
            int $customId,
            Request $request,
            EntityManagerInterface $entityManager
        ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['roleId'])) {
            return new JsonResponse(['message' => 'Role ID is required'], 400);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['customId' => $customId]);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $role = $entityManager->getRepository(Role::class)->find($data['roleId']);

        if (!$role) {
            return new JsonResponse(['message' => 'Role not found'], 404);
        }

        $user->setRole($role);
        $user->setRoleName($role->getName());

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'User role updated successfully',
            'user' => [
                'customId' => $user->getCustomId(),
                'email' => $user->getEmail(),
                'roleName' => $user->getRoleName(),
            ],
        ]);
    }

    #[Route('/users/{customId}/ban', name: 'ban_user', methods: ['DELETE'])]
    public function banUser(
        int $customId,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $user = $entityManager->getRepository(User::class)->findOneBy(['customId' => $customId]);

        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        // Supprime l'utilisateur de la base de données
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'User deleted successfully',
        ]);
    }



}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;


class UserController extends AbstractController
{
    #[Route('/register-user', name: 'register_user', methods: ['POST'])]
    public function registerUser(Request $request, EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['firstName'], $data['lastName'], $data['streetName'],
         $data['streetNumber'], $data['city'], $data['postalCode'])) {
            return new JsonResponse(['message' => 'Données invalides.'], 400);
        }

         // Get the role Admin
         $roleRepository = $entityManager->getRepository(Role::class);
         $adminRole = $roleRepository->findOneBy(['id' => 1]); // ID du rôle ADMIN

         if (!$adminRole) {
            return new JsonResponse(['message' => 'Le rôle ADMIN est introuvable.'], 500);
        }

        $customId = $entityManager->getRepository(User::class)->count([]) + 1;

  
        $user = new User();
        $user->setCustomId($customId);
        $user->setEmail($data['email']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setStreetName($data['streetName']);
        $user->setStreetNumber($data['streetNumber']);
        $user->setCity($data['city']);
        $user->setPostalCode($data['postalCode']);

        //password hashing
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);   
        $user->setPassword($hashedPassword);

        $user->setRole($adminRole); 
        $user->setRoleName('ADMIN'); 
        $user->setRoleId($adminRole->getId());

        $user->setComments('');
        $user->setCommentsId(commentsId: 0);
        $user->setMoviesLiked('');
        $user->setLikes(0);

        // Sauvegarder l'utilisateur dans la base de données
        try {
            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse([
                'message' => 'User registered successfully',
                'user' => [
                    'customId' => $user->getCustomId(),
                    'email' => $user->getEmail(),                
                ],
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Error during registration : ' . $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/login', name: 'login', methods: ['POST'])]
    public function login(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return new JsonResponse(['message' => 'Email et mot de passe requis.'], 400);
        }

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['message' => 'Identifiants invalides.'], 401);
        }

        $apiToken = $user->getApiToken();

        if (!$apiToken) {
            $apiToken = bin2hex(random_bytes(60));
            $user->setApiToken($apiToken);

            try {
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                return new JsonResponse([
                    'message' => 'Error during login : ' . $e->getMessage(),
                ], 500);
            }
        }

        return new JsonResponse([
            'message' => 'Login successful',
            'token' => $apiToken,
            'user' => [
                'customId' => $user->getCustomId(),
                'email' => $user->getEmail(),
                'roleName' => $user->getRoleName(),
                'first_name' => $user->getFirstName(),
                'role_name' => $user->getRoleName(),
            ],
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['POST'])]
    public function logout(Request $request): JsonResponse
    {
        return new JsonResponse(['message' => 'Logout successful'], 200);
    }

    #[Route('/check-token', name: 'check_token', methods: ['GET'])]
    public function checkToken(): JsonResponse
    {
        
        if ($this->getUser()) {
            return new JsonResponse(['message' => 'Token valide dans userController'], 200);
        }

        throw new AuthenticationException('Token invalide ou expiré');
    }
}

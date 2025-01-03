<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{
    #[Route('/register-user', name: 'register_user', methods: ['POST'])]
    public function registerUser(Request $request, EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        // dd('Contrôleur appelé');

        // Connexion à la base de données
        // $connection = $entityManager->getConnection();

        // $stmt = $connection->prepare("
        // INSERT INTO user (custom_id, email, adress, password, role_name, role_id, comments, comments_id, movies_liked, likes)
        // VALUES (:customId, :email, :adress, :password, :roleName, :roleId, :comments, :commentsId, :moviesLiked, :likes)
        // ");

        // try {
        //     $stmt->execute([
        //         'customId' => 123,
        //         'email' => 'test@example.com',
        //         'adress' => '123 Main St',
        //         'password' => 'password123',
        //         'roleName' => 'ADMIN',
        //         'roleId' => 1,
        //         'comments' => '',
        //         'commentsId' => 0,
        //         'moviesLiked' => '',
        //         'likes' => 0,
        //     ]);
        // } catch (\Exception $e) {
        //     return new JsonResponse([
        //         'message' => 'Erreur lors de l\'insertion : ' . $e->getMessage(),
        //     ], 500);
        // }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'], $data['adress'])) {
            return new JsonResponse(['message' => 'Données invalides.'], 400);
        }

         // Récupérer le rôle ADMIN
         $roleRepository = $entityManager->getRepository(Role::class);
         $adminRole = $roleRepository->findOneBy(['id' => 1]); // ID du rôle ADMIN

         if (!$adminRole) {
            return new JsonResponse(['message' => 'Le rôle ADMIN est introuvable.'], 500);
        }

        $customId = $entityManager->getRepository(User::class)->count([]) + 1;

  
        $user = new User();
        $user->setCustomId($customId);
        $user->setEmail($data['email']);

        // Hasher le mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);   
        $user->setPassword($hashedPassword);

        $user->setAdress($data['adress']);
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
                'message' => 'Utilisateur enregistré avec succès.',
                'user' => [
                    'customId' => $user->getCustomId(),
                    'email' => $user->getEmail(),                
                ],
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Erreur lors de l\'enregistrement : ' . $e->getMessage(),
            ], 500);
        }
    }
}

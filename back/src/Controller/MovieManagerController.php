<?php

namespace App\Controller;

use App\Service\ImageUploader;
use App\Entity\Movies;
use App\Entity\MoviesCategories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

class MovieManagerController extends AbstractController
{
    #[Route('/movies_insertion', name: 'movies_insertion', methods: ['POST'])]
    public function moviesInsertion(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'], $data['releaseDate'], $data['summary'], $data['director'], $data['actors'])) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        $movie = new Movies();
        $movie->setTitle($data['title']);
        $movie->setReleaseDate(new \DateTime($data['releaseDate']));
        $movie->setSummary($data['summary']);
        $movie->setDirector($data['director']);
        $movie->setActors($data['actors']);
        $movie->setLikes($data['likes'] ?? 0);

        // Gérer l'image
        if ($request->files->has('image')) {
            $image = $request->files->get('image');
            
            try {
                $imageName = $imageUploader->upload($image);
                $movie->setImage($imageName);
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'Failed to upload image'], 500);
            }
        }

        $entityManager->persist($movie);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Movie inserted successfully'], 201);
    }


    // ------- categories creator -------

    #[Route('/categories_insertions', name: 'categories_insertions', methods: ['POST'])]
    public function categoriesInsertions(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['categoryName'])) {
            return new JsonResponse(['error' => 'Missing categoryName'], 400);
        }

        $existingCategory = $entityManager->getRepository(MoviesCategories::class)
            ->findOneBy(['categoryName' => $data['categoryName']]);

        if ($existingCategory) {
            return new JsonResponse(['error' => 'Category name already exists'], 400);
        }

        $totalCategories = $entityManager->getRepository(MoviesCategories::class)->count([]);
        $customId = $totalCategories + 1;

        $category = new MoviesCategories();
        $category->setCategoryName($data['categoryName']);
        $category->setCustomId($customId);

        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Category inserted successfully', 'customId' => $customId], 201);
    }

    #[Route('/categories-list', name: 'categories_list', methods: ['GET'])]
    public function getCategories(EntityManagerInterface $entityManager): JsonResponse
    {
        $categories = $entityManager->getRepository(MoviesCategories::class)->findAll();
        $data = [];
    
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->getId(),
                'categoryName' => $category->getCategoryName(),
                'customId' => $category->getCustomId(),
            ];
        }
    
        return new JsonResponse($data);
    }

    #[Route('/categories_modify/{customId}', name: 'categories_modify', methods: ['PATCH'])]
    public function modifyCategory(Request $request, EntityManagerInterface $entityManager, int $customId): JsonResponse
    {
        $category = $entityManager->getRepository(MoviesCategories::class)
            ->findOneBy(['customId' => $customId]);

        if (!$category) {
            return new JsonResponse(['error' => 'Category not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['categoryName'])) {
            return new JsonResponse(['error' => 'Missing categoryName'], 400);
        }

        $existingCategory = $entityManager->getRepository(MoviesCategories::class)
            ->findOneBy(['categoryName' => $data['categoryName']]);

        if ($existingCategory && $existingCategory->getCustomId() !== $customId) {
            return new JsonResponse(['error' => 'Category name already exists'], 400);
        }

        $category->setCategoryName($data['categoryName']);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Category updated successfully'], 200);
    }

    #[Route('/categories_delete/{customId}', name: 'categories_delete', methods: ['DELETE'])]
    public function deleteCategory(EntityManagerInterface $entityManager, int $customId): JsonResponse
    {
        $category = $entityManager->getRepository(MoviesCategories::class)
            ->findOneBy(['customId' => $customId]);

        if (!$category) {
            return new JsonResponse(['error' => 'Category not found'], 404);
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Category deleted successfully'], 200);
    }
}

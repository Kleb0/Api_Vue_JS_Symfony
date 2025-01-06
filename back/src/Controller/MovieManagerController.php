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
    #[Route('/movies_insert', name: 'movies_insert', methods: ['POST'])]
    public function insertMovie(Request $request, EntityManagerInterface $entityManager, ImageUploader $imageUploader): JsonResponse
    {
        // Récupérer les données des champs
        $title = $request->request->get('title');
        $releaseDate = $request->request->get('releaseDate');
        $summary = $request->request->get('summary');
        $director = $request->request->get('director');
        $actors = json_decode($request->request->get('actors'), true);
        $categories = json_decode($request->request->get('categories'), true);

        // Vérification des champs obligatoires
        if (!$title || !$releaseDate || !$summary || !$director || !$actors || !$categories) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        // Vérifier si le film existe déjà
        $existingMovie = $entityManager->getRepository(Movies::class)
            ->findOneBy(['title' => $title]);

        if ($existingMovie) {
            return new JsonResponse(['error' => 'Movie with this title already exists'], 400);
        }

        // Calculer l'ID personnalisé
        $totalMovies = $entityManager->getRepository(Movies::class)->count([]);
        $customId = $totalMovies + 1;

        // Créer une nouvelle instance de Movie
        $movie = new Movies();
        $movie->setTitle($title);
        $movie->setCustomId($customId);
        $movie->setReleaseDate(new \DateTime($releaseDate));
        $movie->setSummary($summary);
        $movie->setDirector($director);
        $movie->setActors($actors);
        $movie->setLikes(0); // Valeur par défaut des likes

        // Ajouter les catégories
        foreach ($categories as $categoryId) {
            $category = $entityManager->getRepository(MoviesCategories::class)
                ->findOneBy(['customId' => $categoryId]);
            if ($category) {
                $movie->addCategory($category);
            }
        }

        if ($request->files->has('image')) {
            $image = $request->files->get('image');
            try {
                $imageName = $imageUploader->upload($image);
                // Enregistrer l'URL complète au lieu du chemin relatif
                $movie->setImage($imageName);
            } catch (FileException $e) {
                return new JsonResponse(['error' => 'Failed to upload image'], 500);
            }
        }

        // Persister le film dans la base de données
        $entityManager->persist($movie);
        $entityManager->flush();

        return new JsonResponse(['success' => 'Movie created successfully'], 201);
    }

    #[Route('/movies_list', name: 'movies_list', methods: ['GET'])]
    public function listMovies(EntityManagerInterface $entityManager): JsonResponse
    {
        $movies = $entityManager->getRepository(Movies::class)->findAll();
        $data = [];

        foreach ($movies as $movie) {
            $data[] = [
                'id' => $movie->getId(),
                'customId' => $movie->getCustomId(),
                'title' => $movie->getTitle(),
                'releaseDate' => $movie->getReleaseDate()->format('Y-m-d'),
                'summary' => $movie->getSummary(),
                'director' => $movie->getDirector(),
                'categories' => array_map(fn($cat) => $cat->getCustomId(), $movie->getCategories()->toArray()),
                'actors' => $movie->getActors(),
                'likes' => $movie->getLikes(),
                // 'image' => $this->getParameter('base_url') . $movie->getImage(),
                'image'=> $this->getParameter('base_url') . '/' . $movie->getImage(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/movies_insert', name: 'movies_insert_options', methods: ['OPTIONS'])]
    public function preflightMoviesInsert(): JsonResponse
    {
        return new JsonResponse(null, 204, [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, PATCH, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, Accept, X-Requested-With',
        ]);
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

    //test

}

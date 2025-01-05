<?php

namespace App\Repository;

use App\Entity\MoviesCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MoviesCategories>
 *
 * @method MoviesCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoviesCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoviesCategories[]    findAll()
 * @method MoviesCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoviesCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MoviesCategories::class);
    }

    // Ajoutez vos méthodes personnalisées ici si nécessaire
}

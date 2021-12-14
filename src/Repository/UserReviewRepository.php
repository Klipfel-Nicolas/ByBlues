<?php

namespace App\Repository;

use App\Entity\UserReview;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserReview|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserReview|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserReview[]    findAll()
 * @method UserReview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserReview::class);
    }
}

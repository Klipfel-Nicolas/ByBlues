<?php

namespace App\Repository;

use App\Entity\BaseTimestampableTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BaseTimestampableTrait|null find($id, $lockMode = null, $lockVersion = null)
 * @method BaseTimestampableTrait|null findOneBy(array $criteria, array $orderBy = null)
 * @method BaseTimestampableTrait[]    findAll()
 * @method BaseTimestampableTrait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaseTimestampableTraitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BaseTimestampableTrait::class);
    }
}

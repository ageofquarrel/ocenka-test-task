<?php

declare(strict_types=1);

namespace App\Repository\Estimate;

use App\Entity\Estimate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Репозиторий оценок.
 *
 * @extends ServiceEntityRepository<Estimate>
 *
 * @method Estimate|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estimate|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estimate[]    findAll()
 * @method Estimate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class EstimateRepository extends ServiceEntityRepository
{
    /**
     * Инициализация.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Estimate::class);
    }

    /**
     * Сохранение оценки.
     */
    public function add(Estimate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

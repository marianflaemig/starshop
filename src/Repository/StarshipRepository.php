<?php

namespace App\Repository;

use App\Entity\Starship;
use App\Model\StarshipModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Starship>
 */
class StarshipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Starship::class);
    }

    /**
     * @return Starship[] Returns an array of Starship objects
     */
    public function findSorted(?string $sortBy, string $direction = 'ASC'): array
    {
        $qb = $this->createQueryBuilder('s');

        if (in_array($sortBy, ['name', 'class', 'captain', 'status'])) {
            $qb->orderBy('s.' . $sortBy, $direction === 'DESC' ? 'DESC' : 'ASC');
        } else {
            $qb->orderBy('s.id', $direction);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * Returns a base QueryBuilder for KnpPaginator to sort and paginate.
     */
    public function getBaseQueryBuilder(): QueryBuilder
    {
        // Must use an alias, 's' in this case.
        return $this->createQueryBuilder('s');
    }

    /**
     * @return QueryBuilder Returns a QueryBuilder for the starship index, including sorting
     */
    public function getQueryBuilderForIndex(?string $sortBy, string $direction = 'ASC'): QueryBuilder
    {
        $qb = $this->createQueryBuilder('s');
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

        $sortMapping = [
            'id'      => 's.id',
            'name'    => 's.name',
            'class'   => 's.class',
            'captain' => 's.captain',
            'status'  => 's.status',
        ];

        if ($sortBy && isset($sortMapping[$sortBy])) {
            $qb->orderBy($sortMapping[$sortBy], $direction);
        } else {
            $qb->orderBy('s.id', 'ASC');
        }

        return $qb;
    }

//    /**
//     * @return Starship[] Returns an array of Starship objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Starship
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Flight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Faker\Provider\DateTime;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Yaml;
use function count;

/**
 * @method Flight|null find($id, $lockMode = null, $lockVersion = null)
 * @method Flight|null findOneBy(array $criteria, array $orderBy = null)
 * @method Flight[]    findAll()
 * @method Flight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlightRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flight::class);
    }


    public function findBySearchQuery(array $searchTerms): ?array
    {
        $queryBuilder = $this->createQueryBuilder('f');

        if (isset($searchTerms['departureDate'])) {
            $queryBuilder->andWhere('f.departureDateTime BETWEEN :start AND :end')
                ->setParameters($searchTerms['departureDate']);
            unset($searchTerms['departureDate']);
        }

        foreach ($searchTerms as $key => $term) {
            $queryBuilder
                ->andWhere('f.' . $key . ' =   :' . $key)
                ->setParameter($key, strtoupper($term));
        }

        return $queryBuilder
            ->orderBy('f.departureDateTime', 'DESC')
            ->getQuery()
            ->getResult();
    }



}

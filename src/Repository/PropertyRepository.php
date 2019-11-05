<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function countAll(): int
    {
        $count = $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return (int) $count;
    }

    public function findLatest(int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('f')
            ->leftJoin('p.photos', 'f')
            ->orderBy('p.id', 'DESC');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    public function findByFilter(int $city, int $operation, int $category, int $page = 1): Pagerfanta
    {
        $qb = $this->createQueryBuilder('p');

        $qb->Where('p.published = 1');

        // City
        if ($city > 0) {
            $qb->andWhere('p.city = '.(int) $city);
        }

        // Operation
        if ($operation > 0) {
            $qb->andWhere('p.operation = '.(int) $operation);
        }

        // Category
        if ($category > 0) {
            $qb->andWhere('p.category = '.(int) $category);
        }

        $qb->orderBy('p.id', 'DESC');

        return $this->createPaginator($qb->getQuery(), $page);
    }

    private function findLimit(): int
    {
        $repository = $this->getEntityManager()->getRepository('App:Settings');
        $limit = $repository->findOneBy(['setting_name' => 'items_per_page']);

        return (int) $limit->getSettingValue();
    }

    private function createPaginator(Query $query, int $page): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage($this->findLimit());
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}

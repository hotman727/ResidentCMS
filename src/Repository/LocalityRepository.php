<?php

namespace App\Repository;

use App\Entity\Locality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * @method Locality|null find($id, $lockMode = null, $lockVersion = null)
 * @method Locality|null findOneBy(array $criteria, array $orderBy = null)
 * @method Locality[]    findAll()
 * @method Locality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class LocalityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Locality::class);
    }

    public function countAll()
    {
        $cache = new FilesystemCache();

        if (!$cache->has('localities_count')) {
            $count = $this->createQueryBuilder('l')
            ->select('count(l.id)')
            ->getQuery()
            ->getSingleScalarResult();

            $cache->set('localities_count', $count, 3600);
        }

        return $cache->get('localities_count');
    }
}

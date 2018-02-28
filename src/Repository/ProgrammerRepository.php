<?php

namespace App\Repository;

use App\Entity\Programmer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ProgrammerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Programmer::class);
    }

    
    public function findAllOr($filter = null)
    {
        $result = $this->createQueryBuilder('p');
        if ($filter) {
            $result->where('p.nickname LIKE :filter')
                    // ->orderBy('p.id', 'ASC')
                    // ->setMaxResults(10)
                    ->setParameter('filter', $filter.'%');
        }

        return $result->getQuery()->getResult();
    }
    
}

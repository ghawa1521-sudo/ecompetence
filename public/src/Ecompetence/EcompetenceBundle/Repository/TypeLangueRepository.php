<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TypeLangueRepository extends EntityRepository
{
    public function findOneByDuplicate($libelle)
    {
        return $this->createQueryBuilder('p')
            ->where('p.libelle = :libelle')
            ->setParameter('libelle', $libelle)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
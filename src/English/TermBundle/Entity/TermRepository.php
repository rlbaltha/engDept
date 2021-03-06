<?php

namespace English\TermBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TermRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TermRepository extends EntityRepository
{

    public function currentterms()
    {
        return $this->createQueryBuilder('t')
            ->where('t.type >= :type')
            ->orderBy('t.term')
            ->setParameter('type','1')
            ->getQuery()
            ->getResult()
            ;

    }

    public function findTermsSorted()
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.term','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findTermByType($type)
    {
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    public function findCurrentTerm($term)
    {
        return $this->createQueryBuilder('t')
            ->where('t.term = :term')
            ->setParameter('term', $term)
            ->getQuery()
            ->getSingleResult()
            ;
    }

    public function findDefaultTerm()
    {
        $type =2;
        return $this->createQueryBuilder('t')
            ->where('t.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleResult()
            ;
    }

}
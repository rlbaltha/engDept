<?php

namespace English\DawgspeakBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DefRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DefRepository extends EntityRepository
{
       public function findDefAlpha($alpha)
    {
       $alpha = $alpha.'%';
        return $this->getEntityManager()
            ->createQuery('SELECT d from EnglishDawgspeakBundle:Def d WHERE d.term LIKE ?1 ORDER BY d.term')->setParameter('1',$alpha)->getResult();
    }
}
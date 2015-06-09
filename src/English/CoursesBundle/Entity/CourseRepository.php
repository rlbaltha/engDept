<?php

namespace English\CoursesBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CourseRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CourseRepository extends EntityRepository
{
    
 /**
 * queries for upper by area course listing
 * 
 */
    public function upperbyarea($term, $area)
    {
        return $this->createQueryBuilder('c')
            ->where('c.term = :term')
            ->andWhere('c.area = :area')
            ->setParameter('term', $term)
            ->setParameter('area', '1')
            ->getQuery()
            ->getResult()
            ;

    }


    public function terms()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT t.termName,t.term FROM EnglishTermBundle:Term t ORDER BY t.term DESC')
            ->getResult();

    }
    
   public function findbyname($coursename)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.id,c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.time,c.days,c.term,t.termName FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE c.courseName = ?1 AND c.term=t.term AND t.type > 0')
               ->setParameter('1',$coursename)->getResult();

    }

    public function findByCallTerm($dql_call, $term)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c FROM EnglishCoursesBundle:Course c WHERE (c.callNumber LIKE ?1 or c.callNumber2 LIKE ?1) AND c.term= ?2')
            ->setParameter('1',$dql_call)->setParameter('2',$term)->setMaxResults(1)->getSingleResult();

    }

    public function findFormCourses($courseName)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may,t.termName FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE (LOWER(c.courseName) LIKE ?1 OR LOWER(c.instructorName) LIKE ?1 OR LOWER(c.title) LIKE ?1) AND c.term=t.term AND t.type > 0')
            ->setParameter('1',$courseName)->getResult();

    }

    public function findAllFormCourses($courseName)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may,t.termName FROM EnglishCoursesBundle:Course c  WHERE (LOWER(c.courseName) LIKE ?1 OR LOWER(c.instructorName) LIKE ?1 OR LOWER(c.title) LIKE ?1) ORDER BY c.term Desc')
            ->setParameter('1',$courseName)->getResult();

    }
}
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
   public function upperbyarea1($term)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area = ?2 ORDER BY c.courseName')
               ->setParameter('1',$term)->setParameter('2','1')->getResult();

    }

   public function upperbyarea2($term)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area = ?2 ORDER BY c.courseName')
               ->setParameter('1',$term)->setParameter('2','2')->getResult();

    }

   public function upperbyarea3($term)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area = ?2 ORDER BY c.courseName')
               ->setParameter('1',$term)->setParameter('2','3')->getResult();

    }

   public function upperbyarea4($term)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area = ?2 ORDER BY c.courseName')
               ->setParameter('1',$term)->setParameter('2','4')->getResult();

    }

   public function upperbyarea5($term)
    {
       return $this->getEntityManager()
               ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area = ?2 ORDER BY c.courseName')
               ->setParameter('1',$term)->setParameter('2','5')->getResult();

    }

   public function currentterms()
    {
       return $this->getEntityManager()
               ->createQuery('SELECT t.termName,t.term FROM EnglishTermBundle:Term t WHERE t.type >= ?1 ORDER BY t.term')
               ->setParameter('1','1')->getResult();

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
            ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE (LOWER(c.courseName) LIKE ?1 OR LOWER(c.instructorName) LIKE ?1 OR LOWER(c.title) LIKE ?1) AND c.term=t.term AND t.type > 0')
            ->setParameter('1',$courseName)->getResult();

    }

    public function findAllFormCourses($courseName)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c  WHERE (LOWER(c.courseName) LIKE ?1 OR LOWER(c.instructorName) LIKE ?1 OR LOWER(c.title) LIKE ?1) ORDER BY c.term Desc')
            ->setParameter('1',$courseName)->getResult();

    }
}
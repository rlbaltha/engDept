<?php

namespace English\PeopleBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PeopleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PeopleRepository extends EntityRepository
{

    public function findPeopleByUsername($username)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p  WHERE p.username = ?1")
            ->setParameters(array('1' => $username))->getSingleResult();
    }

    public function findPeopleByLastname($lastname)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p join p.gradinfo g WHERE LOWER(p.lastName) LIKE ?1 AND g.status!='Inactive' ORDER BY p.lastName,p.firstName")
            ->setParameters(array('1' => $lastname))->getResult();
    }

    public function findPeopleIndex()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM
            EnglishPeopleBundle:People p JOIN p.position o WHERE o.position = 'Faculty' ORDER BY p.lastName,p.firstName")
            ->getResult();
    }

    public function findPeopleByArea($area)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p JOIN p.position o JOIN p.area a WHERE o.position = 'Faculty' AND a.id = ?1 ORDER BY p.lastName,p.firstName")
            ->setParameter('1', $area)->getResult();
    }

    public function findPeopleByType($typeWc)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p JOIN p.position o WHERE o.position = ?1 ORDER BY p.lastName,p.firstName")
            ->setParameter('1', $typeWc)->getResult();
    }


    public function findPeopleCourses($id)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.may,c.building,c.room,t.termName,t.term
             FROM EnglishCoursesBundle:Course c, EnglishPeopleBundle:People p, EnglishTermBundle:Term t
             WHERE LOWER(c.instructorName) = LOWER(p.oasisname) AND c.term = t.term AND t.type = '2' AND p.id = ?1 ORDER BY t.termName,c.courseName")
            ->setParameter('1', $id)->getResult();
    }

    public function findGradCom($userid)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p.lastName,p.firstName,g.frole,g.id FROM EnglishGradcomBundle:Gradcom g JOIN g.people p WHERE g.gid = ?1 ORDER BY p.lastName")
            ->setParameter('1', $userid)->getResult();
    }

    public function findGrads()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p WHERE p.gradinfo != 3 AND p.gradinfo != 4 ORDER BY p.lastName,p.firstName")
            ->getResult();
    }

    public function findGradsByAdvisor($people)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishGradcomBundle:Gradcom g,EnglishPeopleBundle:People p WHERE g.gid=p.id AND
            g.people = ?1 ORDER BY p.lastName")
            ->setParameter('1',$people)->getResult();
    }

    public function findGradFaculty()
    {
        return $this->getEntityManager()
            ->createQuery("SELECT p FROM EnglishPeopleBundle:People p join p.position o WHERE o.position='Graduate Faculty' ORDER BY p.lastName,p.firstName")
            ->getResult();
    }

    public function findGradComm($people)
    {
        return $this->getEntityManager($people)
            ->createQuery("SELECT p.lastName,p.firstName,g.frole,g.id FROM EnglishGradcomBundle:Gradcom g JOIN g.people p WHERE g.gid = ?1 ORDER BY p.lastName")
            ->setParameter('1', $people)->getResult();
    }

    public function findGradNotes($id, $userid)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT g FROM EnglishGradnotesBundle:Gradnotes g WHERE g.gid = ?1 AND g.userid = ?2
            ORDER BY g.created DESC")
            ->setParameter('1', $id)->setParameter('2', $userid)->getResult();
    }


}
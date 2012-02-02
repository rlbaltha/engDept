<?php

namespace English\CoursesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Courses Public controller.
 *
 * @Route("/listings")
 */

class DefaultController extends Controller
{
    /**
     * Lists all Courses.
     *
     * @Route("/", name="listings")
     * @Template()
     */
    public function indexAction()
    {
        $currentTerm = '201202';
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id FROM English\CoursesBundle\Entity\Course c WHERE c.term = ?1 ORDER BY c.courseName";
        $courses = $em->createQuery($dql1)->setParameter('1','201202')->getResult();
        $dql2 = "SELECT t.termName,t.term FROM English\TermBundle\Entity\Term t WHERE t.type >= ?1 ORDER BY t.term";
        $terms = $em->createQuery($dql2)->setParameter('1','1')->getResult();
        return $this->render('EnglishCoursesBundle:Default:index.html.twig', array('courses' => $courses,'terms' => $terms,'currentTerm' => $currentTerm)); 
    }
}

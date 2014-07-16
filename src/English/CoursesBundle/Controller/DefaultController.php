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
     * @Template("EnglishCoursesBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        $currentType = 'Upper';
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c, EnglishTermBundle:Term t WHERE c.term = t.term AND t.type = 2 ORDER BY c.courseName";
        $courses = $em->createQuery($dql1)->getResult();
        $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        $dql3 = "SELECT t.termName,t.term FROM English\TermBundle\Entity\Term t WHERE t.type = 2";
        $currentTerm = $em->createQuery($dql3)->getSingleresult();
        return array('courses' => $courses,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType);
    }
 
    /**
     * Finds and displays a Course entity.
     *
     * @Route("/{term}/{type}/list", name="listings_list")
     * @Template()
     */
    public function listAction($term,$type)
    {
        $currentTerm = array('term' => $term);
        $currentType = $type;
        $em = $this->get('doctrine.orm.entity_manager');
        if ($type == 'Upper') {
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area IN ('1','2','3','4','5') ORDER BY c.courseName";
            }
        elseif ($type == 'FYC') {
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.courseName LIKE 'ENGL1%' ORDER BY c.courseName";
            }
        elseif ($type == 'Surveys') {
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and c.area > 'f' ORDER BY c.courseName";
            }
        elseif ($type == 'Graduate') {
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 and (c.courseName LIKE 'ENGL5%' or c.courseName LIKE 'ENGL6%' or c.courseName LIKE 'ENGL7%' or c.courseName LIKE 'ENGL8%' or c.courseName LIKE 'ENGL9%' ) ORDER BY c.courseName";
            }
        else {
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c WHERE c.term = ?1 ORDER BY c.courseName";
            }
        $courses = $em->createQuery($dql1)->setParameter('1', $term)->getResult();
        $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        return $this->render('EnglishCoursesBundle:Default:index.html.twig', array('courses' => $courses,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType)); 
            
    } 

    /**
     * Finds and displays a Description.
     *
     * @Route("/{callNumber}/{term}/detail", name="listings_detail")
     * @Template()
     */    
    public function courseDetailAction($callNumber,$term)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql_call = '%'.$callNumber.'%';
        $dql1 = "SELECT d.id,d.userid,d.description,d.assignments,d.requirements,d.grading,d.attendance,d.material,d.makeup,d.url FROM EnglishDescriptionsBundle:Description d WHERE d.callNumber LIKE ?1 AND d.term = ?2";
        $courseDetail = $em->createQuery($dql1)->setParameter('1', $dql_call)->setParameter('2', $term)->getResult();
        $callNumber = $callNumber;
        return $this->render('EnglishCoursesBundle:Default:detail.html.twig', array('courseDetail' => $courseDetail, 'callNumber'=> $callNumber)); 
            
    }     
 
    /**
     * Finds and displays upper division courses by area
     *
     * @Route("/{term}/byarea", name="listings_byarea")
     * @Template()
     */    
    public function byareaAction($term)
    {
        $currentTerm = array('term' => $term);
        $currentType = 'Upper by Area';
        $em = $this->get('doctrine.orm.entity_manager');
        $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        $area1 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea1($term);
        $area2 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea2($term);
        $area3 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea3($term);
        $area4 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea4($term);
        $area5 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea5($term);
        
        return $this->render('EnglishCoursesBundle:Default:byarea.html.twig', array('terms'=> $terms,'currentTerm'=> $currentTerm,'currentType'=> $currentType,'area1' => $area1,'area2' => $area2,'area3' => $area3,'area4' => $area4,'area5' => $area5, )); 
            
    }      
    
}

<?php

namespace English\CoursesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use English\CoursesBundle\Entity\Course;
use English\CoursesBundle\Form\CourseType;

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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $course = new Course();
        $form = $this->createFindForm($course);

        if ($request->getMethod() == 'POST') {
            $currentType = 'Search';
            $form->handleRequest($request);
            $courseName = "%" . $form->get('courseName')->getData() . "%";
            $courseName = strtolower($courseName);
            if ($this->get('security.context')->isGranted('ROLE_USER')) {
                $courses= $em->getRepository('EnglishCoursesBundle:Course')->findAllFormCourses($courseName);
            }
            else {
                $courses= $em->getRepository('EnglishCoursesBundle:Course')->findFormCourses($courseName);
            }



        } else {
            $currentType = 'Upper';
            $dql1 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,c.term,c.building,c.room,c.may FROM EnglishCoursesBundle:Course c, EnglishTermBundle:Term t WHERE c.term = t.term AND t.type = 2 ORDER BY c.courseName";
            $courses = $em->createQuery($dql1)->getResult();
        }
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        }
        else {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->currentterms();
        }
        $dql3 = "SELECT t FROM English\TermBundle\Entity\Term t WHERE t.type = 2";
        $currentTerm = $em->createQuery($dql3)->getSingleResult();
        return array('courses' => $courses,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType, 'search_form' => $form->createView(),);
    }


    /**
     * Creates a find form
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFindForm(Course $course)
    {
        $form = $this->createForm(new CourseType(), $course, array(
            'action' => $this->generateUrl('listings'),
            'method' => 'POST',
        ));
        $form->add('courseName', 'text', array('label' => 'Search', 'attr' => array('size'=>'10','class' => 'form-control', 'placeholder' => 'Course'),));

        return $form;
    }
 
    /**
     * Finds and displays a Course entity.
     *
     * @Route("/{term}/{type}/list", name="listings_list")
     * @Template()
     */
    public function listAction($term,$type)
    {
        $em = $this->getDoctrine()->getManager();
        $dql2 = "SELECT t FROM English\TermBundle\Entity\Term t WHERE t.term = ?1";
        $currentTerm = $em->createQuery($dql2)->setParameter('1', $term)->getSingleResult();

        $currentType = $type;
        $course = new Course();
        $form = $this->createFindForm($course);
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
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        }
        else {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->currentterms();
        }
        return $this->render('EnglishCoursesBundle:Default:index.html.twig', array('courses' => $courses,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType, 'search_form' => $form->createView(),));
            
    } 

    /**
     * Finds and displays a Description.
     *
     * @Route("/{callNumber}/{term}/detail", name="listings_detail", defaults={"callNumber" = "00000"})
     * @Template("EnglishCoursesBundle:Default:detail.html.twig")
     */    
    public function courseDetailAction($callNumber,$term)
    {

        $em = $this->getDoctrine()->getManager();
        $currentType = 'Upper';
        $course = new Course();
        $form = $this->createFindForm($course);
        $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        $dql3 = "SELECT t.termName,t.term FROM English\TermBundle\Entity\Term t WHERE t.type = 2";
        $currentTerm = $em->createQuery($dql3)->getSingleresult();
        $dql_call = '%'.$callNumber.'%';
        $dql1 = "SELECT d FROM EnglishDescriptionsBundle:Description d WHERE d.callNumber LIKE ?1 AND d.term = ?2";
        $courseDetail = $em->createQuery($dql1)->setParameter('1', $dql_call)->setParameter('2', $term)->getResult();
        $course = $em->getRepository('EnglishCoursesBundle:Course')->findByCallTerm($dql_call,$term );
        $user=$this->getUser();

        if ($user) {
            $username=$user->getUsername();
            $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);
            $userid = $people->getId();
        }
        else {
            $people= null;
            $userid = 0;
        }
        return array('people' => $people,'course' => $course,'courseDetail' => $courseDetail, 'callNumber'=> $callNumber,'userid'=> $userid,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType, 'search_form' => $form->createView(),);
            
    }     
 
    /**
     * Finds and displays upper division courses by area
     *
     * @Route("/{term}/byarea", name="listings_byarea")
     * @Template()
     */    
    public function byareaAction($term)
    {
        $em = $this->getDoctrine()->getManager();
        $course = new Course();
        $form = $this->createFindForm($course);
        $dql2 = "SELECT t FROM English\TermBundle\Entity\Term t WHERE t.term = ?1";
        $currentTerm = $em->createQuery($dql2)->setParameter('1', $term)->getSingleResult();
        $currentType = 'Upper by Area';

        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->terms();
        }
        else {
            $terms = $em->getRepository('EnglishCoursesBundle:Course')->currentterms();
        }
        $area1 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea1($term);
        $area2 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea2($term);
        $area3 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea3($term);
        $area4 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea4($term);
        $area5 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea5($term);
        
        return $this->render('EnglishCoursesBundle:Default:byarea.html.twig', array('terms'=> $terms,'currentTerm'=> $currentTerm,'currentType'=> $currentType,'area1' => $area1,'area2' => $area2,'area3' => $area3,'area4' => $area4,'area5' => $area5, 'search_form' => $form->createView(), ));
            
    }      
    
}

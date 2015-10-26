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
        $currrentTerm = $em->getRepository('EnglishTermBundle:Term')->findDefaultTerm();
        $term = $currrentTerm->getTerm();

        $course = new Course();
        $form = $this->createFindForm($course, $term);


        if ($request->getMethod() == 'POST') {
            $currrentTerm = $em->getRepository('EnglishTermBundle:Term')->findCurrentTerm($term);
            $currentType = 'Search';
            $form->handleRequest($request);
            $courseName = "%" . $form->get('courseName')->getData() . "%";
            $courseName = strtolower($courseName);
            $term = $form->get('term')->getData();
            if ($this->get('security.context')->isGranted('ROLE_USER')) {
                $courses= $em->getRepository('EnglishCoursesBundle:Course')->findAllCourses($courseName);
            }
            else {
                $courses= $em->getRepository('EnglishCoursesBundle:Course')->findCourses($courseName, $term);
            }



        } else {

            return $this->redirect($this->generateUrl('listings_list', array('term' => $term, 'type'=> 'Upper')));

        }
        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishTermBundle:Term')->findTermsSorted();
        }
        else {
            $terms = $em->getRepository('EnglishTermBundle:Term')->currentterms();
        }

        return array('courses' => $courses,'terms' => $terms,'currentTerm' => $currrentTerm,'currentType' => $currentType, 'search_form' => $form->createView(),);
    }


    /**
     * Creates a find form
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFindForm(Course $course, $term)
    {
        $form = $this->createForm(new CourseType(), $course, array(
            'action' => $this->generateUrl('listings'),
            'method' => 'POST',
        ));
        $form->add('courseName', 'text', array('label' => 'Search', 'attr' => array('size'=>'10','class' => 'form-control', 'placeholder' => 'Course'),))
            ->add('term', 'hidden', array('data' => $term,));

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

        if ($type =='Areas') {
            return $this->redirect($this->generateUrl('listings_byarea',
              array('term' => $term)));
        }
        $em = $this->getDoctrine()->getManager();
        $currrentTerm = $em->getRepository('EnglishTermBundle:Term')->findCurrentTerm($term);

        $currentType = $type;
        $course = new Course();
        $form = $this->createFindForm($course, $term);
        $courses = $em->getRepository('EnglishCoursesBundle:Course')->findCoursesByType($term, $type);

        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishTermBundle:Term')->findTermsSorted();
        }
        else {
            $terms = $em->getRepository('EnglishTermBundle:Term')->currentterms();
        }
        return $this->render('EnglishCoursesBundle:Default:index.html.twig', array('courses' => $courses,'terms' => $terms,'currentTerm' => $currrentTerm,
            'currentType' => $currentType, 'search_form' => $form->createView(),));
            
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
        $currentTerm = $em->getRepository('EnglishTermBundle:Term')->findCurrentTerm($term);
        $currentType = 'Upper';
        $course = new Course();
        $form = $this->createFindForm($course, $term);
        $terms = $em->getRepository('EnglishTermBundle:Term')->findTermsSorted();
        $call = '%'.$callNumber.'%';
        $courseDetail = $em->getRepository('EnglishDescriptionsBundle:Description')->findDescriptionByCallTerm ($call, $term);
        $courses = $em->getRepository('EnglishCoursesBundle:Course')->findByCallTerm($call,$term );
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
        return array('people' => $people,'courses' => $courses,'courseDetail' => $courseDetail, 'callNumber'=> $callNumber,'userid'=> $userid,'terms' => $terms,'currentTerm' => $currentTerm,'currentType' => $currentType, 'search_form' => $form->createView(),);
            
    }     
 
    /**
     * Finds and displays upper division courses by area
     *
     * @Route("/{term}/Area", name="listings_byarea")
     * @Template()
     */    
    public function byareaAction($term)
    {
        $em = $this->getDoctrine()->getManager();
        $course = new Course();
        $form = $this->createFindForm($course, $term);
        $currentTerm = $em->getRepository('EnglishTermBundle:Term')->findCurrentTerm($term);
        $currentType = 'Areas';

        if ($this->get('security.context')->isGranted('ROLE_USER')) {
            $terms = $em->getRepository('EnglishTermBundle:Term')->findTermsSorted();
        }
        else {
            $terms = $em->getRepository('EnglishTermBundle:Term')->currentterms();
        }
        $area1 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea($term,'1');
        $area2 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea($term,'2');
        $area3 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea($term,'3');
        $area4 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea($term,'4');
        $area5 = $em->getRepository('EnglishCoursesBundle:Course')->upperbyarea($term,'5');
        
        return $this->render('EnglishCoursesBundle:Default:byarea.html.twig', array('terms'=> $terms,'currentTerm'=> $currentTerm,'currentType'=> $currentType,'area1' => $area1,'area2' => $area2,'area3' => $area3,'area4' => $area4,'area5' => $area5, 'search_form' => $form->createView(), ));
            
    }      
    
}

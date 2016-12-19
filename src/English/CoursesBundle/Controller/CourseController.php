<?php

namespace English\CoursesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\CoursesBundle\Entity\Course;
use English\CoursesBundle\Form\CourseType;

/**
 * Course controller.
 *
 * @Route("/course")
 */
class CourseController extends Controller
{
    /**
     * Internal Course listings.  The Default Controller handles public displays.
     *
     * @Route("/", name="course")
     * @Template("EnglishCoursesBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        
        if ($this->get('security.context')->isGranted('ROLE_COURSEADMIN')) {
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT c.id,c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.time,c.days,c.term,t.termName,c.summerterm FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE c.term=t.term AND t.type = 2";
        $courses = $em->createQuery($dql1)->getResult();
      
        
        $form = $this->createFormBuilder(new Course())
            ->add('courseName')
            ->getForm();
        return array('courses' => $courses, 'form' => $form->createView());
        
        }  
        else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername(); 

        $em = $this->getDoctrine()->getManager();
        $oasisname = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getOasisname();  
        $oasisname = '%'.strtolower($oasisname).'%';
        $dql2 = "SELECT c.id,c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.time,c.days,c.term,t.termName,c.summerterm FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE (LOWER(c.instructorName) LIKE ?1) AND c.term=t.term AND t.type >= 1";
        $courses = $em->createQuery($dql2)->setParameter('1',$oasisname)->getResult();
        return array('courses' => $courses);
        }

    }
    

    
     /**
     * Find Course entity.
     *
     * @Route("/find", name="course_find")
     * @Method("post")
     */
    public function findAction()
    {   $request = $this->get('request');
        $postData = $request->request->get('form');
        $coursename = $postData['courseName'];
        
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('EnglishCoursesBundle:Course')->findbyname($coursename);
        
        $form = $this->createFormBuilder(new Course())
            ->add('courseName')
            ->getForm();
        
        if (!$courses) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }
        return $this->render('EnglishCoursesBundle:Course:index.html.twig', array('courses' => $courses, 'form' => $form->createView()));
        }  

        

    /**
     * Displays a form to create a new Course entity.
     *
     * @Route("/new", name="course_new")
     * @Template()
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $currrentTerm = $em->getRepository('EnglishTermBundle:Term')->findDefaultTerm();
        $term = $currrentTerm->getTerm();
        $entity = new Course();
        $entity->setCourseName('ENGL');
        $entity->setBuilding('Park Hall');
        $entity->setInstructorName('Staff');
        $entity->setCallNumber('00000');
        $entity->setTerm($term);
        $entity->setDays('TBA');
        $entity->setTime('TBA');
        $entity->setRoom('TBA');

        $form   = $this->createForm(new CourseType(), $entity);


        return array(
            'entity' => $entity,
            'form'   => $form->createView(),

        );
    }

    /**
     * Creates a new Course entity.
     *
     * @Route("/create", name="course_create")
     * @Method("post")
     * @Template("EnglishCoursesBundle:Course:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $entity  = new Course();
        
        $entity->setUserid($userid);

        $request = $this->getRequest();

        $form    = $this->createForm(new CourseType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('listings_detail', array('callNumber' => $entity->getCallNumber(), 'term' => $entity->getTerm())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Course entity.
     *
     * @Route("/{id}/edit", name="course_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_COURSEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $editForm = $this->createForm(new CourseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Course entity.
     *
     * @Route("/{id}/update", name="course_update")
     * @Method("post")
     * @Template("EnglishCoursesBundle:Course:edit.html.twig")
     */
    public function updateAction($id)
    {
        if (!$this->get('security.context')->isGranted('ROLE_COURSEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);
        $callNumber = $entity->getCallNumber();
        $term = $entity->getTerm();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $editForm   = $this->createForm(new CourseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('listings_detail', array('callNumber' => $callNumber, 'term' => $term)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Course entity.
     *
     * @Route("/{id}/delete", name="course_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {

        if (!$this->get('security.context')->isGranted('ROLE_COURSEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);
        $term = $entity->getTerm();

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Course entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('listings_list', array('term' => $term, 'type' => 'Upper')));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

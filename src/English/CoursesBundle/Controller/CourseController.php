<?php

namespace English\CoursesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     * @Template("EnglishCoursesBundle:Course:index.html.twig")
     */
    public function indexAction()
    {
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT c.id,c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.time,c.days,c.term,t.termName FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE c.term=t.term AND t.type = 2";
        $courses = $em->createQuery($dql1)->getResult();
      
        
        $form = $this->createFormBuilder(new Course())
            ->add('courseName')
            ->getForm();
        return $this->render('EnglishCoursesBundle:Course:index.html.twig', array('courses' => $courses, 'form' => $form->createView()));
        
        }  
        else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername(); 

        $em = $this->getDoctrine()->getEntityManager();
        $oasisname = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getOasisname();  
        $oasisname = '%'.strtolower($oasisname).'%';
        $dql2 = "SELECT c.id,c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.time,c.days,c.term,t.termName FROM EnglishCoursesBundle:Course c,EnglishTermBundle:Term t  WHERE (LOWER(c.instructorName) LIKE ?1) AND c.term=t.term AND t.type >= 1";
        $courses = $em->createQuery($dql2)->setParameter('1',$oasisname)->getResult();
        return array('courses' => $courses);
        }

    }
    
     /**
     * Finds and displays a Description.
     *
     * @Route("/{callNumber}/{term}/detail", name="course_detail")
     * @Template()
     */    
    public function courseDetailAction($callNumber,$term)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql_call = '%'.$callNumber.'%';
        $dql1 = "SELECT d.id,d.userid,d.description,d.assignments,d.requirements,d.grading,d.attendance,d.material,d.makeup,d.url FROM EnglishDescriptionsBundle:Description d WHERE d.callNumber LIKE ?1 AND d.term = ?2";
        $courseDetail = $em->createQuery($dql1)->setParameter('1', $dql_call)->setParameter('2', $term)->getResult();
        $callNumber = $callNumber;
        $term = $term;
        return $this->render('EnglishCoursesBundle:Course:detail.html.twig', array('courseDetail' => $courseDetail, 'callNumber'=> $callNumber, 'term'=>$term)); 
            
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
        
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('EnglishCoursesBundle:Course')->findByCourseName($coursename);
        
        $form = $this->createFormBuilder(new Course())
            ->add('courseName')
            ->getForm();
        
        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }
        return $this->render('EnglishCoursesBundle:Course:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
        }  

        
    /**
     * Finds and displays a Course entity.
     *
     * @Route("/{id}/show", name="course_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Course entity.
     *
     * @Route("/new", name="course_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Course();
        $form   = $this->createForm(new CourseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
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
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Course();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new CourseType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('course_show', array('id' => $entity->getId())));
            
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
        $em = $this->getDoctrine()->getEntityManager();

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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $editForm   = $this->createForm(new CourseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('course_show', array('id' => $id)));
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
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishCoursesBundle:Course')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Course entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('course'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

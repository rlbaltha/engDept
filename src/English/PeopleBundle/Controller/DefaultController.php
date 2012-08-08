<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PeopleBundle\Entity\People;
use English\PeopleBundle\Form\PeopleType;


/**
 * People Public controller.
 *
 * @Route("/directory")
 */

class DefaultController extends Controller
{
    /**
     * Lists all People for directory.
     *
     * @Route("/", name="directory")
     * @Template()
     */
       public function indexAction()
    {
        $heading = 1;
    	$em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM 
            EnglishPeopleBundle:People p JOIN p.position o WHERE o.position = ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1','Faculty')->getResult();
        $areas =  $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people, 'areas' => $areas, 'heading' => $heading,'form' => $form->createView(),)); 
    }

    /**
     * Finds and displays a People by area.
     *
     * @Route("/{area}/area", name="directory_area")
     * @Template()
     */
        public function areaAction($area)
    {
    	$heading = 1;
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p JOIN p.position o JOIN p.area a WHERE o.position = 'Faculty' AND a.id = ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1',$area )->getResult();
        $areas =  $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people,'areas' => $areas, 'heading' => $heading,'form' => $form->createView(),)); 
    }
    
    /**
     * Finds and displays a People by type.
     *
     * @Route("/{type}/type", name="directory_type")
     * @Template()
     */
    public function typeAction($type)
    {
    	$heading = $type;
    	if ($type == 1)    
    		{$typeWc = 'Faculty';}
	elseif ($type == 2)
		{$typeWc = 'Instructor';}
	elseif ($type == 3)
		{$typeWc = 'Administration';}
	elseif ($type == 4)
		{$typeWc = 'Graduate Student';}
	else {$typeWc = 'Retired';}
        $em = $this->get('doctrine.orm.entity_manager');
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p JOIN p.position o WHERE o.position = ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1',$typeWc )->getResult();
        $areas =  $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people,'areas' => $areas,'heading' => $heading,'form' => $form->createView(),)); 
    }  
    
    /**
     * Finds and displays detail of People.
     *
     * @Route("/{id}/detail", name="directory_detail")
     * @Template()
     */    
    public function detailAction($id)
    {
        $heading = 1;
        $form = $this->createFormBuilder(new People())
        ->add('lastName')
        ->getForm();
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.bio,p.photoUrl,p.homepageUrl,p.vitaUrl,p.officeHours FROM EnglishPeopleBundle:People p WHERE p.id = ?1";
        $peopleDetail = $em->createQuery($dql1)->setParameter('1', $id)->getResult();
        $dql2 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,t.termName,t.term FROM EnglishCoursesBundle:Course c, EnglishPeopleBundle:People p, EnglishTermBundle:Term t WHERE c.instructorName = p.oasisname AND c.term = t.term AND t.type = '2' AND p.id = ?1 ORDER BY t.termName,c.courseName";
        $peopleCourses = $em->createQuery($dql2)->setParameter('1', $id)->getResult();
        return $this->render('EnglishPeopleBundle:Default:detail.html.twig', array('peopleDetail' => $peopleDetail,'peopleCourses' => $peopleCourses,'heading' => $heading,'form' => $form->createView(),)); 
            
    } 
    
    
    /**
     * Find People
     *
     * @Route("/find", name="directory_find")
     * @Method("post")
     */
    public function findAction()
    {   
        $heading = 1;
        $request = $this->get('request');
        $postData = $request->request->get('form');
        $lastname = $postData['lastName'] . "%";
        $lastname = strtolower($lastname);
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p join p.gradinfo g WHERE LOWER(p.lastName) LIKE ?1 AND g.status!='Inactive' ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1',$lastname)->getResult();
        $areas =  $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people, 'areas' => $areas,'heading' => $heading, 'form' => $form->createView()));
        }     
    
}

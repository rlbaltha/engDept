<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p WHERE p.position LIKE ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1','%Faculty%')->getResult();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people,'heading' => $heading,)); 
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
    	if ($area == 1)    
    		{$areaWc = '%American%';}
	elseif ($area == 2)
		{$areaWc = '%Medieval%';}
	elseif ($area == 3)
		{$areaWc = '%Rhetoric%';}
	elseif ($area == 4)
		{$areaWc = '%Creative%';}
	elseif ($area == 5)
		{$areaWc = '%Renaissance%';}
	elseif ($area == 6)
		{$areaWc = '%Eighteenth%';}
	elseif ($area == 7)
		{$areaWc = '%Language%';}
	elseif ($area == 8)
		{$areaWc = '%Folklore%';}
	elseif ($area == 9)
		{$areaWc = '%Computing%';}
	elseif ($area == 10)
		{$areaWc = '%Multicultural%';}
	elseif ($area == 11)
		{$areaWc = '%Nineteenth%';}
	else {$areaWc = '%Twentieth%';}
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p WHERE  p.position LIKE '%Faculty%' AND p.area LIKE ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1',$areaWc )->getResult();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people,'heading' => $heading,)); 
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
    		{$typeWc = '%Faculty%';}
	elseif ($type == 2)
		{$typeWc = '%Instructor%';}
	elseif ($type == 3)
		{$typeWc = '%Administration%';}
	elseif ($type == 4)
		{$typeWc = '%Graduate%';}
	else {$typeWc = '%Retired%';}
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p WHERE  p.position LIKE ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1',$typeWc )->getResult();
        return $this->render('EnglishPeopleBundle:Default:index.html.twig', array('people' => $people,'heading' => $heading)); 
    }    
}

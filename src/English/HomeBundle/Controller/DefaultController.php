<?php

namespace English\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Home controller.
 *
 * @Route("/home")
 */
class DefaultController extends Controller
{
    /**
     * Lists all Home entities.
     *
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $startDate = date("Y-m-d") ;
        $endDate = date("Y-m-d", mktime(0,0,0,date("m")+1,date("d"),date("Y")));
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT c.title,c.date,c.time,c.description FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?1 and c.date < ?2 ORDER BY c.date ASC";
        $calendar = $em->createQuery($dql1)->setParameter('1',$startDate)->setParameter('2',$endDate)->getResult();
        $dql2 = "SELECT s FROM EnglishSpotlightBundle:Spotlight s ORDER BY s.sortOrder";
        $spotlight = $em->createQuery($dql2)->getResult();
        $dql3 = "SELECT ss FROM EnglishSlideshowBundle:Slideshow ss";
        $slideshow = $em->createQuery($dql3)->setMaxResults(1)->getResult();
        return $this->render('EnglishHomeBundle:Default:index.html.twig', array('calendar' => $calendar,'spotlight' => $spotlight,'slideshow' => $slideshow,)); 
    }
}

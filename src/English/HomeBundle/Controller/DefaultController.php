<?php

namespace English\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     */
    public function indexAction()
    {
        $startDate = date("Y-m-d") ;
        $endDate = date("Y-m-d", mktime(0,0,0,date("m")+1,date("d"),date("Y")));
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT c.title,c.date,c.time,c.description FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?1 and c.date < ?2 ORDER BY c.date ASC";
        $calendar = $em->createQuery($dql1)->setParameter('1',$startDate)->setParameter('2',$endDate)->getResult();
        $dql2 = "SELECT s FROM EnglishSpotlightBundle:Spotlight s ORDER BY s.sortOrder";
        $spotlight = $em->createQuery($dql2)->setMaxResults(2)->getResult();
        $dql4 = "SELECT s FROM EnglishSpotlightBundle:Spotlight s WHERE s.sortOrder>1";
        $special_spotlight = $em->createQuery($dql4)->getResult();
        $dql3 = "SELECT ss FROM EnglishSlideshowBundle:Slideshow ss ORDER BY ss.sortOrder";
        $slideshow = $em->createQuery($dql3)->getResult();
        shuffle ( $slideshow );
        return $this->render('EnglishHomeBundle:Default:index.html.twig', array('calendar' => $calendar,'spotlight' => $spotlight,
            'special_spotlight' => $special_spotlight,'slideshow' => $slideshow,)); 
    }
    
    /**
     * Lists all Home entities.
     *
     * @Route("/calendar_index", name="calendar_index")
     */
    public function cal_indexAction()
    {
        $startDate = date("Y-m-d") ;
        $endDate = date("Y-m-d", mktime(0,0,0,date("m"),date("d"),date("Y")+1));
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT c.title,c.date,c.time,c.description FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?1 and c.date < ?2 ORDER BY c.date ASC";
        $calendar = $em->createQuery($dql1)->setParameter('1',$startDate)->setParameter('2',$endDate)->getResult();
        return $this->render('EnglishHomeBundle:Default:cal_index.html.twig', array('calendar' => $calendar,));

    }

    /**
     * Lists all Home entities.
     *
     * @Route("/feed", name="home_feed")
     */
    public function feedAction()
    {
        return $this->render('EnglishHomeBundle:Default:feed.html.twig', array());

    }


    /**.
     *
     * @Route("/notfound", name="home_notfound")
     */
    public function notfoundAction()
    {
        throw new NotFoundHttpException("Page not found");
    }


}

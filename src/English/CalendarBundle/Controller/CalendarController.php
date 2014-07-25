<?php

namespace English\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\CalendarBundle\Entity\Calendar;
use English\CalendarBundle\Form\CalendarType;

/**
 * Calendar controller.
 *
 * @Route(" calendar")
 */
class CalendarController extends Controller
{
    
    /**
     * Lists Calendar entities for user.
     *
     * @Route("/", name="calendar")
     * @Template()
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        $em = $this->getDoctrine()->getManager();
        $startDate = date("Y-m-d") ;
        $dql1 = "SELECT c.id,c.title,c.date,c.time,c.description,c.username FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?2 ORDER BY c.date ASC";
        $events = $em->createQuery($dql1)->setParameter('2',$startDate)->setMaxResults(20)->getResult();
        return array('events' => $events);
        } else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
        $em = $this->getDoctrine()->getManager();
        $startDate = date("Y-m-d") ;
        $dql1 = "SELECT c.id,c.title,c.date,c.time,c.description,c.username FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?2  and c.username = ?3 ORDER BY c.date ASC";
        $events = $em->createQuery($dql1)->setParameter('2',$startDate)->setParameter('3',$username)->setMaxResults(20)->getResult();
        return array('events' => $events);
        }

    }    


    /**
     * Displays a form to create a new Calendar entity.
     *
     * @Route("/new", name="calendar_new")
     * @Template()
     */
    public function newAction()
    {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
        $event = new Calendar();
        $event->setUsername($username);
        $event->setDescription('<p>  </p>');
        $form   = $this->createForm(new CalendarType(), $event);

        return array(
            'event' => $event,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Calendar entity.
     *
     * @Route("/create", name="calendar_create")
     * @Method("post")
     * @Template("EnglishCalendarBundle:Calendar:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $event  = new Calendar();
        $request = $this->getRequest();
        $event->setUserid($userid);
        $form    = $this->createForm(new CalendarType(), $event);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar'));
            
        }

        return array(
            'event' => $event,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Calendar entity.
     *
     * @Route("/{id}/edit", name="calendar_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm = $this->createForm(new CalendarType(), $event);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'event'      => $event,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Calendar entity.
     *
     * @Route("/{id}/update", name="calendar_update")
     * @Method("post")
     * @Template("EnglishCalendarBundle:Calendar:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm   = $this->createForm(new CalendarType(), $event);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar'));
        }

        return array(
            'event'      => $event,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Calendar entity.
     *
     * @Route("/{id}/delete", name="calendar_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $event = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

            if (!$event) {
                throw $this->createNotFoundException('Unable to find Calendar entity.');
            }

            $em->remove($event);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('calendar'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

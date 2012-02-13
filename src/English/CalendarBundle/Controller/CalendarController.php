<?php

namespace English\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $em = $this->getDoctrine()->getEntityManager();
        $startDate = date("Y-m-d") ;
        $dql1 = "SELECT c.id,c.title,c.date,c.time,c.description,c.username FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?2 ORDER BY c.date ASC";
        $entities = $em->createQuery($dql1)->setParameter('2',$startDate)->setMaxResults(20)->getResult();
        return array('entities' => $entities);     
        } else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
        $em = $this->getDoctrine()->getEntityManager();
        $startDate = date("Y-m-d") ;
        $dql1 = "SELECT c.id,c.title,c.date,c.time,c.description,c.username FROM EnglishCalendarBundle:Calendar c WHERE c.date >= ?2  and c.username = ?3 ORDER BY c.date ASC";
        $entities = $em->createQuery($dql1)->setParameter('2',$startDate)->setParameter('3',$username)->setMaxResults(20)->getResult();
        return array('entities' => $entities);
        }

    }    

    
    /**
     * Finds and displays a Calendar entity.
     *
     * @Route("/{id}/show", name="calendar_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
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
        $entity = new Calendar();
        $entity->setUsername($username);
        $entity->setDescription('<p>  </p>');
        $form   = $this->createForm(new CalendarType(), $entity);

        return array(
            'entity' => $entity,
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
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();  
        $entity  = new Calendar();
        $request = $this->getRequest();
        $entity->setUserid($userid);
        $form    = $this->createForm(new CalendarType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm = $this->createForm(new CalendarType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Calendar entity.');
        }

        $editForm   = $this->createForm(new CalendarType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('calendar_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
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

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishCalendarBundle:Calendar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Calendar entity.');
            }

            $em->remove($entity);
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

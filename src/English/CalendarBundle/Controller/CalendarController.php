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
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * Lists all Calendar entities.
     *
     * @Route("/", name="calendar")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishCalendarBundle:Calendar')->findAll();

        return array('entities' => $entities);
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
        $entity = new Calendar();
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
        $entity  = new Calendar();
        $request = $this->getRequest();
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

            return $this->redirect($this->generateUrl('calendar_edit', array('id' => $id)));
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

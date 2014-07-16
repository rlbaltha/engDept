<?php

namespace English\PositionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PositionBundle\Entity\Position;
use English\PositionBundle\Form\PositionType;

/**
 * Position controller.
 *
 * @Route("/position")
 */
class PositionController extends Controller
{
    /**
     * Lists all Position entities.
     *
     * @Route("/", name="position")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $positions = $em->getRepository('EnglishPositionBundle:Position')->findAll();

        return array('positions' => $positions);
    }

    /**
     * Finds and displays a Position entity.
     *
     * @Route("/{id}/show", name="position_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $position = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$position) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'position'      => $position,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Position entity.
     *
     * @Route("/new", name="position_new")
     * @Template()
     */
    public function newAction()
    {
        $position = new Position();
        $form   = $this->createForm(new PositionType(), $position);

        return array(
            'position' => $position,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Position entity.
     *
     * @Route("/create", name="position_create")
     * @Method("post")
     * @Template("EnglishPositionBundle:Position:new.html.twig")
     */
    public function createAction()
    {
        $position  = new Position();
        $request = $this->getRequest();
        $form    = $this->createForm(new PositionType(), $position);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($position);
            $em->flush();

            return $this->redirect($this->generateUrl('position'));
            
        }

        return array(
            'position' => $position,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Position entity.
     *
     * @Route("/{id}/edit", name="position_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $position = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$position) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $editForm = $this->createForm(new PositionType(), $position);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'position'      => $position,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Position entity.
     *
     * @Route("/{id}/update", name="position_update")
     * @Method("post")
     * @Template("EnglishPositionBundle:Position:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $position = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$position) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $editForm   = $this->createForm(new PositionType(), $position);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($position);
            $em->flush();

            return $this->redirect($this->generateUrl('position'));
        }

        return array(
            'position'      => $position,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Position entity.
     *
     * @Route("/{id}/delete", name="position_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $position = $em->getRepository('EnglishPositionBundle:Position')->find($id);

            if (!$position) {
                throw $this->createNotFoundException('Unable to find Position entity.');
            }

            $em->remove($position);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('position'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

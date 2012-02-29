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
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishPositionBundle:Position')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Position entity.
     *
     * @Route("/{id}/show", name="position_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
        $entity = new Position();
        $form   = $this->createForm(new PositionType(), $entity);

        return array(
            'entity' => $entity,
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
        $entity  = new Position();
        $request = $this->getRequest();
        $form    = $this->createForm(new PositionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('position'));
            
        }

        return array(
            'entity' => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $editForm = $this->createForm(new PositionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPositionBundle:Position')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Position entity.');
        }

        $editForm   = $this->createForm(new PositionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('position'));
        }

        return array(
            'entity'      => $entity,
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

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishPositionBundle:Position')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Position entity.');
            }

            $em->remove($entity);
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

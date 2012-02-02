<?php

namespace English\GradinfoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\GradinfoBundle\Entity\Gradinfo;
use English\GradinfoBundle\Form\GradinfoType;

/**
 * Gradinfo controller.
 *
 * @Route("/gradinfo")
 */
class GradinfoController extends Controller
{
    /**
     * Lists all Gradinfo entities.
     *
     * @Route("/", name="gradinfo")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Gradinfo entity.
     *
     * @Route("/{id}/show", name="gradinfo_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradinfo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Gradinfo entity.
     *
     * @Route("/new", name="gradinfo_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Gradinfo();
        $form   = $this->createForm(new GradinfoType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Gradinfo entity.
     *
     * @Route("/create", name="gradinfo_create")
     * @Method("post")
     * @Template("EnglishGradinfoBundle:Gradinfo:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Gradinfo();
        $request = $this->getRequest();
        $form    = $this->createForm(new GradinfoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gradinfo_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Gradinfo entity.
     *
     * @Route("/{id}/edit", name="gradinfo_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradinfo entity.');
        }

        $editForm = $this->createForm(new GradinfoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Gradinfo entity.
     *
     * @Route("/{id}/update", name="gradinfo_update")
     * @Method("post")
     * @Template("EnglishGradinfoBundle:Gradinfo:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradinfo entity.');
        }

        $editForm   = $this->createForm(new GradinfoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('gradinfo_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Gradinfo entity.
     *
     * @Route("/{id}/delete", name="gradinfo_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gradinfo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gradinfo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

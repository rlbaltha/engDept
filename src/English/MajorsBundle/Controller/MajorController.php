<?php

namespace English\MajorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\MajorsBundle\Entity\Major;
use English\MajorsBundle\Form\MajorType;

/**
 * Major controller.
 *
 * @Route("/major")
 */
class MajorController extends Controller
{
    /**
     * Lists all Major entities.
     *
     * @Route("/", name="major")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishMajorsBundle:Major')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Major entity.
     *
     * @Route("/{id}/show", name="major_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Major entity.
     *
     * @Route("/new", name="major_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Major();
        $form   = $this->createForm(new MajorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Major entity.
     *
     * @Route("/create", name="major_create")
     * @Method("post")
     * @Template("EnglishMajorsBundle:Major:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Major();
        $request = $this->getRequest();
        $form    = $this->createForm(new MajorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Major entity.
     *
     * @Route("/{id}/edit", name="major_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm = $this->createForm(new MajorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Major entity.
     *
     * @Route("/{id}/update", name="major_update")
     * @Method("post")
     * @Template("EnglishMajorsBundle:Major:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm   = $this->createForm(new MajorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Major entity.
     *
     * @Route("/{id}/delete", name="major_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Major entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('major'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

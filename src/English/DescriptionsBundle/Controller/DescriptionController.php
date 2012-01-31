<?php

namespace English\DescriptionsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\DescriptionsBundle\Entity\Description;
use English\DescriptionsBundle\Form\DescriptionType;

/**
 * Description controller.
 *
 * @Route("/description")
 */
class DescriptionController extends Controller
{
    /**
     * Lists all Description entities.
     *
     * @Route("/", name="description")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishDescriptionsBundle:Description')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Description entity.
     *
     * @Route("/{id}/show", name="description_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Description entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Description entity.
     *
     * @Route("/new", name="description_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Description();
        $form   = $this->createForm(new DescriptionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Description entity.
     *
     * @Route("/create", name="description_create")
     * @Method("post")
     * @Template("EnglishDescriptionsBundle:Description:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Description();
        $request = $this->getRequest();
        $form    = $this->createForm(new DescriptionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('description_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Description entity.
     *
     * @Route("/{id}/edit", name="description_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Description entity.');
        }

        $editForm = $this->createForm(new DescriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Description entity.
     *
     * @Route("/{id}/update", name="description_update")
     * @Method("post")
     * @Template("EnglishDescriptionsBundle:Description:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Description entity.');
        }

        $editForm   = $this->createForm(new DescriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('description_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Description entity.
     *
     * @Route("/{id}/delete", name="description_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Description entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('description'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

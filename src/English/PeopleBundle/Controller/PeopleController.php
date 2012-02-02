<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PeopleBundle\Entity\People;
use English\PeopleBundle\Form\PeopleType;

/**
 * People controller.
 *
 * @Route("/people")
 */
class PeopleController extends Controller
{
    /**
     * Lists all People entities.
     *
     * @Route("/", name="people")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishPeopleBundle:People')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a People entity.
     *
     * @Route("/{id}/show", name="people_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new People entity.
     *
     * @Route("/new", name="people_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new People();
        $form   = $this->createForm(new PeopleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new People entity.
     *
     * @Route("/create", name="people_create")
     * @Method("post")
     * @Template("EnglishPeopleBundle:People:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new People();
        $request = $this->getRequest();
        $form    = $this->createForm(new PeopleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing People entity.
     *
     * @Route("/{id}/edit", name="people_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        $editForm = $this->createForm(new PeopleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing People entity.
     *
     * @Route("/{id}/update", name="people_update")
     * @Method("post")
     * @Template("EnglishPeopleBundle:People:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        $editForm   = $this->createForm(new PeopleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a People entity.
     *
     * @Route("/{id}/delete", name="people_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find People entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('people'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

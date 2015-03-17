<?php

namespace English\PeopleBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PeopleBundle\Entity\Detail;
use English\PeopleBundle\Form\DetailType;

/**
 * Detail controller.
 *
 * @Route("/detail")
 */
class DetailController extends Controller
{

    /**
     * Lists all Detail entities.
     *
     * @Route("/", name="detail")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnglishPeopleBundle:Detail')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Detail entity.
     *
     * @Route("/{id}/create", name="detail_create")
     * @Method("POST")
     * @Template("EnglishPeopleBundle:Detail:new.html.twig")
     */
    public function createAction(Request $request, $id)
    {
        $entity = new Detail();
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);
        $entity->setPeople($people);
        $options = '';
        $form = $this->createCreateForm($entity, $id, $options);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('detail_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Detail entity.
     *
     * @param Detail $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Detail $entity, $id, $options)
    {

        $form = $this->createForm(new DetailType($options), $entity, array(
            'action' => $this->generateUrl('detail_create', array('id' => $id,)),
            'method' => 'POST',
            'attr'=> array('novalidate'=>'novalidate')
        ));
        $form->add('submit', 'submit', array('label' => 'Post','attr' => array('class' => 'btn btn-primary'),));
        return $form;
    }

    /**
     * Displays a form to create a new Detail entity.
     *
     * @Route("/{id}/new", name="detail_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Detail();
        $em = $this->getDoctrine()->getManager();
        $options = '';
        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);
        $entity->setPeople($people);
        $form   = $this->createCreateForm($entity, $id, $options);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Detail entity.
     *
     * @Route("/{id}", name="detail_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishPeopleBundle:Detail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Detail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Detail entity.
     *
     * @Route("/{id}/edit", name="detail_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishPeopleBundle:Detail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Detail entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Detail entity.
    *
    * @param Detail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Detail $entity)
    {
        $form = $this->createForm(new DetailType(), $entity, array(
            'action' => $this->generateUrl('detail_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Detail entity.
     *
     * @Route("/{id}", name="detail_update")
     * @Method("PUT")
     * @Template("EnglishPeopleBundle:Detail:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishPeopleBundle:Detail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Detail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('detail_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Detail entity.
     *
     * @Route("/{id}", name="detail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishPeopleBundle:Detail')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Detail entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('detail'));
    }

    /**
     * Creates a form to delete a Detail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('detail_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace English\TermBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\TermBundle\Entity\Term;
use English\TermBundle\Form\TermType;

/**
 * Term controller.
 *
 * @Route("/term")
 */
class TermController extends Controller
{
    /**
     * Lists all Term entities.
     *
     * @Route("/", name="term")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnglishTermBundle:Term')->findAll();
        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Term entity.
     *
     * @Route("/{id}/show", name="term_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishTermBundle:Term')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Term entity.
     *
     * @Route("/new", name="term_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Term();
        $form   = $this->createForm(new TermType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Term entity.
     *
     * @Route("/create", name="term_create")
     * @Method("post")
     * @Template("EnglishTermBundle:Term:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $entity  = new Term();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new TermType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('term', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Term entity.
     *
     * @Route("/{id}/edit", name="term_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishTermBundle:Term')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }

        $editForm = $this->createForm(new TermType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Term entity.
     *
     * @Route("/{id}/update", name="term_update")
     * @Method("post")
     * @Template("EnglishTermBundle:Term:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishTermBundle:Term')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }

        $editForm   = $this->createForm(new TermType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('term', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Term entity.
     *
     * @Route("/{id}/delete", name="term_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishTermBundle:Term')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Term entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('term'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

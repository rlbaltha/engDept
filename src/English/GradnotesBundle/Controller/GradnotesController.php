<?php

namespace English\GradnotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\GradnotesBundle\Entity\Gradnotes;
use English\GradnotesBundle\Form\GradnotesType;

/**
 * Gradnotes controller.
 *
 * @Route("/gradnotes")
 */
class GradnotesController extends Controller
{
    /**
     * Lists all Gradnotes entities.
     *
     * @Route("/", name="gradnotes")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Gradnotes entity.
     *
     * @Route("/{id}/show", name="gradnotes_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradnotes entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Gradnotes entity.
     *
     * @Route("/{id}/new", name="gradnotes_new")
     * @Template()
     */
    public function newAction($id)
    {
        $entity = new Gradnotes();
        $entity->setGid($id);
        $entity->setNotes('<p></p>');
        $form   = $this->createForm(new GradnotesType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Gradnotes entity.
     *
     * @Route("/create", name="gradnotes_create")
     * @Method("post")
     * @Template("EnglishGradnotesBundle:Gradnotes:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $entity  = new Gradnotes();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new GradnotesType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getGid())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Gradnotes entity.
     *
     * @Route("/{id}/edit", name="gradnotes_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradnotes entity.');
        }

        $editForm = $this->createForm(new GradnotesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Gradnotes entity.
     *
     * @Route("/{id}/update", name="gradnotes_update")
     * @Method("post")
     * @Template("EnglishGradnotesBundle:Gradnotes:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradnotes entity.');
        }

        $editForm   = $this->createForm(new GradnotesType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id'=>$entity->getGid())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Gradnotes entity.
     *
     * @Route("/{id}/delete", name="gradnotes_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gradnotes entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('people_show', array('id'=>$entity->getGid())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

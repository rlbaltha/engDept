<?php

namespace English\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\HomeBundle\Entity\Help;
use English\HomeBundle\Form\HelpType;

/**
 * Help controller.
 *
 * @Route("/help")
 */
class HelpController extends Controller
{
    /**
     * Lists all Help entities.
     *
     * @Route("/", name="help")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EnglishHomeBundle:Help')->listHelp();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Help entity.
     *
     * @Route("/{id}/show", name="help_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishHomeBundle:Help')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Help entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Help entity.
     *
     * @Route("/new", name="help_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Help();
        $entity->setTeaser('<p></p>');
        $entity->setBody('<p></p>');
        $form   = $this->createForm(new HelpType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Help entity.
     *
     * @Route("/create", name="help_create")
     * @Method("post")
     * @Template("EnglishHomeBundle:Help:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Help();
        $request = $this->getRequest();
        $form    = $this->createForm(new HelpType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('help'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Help entity.
     *
     * @Route("/{id}/edit", name="help_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishHomeBundle:Help')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Help entity.');
        }

        $editForm = $this->createForm(new HelpType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Help entity.
     *
     * @Route("/{id}/update", name="help_update")
     * @Method("post")
     * @Template("EnglishHomeBundle:Help:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishHomeBundle:Help')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Help entity.');
        }

        $editForm   = $this->createForm(new HelpType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('help'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Help entity.
     *
     * @Route("/{id}/delete", name="help_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishHomeBundle:Help')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Help entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('help'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

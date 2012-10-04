<?php

namespace English\DawgspeakBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\DawgspeakBundle\Entity\Def;
use English\DawgspeakBundle\Form\DefType;

/**
 * Def controller.
 *
 * @Route("/def")
 */
class DefController extends Controller
{
    /**
     * Lists all Def entities.
     *
     * @Route("/", name="def")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        

        $entities = $em->getRepository('EnglishDawgspeakBundle:Def')->findDef();

        return array('entities' => $entities);
    }
    
    /**
     * Lists all Def entities by alpha.
     *
     * @Route("/{alpha}/list", name="def_list")
     * @Template("EnglishDawgspeakBundle:Def:index.html.twig")
     */
    public function alphaAction($alpha)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $entities = $em->getRepository('EnglishDawgspeakBundle:Def')->findDefAlpha($alpha);

        return array('entities' => $entities);
    }    

    /**
     * Finds and displays a Def entity.
     *
     * @Route("/{id}/show", name="def_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDawgspeakBundle:Def')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Def entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Def entity.
     *
     * @Route("/new", name="def_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Def();
        $form   = $this->createForm(new DefType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Def entity.
     *
     * @Route("/create", name="def_create")
     * @Method("post")
     * @Template("EnglishDawgspeakBundle:Def:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Def();
        $request = $this->getRequest();
        $form    = $this->createForm(new DefType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('def_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Def entity.
     *
     * @Route("/{id}/edit", name="def_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDawgspeakBundle:Def')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Def entity.');
        }

        $editForm = $this->createForm(new DefType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Def entity.
     *
     * @Route("/{id}/update", name="def_update")
     * @Method("post")
     * @Template("EnglishDawgspeakBundle:Def:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishDawgspeakBundle:Def')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Def entity.');
        }

        $editForm   = $this->createForm(new DefType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('def_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Def entity.
     *
     * @Route("/{id}/delete", name="def_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishDawgspeakBundle:Def')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Def entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('def'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

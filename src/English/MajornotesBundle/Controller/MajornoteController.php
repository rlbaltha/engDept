<?php

namespace English\MajornotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\MajornotesBundle\Entity\Majornote;
use English\MajornotesBundle\Form\MajornoteType;

/**
 * Majornote controller.
 *
 * @Route("/majornote")
 */
class MajornoteController extends Controller
{
    /**
     * Lists all Majornote entities.
     *
     * @Route("/", name="majornote")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishMajornotesBundle:Majornote')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Majornote entity.
     *
     * @Route("/{id}/show", name="majornote_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Majornote entity.
     *
     * @Route("/new", name="majornote_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Majornote();
        $form   = $this->createForm(new MajornoteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Majornote entity.
     *
     * @Route("/create", name="majornote_create")
     * @Method("post")
     * @Template("EnglishMajornotesBundle:Majornote:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Majornote();
        $request = $this->getRequest();
        $form    = $this->createForm(new MajornoteType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('majornote_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Majornote entity.
     *
     * @Route("/{id}/edit", name="majornote_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $editForm = $this->createForm(new MajornoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Majornote entity.
     *
     * @Route("/{id}/update", name="majornote_update")
     * @Method("post")
     * @Template("EnglishMajornotesBundle:Majornote:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $editForm   = $this->createForm(new MajornoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('majornote_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Majornote entity.
     *
     * @Route("/{id}/delete", name="majornote_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Majornote entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('majornote'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

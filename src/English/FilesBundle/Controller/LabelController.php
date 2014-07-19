<?php

namespace English\FilesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\FilesBundle\Entity\Label;
use English\FilesBundle\Form\LabelType;

/**
 * Label controller.
 *
 * @Route("/label")
 */
class LabelController extends Controller
{
    /**
     * Lists all Label entities.
     *
     * @Route("/", name="label")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $labels = $em->getRepository('EnglishFilesBundle:Label')->findAll();

        return array(
            'labels' => $labels,
        );
    }

    /**
     * Finds and displays a Label entity.
     *
     * @Route("/{id}/show", name="label_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $label = $em->getRepository('EnglishFilesBundle:Label')->find($id);

        if (!$label) {
            throw $this->createNotFoundException('Unable to find Label entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'label'      => $label,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Label entity.
     *
     * @Route("/new", name="label_new")
     * @Template()
     */
    public function newAction()
    {
        $label = new Label();
        $form   = $this->createForm(new LabelType(), $label);

        return array(
            'label' => $label,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Label entity.
     *
     * @Route("/create", name="label_create")
     * @Method("POST")
     * @Template("EnglishFilesBundle:Label:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $label  = new Label();
        $form = $this->createForm(new LabelType(), $label);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($label);
            $em->flush();

            return $this->redirect($this->generateUrl('label'));
        }

        return array(
            'label' => $label,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Label entity.
     *
     * @Route("/{id}/edit", name="label_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $label = $em->getRepository('EnglishFilesBundle:Label')->find($id);

        if (!$label) {
            throw $this->createNotFoundException('Unable to find Label entity.');
        }

        $editForm = $this->createForm(new LabelType(), $label);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'label'      => $label,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Label entity.
     *
     * @Route("/{id}/update", name="label_update")
     * @Method("POST")
     * @Template("EnglishFilesBundle:Label:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $label = $em->getRepository('EnglishFilesBundle:Label')->find($id);

        if (!$label) {
            throw $this->createNotFoundException('Unable to find Label entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LabelType(), $label);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($label);
            $em->flush();

            return $this->redirect($this->generateUrl('label'));
        }

        return array(
            'label'      => $label,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Label entity.
     *
     * @Route("/{id}/delete", name="label_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $label = $em->getRepository('EnglishFilesBundle:Label')->find($id);

            if (!$label) {
                throw $this->createNotFoundException('Unable to find Label entity.');
            }

            $em->remove($label);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('label'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

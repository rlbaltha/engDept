<?php

namespace English\GradnotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
     * Displays a form to create a new Gradnotes entity.
     *
     * @Route("/{id}/new", name="gradnotes_new")
     * @Template()
     */
    public function newAction($id)
    {
        $gradnote = new Gradnotes();
        $gradnote->setGid($id);
        $gradnote->setNotes('<p></p>');
        $form   = $this->createForm(new GradnotesType(), $gradnote);

        return array(
            'gradnote' => $gradnote,
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
        
        $gradnote  = new Gradnotes();
        
        $gradnote->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new GradnotesType(), $gradnote);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gradnote);
            $em->flush();

            return $this->redirect($this->generateUrl('directory_detail', array('id' => $gradnote->getGid())));
            
        }

        return array(
            'gradnote' => $gradnote,
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

        $gradnote = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

        if (!$gradnote) {
            throw $this->createNotFoundException('Unable to find Gradnotes entity.');
        }

        $editForm = $this->createForm(new GradnotesType(), $gradnote);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'gradnote'      => $gradnote,
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

        $gradnote = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

        if (!$gradnote) {
            throw $this->createNotFoundException('Unable to find Gradnotes entity.');
        }

        $editForm   = $this->createForm(new GradnotesType(), $gradnote);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($gradnote);
            $em->flush();

            return $this->redirect($this->generateUrl('directory_detail', array('id' => $gradnote->getGid())));
        }

        return array(
            'gradnote'      => $gradnote,
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
            $gradnote = $em->getRepository('EnglishGradnotesBundle:Gradnotes')->find($id);

            if (!$gradnote) {
                throw $this->createNotFoundException('Unable to find Gradnotes entity.');
            }

            $em->remove($gradnote);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('directory_detail', array('id' => $gradnote->getGid())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

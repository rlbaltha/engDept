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
     * Displays a form to create a new Description entity.
     *
     * @Route("/{callNumber}/{term}/new", name="description_new")
     * @Template()
     */
    public function newAction($callNumber,$term)
    {
        $description = new Description();
        $description->setCallNumber($callNumber);
        $description->setTerm($term);
        $description->setTopics('f');
        $form   = $this->createForm(new DescriptionType(), $description);
        
        return array(
            'description' => $description,
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
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $description  = new Description();
        
        $description->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new DescriptionType(), $description);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($description);
            $em->flush();

            return $this->redirect($this->generateUrl('listings_detail', array('callNumber' => $description->getCallNumber(), 'term'=>$description->getTerm())));
            
        }

        return array(
            'description' => $description,
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
        $em = $this->getDoctrine()->getManager();

        $description = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

        if (!$description) {
            throw $this->createNotFoundException('Unable to find Description entity.');
        }

        $editForm = $this->createForm(new DescriptionType(), $description);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'description'      => $description,
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
        $em = $this->getDoctrine()->getManager();

        $description = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

        if (!$description) {
            throw $this->createNotFoundException('Unable to find Description entity.');
        }

        $editForm   = $this->createForm(new DescriptionType(), $description);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($description);
            $em->flush();

            return $this->redirect($this->generateUrl('listings_detail', array('callNumber' => $description->getCallNumber(), 'term'=>$description->getTerm())));
        }

        return array(
            'description'      => $description,
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

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $description = $em->getRepository('EnglishDescriptionsBundle:Description')->find($id);

            if (!$description) {
                throw $this->createNotFoundException('Unable to find Description entity.');
            }

            $em->remove($description);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('course'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

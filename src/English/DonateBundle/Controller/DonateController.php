<?php

namespace English\DonateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\DonateBundle\Entity\Donate;
use English\DonateBundle\Form\DonateType;

/**
 * Donate controller.
 *
 * @Route("/donate")
 */
class DonateController extends Controller
{
    /**
     * Lists all Donate entities.
     *
     * @Route("/", name="donate")
     * @Template()
     */
    public function indexAction()
    {     
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT d FROM EnglishDonateBundle:Donate d ORDER BY d.sortorder";
        $funds = $em->createQuery($dql1)->getResult();
        return array('funds' => $funds);        
    }

    /**
     * Finds and displays a Donate entity.
     *
     * @Route("/{id}/show", name="donate_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fund = $em->getRepository('EnglishDonateBundle:Donate')->find($id);

        if (!$fund) {
            throw $this->createNotFoundException('Unable to find Donate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'fund'      => $fund,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Donate entity.
     *
     * @Route("/new", name="donate_new")
     * @Template()
     */
    public function newAction()
    {
        $fund = new Donate();
        $form   = $this->createForm(new DonateType(), $fund);

        return array(
            'fund' => $fund,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Donate entity.
     *
     * @Route("/create", name="donate_create")
     * @Method("post")
     * @Template("EnglishDonateBundle:Donate:new.html.twig")
     */
    public function createAction()
    {
        $fund  = new Donate();
        $request = $this->getRequest();
        $form    = $this->createForm(new DonateType(), $fund);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fund);
            $em->flush();

            return $this->redirect($this->generateUrl('donate', array('id' => $fund->getId())));
            
        }

        return array(
            'fund' => $fund,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Donate entity.
     *
     * @Route("/{id}/edit", name="donate_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fund = $em->getRepository('EnglishDonateBundle:Donate')->find($id);

        if (!$fund) {
            throw $this->createNotFoundException('Unable to find Donate entity.');
        }

        $editForm = $this->createForm(new DonateType(), $fund);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'fund'      => $fund,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Donate entity.
     *
     * @Route("/{id}/update", name="donate_update")
     * @Method("post")
     * @Template("EnglishDonateBundle:Donate:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $fund = $em->getRepository('EnglishDonateBundle:Donate')->find($id);

        if (!$fund) {
            throw $this->createNotFoundException('Unable to find Donate entity.');
        }

        $editForm   = $this->createForm(new DonateType(), $fund);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($fund);
            $em->flush();

            return $this->redirect($this->generateUrl('donate', array('id' => $id)));
        }

        return array(
            'fund'      => $fund,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Donate entity.
     *
     * @Route("/{id}/delete", name="donate_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fund = $em->getRepository('EnglishDonateBundle:Donate')->find($id);

            if (!$fund) {
                throw $this->createNotFoundException('Unable to find Donate entity.');
            }

            $em->remove($fund);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('donate'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

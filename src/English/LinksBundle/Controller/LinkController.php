<?php

namespace English\LinksBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\LinksBundle\Entity\Link;
use English\LinksBundle\Form\LinkType;

/**
 * Link controller.
 *
 * @Route("/link")
 */
class LinkController extends Controller
{
    /**
     * Lists all Link entities.
     *
     * @Route("/", name="link")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $links = $em->getRepository('EnglishLinksBundle:Link')->findAll();

        return array('links' => $links);
    }

    /**
     * Finds and displays a Link entity.
     *
     * @Route("/{id}/show", name="link_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $link = $em->getRepository('EnglishLinksBundle:Link')->find($id);

        if (!$link) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'link'      => $link,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Link entity.
     *
     * @Route("/new", name="link_new")
     * @Template()
     */
    public function newAction()
    {
        $link = new Link();
        $form   = $this->createForm(new LinkType(), $link);

        return array(
            'link' => $link,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/create", name="link_create")
     * @Method("post")
     * @Template("EnglishLinksBundle:Link:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $link  = new Link();
        
        $link->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new LinkType(), $link);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            return $this->redirect($this->generateUrl('link'));
            
        }

        return array(
            'link' => $link,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/{id}/edit", name="link_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $link = $em->getRepository('EnglishLinksBundle:Link')->find($id);

        if (!$link) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $editForm = $this->createForm(new LinkType(), $link);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'link'      => $link,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Link entity.
     *
     * @Route("/{id}/update", name="link_update")
     * @Method("post")
     * @Template("EnglishLinksBundle:Link:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $link = $em->getRepository('EnglishLinksBundle:Link')->find($id);

        if (!$link) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $editForm   = $this->createForm(new LinkType(), $link);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($link);
            $em->flush();

            return $this->redirect($this->generateUrl('link'));
        }

        return array(
            'link'      => $link,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Link entity.
     *
     * @Route("/{id}/delete", name="link_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $link = $em->getRepository('EnglishLinksBundle:Link')->find($id);

            if (!$link) {
                throw $this->createNotFoundException('Unable to find Link entity.');
            }

            $em->remove($link);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('link'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

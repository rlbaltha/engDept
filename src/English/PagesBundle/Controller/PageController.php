<?php

namespace English\PagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\PagesBundle\Entity\Page;
use English\PagesBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("/{sub}/pages", defaults={"sub" = "default"})
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="pages")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('EnglishPagesBundle:Page')->findAll();

        return array(
            'pages' => $pages,
        );
    }
    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="pages_create")
     * @Method("POST")
     * @Template("EnglishPagesBundle:Page:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $page = new Page();
        $form = $this->createCreateForm($page);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));
        }

        return array(
            'page' => $page,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $page The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $page)
    {
        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('pages_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-default','novalidate' => 'novalidate'),));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="pages_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $page = new Page();
        $form   = $this->createCreateForm($page);

        return array(
            'page' => $page,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="pages_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'page'      => $page,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="pages_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($page);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Page entity.
    *
    * @param Page $page The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Page $page)
    {
        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('pages_update', array('id' => $page->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-default'),));

        return $form;
    }
    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="pages_update")
     * @Method("PUT")
     * @Template("EnglishPagesBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($page);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));
        }

        return array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="pages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($page);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * Creates a form to delete a Page entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pages_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

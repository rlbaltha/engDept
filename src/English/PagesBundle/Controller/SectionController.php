<?php

namespace English\PagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\PagesBundle\Entity\Section;
use English\PagesBundle\Form\SectionType;
use English\PagesBundle\Entity\Page;

/**
 * Section controller.
 *
 * @Route("/section")
 */
class SectionController extends Controller
{

    /**
     * Lists all Section entities.
     *
     * @Route("/", name="section")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sections = $em->getRepository('EnglishPagesBundle:Section')->findAll();

        return array(
            'sections' => $sections,
        );
    }
    /**
     * Creates a new Section entity.
     *
     * @Route("/", name="section_create")
     * @Method("POST")
     * @Template("EnglishPagesBundle:Section:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $section = new Section();
        $form = $this->createCreateForm($section);
        $form->handleRequest($request);

        $page = new Page();
        $page->setSortOrder(1);
        $page->setMenuName('Home');
        $page->setSection($section);



        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('section'));
        }

        return array(
            'section' => $section,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Section entity.
     *
     * @param Section $section The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Section $section)
    {
        $form = $this->createForm(new SectionType(), $section, array(
            'action' => $this->generateUrl('section_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-default')));

        return $form;
    }

    /**
     * Displays a form to create a new Section entity.
     *
     * @Route("/new", name="section_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $section = new Section();
        $form   = $this->createCreateForm($section);

        return array(
            'section' => $section,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="section_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $section = $em->getRepository('EnglishPagesBundle:Section')->find($id);

        if (!$section) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'section'      => $section,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Section entity.
     *
     * @Route("/{id}/edit", name="section_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $section = $em->getRepository('EnglishPagesBundle:Section')->find($id);

        if (!$section) {
            throw $this->createNotFoundException('Unable to find Section entity.');
        }

        $editForm = $this->createEditForm($section);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'section'      => $section,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Section entity.
    *
    * @param Section $section The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Section $section)
    {
        $form = $this->createForm(new SectionType(), $section, array(
            'action' => $this->generateUrl('section_update', array('id' => $section->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-default')));

        return $form;
    }
    /**
     * Edits an existing Section entity.
     *
     * @Route("/{id}", name="section_update")
     * @Method("PUT")
     * @Template("EnglishPagesBundle:Section:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $section = $em->getRepository('EnglishPagesBundle:Section')->find($id);

        if (!$section) {
            throw $this->createNotFoundException('Unable to find Section entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($section);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('section'));
        }

        return array(
            'section'      => $section,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Section entity.
     *
     * @Route("/{id}", name="section_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $section = $em->getRepository('EnglishPagesBundle:Section')->find($id);

            if (!$section) {
                throw $this->createNotFoundException('Unable to find Section entity.');
            }

            $em->remove($section);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('section'));
    }

    /**
     * Creates a form to delete a Section entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('section_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

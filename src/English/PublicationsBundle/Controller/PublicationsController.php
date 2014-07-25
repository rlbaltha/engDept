<?php

namespace English\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\PublicationsBundle\Entity\Publications;
use English\PublicationsBundle\Form\PublicationsType;

/**
 * Publications controller.
 *
 * @Route("/publications")
 */
class PublicationsController extends Controller
{
    /**
     * Lists all Publications entities.
     *
     * @Route("/", name="publications")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publications = $em->getRepository('EnglishPublicationsBundle:Publications')->findAll();

        return array('publications' => $publications);
    }


    /**
     * Displays a form to create a new Publications entity.
     *
     * @Route("/new", name="publications_new")
     * @Template()
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
            $publication = new Publications();
            $publication->setDescription('<p></p>');
            $form   = $this->createForm(new PublicationsType(), $publication);

            return array(
                'publication' => $publication,
                'form'   => $form->createView()
            );
    }

    /**
     * Creates a new Publications entity.
     *
     * @Route("/create", name="publications_create")
     * @Method("post")
     * @Template("EnglishPublicationsBundle:Publications:new.html.twig")
     */
    public function createAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $publication  = new Publications();
        $publication->setUserid($userid);
        $request = $this->getRequest();
        $form    = $this->createForm(new PublicationsType(), $publication);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();

            return $this->redirect($this->generateUrl('publications'));
            
        }

        return array(
            'publication' => $publication,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Publications entity.
     *
     * @Route("/{id}/edit", name="publications_edit")
     * @Template()
     */
    public function editAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $publication = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm = $this->createForm(new PublicationsType(), $publication);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'publication'      => $publication,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Publications entity.
     *
     * @Route("/{id}/update", name="publications_update")
     * @Method("post")
     * @Template("EnglishPublicationsBundle:Publications:edit.html.twig")
     */
    public function updateAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $publication = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

        if (!$publication) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm   = $this->createForm(new PublicationsType(), $publication);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($publication);
            $em->flush();

            return $this->redirect($this->generateUrl('publications'));
        }

        return array(
            'publication'      => $publication,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Publications entity.
     *
     * @Route("/{id}/delete", name="publications_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $publication = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

            if (!$publication) {
                throw $this->createNotFoundException('Unable to find Publications entity.');
            }

            $em->remove($publication);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('publications'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

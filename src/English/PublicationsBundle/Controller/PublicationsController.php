<?php

namespace English\PublicationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishPublicationsBundle:Publications')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Publications entity.
     *
     * @Route("/{id}/show", name="publications_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Publications entity.
     *
     * @Route("/new", name="publications_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Publications();
        $entity->setDescription('<p></p>');
        $form   = $this->createForm(new PublicationsType(), $entity);

        return array(
            'entity' => $entity,
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
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Publications();
        $entity->setUserid($userid);
        $request = $this->getRequest();
        $form    = $this->createForm(new PublicationsType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publications'));
            
        }

        return array(
            'entity' => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm = $this->createForm(new PublicationsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Publications entity.');
        }

        $editForm   = $this->createForm(new PublicationsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('publications'));
        }

        return array(
            'entity'      => $entity,
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
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishPublicationsBundle:Publications')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Publications entity.');
            }

            $em->remove($entity);
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

<?php

namespace English\SpotlightBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\SpotlightBundle\Entity\Spotlight;
use English\SpotlightBundle\Form\SpotlightType;

/**
 * Spotlight controller.
 *
 * @Route("/spotlight")
 */
class SpotlightController extends Controller
{
    /**
     * Lists all Spotlight entities.
     *
     * @Route("/", name="spotlight")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT s FROM EnglishSpotlightBundle:Spotlight s ORDER BY s.sortOrder";
        $entities = $em->createQuery($dql1)->getResult();
        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Spotlight entity.
     *
     * @Route("/{id}/show", name="spotlight_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishSpotlightBundle:Spotlight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spotlight entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Spotlight entity.
     *
     * @Route("/new", name="spotlight_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Spotlight();
        $form   = $this->createForm(new SpotlightType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Spotlight entity.
     *
     * @Route("/create", name="spotlight_create")
     * @Method("post")
     * @Template("EnglishSpotlightBundle:Spotlight:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Spotlight();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new SpotlightType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spotlight_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Spotlight entity.
     *
     * @Route("/{id}/edit", name="spotlight_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishSpotlightBundle:Spotlight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spotlight entity.');
        }

        $editForm = $this->createForm(new SpotlightType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Spotlight entity.
     *
     * @Route("/{id}/update", name="spotlight_update")
     * @Method("post")
     * @Template("EnglishSpotlightBundle:Spotlight:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishSpotlightBundle:Spotlight')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Spotlight entity.');
        }

        $editForm   = $this->createForm(new SpotlightType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('spotlight_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Spotlight entity.
     *
     * @Route("/{id}/delete", name="spotlight_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishSpotlightBundle:Spotlight')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Spotlight entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('spotlight'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

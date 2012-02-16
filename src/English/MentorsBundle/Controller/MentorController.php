<?php

namespace English\MentorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\MentorsBundle\Entity\Mentor;
use English\MentorsBundle\Form\MentorType;

/**
 * Mentor controller.
 *
 * @Route("/mentor")
 */
class MentorController extends Controller
{
    /**
     * Lists all Mentor entities.
     *
     * @Route("/", name="mentor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishMentorsBundle:Mentor')->findAll();

        return array('entities' => $entities);
    }
    
    
    /**
     * Finds and displays a Mentor entity.
     *
     * @Route("/{id}/show", name="mentor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mentor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Mentor entity.
     *
     * @Route("/new", name="mentor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mentor();
        $form   = $this->createForm(new MentorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Mentor entity.
     *
     * @Route("/create", name="mentor_create")
     * @Method("post")
     * @Template("EnglishMentorsBundle:Mentor:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Mentor();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new MentorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mentor_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Mentor entity.
     *
     * @Route("/{id}/edit", name="mentor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mentor entity.');
        }

        $editForm = $this->createForm(new MentorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mentor entity.
     *
     * @Route("/{id}/update", name="mentor_update")
     * @Method("post")
     * @Template("EnglishMentorsBundle:Mentor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mentor entity.');
        }

        $editForm   = $this->createForm(new MentorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mentor_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Mentor entity.
     *
     * @Route("/{id}/delete", name="mentor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mentor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mentor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

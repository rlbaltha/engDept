<?php

namespace English\AdvisorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\AdvisorsBundle\Entity\Advisor;
use English\AdvisorsBundle\Form\AdvisorType;

/**
 * Advisor controller.
 *
 * @Route("/advisor")
 */
class AdvisorController extends Controller
{
    /**
     * Lists all Advisor entities.
     *
     * @Route("/", name="advisor")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT a FROM EnglishAdvisorsBundle:Advisor a ORDER BY a.name";
        $entities = $em->createQuery($dql1)->getResult();
        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Advisor entity.
     *
     * @Route("/{id}/show", name="advisor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Advisor entity.
     *
     * @Route("/new", name="advisor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Advisor();
        $form   = $this->createForm(new AdvisorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Advisor entity.
     *
     * @Route("/create", name="advisor_create")
     * @Method("post")
     * @Template("EnglishAdvisorsBundle:Advisor:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Advisor();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new AdvisorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('advisor_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Advisor entity.
     *
     * @Route("/{id}/edit", name="advisor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $editForm = $this->createForm(new AdvisorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Advisor entity.
     *
     * @Route("/{id}/update", name="advisor_update")
     * @Method("post")
     * @Template("EnglishAdvisorsBundle:Advisor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $editForm   = $this->createForm(new AdvisorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if (1 == 1) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('advisor_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Advisor entity.
     *
     * @Route("/{id}/delete", name="advisor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Advisor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('advisor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

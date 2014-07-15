<?php

namespace English\AreasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\AreasBundle\Entity\Area;
use English\AreasBundle\Form\AreaType;

/**
 * Area controller.
 *
 * @Route("/area")
 */
class AreaController extends Controller
{
    /**
     * Lists all Area entities.
     *
     * @Route("/", name="area")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('EnglishAreasBundle:Area')->findAll();

        return array('entities' => $entities,);
    }

    /**
     * Finds and displays a Area entity.
     *
     * @Route("/{id}/show", name="area_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Area entity.
     *
     * @Route("/new", name="area_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Area();
        $form   = $this->createForm(new AreaType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Area entity.
     *
     * @Route("/create", name="area_create")
     * @Method("post")
     * @Template("EnglishAreasBundle:Area:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $entity  = new Area();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new AreaType(), $entity);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('area'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Area entity.
     *
     * @Route("/{id}/edit", name="area_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $editForm = $this->createForm(new AreaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Area entity.
     *
     * @Route("/{id}/update", name="area_update")
     * @Method("post")
     * @Template("EnglishAreasBundle:Area:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $editForm   = $this->createForm(new AreaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('area'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Area entity.
     *
     * @Route("/{id}/delete", name="area_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EnglishAreasBundle:Area')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Area entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('area'));
    }

    private function createDeleteForm()
    {
        return $this->createFormBuilder()
            ->getForm()
        ;
    }
}

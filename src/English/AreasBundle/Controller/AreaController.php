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
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();

        return array('areas' => $areas,);
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

        $area = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$area) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'area'      => $area,
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
        $area = new Area();
        $form   = $this->createForm(new AreaType(), $area);

        return array(
            'area' => $area,
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
        
        $area  = new Area();
        
        $area->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new AreaType(), $area);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($area);
            $em->flush();

            return $this->redirect($this->generateUrl('area'));
            
        }

        return array(
            'area' => $area,
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

        $area = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$area) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $editForm = $this->createForm(new AreaType(), $area);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'area'      => $area,
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

        $area = $em->getRepository('EnglishAreasBundle:Area')->find($id);

        if (!$area) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $editForm   = $this->createForm(new AreaType(), $area);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($area);
            $em->flush();

            return $this->redirect($this->generateUrl('area'));
        }

        return array(
            'area'      => $area,
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
            $area = $em->getRepository('EnglishAreasBundle:Area')->find($id);

            if (!$area) {
                throw $this->createNotFoundException('Unable to find Area entity.');
            }

            $em->remove($area);
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

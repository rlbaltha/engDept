<?php

namespace English\SlideshowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\SlideshowBundle\Entity\Slideshow;
use English\SlideshowBundle\Form\SlideshowType;

/**
 * Slideshow controller.
 *
 * @Route("/slideshow")
 */
class SlideshowController extends Controller
{
    /**
     * Lists all Slideshow entities.
     *
     * @Route("/", name="slideshow")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $slideshow = $em->getRepository('EnglishSlideshowBundle:Slideshow')->findAll();

        return array('slideshow' => $slideshow);
    }

    /**
     * Finds and displays a Slideshow entity.
     *
     * @Route("/{id}/show", name="slideshow_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $slide = $em->getRepository('EnglishSlideshowBundle:Slideshow')->find($id);

        if (!$slide) {
            throw $this->createNotFoundException('Unable to find Slideshow entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'slide'      => $slide,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Slideshow entity.
     *
     * @Route("/new", name="slideshow_new")
     * @Template()
     */
    public function newAction()
    {
        $slide = new Slideshow();
        $form   = $this->createForm(new SlideshowType(), $slide);

        return array(
            'slide' => $slide,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Slideshow entity.
     *
     * @Route("/create", name="slideshow_create")
     * @Method("post")
     * @Template("EnglishSlideshowBundle:Slideshow:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $slide  = new Slideshow();
        
        $slide->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new SlideshowType(), $slide);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slide);
            $em->flush();

            return $this->redirect($this->generateUrl('slideshow'));
            
        }

        return array(
            'slide' => $slide,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Slideshow entity.
     *
     * @Route("/{id}/edit", name="slideshow_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $slide = $em->getRepository('EnglishSlideshowBundle:Slideshow')->find($id);

        if (!$slide) {
            throw $this->createNotFoundException('Unable to find Slideshow entity.');
        }

        $editForm = $this->createForm(new SlideshowType(), $slide);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'slide'      => $slide,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Slideshow entity.
     *
     * @Route("/{id}/update", name="slideshow_update")
     * @Method("post")
     * @Template("EnglishSlideshowBundle:Slideshow:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $slide = $em->getRepository('EnglishSlideshowBundle:Slideshow')->find($id);

        if (!$slide) {
            throw $this->createNotFoundException('Unable to find Slideshow entity.');
        }

        $editForm   = $this->createForm(new SlideshowType(), $slide);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($slide);
            $em->flush();

            return $this->redirect($this->generateUrl('slideshow'));
        }

        return array(
            'slide'      => $slide,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Slideshow entity.
     *
     * @Route("/{id}/delete", name="slideshow_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $slide = $em->getRepository('EnglishSlideshowBundle:Slideshow')->find($id);

            if (!$slide) {
                throw $this->createNotFoundException('Unable to find Slideshow entity.');
            }

            $em->remove($slide);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('slideshow'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

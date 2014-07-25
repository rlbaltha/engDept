<?php

namespace English\GradcomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\GradcomBundle\Entity\Gradcom;
use English\GradcomBundle\Form\GradcomType;

/**
 * Gradcom controller.
 *
 * @Route("/gradcom")
 */
class GradcomController extends Controller
{

    /**
     * Displays a form to create a new Gradcom entity.
     *
     * @Route("/{id}/new", name="gradcom_new")
     * @Template()
     */
    public function newAction($id)
    {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();
        
        $gradcom = new Gradcom();
        $gradcom->setGid($id);
        $gradcom->setStatus('t');
        $form   = $this->createForm(new GradcomType(), $gradcom);

        return array(
            'gradcom' => $gradcom,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Gradcom entity.
     *
     * @Route("/create", name="gradcom_create")
     * @Method("post")
     * @Template("EnglishGradcomBundle:Gradcom:new.html.twig")
     */
    public function createAction()
    {
        $request = $this->getRequest();
        $postData = $request->request->get('english_gradcombundle_gradcomtype');
        $gid = $postData['gid'];
        
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        $grad = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneById($gid);
        
        
        $gradcom  = new Gradcom();
        $gradcom->setGrad($grad);        
        $gradcom->setUserid($userid);
        

        $form    = $this->createForm(new GradcomType(), $gradcom);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gradcom);
            $em->flush();

            return $this->redirect($this->generateUrl('directory_detail', array('id' => $gradcom->getGid())));
            
        }

        return array(
            'gradcom' => $gradcom,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Gradcom entity.
     *
     * @Route("/{id}/edit", name="gradcom_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $gradcom = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

        if (!$gradcom) {
            throw $this->createNotFoundException('Unable to find Gradcom entity.');
        }

        $editForm = $this->createForm(new GradcomType(), $gradcom);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'gradcom'      => $gradcom,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Gradcom entity.
     *
     * @Route("/{id}/update", name="gradcom_update")
     * @Method("post")
     * @Template("EnglishGradcomBundle:Gradcom:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $gradcom = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

        if (!$gradcom) {
            throw $this->createNotFoundException('Unable to find Gradcom entity.');
        }

        $editForm   = $this->createForm(new GradcomType(), $gradcom);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($gradcom);
            $em->flush();

            return $this->redirect($this->generateUrl('directory_detail', array('id' => $gradcom->getGid())));
        }

        return array(
            'gradcom'      => $gradcom,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Gradcom entity.
     *
     * @Route("/{id}/{gid}/delete", name="gradcom_delete")
     * @Method("post")
     */
    public function deleteAction($id, $gid)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gradcom = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

            if (!$gradcom) {
                throw $this->createNotFoundException('Unable to find Gradcom entity.');
            }

            $em->remove($gradcom);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('directory_detail', array('id' => $gid)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

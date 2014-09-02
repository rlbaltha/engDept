<?php

namespace English\AdvisorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\AdvisorsBundle\Entity\Advisor;
use English\MajorsBundle\Entity\Major;
use English\AdvisorsBundle\Form\AdvisorType;
use English\MajorsBundle\Form\FindType;

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
        $em = $this->getDoctrine()->getManager();
        $major = new Major();
        $find_form = $this->createFindForm($major);
        $dql1 = "SELECT a FROM EnglishAdvisorsBundle:Advisor a ORDER BY a.name";
        $advisors = $em->createQuery($dql1)->getResult();
        return array(
            'advisors' => $advisors,
            'find_form' => $find_form->createView()
        );
    }

    /**
     * Creates a find form
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFindForm(Major $major)
    {
        $form = $this->createForm(new FindType(), $major, array(
            'action' => $this->generateUrl('major'),
            'method' => 'POST',
        ));
        $form->add('name', 'text', array('label' => ' ', 'attr' => array('size'=>'10','class' => 'form-control', 'placeholder' => 'Lastname'),));

        return $form;
    }

    /**
     * Finds and displays a Advisor entity.
     *
     * @Route("/{id}/show", name="advisor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $major = new Major();
        $find_form = $this->createFindForm($major);

        $advisor = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$advisor) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'advisor'      => $advisor,
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
        );
    }

    /**
     * Displays a form to create a new Advisor entity.
     *
     * @Route("/new", name="advisor_new")
     * @Template()
     */
    public function newAction()
    {

        $major = new Major();
        $find_form = $this->createFindForm($major);

        $advisor = new Advisor();
        $form   = $this->createForm(new AdvisorType(), $advisor);

        return array(
            'advisor' => $advisor,
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()
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

        $major = new Major();
        $find_form = $this->createFindForm($major);


        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $advisor  = new Advisor();
        
        $advisor->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new AdvisorType(), $advisor);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($advisor);
            $em->flush();

            return $this->redirect($this->generateUrl('advisor'));
            
        }

        return array(
            'advisor' => $advisor,
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()
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
        $em = $this->getDoctrine()->getManager();

        $major = new Major();
        $find_form = $this->createFindForm($major);

        $advisor = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$advisor) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $editForm = $this->createForm(new AdvisorType(), $advisor);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'advisor'      => $advisor,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
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

        $major = new Major();
        $find_form = $this->createFindForm($major);

        $em = $this->getDoctrine()->getManager();

        $advisor = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

        if (!$advisor) {
            throw $this->createNotFoundException('Unable to find Advisor entity.');
        }

        $editForm   = $this->createForm(new AdvisorType(), $advisor);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if (1 == 1) {
            $em->persist($advisor);
            $em->flush();

            return $this->redirect($this->generateUrl('advisor'));
        }

        return array(
            'advisor'      => $advisor,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
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

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $advisor = $em->getRepository('EnglishAdvisorsBundle:Advisor')->find($id);

            if (!$advisor) {
                throw $this->createNotFoundException('Unable to find Advisor entity.');
            }

            $em->remove($advisor);
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

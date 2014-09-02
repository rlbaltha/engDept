<?php

namespace English\MentorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\MentorsBundle\Entity\Mentor;
use English\MajorsBundle\Entity\Major;
use English\MentorsBundle\Form\MentorType;
use English\MajorsBundle\Form\FindType;


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
        $em = $this->getDoctrine()->getManager();
        $major = new Major();
        $find_form = $this->createFindForm($major);
        $dql1 = "SELECT a FROM EnglishMentorsBundle:Mentor a ORDER BY a.name";
        $mentors = $em->createQuery($dql1)->getResult();
        return array(
            'mentors' => $mentors,
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
     * Displays a form to create a new Mentor entity.
     *
     * @Route("/new", name="mentor_new")
     * @Template()
     */
    public function newAction()
    {
        $major = new Major();
        $find_form = $this->createFindForm($major);

        $mentor = new Mentor();
        $form   = $this->createForm(new MentorType(), $mentor);

        return array(
            'mentor' => $mentor,
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()
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
        $major = new Major();
        $find_form = $this->createFindForm($major);

        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $mentor  = new Mentor();
        
        $mentor->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new MentorType(), $mentor);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mentor);
            $em->flush();

            return $this->redirect($this->generateUrl('mentor'));
            
        }

        return array(
            'mentor' => $mentor,
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()
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
        $major = new Major();
        $find_form = $this->createFindForm($major);

        $em = $this->getDoctrine()->getManager();

        $mentor = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

        if (!$mentor) {
            throw $this->createNotFoundException('Unable to find Mentor entity.');
        }

        $editForm = $this->createForm(new MentorType(), $mentor);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'mentor'      => $mentor,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
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
        $major = new Major();
        $find_form = $this->createFindForm($major);

        $em = $this->getDoctrine()->getManager();

        $mentor = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

        if (!$mentor) {
            throw $this->createNotFoundException('Unable to find Mentor entity.');
        }

        $editForm   = $this->createForm(new MentorType(), $mentor);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($mentor);
            $em->flush();

            return $this->redirect($this->generateUrl('mentor'));
        }

        return array(
            'mentor'      => $mentor,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
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

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $mentor = $em->getRepository('EnglishMentorsBundle:Mentor')->find($id);

            if (!$mentor) {
                throw $this->createNotFoundException('Unable to find Mentor entity.');
            }

            $em->remove($mentor);
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

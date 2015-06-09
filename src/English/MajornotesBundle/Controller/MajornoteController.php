<?php

namespace English\MajornotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\MajorsBundle\Entity\Major;
use English\MajornotesBundle\Entity\Majornote;
use English\MajornotesBundle\Form\MajornoteType;
use English\MajorsBundle\Form\FindType;

/**
 * Majornote controller.
 *
 * @Route("/majornote")
 */
class MajornoteController extends Controller
{
    /**
     * Lists all Majornote entities.
     *
     * @Route("/", name="majornote")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $notes = $em->getRepository('EnglishMajornotesBundle:Majornote')->findAll();

        return array('notes' => $notes);
    }

    /**
     * Finds and displays a Majornote entity.
     *
     * @Route("/{id}/show", name="majornote_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $note = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$note) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'note'      => $note,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Majornote entity.
     *
     * @Route("/{id}/new", name="majornote_new")
     * @Template()
     */
     public function newAction($id)
    {
        $note = new Majornote();
        $note->setMentorId($id);
        $note->setNotes('<p></p>');
        $form   = $this->createForm(new MajornoteType(), $note);

        $major= new Major();
        $find_form = $this->createFindForm($major);

        return array(
            'note' => $note,
            'form'   => $form->createView(),
            'find_form'   => $find_form->createView()

        );
    }   

    /**
     * Creates a new Majornote entity.
     *
     * @Route("/create", name="majornote_create")
     * @Method("post")
     * @Template("EnglishMajornotesBundle:Majornote:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $note  = new Majornote();
        $note->setUserid($userid);     
        $request = $this->getRequest();
        $form    = $this->createForm(new MajornoteType(), $note);
        $form->submit($request);

        $major= new Major();
        $find_form = $this->createFindForm($major);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $note->getMentorId())));
            
        }

        return array(
            'note' => $note,
            'form'   => $form->createView(),
            'find_form'   => $find_form->createView()
        );
    }
    

    /**
     * Emails a mentored notification and writes an update to Majornotes;  
     * still to do: write update to timestamp Major:mentored
     * 
     * @Route("/{id}/email", name="majornote_email")
     * @Template("EnglishMajornotesBundle:Majornote:new.html.twig")
     */
    public function emailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $note = $em->getRepository('EnglishMajorsBundle:Major')->find($id);
        $name = $note->getName();
        if( ($x_pos = strpos($name, ',')) !== FALSE )
        $name = substr($name, $x_pos + 1) . ' ' . substr($name, 0, $x_pos);
        $body =  $name . ' has been mentored.';   
        $message = \Swift_Message::newInstance()
        ->setSubject('Mentored Notification')
        ->setFrom('rlbaltha@uga.edu')
        ->setTo('rlbaltha@uga.edu')
        ->setBody($body)
        ;
        $this->get('mailer')->send($message);
        
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        $note  = new Majornote();
        $note->setUserid($userid);
        $note->setMentorId($id);
        $note->setNotes($body);

        $major = $em->getRepository('EnglishMajorsBundle:Major')->find($id);
        $type=1;
        $currentTerm = $em->getRepository('EnglishTermBundle:Term')->findTermByType($type);
        $current_term_name = $currentTerm->getTermName();
        $major->setTermMentored($current_term_name);

        $em->persist($note);
        $em->persist($major);
        $em->flush();
        

    return $this->redirect($this->generateUrl('major_show', array('id' => $id ))); 
    }



    /**
     * Creates a find form
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFindForm(Major $major)
    {
        $form = $this->createForm(new FindType(), $major, array(
            'action' => $this->generateUrl('major_find'),
            'method' => 'POST',
        ));
        $form->add('name', 'text', array('label' => ' ', 'attr' => array('size'=>'10','class' => 'form-control', 'placeholder' => 'Lastname'),));

        return $form;
    }
    

    /**
     * Displays a form to edit an existing Majornote entity.
     *
     * @Route("/{id}/edit", name="majornote_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $note = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$note) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $major= new Major();
        $find_form = $this->createFindForm($major);
        $editForm = $this->createForm(new MajornoteType(), $note);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'note'      => $note,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form'   => $find_form->createView()
        );
    }

    /**
     * Edits an existing Majornote entity.
     *
     * @Route("/{id}/update", name="majornote_update")
     * @Method("post")
     * @Template("EnglishMajornotesBundle:Majornote:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $note = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$note) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $major= new Major();
        $find_form = $this->createFindForm($major);
        $editForm   = $this->createForm(new MajornoteType(), $note);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($note);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $note->getMentorId())));
        }

        return array(
            'note'      => $note,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'find_form'   => $find_form->createView()
        );
    }

    /**
     * Deletes a Majornote entity.
     *
     * @Route("/{id}/delete", name="majornote_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);
        $em = $this->getDoctrine()->getManager();
        $note = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);
         
        if ($form->isValid()) {
           
            if (!$note) {
                throw $this->createNotFoundException('Unable to find Majornote entity.');
            }

            $em->remove($note);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('major_show', array('id' => $note->getMentorId())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

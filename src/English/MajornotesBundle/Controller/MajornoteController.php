<?php

namespace English\MajornotesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\MajornotesBundle\Entity\Majornote;
use English\MajornotesBundle\Form\MajornoteType;

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
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('EnglishMajornotesBundle:Majornote')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Majornote entity.
     *
     * @Route("/{id}/show", name="majornote_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
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
        $entity = new Majornote();
        $entity->setMentorId($id);
        $entity->setNotes('<p></p>');
        $form   = $this->createForm(new MajornoteType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
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
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Majornote();
        $entity->setUserid($userid);     
        $request = $this->getRequest();
        $form    = $this->createForm(new MajornoteType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getMentorId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
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
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);
        $name = $entity->getName();
        if( ($x_pos = strpos($name, ',')) !== FALSE )
        $name = substr($name, $x_pos + 1) . ' ' . substr($name, 0, $x_pos);
        $body =  $name . ' has been mentored.';   
        $message = \Swift_Message::newInstance()
        ->setSubject('Mentored Notification')
        ->setFrom('rlbaltha@uga.edu')
        ->setTo('ron.balthazor@gmail.com')
        ->setBody($body)
        ;
        $this->get('mailer')->send($message);
        
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        $entity  = new Majornote();
        $entity->setUserid($userid);
        $entity->setMentorId($id);
        $entity->setNotes($body);
        $em->persist($entity);
        $em->flush();
        

    return $this->redirect($this->generateUrl('major_show', array('id' => $id ))); 
    }
    
    
 
    
    

    /**
     * Displays a form to edit an existing Majornote entity.
     *
     * @Route("/{id}/edit", name="majornote_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $editForm = $this->createForm(new MajornoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majornote entity.');
        }

        $editForm   = $this->createForm(new MajornoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getMentorId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $form->bindRequest($request);
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('EnglishMajornotesBundle:Majornote')->find($id);
         
        if ($form->isValid()) {
           
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Majornote entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getMentorId())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

<?php

namespace English\MajorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\MajorsBundle\Entity\Major;
use English\MajorsBundle\Form\MajorType;

/**
 * Major controller.
 *
 * @Route("/major")
 */
class MajorController extends Controller
{
    /**
     * Lists all Major or majors by user.
     *
     * @Route("/", name="major")
     * @Template()
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e ORDER BY m.name ASC');
        $entities = $em->getResult();
        return array('entities' => $entities);  
        } else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE e.username = ?1 or a.username = ?1 ORDER BY m.name ASC');
        $entities = $em->setParameter('1',$username)->getResult();
        return array('entities' => $entities);
        }

    }     


     /**
     * Lists all Major or majors by user.
     *
     * @Route("/{id}/findbyadvisor", name="major_findbyadvisor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbyadvisorAction($id)
    {
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE a.id = ?1 ORDER BY m.name ASC');
        $entities = $em->setParameter('1',$id)->getResult();
        return array('entities' => $entities);
    } 
    
        
    /**
     * Lists all majors by mentor.
     *
     * @Route("/{id}/findbymentor", name="major_findbymentor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbymentorAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager()
        ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE e.id = ?1 ORDER BY m.name ASC');
       $entities = $em->setParameter('1',$id)->getResult();
        return array('entities' => $entities);
    }
    
     

    /**
     * Finds and displays a Major entity.
     *
     * @Route("/{id}/show", name="major_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);
        $advisor = $entity->getAdvisor()->getName();
        $mentor = $entity->getMentor()->getName();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Majors.');
        }
        $notes = $em->createQuery('SELECT n
                FROM EnglishMajornotesBundle:Majornote n, EnglishMajorsBundle:Major m WHERE n.mentorId = ?1 ORDER BY n.created DESC')->setParameter('1',$id)->getResult();
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'advisor'      => $advisor,
            'mentor'      => $mentor,
            'notes'       => $notes,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Major entity.
     *
     * @Route("/new", name="major_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Major();
        $form   = $this->createForm(new MajorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Major entity.
     *
     * @Route("/create", name="major_create")
     * @Method("post")
     * @Template("EnglishMajorsBundle:Major:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new Major();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new MajorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Major entity.
     *
     * @Route("/{id}/edit", name="major_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm = $this->createForm(new MajorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Major entity.
     *
     * @Route("/{id}/update", name="major_update")
     * @Method("post")
     * @Template("EnglishMajorsBundle:Major:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm   = $this->createForm(new MajorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Major entity.
     *
     * @Route("/{id}/delete", name="major_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Major entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('major'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

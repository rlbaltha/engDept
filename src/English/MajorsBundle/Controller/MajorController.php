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
        if ($this->get('security.context')->isGranted('ROLE_ADVISORADMIN')) {
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e ORDER BY m.name ASC');
        $entities = $em->getResult();
        
        $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
        
        return array('entities' => $entities, 'form' => $form->createView());  
        } else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e 
             WHERE e.username = ?1 or a.username = ?1 ORDER BY m.name ASC');
        $entities = $em->setParameter('1',$username)->getResult();
        return array('entities' => $entities);
        }

    }     


     /**
     * Lists all Majors by Advisor.
     *
     * @Route("/{id}/findbyadvisor", name="major_findbyadvisor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbyadvisorAction($id)
    {
         $em = $this->getDoctrine()->getEntityManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE a.id = ?1 ORDER BY m.name ASC');
        $entities = $em->setParameter('1',$id)->getResult();
        
        $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
        
        return array('entities' => $entities, 'form' => $form->createView());
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
        ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE e.id = ?1 ORDER BY m.name ASC');
       $entities = $em->setParameter('1',$id)->getResult();
       
       $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
       
        return array('entities' => $entities, 'form' => $form->createView());
    }
    
    /**
     * Find Majors
     *
     * @Route("/find", name="major_find")
     * @Method("post")
     */
    public function findAction()
    {   $request = $this->get('request');
        $postData = $request->request->get('form');
        $name = strtolower($postData['name'] . "%");
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE LOWER(m.name) LIKE ?1 ORDER BY m.name";
        $entities = $em->createQuery($dql1)->setParameter('1',$name)->getResult();
        $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
        if (!$entities) {

            throw $this->createNotFoundException('Unable to find Major entity.');
        }
        return $this->render('EnglishMajorsBundle:Major:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
        }  
        
      
        
    /**
     * Displays a form to create an advance find
     *
     * @Route("/advancedform", name="major_advancedform")
     * @Template()
     */
    public function advancedformAction()
    {
        $entity = new Major();
        $entity->setCheckedin('1');
        $entity->setHonors('2');
        $entity->setHours('0');
        $entity->setGpa('0');

        $form = $this->createFormBuilder($entity)
            ->add('name', 'text', array('attr' => array('class' => 'width300')))
            ->add('email', 'text', array('attr' => array('class' => 'width300')))
            ->add('firstMajor', 'text', array('label'  => '1st major',))
            ->add('secondMajor', 'text', array('label'  => '2nd major',))
            ->add('aoe', 'text', array('attr' => array('class' => 'width300')))
            ->add('can', 'text', array('label'  => '810',))
            ->add('minor')   
            ->add('honors','choice', array('choices' => array('0'=>'No','1'=> 'Yes','2'=> 'Both'),'expanded'=>true,))
            ->add('hours', 'number', array('attr' => array('widget' => 'single_text','class' => 'width50'),'label'  => 'Hours >=',)) 
            ->add('gpa', 'number', array('attr' => array('widget' => 'single_text','class' => 'width50'),'label'  => 'GPA >=',))     
            ->add('checkedin','choice', array('choices' => array('0'=>'No','1'=> 'Yes'),'expanded'=>true,)) 
            ->getForm();
        
        return array(
             'form'   => $form->createView()
        );
    }       
        
        
   /**
     * Find Majors through advanced search
     *
     * @Route("/advancedfind", name="major_advancedfind")
     * @Method("post")
     */
    public function advancedfindAction()
    {   $request = $this->get('request');
        $postData = $request->request->get('form');
        $name = strtolower($postData['name'] . "%");
        $email = strtolower($postData['email'] . "%");
        $firstMajor = strtolower($postData['firstMajor'] . "%");
        $secondMajor = strtolower($postData['secondMajor'] . "%");
        $aoe = strtolower($postData['aoe'] . "%");
        $minor = strtolower($postData['minor'] . "%");
        $can = $postData['can'] . "%";
        $checkedin = $postData['checkedin'];
        $honors = $postData['honors'];
        $hours = $postData['hours'];
        $gpa = $postData['gpa'];
        $em = $this->getDoctrine()->getEntityManager();
        if ($checkedin == 0) {$queryCheckedin = " AND m.checkedin ='0' ";} else {$queryCheckedin = " AND m.checkedin ='1' ";};
        if ($honors == 0) {$queryHonors = " AND m.honors ='0' ";} elseif ($honors == 1) {$queryHonors = " AND m.honors ='1' ";} else {$queryHonors = '';};
        $dql1 = "SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.gpa,m.checkedin
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e 
            WHERE LOWER(m.name) LIKE ?1 AND LOWER(m.email) LIKE ?2 AND LOWER(m.firstMajor) LIKE ?3 AND LOWER(m.secondMajor) LIKE ?4 AND LOWER(m.aoe) 
            LIKE ?5 AND LOWER(m.minor) LIKE ?6 AND m.can LIKE ?7 AND m.hours >= ?8 AND m.gpa >= ?9 ". $queryCheckedin . $queryHonors ." ORDER BY m.name";
        $entities = $em->createQuery($dql1)->setParameter('1',$name)->setParameter('2',$email)->setParameter('3',$firstMajor)->setParameter('4',$secondMajor)->setParameter('5',$aoe)->setParameter('6',$minor)->setParameter('7',$can)->setParameter('8',$hours)->setParameter('9',$gpa)->getResult();
        $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
        if (!$entities) {

            return $this->redirect($this->generateUrl('major_advancedform'));
        }
        return $this->render('EnglishMajorsBundle:Major:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
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
        $entity -> setStatus('0');
        $entity -> setFirstMajor('ENGL');
        $entity -> setSecondMajor('none');
        $entity -> setMinor('none');
        $entity -> setAoe('none');
        $entity -> setHonors(false);
        $entity -> setCan('810');
        $entity -> setCheckedin(false);
        $entity -> setEmail('needed');
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

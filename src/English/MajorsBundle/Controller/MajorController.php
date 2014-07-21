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
         $em = $this->getDoctrine()->getManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE m.status=0 ORDER BY m.name ASC');
        $majors = $em->getResult();
        
        $form = $this->createFormBuilder(new Major())
            ->add('name', 'text', array('label' => ' ', 'attr' => array('placeholder'=> 'Name', 'class' => 'text form-control')))
            ->getForm();
        
        return array('majors' => $majors, 'form' => $form->createView());  
        } else {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();  
         $em = $this->getDoctrine()->getManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.updated,m.aoe,m.checkedin,m.can,m.hours,m.gpa
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e 
             WHERE e.username = ?1 or a.username = ?1 ORDER BY m.name ASC');
            $majors = $em->setParameter('1',$username)->getResult();
        return array('majors' => $majors);
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
         $em = $this->getDoctrine()->getManager()
         ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
             FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE m.status=0 AND a.id = ?1 ORDER BY m.name ASC');
        $majors = $em->setParameter('1',$id)->getResult();
        
        $form = $this->createFormBuilder(new Major())
            ->add('name', array('attr' => array('class' => 'text form-control')))
            ->getForm();
        
        return array('majors' => $majors, 'form' => $form->createView());
    } 
    
        
    /**
     * Lists all majors by mentor.
     *
     * @Route("/{id}/findbymentor", name="major_findbymentor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbymentorAction($id)
    {
        $em = $this->getDoctrine()->getManager()
        ->createQuery('SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE m.status=0 AND e.id = ?1 ORDER BY m.name ASC');
       $majors = $em->setParameter('1',$id)->getResult();
       
       $form = $this->createFormBuilder(new Major())
            ->add('name', array('attr' => array('class' => 'text form-control')))
            ->getForm();
       
        return array('entities' => $majors, 'form' => $form->createView());
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
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e WHERE m.status=0 AND LOWER(m.name) LIKE ?1 ORDER BY m.name";
        $majors = $em->createQuery($dql1)->setParameter('1',$name)->getResult();
        $form = $this->createFormBuilder(new Major())
            ->add('name', array('attr' => array('class' => 'text form-control')))
            ->getForm();
        if (!$majors) {

            throw $this->createNotFoundException('Unable to find Major entity.');
        }
        return $this->render('EnglishMajorsBundle:Major:index.html.twig', array('entities' => $majors, 'form' => $form->createView()));
        }  
        
      
        
    /**
     * Displays a form to create an advance find
     *
     * @Route("/advancedform", name="major_advancedform")
     * @Template()
     */
    public function advancedformAction()
    {
        $major = new Major();
        $major->setCheckedin('1');
        $major->setHonors('2');
        $major->setHours('0');
        $major->setGpa('0');
        $major->setStatus('0');

        $form = $this->createFormBuilder($major)
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
            ->add('status','choice', array('choices' => array('0'=>'Active','1'=> 'Graduated','2'=> 'Inactive'),'expanded'=>true,))     
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
        $status = $postData['status'];
        $honors = $postData['honors'];
        $hours = $postData['hours'];
        $gpa = $postData['gpa'];
        $em = $this->getDoctrine()->getManager();
        if ($checkedin == 0) {$queryCheckedin = " AND m.checkedin ='0' ";} else {$queryCheckedin = " AND m.checkedin ='1' ";};
        if ($honors == 0) {$queryHonors = " AND m.honors ='0' ";} elseif ($honors == 1) {$queryHonors = " AND m.honors ='1' ";} else {$queryHonors = '';};
        $dql1 = "SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e 
            WHERE LOWER(m.name) LIKE ?1 AND LOWER(m.email) LIKE ?2 AND LOWER(m.firstMajor) LIKE ?3 AND LOWER(m.secondMajor) LIKE ?4 AND LOWER(m.aoe) 
            LIKE ?5 AND LOWER(m.minor) LIKE ?6 AND m.can LIKE ?7 AND m.hours >= ?8 AND m.can >= ?9 AND m.status= ?10 ". $queryCheckedin . $queryHonors ." ORDER BY m.name";
        $majors = $em->createQuery($dql1)->setParameter('1',$name)->setParameter('2',$email)->setParameter('3',$firstMajor)->setParameter('4',$secondMajor)->setParameter('5',$aoe)->setParameter('6',$minor)->setParameter('7',$can)->setParameter('8',$hours)->setParameter('9',$gpa)->setParameter('10',$status)->getResult();
        $form = $this->createFormBuilder(new Major())
            ->add('name')
            ->getForm();
        if (!$majors) {

            return $this->redirect($this->generateUrl('major_advancedform'));
        }
        return $this->render('EnglishMajorsBundle:Major:index.html.twig', array('entities' => $majors, 'form' => $form->createView()));
        }          
        
    /**
     * Finds and displays a Major entity.
     *
     * @Route("/{id}/show", name="major_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $major = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$major) {
            throw $this->createNotFoundException('Unable to find Majors.');
        }
        $notes = $em->createQuery('SELECT n
                FROM EnglishMajornotesBundle:Majornote n, EnglishMajorsBundle:Major m WHERE n.mentorId = ?1 ORDER BY n.created DESC')->setParameter('1',$id)->getResult();
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'major'      => $major,
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
        $major = new Major();
        $major -> setStatus('0');
        $major -> setFirstMajor('ENGL');
        $major -> setSecondMajor('none');
        $major -> setMinor('none');
        $major -> setAoe('none');
        $major -> setHonors(false);
        $major -> setCan('810');
        $major -> setCheckedin(false);
        $major -> setEmail('needed');
        $form   = $this->createForm(new MajorType(), $major);

        return array(
            'major' => $major,
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
        $userid = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();
        
        $major  = new Major();
        
        $major->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new MajorType(), $major);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($major);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $major->getId())));
            
        }

        return array(
            'major' => $major,
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
        $em = $this->getDoctrine()->getManager();

        $major = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$major) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm = $this->createForm(new MajorType(), $major);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'major'      => $major,
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
        $em = $this->getDoctrine()->getManager();

        $major = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

        if (!$major) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm   = $this->createForm(new MajorType(), $major);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($major);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $id)));
        }

        return array(
            'major'      => $major,
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

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $major = $em->getRepository('EnglishMajorsBundle:Major')->find($id);

            if (!$major) {
                throw $this->createNotFoundException('Unable to find Major entity.');
            }

            $em->remove($major);
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

<?php

namespace English\MajorsBundle\Controller;

use Proxies\__CG__\English\PeopleBundle\Entity\People;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\MajorsBundle\Entity\Major;
use English\MajorsBundle\Form\MajorType;
use English\MajorsBundle\Form\FindType;

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
        $em = $this->getDoctrine()->getManager();

        $major= new Major();
        $find_form = $this->createFindForm($major);

        if ($this->get('security.context')->isGranted('ROLE_ADVISORADMIN')) {
            $majors = $em->getRepository('EnglishMajorsBundle:Major')->findMajors();
        } else {
        $username = $this->getUser()->getUsername();
            $majors = $em->getRepository('EnglishMajorsBundle:Major')->findMajorsByUsername($username);
        }
        return array('majors' => $majors, 'find_form' => $find_form->createView(),);
    }


     /**
     * Lists all Majors by Advisor.
     *
     * @Route("/{id}/findbyadvisor", name="major_findbyadvisor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbyadvisorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $major= new Major();
        $find_form = $this->createFindForm($major);

        $majors = $em->getRepository('EnglishMajorsBundle:Major')->findMajorsByAdvisor($id);
        return array('majors' => $majors, 'find_form' => $find_form->createView(),);
    } 
    
        
    /**
     * Lists all majors by mentor.
     *
     * @Route("/{id}/findbymentor", name="major_findbymentor")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
     */
    public function findbymentorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $major= new Major();
        $find_form = $this->createFindForm($major);

        $majors = $em->getRepository('EnglishMajorsBundle:Major')->findMajorsByMentor($id);

        return array('majors' => $majors, 'find_form' => $find_form->createView(),);
    }
    
    /**
     * Find Majors
     *
     * @Route("/find", name="major_find")
     * @Method("post")
     */
    public function findAction(Request $request)
    {
        $major= new Major();
        $find_form = $this->createFindForm($major);
        $find_form->handleRequest($request);
        $name = $find_form->get('name')->getData() . "%";
        $name = strtolower($name);

        $em = $this->getDoctrine()->getManager();


        $majors = $em->getRepository('EnglishMajorsBundle:Major')->findMajorsByName($name);

        if (!$majors) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }
        return $this->render('EnglishMajorsBundle:Major:index.html.twig', array('majors' => $majors, 'find_form' => $find_form->createView()));
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
     * Displays a form to create an advance find
     *
     * @Route("/advancedform", name="major_advancedform")
     * @Template()
     */
    public function advancedformAction()
    {
        $major = new Major();
        $find_form = $this->createFindForm($major);


        $major->setHonors('2');
        $major->setHours('0');
        $major->setGpa('0');
        $major->setStatus('0');

        $form = $this->createFormBuilder($major)
            ->add('name', 'text', array('attr' => array('class' => 'form-control')))
            ->add('email', 'text', array('attr' => array('class' => 'form-control')))
            ->add('firstMajor', 'text', array('attr' => array('class' => 'text form-control')))
            ->add('secondMajor', 'text', array('required' => false,'attr' => array('class' => 'text form-control')))
            ->add('aoe', 'text', array('attr' => array('required' => false,'class' => 'text form-control')))
            ->add('can', 'text', array('attr' => array('required' => false,'class' => 'text form-control')))
            ->add('minor', 'text', array('attr' => array('required' => false,'class' => 'text form-control')))
            ->add('honors','choice', array('choices' => array('0'=>'No','1'=> 'Yes','2'=>'Both'),'expanded'=>true,))
            ->add('gpa', 'number', array('label'=>'GPA (greater than)','attr' => array('required' => false,'class' => 'form-control')))
            ->add('hours', 'number', array('label'=>'Hours (greater than)','attr' => array('required' => false,'class' => 'form-control')))
            ->add('status','choice', array('choices' => array('0'=>'Active','1'=> 'Graduated','2'=> 'Inactive'),'expanded'=>true,))
            ->getForm();



        return array(
             'form'   => $form->createView(), 'find_form' => $find_form->createView(),
        );
    }       
        
        
   /**
     * Find Majors through advanced search
     *
     * @Route("/advancedfind", name="major_advancedfind")
     * @Template("EnglishMajorsBundle:Major:index.html.twig")
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
        $status = $postData['status'];
        $honors = $postData['honors'];
        $hours = $postData['hours'];
        $gpa = $postData['gpa'];
        $em = $this->getDoctrine()->getManager();

        $major= new Major();
        $find_form = $this->createFindForm($major);


        if ($honors == 0) {$queryHonors = " AND m.honors ='0' ";} elseif ($honors == 1) {$queryHonors = " AND m.honors ='1' ";} else {$queryHonors = '';};
        $dql1 = "SELECT m.id,m.name,m.email,a.name as aName,e.name as eName,m.firstMajor,m.secondMajor,m.aoe,m.updated,m.hours,m.can,m.checkedin,m.gpa
            FROM EnglishMajorsBundle:Major m JOIN m.advisor a JOIN m.mentor e 
            WHERE LOWER(m.name) LIKE ?1 AND LOWER(m.email) LIKE ?2 AND LOWER(m.firstMajor) LIKE ?3 AND LOWER(m.secondMajor) LIKE ?4 AND LOWER(m.aoe) 
            LIKE ?5 AND LOWER(m.minor) LIKE ?6 AND m.can LIKE ?7 AND m.hours >= ?8 AND m.can >= ?9 AND m.status= ?10 ". $queryHonors ." ORDER BY m.name";
        $majors = $em->createQuery($dql1)->setParameter('1',$name)->setParameter('2',$email)->setParameter('3',$firstMajor)->setParameter('4',$secondMajor)->setParameter('5',$aoe)->setParameter('6',$minor)->setParameter('7',$can)->setParameter('8',$hours)->setParameter('9',$gpa)->setParameter('10',$status)->getResult();
        if (!$majors) {

            return $this->redirect($this->generateUrl('major_advancedform'));
        }
        return array('majors' => $majors, 'find_form' => $find_form->createView(),);
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
        $find_form = $this->createFindForm($major);

        if (!$major) {
            throw $this->createNotFoundException('Unable to find Majors.');
        }
        $notes = $em->getRepository('EnglishMajorsBundle:Major')->findMajorNotesByAdvisor($id);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'major'      => $major,
            'notes'       => $notes,
            'delete_form' => $deleteForm->createView(),
            'find_form' => $find_form->createView()
        );
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
        $find_form = $this->createFindForm($major);
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
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()

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

        $major = new Major();
        $find_form = $this->createFindForm($major);
        
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
            'form'   => $form->createView(),
            'find_form' => $find_form->createView()
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

        $major = new Major();
        $find_form = $this->createFindForm($major);

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
            'find_form' => $find_form->createView()
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

        $major = new Major();
        $find_form = $this->createFindForm($major);

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
            'find_form' => $find_form->createView()
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

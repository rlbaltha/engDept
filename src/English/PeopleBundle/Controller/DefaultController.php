<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PeopleBundle\Entity\People;
use English\PeopleBundle\Form\PeopleType;
use English\PeopleBundle\Form\AdminPeopleType;
use English\PeopleBundle\Form\FindType;
use English\MajorsBundle\Entity\Major;
use English\MajorsBundle\Form\MajorType;


/**
 * People Public controller.
 *
 * @Route("/directory")
 */
class DefaultController extends Controller
{
    /**
     * Lists all People for directory.
     *
     * @Route("/", name="directory")
     * @Template("EnglishPeopleBundle:Default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $heading = 1;
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $lastname = $form->get('lastName')->getData() . "%";
            $lastname = strtolower($lastname);
            $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByLastname($lastname);

        } else {
            $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleIndex();
        }

        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'form' => $form->createView(),);
    }

    /**
     * Creates a find form
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createFindForm(People $people)
    {
        $form = $this->createForm(new FindType(), $people, array(
            'action' => $this->generateUrl('directory'),
            'method' => 'POST',
        ));
        $form->add('lastName', 'text', array('label' => ' ', 'attr' => array('class' => 'form-control', 'placeholder' => 'Search'),));

        return $form;
    }


    /**
     * Find Grad People
     *
     * @Route("/gradfac", name="people_gradfac")
     * @Template("EnglishPeopleBundle:Default:index.html.twig")
     */
    public function gradfacAction()
    {
        $heading = 1;
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $people= $em->getRepository('EnglishPeopleBundle:People')->findGradFaculty();
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        return array('heading' => $heading,'areas' => $areas, 'people' => $people, 'form' => $form->createView(), 'gradform' => $gradform->createView());
    }


    /**
     * Finds and displays a People by area.
     *
     * @Route("/{area}/area", name="directory_area")
     * @Template("EnglishPeopleBundle:Default:index.html.twig")
     */
    public function areaAction($area)
    {
        $heading = 1;
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByArea($area);
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'form' => $form->createView(),);
    }

    /**
     * Finds and displays a People by type.
     *
     * @Route("/{type}/type", name="directory_type")
     * @Template("EnglishPeopleBundle:Default:index.html.twig")
     */
    public function typeAction($type)
    {
        $heading = $type;
        if ($type == 1) {
            $typeWc = 'Faculty';
        } elseif ($type == 2) {
            $typeWc = 'Instructor';
        } elseif ($type == 3) {
            $typeWc = 'Administration';
        } elseif ($type == 4) {
            $typeWc = 'Graduate Student';
        } else {
            $typeWc = 'Retired';
        }
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByType($typeWc);
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'form' => $form->createView(),);
    }

    /**
     * Finds and displays detail of People.
     *
     * @Route("/{id}/detail", name="directory_detail")
     * @Template("EnglishPeopleBundle:Default:detail.html.twig")
     */
    public function detailAction($id)
    {
        $heading = 1;
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $form = $this->createFindForm($people);
        $people= $em->getRepository('EnglishPeopleBundle:People')->find($id);
        $username = $people->getUsername();
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $peopleCourses =$em->getRepository('EnglishPeopleBundle:People')->findPeopleCourses($id);
        $grads =$em->getRepository('EnglishPeopleBundle:People')->findGradsByAdvisor($people);
        return array('people' => $people, 'peopleCourses' => $peopleCourses, 'grads'=>$grads, 'heading' => $heading, 'form' => $form->createView(),'areas' => $areas,'user' => $user);

    }


    /**
     * Finds and displays user profile
     *
     * @Route("/profile", name="people_profile")
     * @Template("EnglishPeopleBundle:Default:detail.html.twig")
     */
    public function profileAction()
    {
        $heading = 1;
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $form = $this->createFindForm($people);
        $username=$this->getUser()->getUsername();
        $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);
        $id = $people->getId();
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $peopleCourses =$em->getRepository('EnglishPeopleBundle:People')->findPeopleCourses($id);
        $grads =$em->getRepository('EnglishPeopleBundle:People')->findGradsByAdvisor($people);
        return array('people' => $people, 'peopleCourses' => $peopleCourses, 'grads'=>$grads, 'heading' => $heading, 'form' => $form->createView(),'areas' => $areas,'user' => $user);

    }


    /**
     * Displays a form to edit an existing People entity.
     *
     * @Route("/{id}/edit", name="people_edit")
     * @Template("EnglishPeopleBundle:People:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $heading = 1;
        $people = new People();
        $form = $this->createFindForm($people);
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();

        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }


        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $editForm = $this->createForm(new AdminPeopleType(), $people);
        }
        else  {
            $editForm = $this->createForm(new PeopleType(), $people);
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'people'      => $people,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'areas' => $areas,
            'heading' => $heading,
            'form' => $form->createView(),
        );
    }


    /**
     * Edits an existing People entity.
     *
     * @Route("/{id}/update", name="people_update")
     * @Method("post")
     * @Template("EnglishPeopleBundle:People:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        $editForm   = $this->createForm(new PeopleType(), $people);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->submit($request);

        if ($editForm->isValid()) {
            $em->persist($people);
            $em->flush();
            if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
                return $this->redirect($this->generateUrl('directory_detail', array('id' => $id)));
            } else {
                return $this->redirect($this->generateUrl('people_profile'));
            }
        }

        return array(
            'people'      => $people,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a People entity.
     *
     * @Route("/{id}/delete", name="people_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);

            if (!$people) {
                throw $this->createNotFoundException('Unable to find People entity.');
            }

            $em->remove($people);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('people'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }

    /**
     * @Route("/whoismymentor", name="whoismymentor")
     * @Template()
     */
    public function findMentorAction()
    {
        $mentor = "None found";
        if ($this->get('request')) {
            $request = $this->get('request');
            $postData = $request->request->get('form');
            $email = $postData['email'];
            $email = strtolower($email);

            $em = $this->getDoctrine()->getManager();
            $dql1 = "SELECT n.name as mname,a.name as aname FROM EnglishMajorsBundle:Major m JOIN m.mentor n JOIN m.advisor a WHERE LOWER(m.email) = ?1";
            $mentor = $em->createQuery($dql1)->setParameter('1', $email)->getResult();
            if ($email == '') {
                $notification = 'Please enter your email address.';
            } elseif (!$mentor) {
                $notification = 'We did not find your email address.  Please try again.';
            } else {
                $notification = 'Check the People listing above for contact information.';
            }
        };
        $form = $this->createFormBuilder(new Major())
            ->add('email')
            ->getForm();
        return $this->render('EnglishPeopleBundle:Default:findMentor.html.twig', array('mentor' => $mentor, 'notification' => $notification, 'form' => $form->createView(),));
    }

}

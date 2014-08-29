<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'search_form' => $form->createView(),);
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
        $form->add('lastName', 'text', array('label' => 'Search', 'attr' => array('class' => 'form-control', 'placeholder' => 'Lastname'),));

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
        return array('heading' => $heading,'areas' => $areas, 'people' => $people, 'search_form' => $form->createView(), 'gradform' => $gradform->createView());
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
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'search_form' => $form->createView(),);
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
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'search_form' => $form->createView(),);
    }

    /**
     * Finds and displays detail of People  (user and viewer are NOT necessarily the same).
     *
     * @Route("/{id}/detail", name="directory_detail")
     * @Template("EnglishPeopleBundle:Default:detail.html.twig")
     */
    public function detailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $heading = 1;
        $people= $em->getRepository('EnglishPeopleBundle:People')->find($id);


        if ($this->get('security.context')->isGranted('ROLE_USER')) {

            $user=$this->getUser();
            $username=$user->getUsername();
            $current_user_people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);
            $peopleid=$current_user_people->getId();
        }
        else {
            $user= null;
            $peopleid=0;
        }
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($people->getUsername());

        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $peopleCourses =$em->getRepository('EnglishPeopleBundle:People')->findPeopleCourses($id);
        $grads =$em->getRepository('EnglishPeopleBundle:People')->findGradsByAdvisor($people);
        $gradcom =$em->getRepository('EnglishPeopleBundle:People')->findGradComm($people);
        $notes =$em->getRepository('EnglishPeopleBundle:People')->findGradNotes($id, $peopleid);
        return array('people' => $people, 'peopleCourses' => $peopleCourses, 'grads'=>$grads, 'gradcom'=>$gradcom, 'notes'=>$notes,'heading' => $heading, 'search_form' => $form->createView(),'areas' => $areas,'user' => $user,'userid' => $peopleid);

    }


    /**
     * Finds and displays user profile (user and viewer are the same)
     *
     * @Route("/profile", name="people_profile")
     * @Template("EnglishPeopleBundle:Default:detail.html.twig")
     */
    public function profileAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $people = new People();
        $form = $this->createFindForm($people);
        $heading = 1;

        $user=$this->getUser();
        $username=$user->getUsername();
        $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);

        if (!$people) {
            $userManager = $this->get('fos_user.user_manager');
            $user=$this->getUser();
            $userManager->deleteUser($user);
            $session = $this->get('session');
            $session->clear();
            throw new AccessDeniedException();
        }

        $peopleid=$people->getId();

        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $peopleCourses =$em->getRepository('EnglishPeopleBundle:People')->findPeopleCourses($peopleid);
        $grads =$em->getRepository('EnglishPeopleBundle:People')->findGradsByAdvisor($people);
        $gradcom =$em->getRepository('EnglishPeopleBundle:People')->findGradComm($people);
        $notes =$em->getRepository('EnglishPeopleBundle:People')->findGradNotes($peopleid, $peopleid);
        return array('people' => $people, 'peopleCourses' => $peopleCourses, 'grads'=>$grads,'gradcom'=>$gradcom, 'notes'=>$notes, 'heading' => $heading, 'search_form' => $form->createView(),'areas' => $areas,'user' => $user,'userid' => $peopleid);

    }


    /**
     * Displays a form to create a new People entity.
     *
     * @Route("/new", name="people_new")
     * @Template("EnglishPeopleBundle:People:new.html.twig")
     */
    public function newAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $heading = 1;
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $gradinfo = $em->getRepository('EnglishGradinfoBundle:Gradinfo')->findOneByStatus('NA');

        $people = new People();
        $people->setGradinfo($gradinfo);
        $newForm = $this->createForm(new PeopleType(), $people);
        $form = $this->createFindForm($people);

        return array(
            'people' => $people,
            'areas' => $areas,
            'heading' => $heading,
            'form' => $newForm->createView(),
            'search_form'=> $form->createView()
        );
    }

    /**
     * Creates a new People entity.
     *
     * @Route("/create", name="people_create")
     * @Method("post")
     * @Template("EnglishPeopleBundle:People:new.html.twig")
     */
    public function createAction()
    {

        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $heading = 1;
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        $people = new People();
        $request = $this->getRequest();
        $postData = $request->get('english_peoplebundle_peopletype');
        $username = $postData['username'];
        $email = $postData['email'];
        $pw = substr(str_shuffle(MD5(microtime())), 0, 10);
        $form = $this->createForm(new PeopleType(), $people);
        $form->submit($request);

        if ($form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->createUser();
            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($pw);
            $user->setEnabled(true);
            $userManager->updateUser($user);
            $em->persist($people);
            $em->flush();

            return $this->redirect($this->generateUrl('directory_detail', array('id' => $people->getId())));

        }

        return array(
            'people' => $people,
            'areas' => $areas,
            'heading' => $heading,
            'form' => $form->createView()
        );
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

        $people_username=$people->getUsername();
        $user=$this->getUser();
        $username=$user->getUsername();

        if ($this->get('security.context')->isGranted('ROLE_ADMIN') or $people_username==$username) {
            if (!$people) {
                throw $this->createNotFoundException('Unable to find People entity.');
            }

            $editForm = $this->createForm(new PeopleType(), $people);

            $deleteForm = $this->createDeleteForm($id);

            return array(
                'people'      => $people,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
                'areas' => $areas,
                'heading' => $heading,
                'search_form' => $form->createView(),
            );
        }
        else {
            throw new AccessDeniedException();
        }


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
        if (false === $this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

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
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);

            if (!$people) {
                throw $this->createNotFoundException('Unable to find People entity.');
            }
            $userManager = $this->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($people->getUsername());
            $userManager->deleteUser($user);
            $em->remove($people);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('directory'));
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

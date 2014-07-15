<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\PeopleBundle\Entity\People;
use English\PeopleBundle\Form\PeopleType;
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
        $em = $this->get('doctrine.orm.entity_manager');
        $people = new People();
        $form = $this->createFindForm($people);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            $lastname = $form->get('lastName')->getData() . "%";
            $lastname = strtolower($lastname);
            $em = $this->getDoctrine()->getManager();
            $dql1 = "SELECT p FROM EnglishPeopleBundle:People p join p.gradinfo g WHERE LOWER(p.lastName) LIKE ?1 AND g.status!='Inactive' ORDER BY p.lastName,p.firstName";
            $people = $em->createQuery($dql1)->setParameter('1', $lastname)->getResult();
        } else {
            $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM
            EnglishPeopleBundle:People p JOIN p.position o WHERE o.position = ?1 ORDER BY p.lastName,p.firstName";
            $people = $em->createQuery($dql1)->setParameter('1', 'Faculty')->getResult();
        }
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'form' => $form->createView(),);
    }

    /**
     * Creates a find form
     *
     * @param People $entity The entity
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
     * Finds and displays a People by area.
     *
     * @Route("/{area}/area", name="directory_area")
     * @Template("EnglishPeopleBundle:Default:index.html.twig")
     */
    public function areaAction($area)
    {
        $heading = 1;
        $em = $this->get('doctrine.orm.entity_manager');
        $people = new People();
        $form = $this->createFindForm($people);
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p JOIN p.position o JOIN p.area a WHERE o.position = 'Faculty' AND a.id = ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1', $area)->getResult();
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
        $em = $this->get('doctrine.orm.entity_manager');
        $people = new People();
        $form = $this->createFindForm($people);
        $dql1 = "SELECT p.id,p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.username FROM English\PeopleBundle\Entity\People p JOIN p.position o WHERE o.position = ?1 ORDER BY p.lastName,p.firstName";
        $people = $em->createQuery($dql1)->setParameter('1', $typeWc)->getResult();
        $areas = $em->getRepository('EnglishAreasBundle:Area')->findAll();
        return array('people' => $people, 'areas' => $areas, 'heading' => $heading, 'form' => $form->createView(),);
    }

    /**
     * Finds and displays detail of People.
     *
     * @Route("/{id}/detail", name="directory_detail")
     * @Template()
     */
    public function detailAction($id)
    {
        $heading = 1;
        $people = new People();
        $form = $this->createFindForm($people);
        $em = $this->get('doctrine.orm.entity_manager');
        $dql1 = "SELECT p.lastName,p.firstName,p.email,p.title,p.officeNumber,p.officePhone,p.bio,p.photoUrl,p.homepageUrl,p.vitaUrl,p.officeHours FROM EnglishPeopleBundle:People p WHERE p.id = ?1";
        $peopleDetail = $em->createQuery($dql1)->setParameter('1', $id)->getResult();
        $dql2 = "SELECT c.courseName,c.title,c.instructorName,c.callNumber,c.callNumber2,c.days,c.time,c.id,t.termName,t.term FROM EnglishCoursesBundle:Course c, EnglishPeopleBundle:People p, EnglishTermBundle:Term t WHERE LOWER(c.instructorName) = LOWER(p.oasisname) AND c.term = t.term AND t.type = '2' AND p.id = ?1 ORDER BY t.termName,c.courseName";
        $peopleCourses = $em->createQuery($dql2)->setParameter('1', $id)->getResult();
        return $this->render('EnglishPeopleBundle:Default:detail.html.twig', array('peopleDetail' => $peopleDetail, 'peopleCourses' => $peopleCourses, 'heading' => $heading, 'form' => $form->createView(),));

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

            $em = $this->get('doctrine.orm.entity_manager');
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

<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use FOS\UserBundle\Entity\UserManager;
use English\PeopleBundle\Entity\People;
use English\PeopleBundle\Form\PeopleType;
use English\PeopleBundle\Form\AdminPeopleType;

/**
 * People controller.
 *
 * @Route("/people")
 */
class PeopleController extends Controller
{
    
    /**
     * Find People
     *
     * @Route("/find", name="people_find")
     * @Method("post")
     * @Template("EnglishPeopleBundle:People:index.html.twig")
     */
    public function findAction()
    {   $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $postData = $request->request->get('form');
        $lastname = $postData['lastName'] . "%";
        $lastname = strtolower($lastname);
        $people= $em->getRepository('EnglishPeopleBundle:People')->findPeopleByLastname($lastname);
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        return array('people' => $people, 'form' => $form->createView());
        }     

    /**
     * Find Grad People
     *
     * @Route("/grad", name="people_grad")
     * @Template("EnglishPeopleBundle:People:index.html.twig")
     */        
    public function gradAction()
    {
        $em = $this->getDoctrine()->getManager();
        $people= $em->getRepository('EnglishPeopleBundle:People')->findGrads();
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        return array('people' => $people, 'form' => $form->createView(), 'gradform' => $gradform->createView());
    }
    
    /**
     * Find Grad People
     *
     * @Route("/gradfac", name="people_gradfac")
     * @Template("EnglishPeopleBundle:People:index.html.twig")
     */        
    public function gradfacAction()
    {
        $em = $this->getDoctrine()->getManager();
        $people= $em->getRepository('EnglishPeopleBundle:People')->findGradFaculty();
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        return array('people' => $people, 'form' => $form->createView(), 'gradform' => $gradform->createView());
    }    
    
     /**
     * Find My Grad
     *
     * @Route("/mygrad", name="people_mygrad")
     * 
     */   
    public function mygradAction()
    {   
        $username = $this->get('security.context')->getToken()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username);
        $em = $this->getDoctrine()->getManager();
        $entities = $em->createQuery('SELECT p FROM EnglishGradcomBundle:Gradcom g,EnglishPeopleBundle:People p WHERE g.gid=p.id AND 
            g.people = ?1 ORDER BY p.lastName')->setParameter('1',$people)->getResult(); 
        
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        
        
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
               
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView(), 'gradform' => $gradform->createView()));
    }
    
        
     /**
     * Find Grad
     *
     * @Route("/gradfind", name="grad_find")
     * @Method("post")
     */
    public function gradfindAction()
    {   $request = $this->get('request');
        $postData = $request->request->get('form');
        $lastname = $postData['lastName'] . "%";
        $lastname = strtolower($lastname);
        $em = $this->getDoctrine()->getManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p WHERE p.gradinfo != 3 AND p.gradinfo != 4 AND LOWER(p.lastName) LIKE ?1 ORDER BY p.lastName,p.firstName";
        $entities = $em->createQuery($dql1)->setParameter('1',$lastname)->getResult();
        
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        
        if (!$entities) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView(), 'gradform' => $gradform->createView()));
        }  

    /**
     * Finds and displays a People entity.
     *
     * @Route("/{id}/show", name="people_show")
     * @Template()
     */
    public function showAction($id)
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username);
        $userid = $people->getId(); 
        
        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);
        $status = $people->getGradinfo()->getStatus();
        $areas = $em->createQuery('SELECT a.area FROM EnglishPeopleBundle:People p JOIN p.area a WHERE p.id = ?1 ORDER BY a.area')->setParameter('1',$id)->getResult();
        
        
        $gradcom = $em->createQuery('SELECT p.lastName,p.firstName,g.frole,g.id FROM EnglishGradcomBundle:Gradcom g JOIN g.people p WHERE g.gid = ?1 ORDER BY p.lastName')->setParameter('1',$id)->getResult(); 
        $join = $em->createQuery('SELECT count(g.id) FROM EnglishGradcomBundle:Gradcom g WHERE g.people = ?1 AND g.gid = ?2')->setParameter('1',$people)->setParameter('2',$id)->getSingleResult(); 
        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        $notes = $em->createQuery('SELECT g FROM EnglishGradnotesBundle:Gradnotes g WHERE g.gid = ?1 AND g.userid = ?2 
            ORDER BY g.created DESC')->setParameter('1',$id)->setParameter('2',$userid)->getResult();      

        $deleteForm = $this->createDeleteForm($id);
        return array(
            'userid'     => $userid,
            'areas'       => $areas,
            'people'      => $people,
            'gradcom'     => $gradcom,
            'notes'       => $notes,
            'join'        => $join,
            'status'        => $status,
            'delete_form' => $deleteForm->createView(),        );
    }
    
    /**
     * Finds and displays a People entity.
     *
     * @Route("/{id}/showgradcomm", name="people_showgradcomm")
     * @Template()
     */
    public function showgradcommAction($id)
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $user = $this->getDoctrine()->getManager()->getRepository('EnglishPeopleBundle:People')->findOneById($id);
        
        
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->find($id);
      
        $gradcomphd = $em->createQuery('SELECT r.lastName,r.firstName,g.frole,g.id,i.status FROM EnglishGradcomBundle:Gradcom g JOIN g.people p JOIN g.grad r JOIN r.gradinfo i WHERE g.people = ?1 AND r.gradinfo=2 ORDER BY p.lastName')->setParameter('1',$user)->getResult(); 
        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        $gradcomma = $em->createQuery('SELECT r.lastName,r.firstName,g.frole,g.id,i.status FROM EnglishGradcomBundle:Gradcom g JOIN g.people p JOIN g.grad r JOIN r.gradinfo i WHERE g.people = ?1 AND r.gradinfo=1 ORDER BY p.lastName')->setParameter('1',$user)->getResult(); 
        if (!$people) {
            throw $this->createNotFoundException('Unable to find People entity.');
        } 
        
        
        return array(
            'people'      => $people,
            'gradcomphd'     => $gradcomphd,
            'gradcomma'     => $gradcomma,
                   );
    }    

    /**
     * Displays a form to create a new People entity.
     *
     * @Route("/new", name="people_new")
     * @Template()
     */
    public function newAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $people = new People();
        $people->setUsername($username);
        $form   = $this->createForm(new PeopleType(), $people);

        return array(
            'people' => $people,
            'form'   => $form->createView()
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
        $username = $this->get('security.context')->getToken()->getUsername();
        
        $people  = new People();
        
        $people->setUsername($username);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new PeopleType(), $people);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($people);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $people->getId())));
            
        }

        return array(
            'people' => $people,
            'form'   => $form->createView()
        );
    }




     /**
     * promote Users
     *
     * @Route("/{username}/{role}/promote", name="people_promote")
     * @Template()
     */   
    public function promoteuserAction($username,$role)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->addRole($role);
        $userManager->updateUser($user);
        return $this->render('EnglishPeopleBundle:People:adminlist.html.twig', array('user' => $user));
        };
    }  
    
     /**
     * demote Users
     *
     * @Route("/{username}/{role}/demote", name="people_demote")
     * @Template()
     */   
    public function demoteuserAction($username,$role)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        $user->removeRole($role);
        $userManager->updateUser($user);
        return $this->render('EnglishPeopleBundle:People:adminlist.html.twig', array('user' => $user));
        };
    } 

    
}

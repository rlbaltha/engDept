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
     * Lists all People
     *
     * @Route("/", name="people")
     */
    public function indexAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p ORDER BY p.lastName,p.firstName";
        $entities = $em->createQuery($dql1)->getResult();
        
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView(), 'gradform' => $gradform->createView()));
        
        
        } else {
        $username = $this->get('security.context')->getToken()->getUsername();
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username);
        
        if (!$entity) {
            return $this->redirect($this->generateUrl('people_new'));
        }        

        
        $userid = $entity->getId(); 
        $gradcom = $em->createQuery('SELECT p.lastName,p.firstName,g.frole,g.id FROM EnglishGradcomBundle:Gradcom g JOIN g.people p WHERE g.gid = ?1 ORDER BY p.lastName')->setParameter('1',$userid)->getResult();
        $notes = $em->createQuery('SELECT g FROM EnglishGradnotesBundle:Gradnotes g WHERE g.gid = ?1 AND g.userid = ?2 
            ORDER BY g.created DESC')->setParameter('1',$userid)->setParameter('2',$userid)->getResult();   
        $status = $entity->getGradinfo()->getStatus();
        $areas = $em->createQuery('SELECT a.area FROM EnglishPeopleBundle:People p JOIN p.area a WHERE p.id = ?1 ORDER BY a.area')->setParameter('1',$userid)->getResult();
        
        return $this->render('EnglishPeopleBundle:People:show.html.twig', array('entity' => $entity, 'userid' => $userid,'gradcom' => $gradcom,'userid' => $userid,'status'        => $status,'notes' => $notes, 'areas' => $areas));
        } 
    }
    
    /**
     * Find People
     *
     * @Route("/find", name="people_find")
     * @Method("post")
     */
    public function findAction()
    {   $request = $this->get('request');
        $postData = $request->request->get('form');
        $lastname = $postData['lastName'] . "%";
        $lastname = strtolower($lastname);
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p WHERE LOWER(p.lastName) LIKE ?1 ORDER BY p.lastName,p.firstName";
        $entities = $em->createQuery($dql1)->setParameter('1',$lastname)->getResult();
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        if (!$entities) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView()));
        }     

    /**
     * Find Grad People
     *
     * @Route("/grad", name="people_grad")
     */        
    public function gradAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p WHERE p.gradinfo != 3 ORDER BY p.lastName,p.firstName";
        $entities = $em->createQuery($dql1)->getResult();
        
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        
        
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
               
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView(), 'gradform' => $gradform->createView()));
    }
    
    /**
     * Find Grad People
     *
     * @Route("/gradfac", name="people_gradfac")
     */        
    public function gradfacAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p join p.position o WHERE o.position='Graduate Faculty' ORDER BY p.lastName,p.firstName";
        $entities = $em->createQuery($dql1)->getResult();
        
        $form = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
        
        
        $gradform = $this->createFormBuilder(new People())
            ->add('lastName')
            ->getForm();
               
        return $this->render('EnglishPeopleBundle:People:index.html.twig', array('entities' => $entities, 'form' => $form->createView(), 'gradform' => $gradform->createView()));
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
        $em = $this->getDoctrine()->getEntityManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username);
        $em = $this->getDoctrine()->getEntityManager();  
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
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT p FROM EnglishPeopleBundle:People p WHERE p.gradinfo != 3 AND LOWER(p.lastName) LIKE ?1 ORDER BY p.lastName,p.firstName";
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
        $em = $this->getDoctrine()->getEntityManager();
        $people = $em->getRepository('EnglishPeopleBundle:People')->findOneById($id);
        $userid = $people->getId(); 
        
        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);
        $status = $entity->getGradinfo()->getStatus();
        $areas = $em->createQuery('SELECT a.area FROM EnglishPeopleBundle:People p JOIN p.area a WHERE p.id = ?1 ORDER BY a.area')->setParameter('1',$id)->getResult();
        
        
        $gradcom = $em->createQuery('SELECT p.lastName,p.firstName,g.frole,g.id FROM EnglishGradcomBundle:Gradcom g JOIN g.people p WHERE g.gid = ?1 ORDER BY p.lastName')->setParameter('1',$id)->getResult(); 
        $join = $em->createQuery('SELECT count(g.id) FROM EnglishGradcomBundle:Gradcom g WHERE g.people = ?1 AND g.gid = ?2')->setParameter('1',$people)->setParameter('2',$id)->getSingleResult(); 
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        $notes = $em->createQuery('SELECT g FROM EnglishGradnotesBundle:Gradnotes g WHERE g.gid = ?1 AND g.userid = ?2 
            ORDER BY g.created DESC')->setParameter('1',$id)->setParameter('2',$userid)->getResult();      

        $deleteForm = $this->createDeleteForm($id);
        return array(
            'userid'     => $userid,
            'areas'       => $areas,
            'entity'      => $entity,
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
        $user = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneById($id);
        
        
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);
      
        $gradcomphd = $em->createQuery('SELECT r.lastName,r.firstName,g.frole,g.id,i.status FROM EnglishGradcomBundle:Gradcom g JOIN g.people p JOIN g.grad r JOIN r.gradinfo i WHERE g.people = ?1 AND r.gradinfo=2 ORDER BY p.lastName')->setParameter('1',$user)->getResult(); 
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }
        $gradcomma = $em->createQuery('SELECT r.lastName,r.firstName,g.frole,g.id,i.status FROM EnglishGradcomBundle:Gradcom g JOIN g.people p JOIN g.grad r JOIN r.gradinfo i WHERE g.people = ?1 AND r.gradinfo=1 ORDER BY p.lastName')->setParameter('1',$user)->getResult(); 
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        } 
        
        
        return array(
            'entity'      => $entity,
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
        $entity = new People();
        $entity->setUsername($username);
        $form   = $this->createForm(new PeopleType(), $entity);

        return array(
            'entity' => $entity,
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
        
        $entity  = new People();
        
        $entity->setUsername($username);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new PeopleType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing People entity.
     *
     * @Route("/{id}/edit", name="people_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $editForm = $this->createForm(new AdminPeopleType(), $entity);
        }
        else  {
            $editForm = $this->createForm(new PeopleType(), $entity);
        }    
        
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find People entity.');
        }

        $editForm   = $this->createForm(new PeopleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('people_show', array('id' => $id)));
            } else {
            return $this->redirect($this->generateUrl('people'));    
            }
        }

        return array(
            'entity'      => $entity,
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

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishPeopleBundle:People')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find People entity.');
            }

            $em->remove($entity);
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
     * Finds Users
     *
     * @Route("/{username}/admin", name="people_admin")
     * @Template()
     */   
    public function adminAction($username)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($username);
        return $this->render('EnglishPeopleBundle:People:adminlist.html.twig', array('user' => $user));
    }
 
     /**
     * Finds Users
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
     * Finds Users
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
    
     /**
     * Create Users
      * for importing for migration
     *
     * @Route("/createusers", name="people_createusers")
     * * @Template("EnglishPeopleBundle:People:new.html.twig")
     */   
/**    public function createusersAction()
    {

          $em = $this->getDoctrine()->getEntityManager();
          $dql1 = "SELECT p FROM EnglishPeopleBundle:People p WHERE p.email!='' AND p.username!='' AND p.username!='none' AND p.password!='' ORDER BY p.lastName,p.firstName";
          $oldusers = $em->createQuery($dql1)->getResult();  
          $userManager = $this->get('fos_user.user_manager');

          foreach ($oldusers as $item) {
          $newItem = $userManager->createUser();

          //$newItem->setId($item->getObjId());
          // FOSUserBundle required fields
          $newItem->setUsername($item->getUsername());
          $newItem->setEmail($item->getEmail());
          $newItem->setPlainPassword($item->getPassword()); // get original password
          $newItem->setEnabled(true);

          $userManager->updateUser($newItem, true);

        };
        return $this->redirect($this->generateUrl('directory'));

    }     
    
 * 
 */    
    
}

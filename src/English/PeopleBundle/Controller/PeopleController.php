<?php

namespace English\PeopleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
     * promote Users
     *
     * @Route("/{username}/{role}/promote", name="people_promote")
     * @Template()
     */
    public function promoteuserAction($username, $role)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($username);
            $user->addRole($role);
            $userManager->updateUser($user);
            $people = $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);
            return $this->redirect($this->generateUrl('directory_detail', array('id' => $people->getId())));

        };
    }

    /**
     * demote Users
     *
     * @Route("/{username}/{role}/demote", name="people_demote")
     * @Template()
     */
    public function demoteuserAction($username, $role)
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $em = $this->getDoctrine()->getManager();
            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsername($username);
            $user->removeRole($role);
            $userManager->updateUser($user);
            $people = $em->getRepository('EnglishPeopleBundle:People')->findPeopleByUsername($username);
            return $this->redirect($this->generateUrl('directory_detail', array('id' => $people->getId())));
        };
    }


}

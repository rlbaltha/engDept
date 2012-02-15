<?php

namespace English\GradcomBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use English\GradcomBundle\Entity\Gradcom;
use English\GradcomBundle\Form\GradcomType;

/**
 * Gradcom controller.
 *
 * @Route("/gradcom")
 */
class GradcomController extends Controller
{
    /**
     * Lists all Gradcom entities.
     *
     * @Route("/", name="gradcom")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT pg.lastName as glastname, pf.lastName as flastname,g.frole,g.gid FROM EnglishPeopleBundle:People pg, EnglishPeopleBundle:People pf, 
            EnglishGradcomBundle:Gradcom g WHERE pg.id=g.gid and pf.username=g.fid AND g.frole=2 ORDER BY pg.lastName,pg.firstName";
        $entities = $em->createQuery($dql1)->getResult();
        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Gradcom entity.
     *
     * @Route("/{gid}/show", name="gradcom_show")
     * @Template()
     */
    public function showAction($gid)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT pg.lastName as glastname,pg.firstName as gfirstname, pf.lastName as flastname,g.frole,g.gid FROM EnglishPeopleBundle:People pg, EnglishPeopleBundle:People pf, 
            EnglishGradcomBundle:Gradcom g WHERE pg.id=g.gid and pf.username=g.fid AND g.gid = ?1 ORDER BY g.frole DESC";
        $entities = $em->createQuery($dql1)->setParameter('1',$gid)->getResult();
        return array('entities' => $entities);
    }

    /**
     * Displays a form to create a new Gradcom entity.
     *
     * @Route("/{id}/new", name="gradcom_new")
     * @Template()
     */
    public function newAction($id)
    {
        $securityContext = $this->get('security.context');
        $username = $securityContext->getToken()->getUsername();
        $entity = new Gradcom();
        $entity->setGid($id);
        $entity->setFid($username);
        $entity->setStatus('t');
        $form   = $this->createForm(new GradcomType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Gradcom entity.
     *
     * @Route("/create", name="gradcom_create")
     * @Method("post")
     * @Template("EnglishGradcomBundle:Gradcom:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Gradcom();
        $request = $this->getRequest();
        $form    = $this->createForm(new GradcomType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getGid())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Gradcom entity.
     *
     * @Route("/{id}/edit", name="gradcom_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradcom entity.');
        }

        $editForm = $this->createForm(new GradcomType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Gradcom entity.
     *
     * @Route("/{id}/update", name="gradcom_update")
     * @Method("post")
     * @Template("EnglishGradcomBundle:Gradcom:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Gradcom entity.');
        }

        $editForm   = $this->createForm(new GradcomType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('people_show', array('id' => $entity->getGid())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Gradcom entity.
     *
     * @Route("/{id}/{gid}/delete", name="gradcom_delete")
     * @Method("post")
     */
    public function deleteAction($id, $gid)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishGradcomBundle:Gradcom')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gradcom entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('people_show', array('id' => $gid)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

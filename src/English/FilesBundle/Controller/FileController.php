<?php

namespace English\FilesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use English\FilesBundle\Entity\File;
use English\FilesBundle\Form\FileType;

/**
 * File controller.
 *
 * @Route("/file")
 */
class FileController extends Controller
{
    
    /**
     * Uploads a file with a Document entity.
     *
     * @Route("/upload", name="file_upload")
     * @Template()
     */    
     public function uploadAction()
     {
         $username = $this->get('security.context')->getToken()->getUsername();
         $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId();  
         $file = new File();
         $file->setUserid($userid);
         $form = $this->createFormBuilder($file)
             ->add('name')
             ->add('label', 'entity', array('class' => 'EnglishFilesBundle:Label','property'=>'name', 'query_builder' => 
                 function(\English\FilesBundle\Entity\LabelRepository $er) {
                 return $er->createQueryBuilder('l')
                 ->where('l.display = :display')
                 ->setParameter('display', TRUE)          
                 ->orderBy('l.name', 'ASC');
                 }))     
             ->add('description', 'text', array('attr' => array('class' => 'width300')))    
             ->add('userid', 'hidden')    
             ->add('file')
             ->getForm()
         ;

         if ($this->getRequest()->getMethod() === 'POST') {
             $form->bindRequest($this->getRequest());
             if ($form->isValid()) {
                 $em = $this->getDoctrine()->getEntityManager();
                 $file->upload();
                 $em->persist($file);
                 $em->flush(); 
                 return $this->redirect($this->generateUrl('file_show', array('id' => $file->getId())));
             }
             
         }

    return array('form' => $form->createView());
     }


    /**
     * Lists all File entities.
     *
     * @Route("/{labelid}/", name="file")
     * @Template()
     */
    public function indexAction($labelid)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $dql1 = "SELECT f FROM EnglishFilesBundle:File f JOIN f.label l WHERE l.id = ?1 ORDER BY f.name ASC";
        $entities = $em->createQuery($dql1)->setParameter('1',$labelid)->getResult();
        $dql2 = "SELECT l FROM EnglishFilesBundle:Label l WHERE l.display = TRUE";
        $labels = $em->createQuery($dql2)->getResult();
        return array('entities' => $entities, 'labels' => $labels);       
    }

    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}/show", name="file_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishFilesBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/new", name="file_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new File();
        $form   = $this->createForm(new FileType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new File entity.
     *
     * @Route("/create", name="file_create")
     * @Method("post")
     * @Template("EnglishFilesBundle:File:new.html.twig")
     */
    public function createAction()
    {
        $username = $this->get('security.context')->getToken()->getUsername();
        $userid = $this->getDoctrine()->getEntityManager()->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username)->getId(); 
        
        $entity  = new File();
        
        $entity->setUserid($userid);
        
        $request = $this->getRequest();
        $form    = $this->createForm(new FileType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="file_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishFilesBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing File entity.
     *
     * @Route("/{id}/update", name="file_update")
     * @Method("post")
     * @Template("EnglishFilesBundle:File:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('EnglishFilesBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $editForm   = $this->createForm(new FileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a File entity.
     *
     * @Route("/{id}/delete", name="file_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('EnglishFilesBundle:File')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find File entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('file'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    
    /**
     * Finds and displays a File.
     *
     * @Route("/{id}/view", name="file_view")
     * 
     */     
    public function viewAction($id)
	{       
        $em = $this->getDoctrine()->getEntityManager();

        $file = $em->getRepository('EnglishFilesBundle:File')->find($id);

        if (!$file) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }
             $ext = $file->getExt();
		
		$response = new Response();
		
		$response->setStatusCode(200);
                switch ($ext) {
                      case "png":
                      $response->headers->set('Content-Type', 'image/png');
                      break;
                      case "gif":
                      $response->headers->set('Content-Type', 'image/gif');
                      break;
                      case "jpg":
                      $response->headers->set('Content-Type', 'image/jpeg');
                      break;
                      case "odt":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.text');
                      break;
                      case "ods":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.spreadsheet');
                      break;
                      case "odp":
                      $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.presentation');
                      break;
                      case "doc":
                      $response->headers->set('Content-Type', 'application/msword');
                      break;
                      case "ppt":
                      $response->headers->set('Content-Type', 'application/mspowerpoint');
                      break;
                      case "xls":
                      $response->headers->set('Content-Type', 'application/x-msexcel');
                      break;                  
                      case "pdf":
                      $response->headers->set('Content-Type', 'application/pdf');
                      break;
                      default:
                      $response->headers->set('Content-Type', 'application/octet-stream');    
                      }
		$response->setContent( file_get_contents( $file->getAbsolutePath() ));
		
		$response->send();
		
		return $response;
	} 
        
        
}

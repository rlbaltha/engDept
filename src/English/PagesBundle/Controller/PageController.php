<?php

namespace English\PagesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use English\PagesBundle\Entity\Page;
use English\PagesBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("/{sub}/pages", defaults={"sub" = "default"})
 */
class PageController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="pages")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $pages = $em->getRepository('EnglishPagesBundle:Page')->findAll();
        $label = $em->getRepository('EnglishFilesBundle:Label')->findNewsletterLabel();
        $labelid = $label->getId();

        return array(
            'pages' => $pages,
            'labelid' => $labelid,
        );
    }
    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="pages_create")
     * @Method("POST")
     * @Template("EnglishPagesBundle:Page:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $page = new Page();
        $form = $this->createCreateForm($page);
        $form->handleRequest($request);




        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $username=$user->getUsername();
            $people=$pages = $em->getRepository('EnglishPeopleBundle:People')->findOneByUsername($username);

            foreach ($page->getSection()->getPages() as $pages) {
                if ($page->getSortorder() <= $pages->getSortorder()) {
                    $currentsort = $pages->getSortorder();
                    $page->setSortOrder($currentsort + 1);
                }
            }

            $page->setUser($people);
            $em->persist($page);
            $em->flush();

            return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));
        }

        return array(
            'page' => $page,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Page entity.
     *
     * @param Page $page The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Page $page)
    {
        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('pages_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-default','novalidate' => 'novalidate'),));

        return $form;
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/{sectionid}/{pageid}/new", name="pages_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($sectionid, $pageid)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('EnglishPagesBundle:Section')->find($sectionid);
        $parent = $em->getRepository('EnglishPagesBundle:Page')->find($pageid);
        $sort = 1;
        $page = new Page();
        $page->setSection($section);
        $page->setParent($parent);
        $page->setSortorder($sort);
        $form   = $this->createCreateForm($page);
        $label = $em->getRepository('EnglishFilesBundle:Label')->findNewsletterLabel();
        $labelid = $label->getId();

        return array(
            'page' => $page,
            'form'   => $form->createView(),
            'labelid' => $labelid,
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/newsletter", name="pages_newsletter")
     * @Method("GET")
     * @Template("EnglishPagesBundle:Page:show.html.twig")
     */
    public function newsletterAction()
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->findOnNav();
        $id = $page->getId();
        $section = $page->getSection();
        $menu = $em->getRepository('EnglishPagesBundle:Page')->findPageMenu($section);
        $label = $em->getRepository('EnglishFilesBundle:Label')->findNewsletterLabel();
        $labelid = $label->getId();

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'menu'  => $menu,
            'page'      => $page,
            'section'      => $section,
            'delete_form' => $deleteForm->createView(),
            'labelid' => $labelid,
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="pages_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);
        $section = $page->getSection();
        $menu = $em->getRepository('EnglishPagesBundle:Page')->findPageMenu($section);
        $label = $em->getRepository('EnglishFilesBundle:Label')->findNewsletterLabel();
        $labelid = $label->getId();

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'menu'  => $menu,
            'page'      => $page,
            'section'      => $section,
            'delete_form' => $deleteForm->createView(),
            'labelid' => $labelid,
        );
    }



    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="pages_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);
        $label = $em->getRepository('EnglishFilesBundle:Label')->findNewsletterLabel();
        $labelid = $label->getId();

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($page);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'labelid' => $labelid,
        );
    }

    /**
    * Creates a form to edit a Page entity.
    *
    * @param Page $page The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Page $page)
    {
        $form = $this->createForm(new PageType(), $page, array(
            'action' => $this->generateUrl('pages_update', array('id' => $page->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-default'),));

        return $form;
    }
    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="pages_update")
     * @Method("PUT")
     * @Template("EnglishPagesBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);

        $postData = $request->request->get('english_pagesbundle_page');
        $onNav = $postData['on_nav'];

        if ($onNav == 1) {
            $default_page = $em->getRepository('EnglishPagesBundle:Page')->findOnNav();
            $default_page->setOnNav('0');
            $em->persist($default_page);
        }

        if (!$page) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($page);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));
        }

        return array(
            'page'      => $page,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Moves a Project entity up one in the display order.
     *
     * @Route("/{pageid}/{previouspageid}/promote", name="page_promote")
     */
    public function promoteAction($pageid, $previouspageid)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($pageid);
        $currentOrder = $page->getSortorder();
        $previousPage = $em->getRepository('EnglishPagesBundle:Page')->find($previouspageid);
        $previousOrder = $previousPage->getSortorder();
        $page->setSortOrder($previousOrder);
        $previousPage->setSortorder($currentOrder);
        $em->persist($page);
        $em->persist($previousPage);
        $em->flush();

        return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));

    }

    /**
     * Moves a Project entity down one in the display order.
     *
     * @Route("/{pageid}/{followingpageid}/demote", name="page_demote")
     */
    public function demoteAction($pageid, $followingpageid)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();

        $page = $em->getRepository('EnglishPagesBundle:Page')->find($pageid);
        $currentOrder = $page->getSortorder();
        $followingPage = $em->getRepository('EnglishPagesBundle:Page')->find($followingpageid);
        $followingOrder = $followingPage->getSortorder();
        $page->setSortOrder($followingOrder);
        $followingPage->setSortorder($currentOrder);
        $em->persist($page);
        $em->persist($followingPage);
        $em->flush();

        return $this->redirect($this->generateUrl('pages_show', array('id' => $page->getId())));

    }




    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="pages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_PAGEADMIN')) {
            throw new AccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $page = $em->getRepository('EnglishPagesBundle:Page')->find($id);
            $section = $page->getSection();

            if (!$page) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($page);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('section_show', array('id' => $section->getId())));
    }

    /**
     * Creates a form to delete a Page entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pages_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    /**
     * Finds and displays an image for pages.
     *
     * @Route("/{id}/view", name="public_view" )
     *
     */
    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

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

<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\News;
use Agent\AgentBundle\Form\NewsType;

/**
 * News controller.
 *
 */
class NewsController extends Controller {

    /**
     * Lists all News entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AgentBundle:News')->findAll();

        return $this->render('AgentBundle:News:index.html.twig', array(
                    'news' => $news,
        ));
    }

    /**
     * Creates a new News entity.
     *
     */
    public function newAction(Request $request) {
        $news = new News();
        $form = $this->createForm('Agent\AgentBundle\Form\NewsType', $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('AgentBundle:News:new.html.twig', array(
                    'news' => $news,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction(News $news) {
        $deleteForm = $this->createDeleteForm($news);

        return $this->render('news/show.html.twig', array(
                    'news' => $news,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction(Request $request, News $news) {
        $deleteForm = $this->createDeleteForm($news);
        $editForm = $this->createForm('Agent\AgentBundle\Form\NewsUpdateType', $news);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            return $this->redirectToRoute('news_index');
        }

        return $this->render('AgentBundle:News:edit.html.twig', array(
                    'news' => $news,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function newsAction() {

        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AgentBundle:News')->newsActif();
        return $this->render('AgentBundle:News:news.html.twig', array('news' => $news));
    }

    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, News $news) {
        $form = $this->createDeleteForm($news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();
        }

        return $this->redirectToRoute('news_index');
    }

    /**
     * Creates a form to delete a News entity.
     *
     * @param News $news The News entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(News $news) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('news_delete', array('id' => $news->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}

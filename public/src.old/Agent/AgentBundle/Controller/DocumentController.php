<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Agent\AgentBundle\Entity\Document;
use Agent\AgentBundle\Form\DocumentType;

/**
 * Document controller.
 *
 */
class DocumentController extends Controller {

    /**
     * Lists all Document entities.
     *
     */
    public function indexAction($matricule) {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Document')->afficherDocumentAgent($matricule);
        $agent = $em->getRepository('AgentBundle:Agent')->find($matricule);

        return $this->render('AgentBundle:Document:index.html.twig', array(
                    'entities' => $entities,
                    'agent' => $agent,
        ));
    }

    /**
     * Creates a new Document entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Document();
        //$matricule=$entity->getId();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            //var_dump($entity); die;
            $em->flush();
            $this->addFlash(
                    'notice', 'Le document a été créé avec Succès'
            );
            return $this->redirect($this->generateUrl('document', array('matricule' => $entity->getMatricule()->getId())));
        }

        return $this->render('AgentBundle:Document:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Document $entity) {
        //  $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

    /**
     * Displays a form to create a new Document entity.
     *
     */
    public function newAction($matricule) {
        //var_dump($matricule); die;
        $entity = new Document();
        $em = $this->getDoctrine()->getManager();

        $agentMat = $em->getRepository('AgentBundle:Agent')->find($matricule);
        $entity->setMatricule($agentMat);
        $form = $this->createCreateForm($entity, $matricule);

        return $this->render('AgentBundle:Document:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Document entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Document')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Document:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Document')->find($id);
        $matricule = $id; //$entity->getMatricule()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $editForm = $this->createEditForm($entity, $matricule);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Document:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Document entity.
     *
     * @param Document $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Document $entity, $matricule) {
        //  $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DocumentType(), $entity, array(
            'action' => $this->generateUrl('document_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à Jour', 'attr' => array('class' => 'btn-warning')));

        return $form;
    }

    /**
     * Edits an existing Document entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Document')->find($id);
        //dump($entity);
        //die;
        $matricule = $entity->getMatricule()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Document entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $matricule);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('document', array('matricule' => $entity->getMatricule()->getId())));
        }

        return $this->render('AgentBundle:Document:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Document entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Document')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Document entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('document'));
    }

    /**
     * Creates a form to delete a Document entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('document_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

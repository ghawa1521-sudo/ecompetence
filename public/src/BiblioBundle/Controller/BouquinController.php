<?php

namespace BiblioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BiblioBundle\Entity\Droit;
use BiblioBundle\Entity\Bouquin;
use BiblioBundle\Form\BouquinType;
use BiblioBundle\Form\BouquinUpdateType;

/**
 * Bouquin controller.
 *
 */
class BouquinController extends Controller {

    /**
     * Download Action
     * Méthode de téléchargement de Fichier Vich
     */
    public function donwloadAction(Image $image) {
        $downloadHandler = $this->get('vich_uploader.download_handler');
        return $downloadHandler->downloadObject($image, $fileField = 'imageFile');
    }

    /**
     * Lists all Bouquin entities.
     *
     */
    public function indexAction($todo) {
        if(!in_array($todo, array('all','edit','delete'))){
            $todo='all';
        }
        
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BiblioBundle:Bouquin')->findAll();
        return $this->render('BiblioBundle:Bouquin:index.html.twig', array(
                    'entities' => $entities,
                    'todo' => $todo,
        ));
    }
    /**
     * Lists all Bouquin entities.
     *
     */
    public function bookallAction() {

        $em = $this->getDoctrine()->getManager();

        $entitiesAll = $em->getRepository('BiblioBundle:Bouquin')->findAll();
        $entities = [];
        foreach ($entitiesAll as $entity) {
            if($entity->getDroit()->hasDroit($this->getUser()->getAgent()->getDirection()->getId())){
                $entities[]=$entity;
            }
        }
        return $this->render('BiblioBundle:Bouquin:index.html.twig', array(
                    'entities' => $entities,
        ));
    }
    /**
     * Lists all Bouquin entities.
     *
     */
    public function madirAction() {

        $em = $this->getDoctrine()->getManager();
        $directionid=$this->getUser()->getAgent()->getDirection()->getId();
        
        $entitiesAll = $em->getRepository('BiblioBundle:Bouquin')->findByDirection($directionid);
        $entities = [];
        foreach ($entitiesAll as $entity) {
            if($entity->getDroit()->hasDroit($directionid)){
                $entities[]=$entity;
            }
        }
        return $this->render('BiblioBundle:Bouquin:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Bouquin entity.
     *
     */
    public function createAction(Request $request) {


        $entity = new Bouquin();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);



        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $directions = $request->request->get('directions');

            $droit = new Droit();
            $droit->setDirections($directions);
            $droit->setBouquin($entity);
            
            $entity->setCreateur($this->getUser());
            $entity->setDroit($droit);
            $em->persist($droit);
            $em->persist($entity);


            $em->flush();

            return $this->redirect($this->generateUrl('bouquin_show', array('id' => $entity->getId())));
        }

        return $this->render('BiblioBundle:Bouquin:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Bouquin entity.
     *
     * @param Bouquin $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Bouquin $entity) {
        $form = $this->createForm(new BouquinType(), $entity, array(
            'action' => $this->generateUrl('bouquin_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Bouquin entity.
     *
     */
    public function newAction() {
        $em = $this->getDoctrine()->getManager();
        //liste des Directions
        $directions = $em->getRepository('AgentBundle:Direction')->findAll();

        $entity = new Bouquin();
        $form = $this->createCreateForm($entity);

        return $this->render('BiblioBundle:Bouquin:new.html.twig', array(
                    'entity' => $entity,
                    'directions' => $directions,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Bouquin entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BiblioBundle:Bouquin')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bouquin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BiblioBundle:Bouquin:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Bouquin entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BiblioBundle:Bouquin')->find($id);

        $directions = $em->getRepository('AgentBundle:Direction')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bouquin entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BiblioBundle:Bouquin:edit.html.twig', array(
                    'entity' => $entity,
                    'directions' => $directions,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Bouquin entity.
     *
     * @param Bouquin $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Bouquin $entity) {
        $form = $this->createForm(new BouquinUpdateType(), $entity, array(
            'action' => $this->generateUrl('bouquin_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Bouquin entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BiblioBundle:Bouquin')->find($id);
        $directions = $em->getRepository('AgentBundle:Direction')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Bouquin entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $directions = $request->request->get('directions');
            $entity->getDroit()->setDirections($directions);
            $em->persist($entity);


            $em->flush();

            return $this->redirect($this->generateUrl('bouquin_edit', array('id' => $id)));
        }

        return $this->render('BiblioBundle:Bouquin:edit.html.twig', array(
                    'entity' => $entity,
                    'directions' => $directions,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Bouquin entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BiblioBundle:Bouquin')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Bouquin entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bouquin'));
    }

    /**
     * Creates a form to delete a Bouquin entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('bouquin_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

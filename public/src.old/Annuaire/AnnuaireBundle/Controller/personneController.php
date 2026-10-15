<?php

namespace Annuaire\AnnuaireBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Annuaire\AnnuaireBundle\Entity\personne;
use Annuaire\AnnuaireBundle\Form\personneType;

/**
 * personne controller.
 *
 */
class personneController extends Controller
{

    /**
     * Lists all personne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AnnuaireBundle:personne')->findAll();

        return $this->render('AnnuaireBundle:personne:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function villeajaxAction($id) {

        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $recupVille = $em->getRepository('AnnuaireBundle:ville')->findBy(array('id' => $id));
        
        $villeJson = array();
        foreach ($recupVille as $d) {
            $id = $d->getId();
            $nomville = $d->getNom();
            $villeJson[$id] = utf8_encode($nomville);
        }
        
        //var_dump($depotL);
        $response->setData($villeJson);
        return $response;
        //die;
    }
    /**
     * Creates a new personne entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new personne();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('personne_show', array('id' => $entity->getId())));
        }

        return $this->render('AnnuaireBundle:personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a personne entity.
     *
     * @param personne $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(personne $entity)
    {
        $form = $this->createForm(new personneType(), $entity, array(
            'action' => $this->generateUrl('personne_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new personne entity.
     *
     */
    public function newAction()
    {
        $entity = new personne();
        $form   = $this->createCreateForm($entity);

        return $this->render('AnnuaireBundle:personne:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a personne entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find personne entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AnnuaireBundle:personne:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing personne entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find personne entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AnnuaireBundle:personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a personne entity.
    *
    * @param personne $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(personne $entity)
    {
        $form = $this->createForm(new personneType(), $entity, array(
            'action' => $this->generateUrl('personne_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing personne entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AnnuaireBundle:personne')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find personne entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('personne_edit', array('id' => $id)));
        }

        return $this->render('AnnuaireBundle:personne:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a personne entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnnuaireBundle:personne')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find personne entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('personne'));
    }

    /**
     * Creates a form to delete a personne entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('personne_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

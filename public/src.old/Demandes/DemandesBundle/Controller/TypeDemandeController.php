<?php

namespace Demandes\DemandesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Demandes\DemandesBundle\Entity\TypeDemande;
use Demandes\DemandesBundle\Form\TypeDemandeType;

/**
 * TypeDemande controller.
 *
 */
class TypeDemandeController extends Controller
{

    /**
     * Lists all TypeDemande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DemandesBundle:TypeDemande')->findAll();

        return $this->render('DemandesBundle:TypeDemande:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypeDemande entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TypeDemande();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typedemande_show', array('id' => $entity->getId())));
        }

        return $this->render('DemandesBundle:TypeDemande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TypeDemande entity.
     *
     * @param TypeDemande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeDemande $entity)
    {
        $form = $this->createForm(new TypeDemandeType(), $entity, array(
            'action' => $this->generateUrl('typedemande_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TypeDemande entity.
     *
     */
    public function newAction()
    {
        $entity = new TypeDemande();
        $form   = $this->createCreateForm($entity);

        return $this->render('DemandesBundle:TypeDemande:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeDemande entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:TypeDemande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDemande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DemandesBundle:TypeDemande:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeDemande entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:TypeDemande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDemande entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DemandesBundle:TypeDemande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypeDemande entity.
    *
    * @param TypeDemande $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeDemande $entity)
    {
        $form = $this->createForm(new TypeDemandeType(), $entity, array(
            'action' => $this->generateUrl('typedemande_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing TypeDemande entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:TypeDemande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeDemande entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typedemande_edit', array('id' => $id)));
        }

        return $this->render('DemandesBundle:TypeDemande:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypeDemande entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DemandesBundle:TypeDemande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TypeDemande entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('typedemande'));
    }

    /**
     * Creates a form to delete a TypeDemande entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typedemande_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

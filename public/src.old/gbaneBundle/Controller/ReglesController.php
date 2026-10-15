<?php

namespace gbaneBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use gbaneBundle\Entity\Regles;
use gbaneBundle\Form\ReglesType;

/**
 * Regles controller.
 *
 */
class ReglesController extends Controller
{

    /**
     * Lists all Regles entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('gbaneBundle:Regles')->findAll();

        return $this->render('gbaneBundle:Regles:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Regles entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Regles();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('regles_show', array('id' => $entity->getId())));
        }

        return $this->render('gbaneBundle:Regles:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Regles entity.
     *
     * @param Regles $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Regles $entity)
    {
        $form = $this->createForm(new ReglesType(), $entity, array(
            'action' => $this->generateUrl('regles_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Creer','attr'=>array('class'=>'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Regles entity.
     *
     */
    public function newAction()
    {
        $entity = new Regles();
        $form   = $this->createCreateForm($entity);

        return $this->render('gbaneBundle:Regles:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Regles entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gbaneBundle:Regles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('gbaneBundle:Regles:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Regles entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gbaneBundle:Regles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regles entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('gbaneBundle:Regles:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Regles entity.
    *
    * @param Regles $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Regles $entity)
    {
        $form = $this->createForm(new ReglesType(), $entity, array(
            'action' => $this->generateUrl('regles_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-primary')));

        return $form;
        
    }
    /**
     * Edits an existing Regles entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gbaneBundle:Regles')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regles entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('regles_edit', array('id' => $id)));
        }

        return $this->render('gbaneBundle:Regles:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Regles entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('gbaneBundle:Regles')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Regles entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('regles'));
    }

    /**
     * Creates a form to delete a Regles entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regles_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'supprimer','attr'=>array('class'=>'btn btn-primary')))
            ->getForm()
        ;
    }
}

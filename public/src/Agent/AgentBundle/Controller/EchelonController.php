<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\Echelon;
use Agent\AgentBundle\Form\EchelonType;

/**
 * Echelon controller.
 *
 */
class EchelonController extends Controller
{

    /**
     * Lists all Echelon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Echelon')->findAll();

        return $this->render('AgentBundle:Echelon:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Echelon entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Echelon();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('echelon_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Echelon:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Echelon entity.
     *
     * @param Echelon $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Echelon $entity)
    {
        $form = $this->createForm(new EchelonType(), $entity, array(
            'action' => $this->generateUrl('echelon_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Echelon entity.
     *
     */
    public function newAction()
    {
        $entity = new Echelon();
        $form   = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Echelon:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Echelon entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Echelon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Echelon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Echelon:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Echelon entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Echelon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Echelon entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Echelon:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Echelon entity.
    *
    * @param Echelon $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Echelon $entity)
    {
        $form = $this->createForm(new EchelonType(), $entity, array(
            'action' => $this->generateUrl('echelon_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Echelon entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Echelon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Echelon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('echelon_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Echelon:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Echelon entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Echelon')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Echelon entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('echelon'));
    }

    /**
     * Creates a form to delete a Echelon entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('echelon_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

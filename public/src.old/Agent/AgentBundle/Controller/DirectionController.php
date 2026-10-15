<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\Direction;
use Agent\AgentBundle\Form\DirectionType;

/**
 * Direction controller.
 *
 */
class DirectionController extends Controller
{

    /**
     * Lists all Direction entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Direction')->findAll();

        return $this->render('AgentBundle:Direction:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    /**
     * Creates a new Direction entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Direction();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('direction_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Direction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Direction entity.
     *
     * @param Direction $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Direction $entity)
    {
        $form = $this->createForm(new DirectionType(), $entity, array(
            'action' => $this->generateUrl('direction_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Creer', 'attr'=>array('class'=>'btn btn-success col-md-3')));

        return $form;
    }

    /**
     * Displays a form to create a new Direction entity.
     *
     */
    public function newAction()
    {
        $entity = new Direction();
        $form   = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Direction:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Direction entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Direction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Direction:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Direction entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Direction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direction entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Direction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Direction entity.
    *
    * @param Direction $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Direction $entity)
    {
        $form = $this->createForm(new DirectionType(), $entity, array(
            'action' => $this->generateUrl('direction_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre a jour'));

        return $form;
    }
    /**
     * Edits an existing Direction entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Direction')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Direction entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('direction_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Direction:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Direction entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Direction')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Direction entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('direction'));
    }

    /**
     * Creates a form to delete a Direction entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('direction_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\Syndicat;
use Agent\AgentBundle\Form\SyndicatType;

/**
 * Syndicat controller.
 *
 */
class SyndicatController extends Controller
{

    /**
     * Lists all Syndicat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Syndicat')->findAll();

        return $this->render('AgentBundle:Syndicat:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Syndicat entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Syndicat();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('syndicat_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Syndicat:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Syndicat entity.
     *
     * @param Syndicat $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Syndicat $entity)
    {
        $form = $this->createForm(new SyndicatType(), $entity, array(
            'action' => $this->generateUrl('syndicat_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Syndicat entity.
     *
     */
    public function newAction()
    {
        $entity = new Syndicat();
        $form   = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Syndicat:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Syndicat entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Syndicat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Syndicat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Syndicat:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Syndicat entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Syndicat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Syndicat entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Syndicat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Syndicat entity.
    *
    * @param Syndicat $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Syndicat $entity)
    {
        $form = $this->createForm(new SyndicatType(), $entity, array(
            'action' => $this->generateUrl('syndicat_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Syndicat entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Syndicat')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Syndicat entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('syndicat_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Syndicat:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Syndicat entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Syndicat')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Syndicat entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('syndicat'));
    }

    /**
     * Creates a form to delete a Syndicat entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('syndicat_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

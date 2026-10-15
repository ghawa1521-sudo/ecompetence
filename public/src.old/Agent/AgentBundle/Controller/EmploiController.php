<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\Emploi;
use Agent\AgentBundle\Form\EmploiType;

/**
 * Emploi controller.
 *
 */
class EmploiController extends Controller
{

    /**
     * Lists all Emploi entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Emploi')->findAll();

        return $this->render('AgentBundle:Emploi:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Emploi entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Emploi();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('emploi_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Emploi:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Emploi entity.
     *
     * @param Emploi $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Emploi $entity)
    {
        $form = $this->createForm(new EmploiType(), $entity, array(
            'action' => $this->generateUrl('emploi_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Emploi entity.
     *
     */
    public function newAction()
    {
        $entity = new Emploi();
        $form   = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Emploi:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Emploi entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Emploi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emploi entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Emploi:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Emploi entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Emploi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emploi entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Emploi:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Emploi entity.
    *
    * @param Emploi $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Emploi $entity)
    {
        $form = $this->createForm(new EmploiType(), $entity, array(
            'action' => $this->generateUrl('emploi_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Emploi entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Emploi')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Emploi entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('emploi_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Emploi:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Emploi entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Emploi')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Emploi entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('emploi'));
    }

    /**
     * Creates a form to delete a Emploi entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('emploi_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

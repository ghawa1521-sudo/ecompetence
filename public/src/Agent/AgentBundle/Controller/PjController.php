<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\Pj;
use Agent\AgentBundle\Form\PjType;

/**
 * Pj controller.
 *
 */
class PjController extends Controller
{

    /**
     * Lists all Pj entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Pj')->findAll();

        return $this->render('AgentBundle:Pj:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pj entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pj();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pj_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Pj:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Pj entity.
     *
     * @param Pj $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pj $entity)
    {
        $form = $this->createForm(new PjType(), $entity, array(
            'action' => $this->generateUrl('pj_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pj entity.
     *
     */
    public function newAction()
    {
        $entity = new Pj();
        $form   = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Pj:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pj entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Pj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pj entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Pj:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pj entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Pj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pj entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Pj:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pj entity.
    *
    * @param Pj $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pj $entity)
    {
        $form = $this->createForm(new PjType(), $entity, array(
            'action' => $this->generateUrl('pj_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pj entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Pj')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pj entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pj_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Pj:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Pj entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Pj')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pj entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pj'));
    }

    /**
     * Creates a form to delete a Pj entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pj_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

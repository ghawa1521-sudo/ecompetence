<?php

namespace Ecompetence\EcompetenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecompetence\EcompetenceBundle\Entity\Agentcompetence;
use Ecompetence\EcompetenceBundle\Form\AgentcompetenceType;

/**
 * Agentcompetence controller.
 *
 */
class AgentcompetenceController extends Controller
{

    /**
     * Lists all Agentcompetence entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EcompetenceBundle:Agentcompetence')->findAll();

        return $this->render('EcompetenceBundle:Agentcompetence:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Agentcompetence entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Agentcompetence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('y_show', array('id' => $entity->getId())));
        }

        return $this->render('EcompetenceBundle:Agentcompetence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Agentcompetence entity.
     *
     * @param Agentcompetence $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Agentcompetence $entity)
    {
        $form = $this->createForm(new AgentcompetenceType(), $entity, array(
            'action' => $this->generateUrl('y_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Agentcompetence entity.
     *
     */
    public function newAction()
    {
        $entity = new Agentcompetence();
        $form   = $this->createCreateForm($entity);

        return $this->render('EcompetenceBundle:Agentcompetence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Agentcompetence entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Agentcompetence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agentcompetence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Agentcompetence:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Agentcompetence entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Agentcompetence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agentcompetence entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Agentcompetence:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Agentcompetence entity.
    *
    * @param Agentcompetence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Agentcompetence $entity)
    {
        $form = $this->createForm(new AgentcompetenceType(), $entity, array(
            'action' => $this->generateUrl('y_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Agentcompetence entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Agentcompetence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agentcompetence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('y_edit', array('id' => $id)));
        }

        return $this->render('EcompetenceBundle:Agentcompetence:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Agentcompetence entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcompetenceBundle:Agentcompetence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Agentcompetence entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('y'));
    }

    /**
     * Creates a form to delete a Agentcompetence entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('y_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

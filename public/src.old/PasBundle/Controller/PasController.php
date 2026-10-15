<?php

namespace PasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PasBundle\Entity\Pas;
use PasBundle\Form\PasType;

/**
 * Pas controller.
 *
 */
class PasController extends Controller
{

    /**
     * Lists all Pas entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PasBundle:Pas')->findAll();

        return $this->render('PasBundle:Pas:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Pas entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Pas();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pasc_show', array('id' => $entity->getId())));
        }

        return $this->render('PasBundle:Pas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Pas entity.
     *
     * @param Pas $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Pas $entity)
    {
        $form = $this->createForm(new PasType(), $entity, array(
            'action' => $this->generateUrl('pasc_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Pas entity.
     *
     */
    public function newAction()
    {
        $entity = new Pas();
        $form   = $this->createCreateForm($entity);

        return $this->render('PasBundle:Pas:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pas entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PasBundle:Pas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PasBundle:Pas:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pas entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PasBundle:Pas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pas entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('PasBundle:Pas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Pas entity.
    *
    * @param Pas $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Pas $entity)
    {
        $form = $this->createForm(new PasType(), $entity, array(
            'action' => $this->generateUrl('pasc_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Pas entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PasBundle:Pas')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pas entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pasc_edit', array('id' => $id)));
        }

        return $this->render('PasBundle:Pas:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Pas entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PasBundle:Pas')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Pas entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pasc'));
    }

    /**
     * Creates a form to delete a Pas entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pasc_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

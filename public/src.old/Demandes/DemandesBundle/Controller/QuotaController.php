<?php

namespace Demandes\DemandesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Demandes\DemandesBundle\Entity\Quota;
use Demandes\DemandesBundle\Form\QuotaType;
use Demandes\DemandesBundle\Form\QuotaEditType;
/**
 * Quota controller.
 *
 */
class QuotaController extends Controller
{

    /**
     * Lists all Quota entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DemandesBundle:Quota')->findAll();

        return $this->render('DemandesBundle:Quota:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Quota entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Quota();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('quota'));
        }

        return $this->render('DemandesBundle:Quota:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Quota entity.
     *
     * @param Quota $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Quota $entity)
    {
        $form = $this->createForm(new QuotaType(), $entity, array(
            'action' => $this->generateUrl('quota_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer', 'attr' =>['class' => 'btn btn-success col-md-push-3 col-md-6']));

        return $form;
    }

    /**
     * Displays a form to create a new Quota entity.
     *
     */
    public function newAction()
    {
        $entity = new Quota();
        $form   = $this->createCreateForm($entity);

        return $this->render('DemandesBundle:Quota:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Quota entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Quota')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quota entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DemandesBundle:Quota:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Quota entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Quota')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quota entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DemandesBundle:Quota:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Quota entity.
    *
    * @param Quota $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Quota $entity)
    {
        $form = $this->createForm(new QuotaEditType(), $entity, array(
            'action' => $this->generateUrl('quota_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier', 'attr' =>['class' => 'btn btn-success col-md-push-3 col-md-6']));

        return $form;
    }
    /**
     * Edits an existing Quota entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Quota')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quota entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('quota'));
        }

        return $this->render('DemandesBundle:Quota:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Quota entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DemandesBundle:Quota')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Quota entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('quota'));
    }

    /**
     * Creates a form to delete a Quota entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('quota_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

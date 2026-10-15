<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\Avis;
use Agent\AgentBundle\Form\AvisType;

/**
 * Avis controller.
 *
 */
class AvisController extends Controller {

    /**
     * Lists all Avis entities.
     *
     */
    public function indexAction($type = 1) {
        $em = $this->getDoctrine()->getManager();

        //Sans avis
        $demande = $em->getRepository('AgentBundle:Avis')->getAvis(1, $this->getUser()->getAgent(), 0);

        $conge = $em->getRepository('AgentBundle:Avis')->getAvis(2, $this->getUser()->getAgent(), 0);
 
        //Avec Avis
        $demandeok = $objet = $em->getRepository('AgentBundle:Avis')->getAvis(1, $this->getUser()->getAgent(), 1);
        $congeok = $objet = $em->getRepository('AgentBundle:Avis')->getAvis(2, $this->getUser()->getAgent(), 1);
       //dump(123);die; 
       if ($type == 1) {//demandes
            $view = '';
        } elseif ($type == 2) {//Conges
            $view = '';
        }
       // dump($congeok); die;
        //Récupérer la Liste des avis

        return $this->render('AgentBundle:Avis:index.html.twig', array(
                    'demandeok' => $demandeok,
                    'congeok' => $congeok,
                    'demande' => $demande,
                    'conge' => $conge,
                    'entities' => null
        ));
    }

    public function aviserAction($id, $objet, $action) {
        $em = $this->getDoctrine()->getManager();

        //A renforcer sécuriser
        if (!in_array($action, [1, 2])) {

        }
        if (!in_array($objet, [1, 2])) {
            return $this->redirect($this->generateUrl('avis'));
        }
        /*
          dump(in_array($action, [1, 2]));
          dump(in_array($objet, [1, 2]));
          die;
         */
        $avis = new Avis();
        $avis->setEtat($action);
        if ($objet == 1) {//demande
            $demande = $em->getRepository('DemandesBundle:Demande')->find($id);
            if ($demande) {
                $avis->setDemande($demande);
                $demande->setAvis($avis);
                $em->persist($avis);
                $em->persist($demande);
                $em->flush();
            }
        } elseif ($objet == 2) {//conge
            $conge = $em->getRepository('AgentBundle:Conges')->find($id);
            if ($conge) {
                $avis->setConge($conge);
                $conge->setAvis($avis);
                $em->persist($avis);
                $em->persist($conge);
                $em->flush();
            }
        }


        return $this->redirect($this->generateUrl('avis'));
    }

    /**
     * Creates a new Avis entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Avis();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('avis_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Avis:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Avis entity.
     *
     * @param Avis $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Avis $entity) {
        $form = $this->createForm(new AvisType(), $entity, array(
            'action' => $this->generateUrl('avis_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Avis entity.
     *
     */
    public function newAction() {
        $entity = new Avis();
        $form = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Avis:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Avis entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Avis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Avis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Avis:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Avis entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Avis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Avis entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Avis:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Avis entity.
     *
     * @param Avis $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Avis $entity) {
        $form = $this->createForm(new AvisType(), $entity, array(
            'action' => $this->generateUrl('avis_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Avis entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Avis')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Avis entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('avis_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Avis:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Avis entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Avis')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Avis entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('avis'));
    }

    /**
     * Creates a form to delete a Avis entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('avis_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

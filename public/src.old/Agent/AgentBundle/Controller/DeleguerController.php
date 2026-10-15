<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\Deleguer;
use Agent\AgentBundle\Entity\Deleguation;
use Agent\AgentBundle\Form\DeleguerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Deleguer controller.
 *
 */
class DeleguerController extends Controller {

    /**
     * Lists all Deleguer entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AgentBundle:Deleguer')->findAll();
        $fonctionalites = $em->getRepository('AgentBundle:Fonctionalite')->findBy([]);

        return $this->render('AgentBundle:Deleguer:index.html.twig', array(
                    'entities' => $entities,
                    'fonctionalites' => $fonctionalites
        ));
    }

    /**
     * Creates a new Deleguer entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Deleguer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($entity->getDeleguation() as $deleguation) {
                $deleguation->setDeleguer($entity);
                $deleguation->setDeleguataire($this->getUser()->getAgent());
                $deleguation->setDatecreation(new \DateTime());
                $fid=$deleguation->getRubriques()->getFonctionalite()->getId();
            }
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('deleguer_show', array('id' => $entity->getId())));


            return $this->redirect($this->generateUrl('deleguer_edit', array('id' => $entity->getId(), 'fid'=>$fid)));
        }

        return $this->render('AgentBundle:Deleguer:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Deleguer entity.
     *
     * @param Deleguer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Deleguer $entity, $fid=null) {
        $form = $this->createForm(new DeleguerType(), $entity, array(
            'fid'=>$fid,
            'action' => $this->generateUrl('deleguer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer', 'attr'=>['class'=>'btn btn-success']));

        return $form;
    }

    /**
     * Displays a form to create a new Deleguer entity.
     *
     */
    public function newAction($fid = 'all') {
        $em = $this->getDoctrine()->getManager();
        $entity = new Deleguer();
        $id = $fid;



        if (!in_array($fid, ['all', 1, 2, 3, 4,5,6])) {
            $fid = [];
        }



        $deleguation = $em->getRepository('AgentBundle:Deleguation')->findOneBy(['fonctionalite' => $id]);
        if ($deleguation) {
            return $this->redirect($this->generateUrl('deleguer_edit', array('id' => $deleguation->getDeleguer()->getId(), 'fid' => $id)));
        }


        $fid = ['id' => $fid];
        $fonctionalites = $em->getRepository('AgentBundle:Fonctionalite')->findBy($fid);
        foreach ($fonctionalites as $fonctionalite) {
            foreach ($fonctionalite->getRubriques() as $rubrique) {

                $delegation = new Deleguation();
                $delegation->setFonctionalite($fonctionalite);
                $delegation->setRubriques($rubrique);
                $entity->addDeleguation($delegation);
            }
        }
        $form = $this->createCreateForm($entity,intval($fid['id']));
        return $this->render('AgentBundle:Deleguer:new.html.twig', array(
                    'entity' => $entity,
                    'fonctionalites' => $fonctionalites,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Deleguer entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Deleguer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deleguer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Deleguer:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Deleguer entity.
     *
     */
    public function editAction($id, $fid = null) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Deleguer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deleguer entity.');
        }

        if (!in_array($fid, ['all', 1, 2, 3, 4,5,6])) {
            $fid = [];
        }

        $fid = ['id' => $fid];
        $fonctionalites = $em->getRepository('AgentBundle:Fonctionalite')->findBy($fid);


        $Form = $this->createEditForm($entity, intval($fid['id']));
        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Deleguer:edit.html.twig', array(
                    'entity' => $entity,
                    'fonctionalites' => $fonctionalites,
                    'form' => $Form->createView(),
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Deleguer entity.
     *
     * @param Deleguer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Deleguer $entity, $fid=null) {
        $form = $this->createForm(new DeleguerType(), $entity, array(
            'fid'=>$fid,
            'action' => $this->generateUrl('deleguer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer', 'attr'=>['class'=>'btn btn-success']));

        return $form;
    }

    /**
     * Edits an existing Deleguer entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Deleguer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Deleguer entity.');
        }

        $originalDelegu = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getDeleguation() as $delegu) {
            $originalDelegu->add($delegu);
        }



        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($originalDelegu as $delegu) {
                if (false === $entity->getDeleguation()->contains($delegu)) {
                    // remove the Task from the Tag
                    $em->remove($delegu);

                    // if it was a many-to-one relationship, remove the relationship like this
                    // $tag->setTask(null);

                    $em->persist($delegu);

                    // if you wanted to delete the Tag entirely, you can also do that
                    // $entityManager->remove($tag);
                }
                foreach ($entity->getDeleguation() as $deleguation) {
                    $deleguation->setFonctionalite($deleguation->getRubriques()->getFonctionalite());
                    $deleguation->setDeleguer($entity);
                    $deleguation->setDeleguataire($this->getUser()->getAgent());
                    $deleguation->setDatecreation(new \DateTime());
                    $em->persist($deleguation);
                    $fid=$deleguation->getRubriques()->getFonctionalite()->getId();
                    # code...
                }
            }


            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('deleguer_edit', array('id' => $id,'fid'=> $fid)));
        }

        return $this->render('AgentBundle:Deleguer:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Deleguer entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Deleguer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Deleguer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('deleguer'));
    }

    /**
     * Creates a form to delete a Deleguer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('deleguer_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

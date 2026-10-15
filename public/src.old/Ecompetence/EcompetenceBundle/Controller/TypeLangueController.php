<?php

namespace Ecompetence\EcompetenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecompetence\EcompetenceBundle\Entity\TypeLangue;
use Ecompetence\EcompetenceBundle\Form\TypeLangueType;

/**
 * TypeLangue controller.
 *
 */
class TypeLangueController extends Controller
{

    /**
     * Lists all TypeLangue entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EcompetenceBundle:TypeLangue')->findAll();

        return $this->render('EcompetenceBundle:TypeLangue:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new TypeLangue entity.
     *
     */
   /* public function createAction(Request $request)
    {
        $entity = new TypeLangue();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('typelangue_show', array('id' => $entity->getId())));
        }

        return $this->render('EcompetenceBundle:TypeLangue:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }*/
    
public function createAction(Request $request)
{
    $entity = new TypeLangue();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    // Vérifier si le formulaire est valide
    if ($form->isValid()) {
        // Vérifier si le type de langue existe déjà dans la base de données
        $existingTypeLangue = $this->getDoctrine()->getRepository(TypeLangue::class)->findOneBy([
            'libelle' => $entity->getLibelle() // Remplacez 'nom' par le champ de l'entité que vous souhaitez vérifier
        ]);

        // Si le type de langue existe déjà, afficher une erreur
        if ($existingTypeLangue) {
            $this->addFlash('error', 'Ce type de langue existe déjà.');

            // Renvoyer l'utilisateur au formulaire avec les données précédentes
            return $this->render('EcompetenceBundle:TypeLangue:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        }

        // Si le type de langue n'existe pas, persister l'entité
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        // Rediriger vers la page de détails du type de langue
        return $this->redirect($this->generateUrl('typelangue_show', array('id' => $entity->getId())));
    }

    // Si le formulaire n'est pas valide, retourner à la vue avec les erreurs
    return $this->render('EcompetenceBundle:TypeLangue:new.html.twig', array(
        'entity' => $entity,
        'form'   => $form->createView(),
    ));
}

    /**
     * Creates a form to create a TypeLangue entity.
     *
     * @param TypeLangue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TypeLangue $entity)
    {
        $form = $this->createForm(new TypeLangueType(), $entity, array(
            'action' => $this->generateUrl('typelangue_create'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', [
            'label' => 'Ajouter',
            'attr'  => [
                        'class' => 'btn', // tu peux garder btn si tu utilises Bootstrap
                        'style' => 'background-color:#007bff; color:white; border:none;'
                        ]
        ]);
        
        return $form;
    }

    /**
     * Displays a form to create a new TypeLangue entity.
     *
     */

     public function newAction(Request $request)
     {
         $entity = new TypeLangue();
         $form = $this->createCreateForm($entity);
         $form->handleRequest($request);
     
         
             // Vérifier si le formulaire est valide
             if ($form->isValid()) {
                 // Récupérer le gestionnaire d'entité
                 $em = $this->getDoctrine()->getManager();
     
                 // Rechercher si un type de langue avec le même libellé existe déjà
                 $existingTypeLangue = $em->getRepository('EcompetenceBundle:TypeLangue')
                                          ->findOneBy(array('libelle' => $entity->getLibelle()));
     
                 if ($existingTypeLangue) {
                     // Si un type de langue avec ce libellé existe déjà, afficher un message d'erreur
                     $this->get('session')->getFlashBag()->add('error', 'Ce type de langue existe déjà.');
     
                     // Retourner le formulaire avec le message d'erreur
                     return $this->render('EcompetenceBundle:TypeLangue:new.html.twig', array(
                         'entity' => $entity,
                         'form' => $form->createView(),
                     ));
                 }
     
                 // Si aucun doublon n'est trouvé, persister l'entité et sauvegarder
                 $em->persist($entity);
                 $em->flush();
     
                 // Redirection après la création réussie
                 return $this->redirect($this->generateUrl('type_langue_show', array('id' => $entity->getId())));
             }
         
     
         // Afficher le formulaire si non soumis ou non valide
         return $this->render('EcompetenceBundle:TypeLangue:new.html.twig', array(
             'entity' => $entity,
             'form' => $form->createView(),
         ));
     }
     

 
    /**
     * Finds and displays a TypeLangue entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:TypeLangue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLangue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:TypeLangue:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TypeLangue entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:TypeLangue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLangue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:TypeLangue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TypeLangue entity.
    *
    * @param TypeLangue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TypeLangue $entity)
    {
        $form = $this->createForm(new TypeLangueType(), $entity, array(
            'action' => $this->generateUrl('typelangue_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        ;
        $form->add('submit', 'submit', [
            'label' => 'Mettre à jour',
            'attr'  => [
                        'class' => 'btn', // tu peux garder btn si tu utilises Bootstrap
                        'style' => 'background-color:#007bff; color:white; border:none;'
                        ]
        ]);
        
        return $form;
    }
    /**
     * Edits an existing TypeLangue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:TypeLangue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TypeLangue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('typelangue_edit', array('id' => $id)));
        }

        return $this->render('EcompetenceBundle:TypeLangue:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TypeLangue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {    // Créer et traiter le formulaire de suppression
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        
        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcompetenceBundle:TypeLangue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Impossible de trouver l\'entité TypeLangue.');
            }
        // Supprimer l'entité
            $em->remove($entity);
            $em->flush();
        // Ajouter un message flash pour indiquer que la suppression a réussi
        $this->addFlash('success', 'Le type de langue a été supprimé avec succès.');
        } 
        else {
        // Ajouter un message flash en cas d'erreur de validation
        $this->addFlash('error', 'Une erreur s\'est produite lors de la suppression du type de langue.');
        
        }
        
    
         // Redirection après suppression
        return $this->redirect($this->generateUrl('typelangue'));
    }

    /**
     * Creates a form to delete a TypeLangue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typelangue_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}

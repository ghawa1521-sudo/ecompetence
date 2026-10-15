<?php

namespace Ecompetence\EcompetenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ecompetence\EcompetenceBundle\Entity\Domaine;
use Ecompetence\EcompetenceBundle\Form\DomaineType;

/**
 * Domaine controller.
 *
 */
class DomaineController extends Controller
{

    /**
     * Lists all Domaine entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

       // $entities = $em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=> NULL ]);
       $entities = $em->getRepository('EcompetenceBundle:Domaine')->findBy(
        array('parent' => NULL),
        array('libDomaine' => 'ASC') // Trie par ordre alphabétique
        );
    

        return $this->render('EcompetenceBundle:Domaine:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Domaine entity.
     *
     */
   /* public function createAction(Request $request)
    {
        $entity = new Domaine();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('domaine'));
        }

        return $this->render('EcompetenceBundle:Domaine:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }*/
    
public function createAction(Request $request)
{
    $entity = new Domaine();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);

    // Vérifier si le formulaire est valide
    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();

        // Vérifier si un domaine avec le même nom (ou une autre caractéristique unique) existe déjà
        $existingDomaine = $em->getRepository(Domaine::class)->findOneBy([
            'libDomaine' => $entity->getLibDomaine() // Assurez-vous que 'nom' est le champ qui doit être unique
        ]);

        if ($existingDomaine) {
            // Domaine déjà existant, afficher un message d'erreur
            $this->addFlash('error', 'Ce domaine existe déjà.');

            // Renvoyer l'utilisateur au formulaire avec les données déjà saisies
            return $this->render('EcompetenceBundle:Domaine:new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]);
        }

        // Si le domaine n'existe pas encore, le persister
        $em->persist($entity);
        $em->flush();

        // Rediriger vers la liste des domaines ou une autre page après la création
        return $this->redirectToRoute('domaine');
    }

    // Si le formulaire n'est pas valide, renvoyer le formulaire avec les erreurs
    return $this->render('EcompetenceBundle:Domaine:new.html.twig', [
        'entity' => $entity,
        'form'   => $form->createView(),
    ]);
}

    /**
     * Creates a form to create a Domaine entity.
     *
     * @param Domaine $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Domaine $entity)
    {
        $form = $this->createForm(new DomaineType(), $entity, array(
            'action' => $this->generateUrl('domaine_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Domaine entity.
     *
     */
    public function newAction()
    {
        $entity = new Domaine();
        $form   = $this->createCreateForm($entity);
        
        return $this->render('EcompetenceBundle:Domaine:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Domaine entity.
     *
     */
    public function showAction($id)
    {
       /* $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);
        $enfant = new Domaine();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Domaine entity.');
        }
        $enfant->setParent($entity);
        $editForm = $this->createCreateForm($enfant);
        //$deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Domaine:show.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        ));*/
     $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);

    if (!$entity) {
        throw $this->createNotFoundException('Unable to find Domaine entity.');
    }

    // Récupérer les enfants (si ta relation est bien mappée OneToMany)
    $children = $entity->getChildren();

    return $this->render('EcompetenceBundle:Domaine:show.html.twig', array(
        'entity'   => $entity,
        'children' => $children,
    ));
    }

    /**
     * Displays a form to edit an existing Domaine entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Domaine entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Domaine:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an sous Domaine entity.
     *
     */
    public function editsousdomaineAction($id)
    {
       
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Domaine entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Domaine:editsousdomaine.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Domaine entity.
    *
    * @param Domaine $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Domaine $entity)
    {
        $form = $this->createForm(new DomaineType(), $entity, array(
            'action' => $this->generateUrl('domaine_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Domaine entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Domaine entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('domaine_edit', array('id' => $id)));
        }

        return $this->render('EcompetenceBundle:Domaine:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Domaine entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcompetenceBundle:Domaine')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Domaine entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('domaine'));
    }

    /**
     * Creates a form to delete a Domaine entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('domaine_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

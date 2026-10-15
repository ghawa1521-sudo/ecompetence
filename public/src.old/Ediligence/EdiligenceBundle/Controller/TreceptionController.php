<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ediligence\EdiligenceBundle\Entity\Treception;
use Ediligence\EdiligenceBundle\Form\TreceptionType;

/**
 * Treception controller.
 *
 */
class TreceptionController extends Controller {

    /**
     * Lists all Treception entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EdiligenceBundle:Treception')->findAll();

        return $this->render('EdiligenceBundle:Treception:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Treception entity.
     *
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = new Treception();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) { 
           $service_sup=$this->getUser()->getAgent()->retour_service();
           //recuperer l'imputation
           $imputation=$em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('id'=>$entity->getIdImput(),'serviceImput'=>'DG0001'));//, 'etatTrait'=>0
           //verifier que le courrier est deja enregistre
           $id_reception = $em->getRepository('EdiligenceBundle:Treception')->findOneBy(array('courrier'=>$imputation->getCourrier()->getId(), 'servicereception'=>$service_sup['service']));//'matriculereception'=>$this->getUser()->getAgent()->getMatricule()
           $datereception = $entity->getDatereception();
           $err = 0;
           $interval = $imputation->getDateImput()->diff($datereception);
           
           $chrono = $em->getRepository('EdiligenceBundle:Treception')->findOneBy(array('servicereception'=>$service_sup['service'], 'chrono'=>$entity->getChrono()));
           
           if(!$chrono){$err = 0;}else{$err = 1;}
           if(!$id_reception){$err = 0;}else{$err = 1;}
           if( (int)$interval->format('%R%a days')<0){$err = 1;} 
           //dump($chrono); dump($interval);dump($datereception);dump($id_reception); dump($entity); dump($form->getData());die;
           $id_courrier =$em->getRepository('EdiligenceBundle:Tcourrier')->findOneBy(array('id'=>$imputation->getCourrier()));
            //$typ_courrier =$em->getRepository('EdiligenceBundle:Ttypecourrier')->findOneBy(array('id'=>$request->request->get('typ_courrier')));
            
            //$datereception = (\DateTime::createFromFormat('d-m-Y', $request->request->get('ediligence_ediligencebundle_treception')['datereception']));
            
            if($err==0){ 
                $reception = new Treception();
                //2 remplir les objets
                $reception->setDatereception($entity->getDatereception());
                $reception->setEtatreception(1);
                $reception->setMatriculereception($this->getUser()->getAgent()->getMatricule());
                $reception->setIdImput($entity->getIdImput());
                $reception->setChrono($entity->getChrono());
                //$reception->setChrono($request->request->get('ediligence_ediligencebundle_treception')['chrono']);
                $reception->setCourrier($imputation->getCourrier());
                $reception->setTypecourrier($imputation->getCourrier()->getTypecourrier());
                $reception->setServicereception($service_sup['service']);
                
                $em->persist($reception);
                
                $id_courrier->setEtatReception(1);
                $em->persist($id_courrier);
               
                $em->flush();

                $msg = "Courrier Receptionné avec succès";
                $this->addFlash('notice', $msg);
            }
            else{
                $msg = "Ce code d\'enregistrement ".$request->request->get('ediligence_ediligencebundle_treception')['chrono']." est dejà utilisé";
                $this->addFlash('error', $msg); 
            }
            return $this->redirect($this->generateUrl('courrier_int'));
        }

        return $this->render('EdiligenceBundle:Treception:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Treception entity.
     *
     * @param Treception $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Treception $entity) {
        $form = $this->createForm(new TreceptionType(), $entity, array(
            'action' => $this->generateUrl('reception_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Receptionner'));

        return $form;
    }

    /**
     * Displays a form to create a new Treception entity.
     *
     */
    public function newAction($id) {
        $em = $this->getDoctrine()->getManager();
        //service du connecte
        $service_sup = $this->getUser()->getAgent()->retour_service();
        
        $imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($id);
        if ($imputation) {
            $entities = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $imputation, 'idImputDir' => $service_sup['service']));
            $impudir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $imputation, 'serviceImput' => $service_sup['service']));  
        }
        
        $entity = new Treception();
        $form = $this->createCreateForm($entity);
        
        //compter tous les courriers receptionne
        $chronos = $em->getRepository('EdiligenceBundle:Treception')->findBy(array('matriculereception' => $this->getUser()->getAgent()->getMatricule(), 'servicereception' => $service_sup['service']));
        $nbredossier=0;
        if($chronos){$nbredossier = count($chronos);}
        
        return $this->render('EdiligenceBundle:Treception:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'entities' => $entities,
                    'imputation' => $imputation,
                    'imputdir' => $impudir,
                    'nbredossier' => $nbredossier,
        ));
    }

    /**
     * Finds and displays a Treception entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Treception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Treception entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EdiligenceBundle:Treception:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Treception entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Treception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Treception entity.');
        }

        $service_sup = $this->getUser()->getAgent()->retour_service();
        $imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($entity->getIdImput());
        if ($imputation) {
            $entities = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $entity->getIdImput(), 'idImputDir' => $service_sup['service']));
            $impudir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $entity->getIdImput(), 'serviceImput' => $service_sup['service']));   
        }
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        
        //compter tous les courriers receptionne
        $chronos = $em->getRepository('EdiligenceBundle:Treception')->findBy(array('matriculereception' => $this->getUser()->getAgent()->getMatricule(), 'servicereception' => $service_sup['service']));
        $nbredossier=0;
        if($chronos){$nbredossier = count($chronos);}
        
        return $this->render('EdiligenceBundle:Treception:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'entities' => $entities,
                    'imputation' => $imputation,
                    'imputdir' => $impudir,
                    'nbredossier' => $nbredossier,
        ));
    }

    /**
     * Creates a form to edit a Treception entity.
     *
     * @param Treception $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Treception $entity) {
        $form = $this->createForm(new TreceptionType(), $entity, array(
            'action' => $this->generateUrl('reception_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier Diligence'));

        return $form;
    }

    /**
     * Edits an existing Treception entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Treception')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Treception entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
       
        if ($editForm->isValid()) {
            $em->flush();
            $em->flush();
            $msg = "Diligence modifiée avec succès";
            $this->addFlash('notice', $msg);

            return $this->redirect($this->generateUrl('courrier_reg', array('id' => $id)));
        }

        return $this->render('EdiligenceBundle:Treception:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Treception entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EdiligenceBundle:Treception')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Treception entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('reception'));
    }

    /**
     * Creates a form to delete a Treception entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('reception_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}

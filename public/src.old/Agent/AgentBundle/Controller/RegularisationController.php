<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Agent\AgentBundle\Entity\AgentDel;
use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Entity\Regularisation;
use Agent\AgentBundle\Entity\Detachement;
use Agent\AgentBundle\Entity\Changement;
use Agent\AgentBundle\Form\RegularisationType;
use Agent\AgentBundle\Form\DetachementType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
/**
 * Regularisation controller.
 *
 */
class RegularisationController extends Controller
{

    /**
     * Lists all Regularisation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Regularisation')->listeImprimer(0,null,null,$this->getUser());
        //dump($entities);die;
        return $this->render('AgentBundle:Regularisation:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    public function printAction($id=null,$nature=null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Regularisation')->listeImprimer(null,$id,$nature,$this->getUser());
        
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'regularisation-' . $id , -2, -2, 'black', [-2, -2, -2, -2], 'white');
       //dump($entities); die;
        return $this->render('AgentBundle:Regularisation:preview_pdf.html.twig', array(
            'entity' => $entities,
            //'changement'=>$entities[1],
            'qr'=>$qr,
        ));
    }
    /**
     * Creates a new Regularisation entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id=$request->query->get('id');
        $modif=$request->query->get('modif');
        $liste = $em->getRepository('AgentBundle:Regularisation')->listeImprimer(0, null, $id,$this->getUser());
       //dump($modif); die;
         if($modif>0){
         $entity = $em->getRepository('AgentBundle:Regularisation')->find($modif);
        }else{
            $entity = new Regularisation();
            
        }
      
        $form = $this->createCreateForm($entity,$id,$modif);
        $form->handleRequest($request);

        if ($form->isValid()) {
          //dump($entity); die;
            
            if(in_array($id, [1,2,3])){
                switch ($id) {
                    case 1:
                        # code...1
                        # emploi 
                                if ($entity->getAgent()->getEmploi()->getId() != $entity->getNew()->getId()){
                                    $entity->setNature(1);
                                    $entity->setMatAgent($this->get('ediligence.fonctiondebase')->returnConnect());
                                    $entity->setOld($entity->getAgent()->getEmploi()->getId());
                                            $docuPj = $entity->getPj();
                                            $docuPj->setMatricule($entity->getAgent());
                                            $docuPj->setLibelle("Note de service DRH SIGFAE");
                                            $docuPj->setEtat(3);
                                    $entity->setPj($docuPj);
                                            $pjJustificatif=$entity->getPjJustificatif();
                                            $pjJustificatif->setMatricule($entity->getAgent());
                                            $pjJustificatif->setLibelle("Certificat de prise de service DGE antérieur");
                                            $pjJustificatif->setEtat(4);
                                    $entity->setPjJustificatif($pjJustificatif);
                                    $em->persist($entity);

                                    $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$entity->getAgent()->getId()]);
                                    $emploi=$em->getRepository('AgentBundle:Emploi')->findOneBy(['id'=>$entity->getNew()->getId()]);
                                    $entity->setNew($emploi->getId());
                                    $agent->setEmploi($emploi);
                                    $em->flush();
                                     return $this->redirect($this->generateUrl('regularisation_print', array('id' => $entity->getId(),'nature'=>$entity->getNature())));
                                }else{
                                    $this->addFlash('error','emploi erroné');
                                }
                        break;
                case 2:
                    # code...
                    # fonction
                				
                                if ($entity->getAgent()->getFonction()->getId() != $entity->getNew()->getId()/* and $entity->getServiceActuel() != $entity->getAgent()->getServiceActuel()*/){
                                    $entity->setNature(2);
                                    $entity->setMatAgent($this->get('ediligence.fonctiondebase')->returnConnect());
                                    $entity->setOld($entity->getAgent()->getFonction()->getId());
                                            $docuPj = $entity->getPj();
                                            $docuPj->setMatricule($entity->getAgent());
                                            $docuPj->setLibelle("Décision dans la fonction");
                                            $docuPj->setEtat(3);
                                    $entity->setPj($docuPj);
                                            $pjJustificatif=$entity->getPjJustificatif();
                                            $pjJustificatif->setMatricule($entity->getAgent());
                                            $pjJustificatif->setLibelle("Certificat de prise de service DGE antérieur");
                                            $pjJustificatif->setEtat(4);
                                    $entity->setPjJustificatif($pjJustificatif);
                                    $em->persist($entity);

                                    $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$entity->getAgent()->getId()]);
                                    $fonction=$em->getRepository('AgentBundle:Fonction')->findOneBy(['id'=>$entity->getNew()->getId()]);
                                    $entity->setNew($fonction->getId());
                                    $agent->setFonction($fonction);
                                    //yapi//direction
                                    $changement= new Changement();
                                    $changement->setOldCodeDg($agent->getCodeDg());
                                    $changement->setOldCodeDc($agent->getDirection());
                                    $changement->setOldCodeSd($agent->getCodeSd());
                                    $changement->setOldCodeSc($agent->getCodeSc());
                                    
                                    $agent->setCodeDg($entity->getCodeDg());
                                    $agent->setCodeDc($entity->getCodeDc()->getId());
                                    $agent->setDirection($entity->getCodeDc());
                                    $agent->setCodeSd($entity->getCodeSd());
                                    $agent->setCodeSc($entity->getCodeSc());
                                  
                                    $changement->setMatEnreg($this->get('ediligence.fonctiondebase')->returnConnect());
                                    $changement->setMatAgent($agent);

                                     $changement->setNewCodeDg($entity->getCodeDg());
                                    $changement->setNewCodeDc($entity->getCodeDc());
                                    $changement->setNewCodeSd($entity->getCodeSd());
                                    $changement->setNewCodeSc($entity->getCodeSc());
                                    $em->persist($changement);
                                    $em->flush();
                                    return $this->redirect($this->generateUrl('regularisation_print', array('id' => $entity->getId(),'nature'=>$entity->getNature())));
                                }else{
                                	//	dump($entity); die;
                                    $this->addFlash('error','fonction identique à la précédente');
                                }
                    break;
                case 3:
                        $entity->setNature(3);
                        $entity->setMatAgent($this->get('ediligence.fonctiondebase')->returnConnect());
                                    $entity->setOld($entity->getAgent()->getEmploi()->getId());
                                    $entity->setDateOld($entity->getAgent()->getDatePriseServiceDge());
                                            $docuPj = $entity->getPj();
                                            $docuPj->setMatricule($entity->getAgent());
                                            $docuPj->setLibelle("Note de service DRH SIGFAE");
                                            $docuPj->setEtat(3);
                                    $entity->setPj($docuPj);
                                            /*$pjJustificatif=$entity->getPjJustificatif();
                                            $pjJustificatif->setMatricule($entity->getAgent());
                                            $pjJustificatif->setLibelle("Certificat de prise de service DGE antérieur");
                                            $pjJustificatif->setEtat(4);
                                    $entity->setPjJustificatif($pjJustificatif);*/
                                    $em->persist($entity);

                                    $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$entity->getAgent()->getId()]);
                                    $emploi=$em->getRepository('AgentBundle:Emploi')->findOneBy(['id'=>$entity->getNew()->getId()]);
                                    $type=$em->getRepository('AgentBundle:Type')->find('1');
                                    $entity->setNew($emploi->getId());
                                    $agent->setEmploi($emploi);
                                    $agent->setDatePriseServiceDge($entity->getDateNew());
                                    $agent->setDatePremierService($entity->getDateNew());
                                    $agent->setType($type);
                                    $em->flush();
                                     return $this->redirect($this->generateUrl('regularisation_print', array('id' => $entity->getId(),'nature'=>$entity->getNature())));
                    break;
                   
                }
            }
            
            
        }
        

        return $this->render('AgentBundle:Regularisation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'=> $id,
            'listeimprimer'=>$liste
        ));
    }

    /**
     * Creates a form to create a Regularisation entity.
     *
     * @param Regularisation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Regularisation $entity, $id=1,$modif=0)
    {
        $form = $this->createForm(new RegularisationType(), $entity, array(
            'id'=>$id,
            'action' => $this->generateUrl('regularisation_create',['id'=>$id,'modif'=>$modif]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Regularisation entity.
     *
     */
    public function newAction($id=1,$modif=0)
    {	
    	$em = $this->getDoctrine()->getManager();

        $liste = $em->getRepository('AgentBundle:Regularisation')->listeImprimer(0, null, $id, $this->getUser());
        //dump($liste); //dump($modif);
        //die;
         if($modif>0){
         $entity = $em->getRepository('AgentBundle:Regularisation')->find($modif);
        }else{
        	$entity = new Regularisation();
        	
        }
         $form   = $this->createCreateForm($entity,$id,$modif);
        /* $Form->handleRequest($request);

        if ($Form->isValid()) {
        	$em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('regularisation_edit', array('id' => $id)));
        }*/
        return $this->render('AgentBundle:Regularisation:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'=>$id,
            'listeimprimer'=>$liste,
        ));
    }

    /**
     * Finds and displays a Regularisation entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Regularisation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regularisation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Regularisation:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Regularisation entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Regularisation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regularisation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Regularisation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Regularisation entity.
    *
    * @param Regularisation $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Regularisation $entity)
    {
        $form = $this->createForm(new RegularisationType(), $entity, array(
            'action' => $this->generateUrl('regularisation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Regularisation entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Regularisation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Regularisation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('regularisation_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Regularisation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Regularisation entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Regularisation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Regularisation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('regularisation'));
    }

    /**
     * Creates a form to delete a Regularisation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regularisation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


     public function positionAction($id=1, Request $request,$modif=0)
    {   
        $em = $this->getDoctrine()->getManager();

        $liste = $em->getRepository('AgentBundle:Detachement')->detachlisteImprimer(0, $id, $id, $this->getUser());
        
         if($modif>0){
            $entity = $em->getRepository('AgentBundle:Detachement')->find($modif);
        }else{
            $entity = new Detachement();   
        }
         $form   = $this->createDetachForm($entity,$id,$modif);
         $form->handleRequest($request);

        if ($form->isValid()) {
           //ENREGISTREMENT DANS LA TABLE DETACHEMENT
            $nature =  $em->getRepository('AgentBundle:Naturedetachement')->findOneById($id);
            $entity->setNaturedetachement($nature);
            $entity->setNameactor($this->getUser()->getAgent());

            $em->persist($entity);

            $agent =  $em->getRepository('AgentBundle:Agent')->findOneById($entity->getAgent());
            $agent->setPosition($id);
            $em->persist($agent);
//dump($entity);dump($agent);die;
            $em->flush();

            $this->addFlash('notice', 'Enregistré avec Succès' );
            return $this->redirect($this->generateUrl('regularisation_position', array('id' => $id, 'modif' => 0)));
        }
        //dump($liste);
        return $this->render('AgentBundle:Regularisation:positionagent.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'id'=>$id,
            'listeimprimer'=>$liste,
        ));

       /* if($modif>0){
        $liste_agent = $em->getRepository('AgentBundle:Agent')->findBy(['positionagent'=>$id, 'id'=>$modif]);
        }else{
       $liste_agent = $em->getRepository('AgentBundle:Agent')->findBy(['positionagent'=>$id]);

        }

       $form = $this->createFormBuilder()
                 ->add('agent', 'entity', ['attr' => [
                                                   'style' => 'color:green',
                                                   'class' => 'selectpicke',
                                                   'data-live-search' => 'true', 
                                                   'title' => 'Choisir l\'agent'
                                                 ] ,
                                                'choice_attr' => function ($agent, $key, $value) use ($liste_agent) {

                                                    if(count($liste_agent)==1 && $agent==$liste_agent[0]){
                                                        return ['selected' => 'selected'];
                                                    }else{
                                                       return  ['i'=>0];
                                                    }
                                
                            },
                                        'choice_label' => 'concatNommatricule',
                                        'placeholder' => ' Choisir un agent',
                                        'class' => 'AgentBundle:Agent',
                                        'group_by' => 'Direction',
                                        'query_builder' => function(EntityRepository $repo)  {
                                            $respo = $repo->createQueryBuilder('a');
                                                       // ->where('a.positionagent = :positionagent')
                                                       // ->setParameter('positionagent', 0);  
                                                        $respo = $respo->orderBy('a.Direction,a.code_sd,a.nom, a.prenoms', 'ASC');
                                            
                                            return $respo;
                                        },

                                       
                                      ]

                      )    
        
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer Position Agent'])
            ->getForm(); 

         $form->handleRequest($request);
         if ($form->isValid()) {

            $agents = $form->getData()['agent'];
            $agents->setPositionagent($id);
            //$agents->setDatepositionagent(\DateTime('now'));
            $agents->setActorposition($this->getUser()->getAgent());
            $em->persist($agents);

            $users =  $em->getRepository('UsersBundle:Users')->findOneByAgent($agents->getId());
            if($users){
                $users->setEnabled(0);
                $em->persist($users);
            }

             $em->flush(); 
             $this->addFlash('notice', 'Enregistré avec Succès' );
            return $this->redirect($this->generateUrl('regularisation_position', array('id' => $id)));
           
      }

         return $this->render('AgentBundle:Regularisation:positionagent.html.twig', array('form' => $form->createView(), 'id'=>$id,
            'liste_agent'=>$liste_agent));
        */

        
    }

    private function createDetachForm(Detachement $entity, $id=1,$modif=0)
    {
        $form = $this->createForm(new DetachementType(), $entity, array(
            'id'=>$id,
            'modif'=>$modif,
            'action' => $this->generateUrl('regularisation_position',['id'=>$id,'modif'=>$modif]),
            'method' => 'POST',
        ));

        $form->add('Enregistrer', 'submit', array('label' => 'Enregistrer Position Agent'));

        return $form;
    }

    public function detachprintAction($id=null,$nature=null)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Detachement')->detachlisteImprimer(1,$nature,$id,$this->getUser());
         $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'regularisation-' . $id . '-', -2, -2, 'black', [-2, -2, -2, -2], 'white');
//dump($entities);die;
        return $this->render('AgentBundle:Regularisation:preview_detachpdf.html.twig', array(
            'entity' => $entities,
            'qr'=>$qr,
        ));
    } 


public function delAgentAction(Request $request,$id=0, $todo=0, $res=0)
    {   
        $this->denyAccessUnlessGranted('ROLE_RESPO_SRHMG');
        $em = $this->getDoctrine()->getManager();

        $demande=$conge=null;
        $agentsdel = $em->getRepository('AgentBundle:AgentDel')->findAll();
        $agents = $em->getRepository('AgentBundle:Agent')->findBy([],['nom'=>'ASC']);

        if($id>0 && $res==0){
            $agents = $em->getRepository('AgentBundle:Agent')->findBy(['id'=>$id]);
            if($agents){
                  //check  actions conge /demande
            $demande =$em->getRepository('DemandesBundle:Demande')->findBy(['emmeteur'=>$id]);//, 'etatEncours'=>0
            $conge   = $em->getRepository('AgentBundle:Conges')->findBy(['agent'=>$id]);//, 'etat'=>3

            if((empty($demande) && empty($conge)) || $todo>0){
                //users
                $utilisateur = $em->getRepository('UsersBundle:Users')->findOneByAgent($agents[0]->getId());
                 if(!$utilisateur){
                	$tabobject = ['agent'=>$agents[0]];
                }else{
 					$tabobject = $this->getforeignkey(['agent','users'], $utilisateur );
                }
         //dump($tabobject); die;
                $this->delagents($em, $this->getUser()->getAgent(), $tabobject);
                $this->addFlash('error','Agent supprimé');
                $agents= $em->getRepository('AgentBundle:Agent')->findBy([],['nom'=>'ASC']);
                return $this->redirect($this->generateUrl('regularisation_del', array()));
            }
            
            }else{
                throw $this->createNotFoundException('Unable to find Regularisation entity.');
            }

        }

        if($res>0){
           $agentsdel = $em->getRepository('AgentBundle:AgentDel')->findOneBy(['id'=>$res]);
           $this->getRestaure($agentsdel, $this->getUser()->getAgent());
            return $this->redirect($this->generateUrl('regularisation_del', array()));
        }

        return $this->render('AgentBundle:Regularisation:delagent.html.twig', array(
                    'agents' => $agents,
                    'demandes' => $demande,
                    'conges' => $conge,
                    'todo' => $todo,
                    'agentdel' => $agentsdel,
        ));

   }

  private function delagents($em, $user, $table){
//check existance of the agent
        $object = new AgentDel();
        $object->setNature('suppression');
        $object->setObjet($table);
        $object->setDatecreation(new \DateTime('now'));
        $object->setActeur($user->getMatricule());
        $em->persist($object);
      //delete users
        $em->remove($table['agent']);  
        $em->flush();

    return 1;
    }
  
 
 private function getforeignkey($table, $id){
    $keys = $this->getDoctrine()->getManager()->getRepository('AgentBundle:AgentDel')->foreignkey($table, $id);
    return $keys;
 }

 private function getRestaure($objet, $user){
    $em = $this->getDoctrine()->getManager();
    if(!empty($objet)){
      //restore agent
        $agent = $objet->getObjet()['agent'];
        $dependances = $objet->getObjet();

        $h = $em->getRepository('AgentBundle:AgentDel')->inserttable($dependances);
       
        $em->remove($objet);
        $em->flush();
    
    }
    
 }



}

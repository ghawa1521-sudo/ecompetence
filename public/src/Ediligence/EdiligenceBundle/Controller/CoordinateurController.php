<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ediligence\EdiligenceBundle\Entity\Ttraitement;
use Ediligence\EdiligenceBundle\Entity\Tmp_traitement;
use Ediligence\EdiligenceBundle\Entity\Rejet;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Agent\AgentBundle\Form\PjRType;
use Ediligence\EdiligenceBundle\Form\Tmp_traitementType;
use Ediligence\EdiligenceBundle\Form\RejetType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Treception controller.
 *
 */
class CoordinateurController extends Controller {

    /**
     * Lists all Treception entities.
     *csrecu
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'cs_recu/cs_coord.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matricule = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->compiler($service_sup['service'], $matricule);
        $tab_dir = '';
        
        foreach ($entities as $line) {
            $tab_dir.= $line->getId() . ',';
        }
        $tab_dir = substr($tab_dir, 0, (strlen($tab_dir) - 1));
        
        $entity1 = $em->getRepository('EdiligenceBundle:TimputDir')->service_dest($tab_dir);
  
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'entity1' => $entity1));
    }

    public function compileAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $matricule = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->findBy(array('id' => $id));
        
        if ($entities) {
            //checked if the traitement is transfered
            $tmptraitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array('idImput'=>$id, 'matriculeimpute'=>$this->getUser()->getAgent()->getMatricule()));
            //$tmptraitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array('codecourrier'=>$entities[0]->getCourrier(), 'matriculeimpute'=>$this->getUser()->getAgent()->getMatricule()));
           //dump($id);dump($this->getUser()->getAgent()->getMatricule());dump($tmptraitement);die;
            //search of the instruction by the direction
            $direction = $em->getRepository('EdiligenceBundle:TimputInstruction')->findinstruct($id); 
            //dump($direction);die;
           // $instruction = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $entities));
            $dirimput = $em->getRepository('EdiligenceBundle:TimputDir')->cord_imput($id);
            //dump($dirimput);die;
            $service_sup = $this->getUser()->getAgent()->retour_service();
            $service_cord = $em->getRepository('EdiligenceBundle:TimputDir')->find_imputdir($service_sup['service'], $matricule);
            
            $dirrejet = $em->getRepository('EdiligenceBundle:TimputDir')->cord_rejet($id);
             
            // dump( $entities);
            //dump($direction);
            //dump($service_cord[0]->getId());
            //dump($tmptraitement);dump($dirrejet);die;
            
            $vue = 'cs_recu/coordonner.html.twig';
            $array = array('id' => $id, 'entities' => $entities, 'direction'=>$direction, 'dirimput' => $dirimput, 'scecord' => $service_cord[0]->getId(), 'tmptraitement'=>$tmptraitement, 'rejet'=>$dirrejet);

        }

        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
    }

    public function trtAction(Request $request) {
        $err=0;
        $id = $request->request->get('imput');
        $scecord = $request->request->get('scecord');

        $em = $this->getDoctrine()->getManager();

        if($id==null){
         $err=1;
        $scecord =  intval($request->request->get('ediligence_ediligencebundle_tmp_traitement')['imputdir']);
         $id =       intval($request->request->get('ediligence_ediligencebundle_tmp_traitement')['idImput']);
        }
        
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->findBy(array('id' => $id));
        $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findOneBy(array('id' => $scecord));
        
        
        $task = new Tmp_traitement();
        
        $task->setImputdir($imputdir);
        $form = $this->createForm(new Tmp_traitementType(), $task, array(
            'action' => $this->generateUrl('coordinateur_trt'),
            'method' => 'POST',
        ));
        
        
        $form->handleRequest($request);
       
        $traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->max_traitement($entities[0]->getCourrier()->getId(), $id);
        if ($traitement['max_enreg'] != null || $traitement['max_enreg'] == 0) {
            $trt = $traitement['max_enreg'] + 1;
        } else {
            $trt = 1;
        }

        $vue = 'cs_recu/trans_cord.html.twig';
        $array = array('id' => $id, 'entities' => $entities, 'form' => $form->createView(), 'traitement' => $trt, 'scecord' => $scecord);
  
        if($err==1 && $id !=null){
            //persistence tmptraitement
            $task->setDatetraitement(new \DateTime());
            $task->setTxttraitement($task->getLibtraitement());
            $task->setNumtraitement($trt);
            $task->setMatriculeimpute($this->getUser()->getAgent()->getMatricule());
            $task->setMatriculeimputeur($entities[0]->getMatriculeImput()->getMatricule());
            $task->setCodecourrier($entities[0]->getCourrier()->getId());
            $task->setEtataff(1);
            $em->persist($task);
            
            $task1 = new Ttraitement();
            $task1->setDatetraitement(new \DateTime()); 
            $task1->setLibtraitement($task->getLibtraitement());
            $task1->setTxttraitement($task->getTxttraitement());
            $task1->setEtattraitement(0);
            $task1->setNumtraitement($task->getNumtraitement());
            $task1->setMatriculeimpute($task->getMatriculeimpute());
            $task1->setMatriculeimputeur($task->getMatriculeimputeur());
            $task1->setCodecourrier($task->getCodecourrier());
            $task1->setIdImput($task->getIdImput());
            $task1->setPjtraitement($task->getPjtraitement());
            $task1->setEtataff(1);  
            $em->persist($task1);
            
            $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($entities[0]->getCourrier()->getId());
            $update_courrier->setEtataff(1);
            $em->persist($update_courrier);
            
            $update_imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($id);
            $update_imputation->setEtatTrait(1);
            $em->persist($update_imputation);
            
            $update_imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->find($imputdir);
            $update_imputdir->setDesactive(1);
            $em->persist($update_imputdir);
            
            //desactiver les anciens traitements
           // $old_traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('desactive'=>0, 'etattraitement'=>0, 'idImput'=>$id, 'codecourrier'=>$entities[0]->getCourrier()->getId()));
            
            
            $em->flush();
            $msg = "Diligence transmise avec succès";
            $this->addFlash('notice', $msg);
            
            return $this->redirect($this->generateUrl('courrier_csrecu'));
                
        }
        
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);

    }

   public function archiveAction(Request $request) {
      $em = $this->getDoctrine()->getManager();
      $direction='';
      $archive = $em->getRepository('EdiligenceBundle:Tarchive')->archive();
     
      if($archive){
          $idimput='';
          foreach($archive as $value){
             $idimput=$idimput.$value['idImput'].',';
          }
       //$idimput=','.$archive[0]['idImput'];
       $idimput=substr($idimput,0,strlen($idimput)-1);
       $direction = $em->getRepository('EdiligenceBundle:TimputDir')->service_dest($idimput);
       //dump( $direction);die;
      }

      $vue = 'dge/listearchive.html.twig';
      $array=array('archive'=>$archive,'direction'=>$direction);
      
      return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
   } 
    
   public function transmisAction(Request $request) {
      $em = $this->getDoctrine()->getManager();
      $matricule = $this->getUser()->getAgent()->getMatricule();
      $entities = $em->getRepository('EdiligenceBundle:Tmp_traitement')->trt_list($matricule);
      
      $vue = 'cs_recu/transmis.html.twig';
      $array=array('entities'=>$entities);
      
      return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
   }
  
   public function retAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();
    $rejet = new Tmp_traitement();
    $form = $this->createForm(new RejetType(), $rejet, 
            array('action' => $this->generateUrl('coordinateur_ret',array('id'=>intval($id), 'method' => 'POST',)) ));  
    $form->handleRequest($request); 
    if ($form->isValid()&& $form->isSubmitted()) {
       //verifier que le traitement existe
      $traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('imputdir'=>$id)); 
       //desactiver le traitement
      if($traitement){
        //$rejet = new Tmp_traitement(); 
        $traitement->setModif(1);
        $traitement->setDaterejet(new \DateTime());
        $traitement->setMatriculecord($this->getUser()->getAgent()->getMatricule()); 
        $traitement->setLibrejet($rejet->getLibrejet());
        $traitement->setPjrejet($rejet->getPjrejet());
        $em->persist($traitement);
        $em->flush();
        $msg = "Diligence transmise avec succès";
        $this->addFlash('notice', $msg);
  
        return $this->redirect($this->generateUrl('coordinateur_compile', array('id'=>$traitement->getIdImput())));
      }   
       //rediriger vers la page precedente
    }
    $imputation=0;
    $dirimput = $em->getRepository('EdiligenceBundle:TimputDir')->cord_renvoi(intval($id));
    if($dirimput){
      $imputation=$dirimput[0]['tr']->getIdImput();
    }
    
    $vue = 'cs_recu/retcoord.html.twig';
    $array=array('dirimput'=>$dirimput, 'id'=>$imputation, 'form' => $form->createView());
      
      return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
   }
/*  
 public function trtretAction(Request $request) {
  $em = $this->getDoctrine()->getManager();
  $traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('imputdir'=>$request->request->get('imputdir')));
  $matricule = $this->getUser()->getAgent()->getMatricule();
  if($traitement){
  $rejet = new Rejet();
  $rejet->setDatetraitement($traitement->getDatetraitement()); 
  $rejet->setLibtraitement($traitement->getLibtraitement());
  $rejet->setTxttraitement($traitement->getTxttraitement());
  $rejet->setEtattraitement($traitement->getEtattraitement());
  $rejet->setNumtraitement($traitement->getNumtraitement());
  $rejet->setMatriculeimpute($traitement->getMatriculeimpute());
  $rejet->setMatriculeimputeur($traitement->getMatriculeimputeur());
  $rejet->setCodecourrier($traitement->getCodecourrier());
  $rejet->setIdImput($traitement->getIdImput());
  $rejet->setPjtraitement($traitement->getPjtraitement());
  $rejet->setEtataff($traitement->getEtataff());
  $rejet->setImputdir($traitement->getImputdir());
  $rejet->setDaterejet(new \DateTime()); 
  $rejet->setMatriculecord($matricule); 
  
  $em->persist($rejet);
  $em->remove($traitement);
  $idimput=$traitement->getIdImput();
  $em->flush();
  $msg = "Diligence transmise avec succès";
  $this->addFlash('notice', $msg);
  
  //$referer = $this->getRequest()->headers->get('referer');
 // return $this->redirect($referer);
  return $this->redirect($this->generateUrl('coordinateur_compile', array('id'=>$idimput)));
  }  
}  */ 
 
 public function csrecuAction() {
    $em = $this->getDoctrine()->getManager();
    $vue = 'cs_recu/digimpute.html.twig';
    $service_sup = $this->getUser()->getAgent()->retour_service();
    $matricule = $this->getUser()->getAgent()->getMatricule();
    $dest='';
    /*switch (strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase())) {
        case 'ROLE_DGE': { $entities = $em->getRepository('EdiligenceBundle:Timputations')->dilig_impute($service_sup['service'],$matricule); } break;
        default: { $entities = $em->getRepository('EdiligenceBundle:Timputations')->dilig_impute($service_sup['service'],$matricule); }    
     }*/
    $entities = $em->getRepository('EdiligenceBundle:Timputations')->dilig_impute($service_sup['service'],$matricule);
    //dump($entities); dump($entities[0]['imput']);die;
    if($entities){
      $dest = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation'=>$entities[0]['imput'])); 
    }
    return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'dest'=>$dest));
    }   
   
 public function delimputeAction($id){
    $em = $this->getDoctrine()->getManager();
    $service_sup = $this->getUser()->getAgent()->retour_service();
    $entity = $em->getRepository('EdiligenceBundle:Timputations')->find($id); 
    $matricule = $this->getUser()->getAgent()->getMatricule();
    
    if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        }
    else{ 
      //delete the rows in the table timputations
       $imputdirs = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation'=>$id));
       //$newimputation = $imputdirs[0]->getImputation()->getId();
       $imputinstructions = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation'=>$id));
       //reactiver l'ancienne ligne
       $courrier = $em->getRepository('EdiligenceBundle:TimputDir')->timputdir_search($matricule, $service_sup['service'], 1);
       $courrier[0]->setEtatImputDir(0);
       $courrier[0]->setDesactive(0);
       $em->persist($courrier[0]);
       // dump($imputdirs[0]->getImputation()->getId());dump($id);dump($courrier);die;
       foreach($imputdirs  as $imputdir){
         $em->remove($imputdir);   
       }
       
       foreach($imputinstructions  as $imputinstruction){
        $em->remove($imputinstruction);   
       }
      
       $em->remove($entity);
       
       $em->flush();
       
       $msg = "Diligence supprimée avec succès";
       $this->addFlash('notice', $msg);
       
       return $this->redirect($this->generateUrl('coordinateur_csrecu'));   
     } 
    
 }
   
 public function forumAction(Request $request, $id) {
    dump(1245);die;
  }

 
}

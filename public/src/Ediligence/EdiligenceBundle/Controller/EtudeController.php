<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ediligence\EdiligenceBundle\Entity\Tmp_traitement;
use Ediligence\EdiligenceBundle\Entity\Ttraitement;
use Ediligence\EdiligenceBundle\Entity\Tarchive;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ediligence\EdiligenceBundle\Form\TrtcsType;
use Ediligence\EdiligenceBundle\Form\RejetType;
use Ediligence\EdiligenceBundle\Form\TarchiveType;

class EtudeController extends Controller {

    function __construct() {
        
    }

    public function trtAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $vue = 'etude/index.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $fonction = $this->getUser()->getAgent()->getFonction()->getId();
        $role = strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase());
        $nbreobjet = explode(',', $service_sup['tab_imput']);

        if (count($nbreobjet) > 1) {
            $sup = $nbreobjet[1];
        } elseif (count($nbreobjet) == 1) {
            $sup = $nbreobjet[0];
        }
        switch (substr($sup, 0, 2)) {
            case 'DG': {
                    $code = 'code_dg';
                }break;
            case 'DC': {
                    $code = 'code_dc';
                }break;
            case 'SD': {
                    $code = 'code_sd';
                }break;
            case 'SC': {
                    $code = 'code_sc';
                }break;
        }

        $array = array();
        //verifier l'existence du traitement
        $dest = null;
        $nfois = 0;
        $entities = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findtrt($id);

        if ($entities) {
             $t= $em->getRepository('EdiligenceBundle:TimputDir')->findFirstImput($entities[0]['codecourrier']);
             if(strcmp($matuser, $t['imputMatricule'])==0){
                $destfinal=$t['imputMatricule'];
             }else{
                $destfinal=null; 
             }
           // dump($t);die;
            
            $array = array('id' => $id, 'entities' => $entities, 'destfinal'=>$destfinal); //, 'sup' => $dest, 'nfois' => $nfois

            if ($request->getMethod() == 'POST' && $request->request->get('traiter') == 'dgearchive') {
                //dump($entities[0]['idImput']);dump($entities[0]['codecourrier']);die;
                //recuperer le traitement
                if( $entities[0]['typecourrier']==2){
                  $traitement_id = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('id' => $id));
                  
                  $newttraitement = new Ttraitement();
                  $newttraitement->setPjtraitement($traitement_id->getPjtraitement());
                  $newttraitement->setDatetraitement($traitement_id->getDatetraitement());
                  $newttraitement->setLibtraitement($traitement_id->getLibtraitement());
                  $newttraitement->setTxttraitement($traitement_id->getTxttraitement());
                  $newttraitement->setEtattraitement($traitement_id->getEtattraitement());
                  $newttraitement->setNumtraitement($traitement_id->getNumtraitement());
                  $newttraitement->setMatriculeimpute($traitement_id->getMatriculeimpute());
                  $newttraitement->setMatriculeimputeur($traitement_id->getMatriculeimputeur());
                  $newttraitement->setCodecourrier($traitement_id->getCodecourrier());
                  $newttraitement->setIdImput($traitement_id->getIdImput());
                  $newttraitement->setEtataff($traitement_id->getEtataff()); 
                  $newttraitement->setModif($traitement_id->getModif());

                  $em->persist($newttraitement);
                  
                }else{
                $traitement_id = $em->getRepository('EdiligenceBundle:Ttraitement')->findOneBy(array('idImput' => $entities[0]['idImput'], 'codecourrier' => $entities[0]['codecourrier'], 'etattraitement' => 0));
                }
               // dump($traitement_id);die;
              /*  if ($traitement_id != null) {
                    $traitement_id = $traitement_id;
                } else {
                    $traitement_id = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('id' => $id));
                }*/


                //archiver le traitement      
                $archive = new Tarchive();
                $archive->setDateArchive(new \DateTime());
                $archive->setMatriculeArchiveur($matuser);
                $archive->setNumtraitement($entities[0]['numtraitement']);
                 if( $entities[0]['typecourrier']==2){
                $archive->setObsrv('VALIDATION'); 
                 }else{
                $archive->setObsrv('VALIDATION DGE');
                 }
                $archive->setServiceArchive($service_sup['service']);
                $archive->setCodecourrier($entities[0]['codecourrier']);
                $archive->setNomFichier($entities[0]['pj']);
                 if( $entities[0]['typecourrier']==2){
                     $archive->setTraitements($newttraitement);
                 }else{
                $archive->setTraitements($traitement_id);
                 }
                $em->persist($archive);

                //desactiver l'ancien tmp_traitement
                $old_traitement1 = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array( 'etattraitement' => 0, 'codecourrier' => $entities[0]['codecourrier']));//'desactive' => 0,
                $w = count($old_traitement1);
                
               //dump($old_traitement1);dump($w);die;
                if ($w >= 1) {
                    foreach ($old_traitement1 as $old) {
                        $old->setEtattraitement(1);
                        $old->setDesactive(1);
                        $em->persist($old);
                       // dump($old);
                    }
                }
                
                //desactiver le traitement
                if( $entities[0]['typecourrier']==2){
                 // $old_traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->find($newttraitement);  
                }else{
                $old_traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->find($traitement_id);
                $old_traitement->setEtattraitement(1);
                $em->persist($old_traitement);
                //dump($old_traitement);
                }
               
                //desactive le courrier
                $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($entities[0]['codecourrier']);
                $update_courrier->setEtataff(1);
                //die;
                $em->persist($update_courrier);
//die;
                $em->flush();
                $msg = "Diligence archivé avec succès";
                $this->addFlash('notice', $msg);
                return $this->redirect($this->generateUrl('courrier_diligtrt'));
            }


            if ($request->getMethod() == 'POST' && $request->request->get('traiter') == 'dge') {
                //redirection sur formulaire archivage
                $archive = new Tarchive();
                $formtype = new TarchiveType();
                $action = 'etude_trt';
                $vue = 'etude/archive.html.twig';
                $form = $this->createForm($formtype, $archive, array('action' => $this->generateUrl($action, array('id' => $id)), 'method' => 'POST'));
                $array = array('id' => $id, 'entities' => $entities, 'sup' => $dest, 'form' => $form->createView(), 'nfois' => $nfois);

                if ($request->request->get('etat') == 'archiver') {
                    $form->handleRequest($request);
                    $idtraitement = $request->request->get('id_traitement');
                    $codecourrier = $request->request->get('courrier');
                    $imputations = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('serviceImput' => $service_sup['service'], 'courrier' => $codecourrier));

                    $traitement = new Ttraitement();
                    //verifier que le fichier existe
                    if ($form->getData()->getNomFichier()) {
                        $traitement->setPjtraitement($form->getData()->getNomFichier());
                    } else {
                        //$jointepiece = $em->getRepository('AgentBundle:Pj')->findOneBy(array('id'=>$entities[0]['pj']->getId()));
                        $traitement->setPjtraitement($entities[0]['pj']);
                    }
                    // dump($form->getData()->getNomFichier());dump($entities[0]['pj']->getId());dump($jointepiece);die;
                    $traitement->setDatetraitement(new \DateTime());
                    $traitement->setLibtraitement($form->getData()->getObsrv());
                    $traitement->setTxttraitement($form->getData()->getObsrv());
                    $traitement->setEtattraitement(0);
                    $numtraitement = $entities[0]['numtraitement'] + 1;
                    $traitement->setNumtraitement($numtraitement);
                    $traitement->setMatriculeimpute($entities[0]['matriculeimpute']);
                    $traitement->setMatriculeimputeur($matuser);
                    $traitement->setCodecourrier($codecourrier);
                    $traitement->setIdImput($imputations->getId());
                    $traitement->setEtataff(1);
                    $traitement->setModif(0);
                    $em->persist($traitement);

                    //desactiver l'ancien traitement
                    $old_traitement1 = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array('desactive' => 0, 'etattraitement' => 0, 'idImput' => $imputations->getId(), 'codecourrier' => $codecourrier));

                    $w = count($old_traitement1);
                    if ($w > 1) {
                        foreach ($old_traitement1 as $old) {
                            $old->setEtattraitement(1);
                            $old->setDesactive(1);
                            $em->persist($old);
                        }
                        // dump($w); dump($old_traitement1);dump($old->getId()); die;
                    }


                    // dump($old_traitement1); dump($old_traitement); die;


                    $old_traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->find($idtraitement);
                    $old_traitement->setEtattraitement(1);
                    $old_traitement->setDesactive(1);
                    $em->persist($old_traitement);

                    //archiver le traitement
                    $archive = new Tarchive();
                    $archive->setDateArchive(new \DateTime());
                    $archive->setMatriculeArchiveur($matuser);
                    $archive->setNumtraitement($numtraitement);
                    $archive->setObsrv($form->getData()->getObsrv());
                    $archive->setServiceArchive($service_sup['service']);
                    $archive->setCodecourrier($codecourrier);
                    if ($form->getData()->getNomFichier()) {
                        $archive->setNomFichier($form->getData()->getNomFichier());
                    } else {
                        //$jointepiece = $em->getRepository('AgentBundle:Pj')->findOneBy(array('id'=>$entities[0]['pj']->getId()));
                        $archive->setNomFichier($entities[0]['pj']);
                    }

                    $archive->setTraitements($traitement);
                    $em->persist($archive);

                    //desactive le courrier
                    $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($codecourrier);
                    $update_courrier->setEtataff(1);
                    $em->persist($update_courrier);

                    $em->flush();
                    $msg = "Diligence transmise avec succès";
                    $this->addFlash('notice', $msg);
                    return $this->redirect($this->generateUrl('courrier_diligtrt'));
                    /* //recuperer l'id du traitement dans traitement
                      $cletraitement = $em->getRepository('EdiligenceBundle:Ttraitement')->findOneBy(array('codecourrier'=>$codecourrier));
                      $update_archive = $em->getRepository('EdiligenceBundle:Tarchive')->findOneBy(array('codecourrier'=>$codecourrier));
                      $update_archive->setTraitements($cletraitement);
                      $em->persist($update_archive);
                      dump($entities); */
                }
            }

            if ($request->getMethod() == 'POST' && $request->request->get('traiter') == 'traiter') { 
                //le nbre dimputations du dossier
                if ($request->request->get('etatImput') > 0) {
                    $dest = $em->getRepository('AgentBundle:Agent')->getsup($sup, $code, $fonction);
                    //trouver le superieur du chef
                    $sup_dest = $em->getRepository('AgentBundle:Agent')->find_sup_agent($dest[0]->getMatricule(), $entities[0]['codecourrier']);
                    // dump($dest); die;
                    if ($sup_dest == 1) {
                        $dest = $em->getRepository('AgentBundle:Agent')->getsup($sup, $code, $fonction);
                    } else {
                        $dest = $sup_dest;
                    }
                } else {
                    $dest = $em->getRepository('AgentBundle:Agent')->getsup($sup, $code, $fonction);
                }
                $traitement = new Tmp_traitement();
                $formtype = new TrtcsType();
                $action = 'etude_trt';
                $vue = 'etude/trait.html.twig';
                $form = $this->createForm($formtype, $traitement, array('action' => $this->generateUrl($action, array('id' => $id)), 'method' => 'POST'));

                $array = array('id' => $id, 'entities' => $entities, 'sup' => $dest, 'form' => $form->createView(), 'nfois' => $request->request->get('etatImput'), 'typecourrier'=>$request->request->get('typecourrier'), 'destfinal'=>$request->request->get('destfinal'));

                if ($request->request->get('etat') == 'traiter') {
                    $form->handleRequest($request);
                    $idtraitement = $request->request->get('id_traitement');
                    $codecourrier = $request->request->get('codecourrier');
                    $typecourrier = $request->request->get('typecourrier');
                    $destfinal = $request->request->get('destfinal');
                    
                    //rechercher imputation grace a service_imput ou matriculeimpute et desactive = 1
                    $imputations = $em->getRepository('EdiligenceBundle:Timputations')->findimput($service_sup['service'], $matuser, $codecourrier);
                    //dump($codecourrier);dump($imputations);die;
                    $timputdir = $em->getRepository('EdiligenceBundle:TimputDir')->find($imputations[0]['imputdirs']);
                    //dump($imputations); dump($imputations[0]['imputdirs']);dump($imputations[0][0]->getId());dump($imputations[0][0]->getCourrier()->getId());die;
                    //verifier l'existance du traitement
                    $traitements = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findOneBy(array('matriculeimpute' => $matuser, 'codecourrier' => $imputations[0][0]->getCourrier()->getId(), 'idImput' => $imputations[0][0]->getId(), 'imputdir' => $imputations[0]['imputdirs'], 'modif' => 0));

                    // dump($request->request->get('destfin'));dump($traitements);die;
                    if ($traitements) {
                        $msg = "Erreur traitement";
                        $this->addFlash('error', $msg);
                        return $this->redirect($this->generateUrl('etude_trt', array('id' => $idtraitement)));
                    } else {
                        $old_traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->find($idtraitement);
                        $numtraitement = $old_traitement->getNumtraitement() + 1;
                        //insertion dans tmp_traitement
                        $traitementss = new Tmp_traitement();
                        $traitementss->setPjtraitement($form->getData()->getPjtraitement());
                        $traitementss->setDatetraitement(new \DateTime());
                        $traitementss->setLibtraitement($form->getData()->getLibtraitement());
                        $traitementss->setTxttraitement($form->getData()->getLibtraitement());
                        $traitementss->setEtattraitement(0);
                        $traitementss->setNumtraitement($numtraitement);
                        $traitementss->setMatriculeimpute($matuser);
                        //if($ici==1){ $traitementss->setMatriculeimputeur($dest->getMatricule());}else{ $traitementss->setMatriculeimputeur($dest[0]->getMatricule());}
                        $traitementss->setMatriculeimputeur($dest[0]->getMatricule());
                        $traitementss->setCodecourrier($imputations[0][0]->getCourrier()->getId());
                        $traitementss->setIdImput($imputations[0][0]->getId());
                        $traitementss->setEtataff(1);
                        $traitementss->setModif(0);
                        $traitementss->setImputdir($timputdir);
                        //$traitementss->setDesactive(1);
                        $em->persist($traitementss);
                        //desactiver l'ancien traitement
                        $old_traitement->setEtattraitement(1);
                        $old_traitement->setDesactive(1);
                        $em->persist($old_traitement);
                        //desactiver l'imputation
                        $timputdirss = $em->getRepository('EdiligenceBundle:TimputDir')->find($old_traitement->getImputdir()->getId());
                        $timputdirss->setDesactive(1);
                        $em->persist($timputdirss);

                        $timputationss = $em->getRepository('EdiligenceBundle:Timputations')->find($imputations[0][0]->getId());
                        $timputationss->setEtatTrait(1);
                        $em->persist($timputationss);

                        
                        if ( ($request->request->get('destfin') == '500512V') || ($request->request->get('typecourrier')==3) ){
                            $traitement_id = $em->getRepository('EdiligenceBundle:Ttraitement')->findAll();
                            $x = count($traitement_id);

                            //dump(count($traitement_id));dump($traitement_id);die;
                            //enregistrement dans traitement
                            $traitement = new Ttraitement();
                            //verifier que le fichier existe
                            $traitement->setPjtraitement($form->getData()->getPjtraitement());
                            $traitement->setDatetraitement(new \DateTime());
                            $traitement->setLibtraitement($form->getData()->getLibtraitement());
                            $traitement->setTxttraitement($form->getData()->getLibtraitement());
                            $traitement->setEtattraitement(0);

                            $numtraitement = $x + 1;

                            $traitement->setNumtraitement($numtraitement);
                            $traitement->setMatriculeimpute($matuser);
                            $traitement->setMatriculeimputeur($dest[0]->getMatricule());
                            $traitement->setCodecourrier($imputations[0][0]->getCourrier()->getId());
                            $traitement->setIdImput($imputations[0][0]->getId());
                            $traitement->setEtataff(1);
                            $traitement->setModif(0);

                            $em->persist($traitement);
                        }

                        $em->flush();
                        $msg = "Traitement transmis avec succès";
                        $this->addFlash('notice', $msg);
                        return $this->redirect($this->generateUrl('courrier_diligtrt'));
                    }
                }
            }

            if ($request->getMethod() == 'POST' && $request->request->get('traiter') == 'rejeter') {
                $traitement = new Tmp_traitement();
                $formtype = new RejetType();
                $action = 'etude_trt';
                $vue = 'etude/rejet.html.twig';
                $form = $this->createForm($formtype, $traitement, array('action' => $this->generateUrl($action, array('id' => $id)), 'method' => 'POST'));

                $array = array('id' => $id, 'entities' => $entities, 'sup' => $dest, 'form' => $form->createView(), 'nfois' => $nfois);

                if ($request->request->get('etat') == 'rejeter') {
                    $form->handleRequest($request);

                    $idtraitement = $request->request->get('id_traitement');
                    $traitement = $em->getRepository('EdiligenceBundle:Tmp_traitement')->find($idtraitement);
                    // dump($traitement->getNumtraitement() +1);die;
                    if ($traitement) {
                        $idimput = $traitement->getIdImput();
                        $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $idimput));
                        $imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($idimput);
                        //enregistrement dans tmp_traitement en utilisant id_traitement (modif = 1 etattraitement = 1)
                        $traitement->setModif(1);
                        $traitement->setEtattraitement(1);
                        $traitement->setDaterejet(new \DateTime());
                        $traitement->setMatriculecord($this->getUser()->getAgent()->getMatricule());
                        $traitement->setLibrejet($form->getData()->getLibrejet());
                        $traitement->setPjrejet($form->getData()->getPjrejet());
                        $traitement->setDesactive(1);
                        $em->persist($traitement);

                        //desactiver l'imputation dans timput_dir (desactive = 1)
                        foreach ($imputdir as $timputdir) {
                            $timputdir->setDesactive(0);
                            $em->persist($timputdir);
                        }

                        //desactiver l'imputation dans timputation (etattrait = 0) 
                        $imputation->setEtatTrait(0);
                        $em->persist($imputation);

                        if ($imputdir && $imputation) {
                            $em->flush();
                            $msg = "Traitement rejeté avec succès";
                            $this->addFlash('notice', $msg);
                            return $this->redirect($this->generateUrl('courrier_diligtrt'));
                        } else {
                            $msg = "Erreur rejet traitement";
                            $this->addFlash('error', $msg);
                            return $this->redirect($this->generateUrl('etude_trt', array('id' => $idtraitement)));
                        }
                    }

                    // dump($form->getData()); dump($form->getData()->getPjrejet());die;
                }
            }

            //dump($request->isMethod('POST')); dump($form->handleRequest($request)->isValid()); die;
            return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
        } else {
            die;
        }
    }

    public function archiveAction(Request $request, $id) {
        dump(1234);
        die;
    }

}

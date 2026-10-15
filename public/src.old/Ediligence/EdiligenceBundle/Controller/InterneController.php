<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ediligence\EdiligenceBundle\Entity\Tcourrier_i;
use Ediligence\EdiligenceBundle\Form\Tcourrier_iType;
use Ediligence\EdiligenceBundle\Entity\Timputations_i;
use Ediligence\EdiligenceBundle\Entity\TimputDir_i;
use Ediligence\EdiligenceBundle\Entity\TimputInstruction_i;

/**
 * Interne controller.
 *
 */
class InterneController extends Controller {

    /**
     * Lists all Tcourrier entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'index.html.twig';
        $entity = new Tcourrier_i();
        $form = $this->createForm(new Tcourrier_iType(), $entity, array('action' => $this->generateUrl('interne_create'), 'method' => 'POST',));
        $form->add('submit', 'submit', array('attr' => array('class' => 'btn btn-sm btn-primary'), 'label' => '>Imputer aux collaborateurs'));
        $recover_enr = $em->getRepository('EdiligenceBundle:Tcourrier_i')->recover_enreg();

        $array = array('entity' => $entity, 'form' => $form->createView(), 'recover_enr' => $recover_enr['max_enreg']);
        return $this->render('EdiligenceBundle:Interne:' . $vue, $array);
    }

    public function createAction(Request $request) {
        $entity = new Tcourrier_i();
        $form = $this->createForm(new Tcourrier_iType(), $entity, array('action' => $this->generateUrl('interne_create'), 'method' => 'POST',));
        $form->add('submit', 'submit', array('attr' => array('class' => 'btn btn-sm btn-primary'), 'label' => '>Imputer aux collaborateurs'));
        $form->handleRequest($request);
        //dump($request);die;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $typecourrier = $em->getRepository('EdiligenceBundle:Ttypecourrier')->find(2);
            $entity->setTypecourrier($typecourrier);
            $entity->setIdIdentifiant($this->getUser()->getAgent()->getMatricule());
            //  dump($form->getData());dump($this->getUser());die;
            if ($form->getData()->getPiecejointe() != null) {
                $entity->getPiecejointe()->setUtilisateur($this->getUser());
                //  $entity->setPiecejointe($form->getData()->getPiecejointe());  
            }
            $em->persist($entity);
            $em->flush();

            $courrier = $em->getRepository('EdiligenceBundle:Tcourrier_i')->find($entity);
            return $this->redirect($this->generateUrl('interne_imput', array('id' => $courrier->getId())));
        }

        return $this->render('EdiligenceBundle:Interne:index.html.twig', array('entity' => $entity, 'form' => $form->createView(),));
    }

    public function imputAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $matriculeImput = $this->getUser()->getAgent();
        //verifier l'existence du courrier
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier_i')->find($id);
        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            $msg = "Erreur imputation";
            $this->addFlash('error', $msg);
            return $this->redirect($this->generateUrl('interne'));
        } else {
            $vue = 'imput.html.twig';
            $inst_all = $em->getRepository('EdiligenceBundle:Tinstruction')->findinstruction();

            $dir_imput = $em->getRepository('AgentBundle:Agent')->getlistepersonnel($service_sup['abrv'], $service_sup['service']);

            if ($request->isMethod('POST') && $entities->getEtatcourrier() == 0) {

                //recuperer les elements du formulaire
                $err = 0;
                $nbrepers = 0;
                $imp = 0;
                $dir = 0;
                $inst = 0;
                $rep_cood = 0;
                $tab_dir = $request->request->get('DestHide');
                $tab_inst = $request->request->get('In');
                $coordinateur = $request->request->get('lstcoordon');
                $priorite = $request->request->get('priorite');
                $txt_delais = (\DateTime::createFromFormat('d/m/Y', $request->request->get('txt_delais')));
                $txtInstr = $request->request->get('txtInstr');
                $interval = $entities->getDateCreat()->diff($txt_delais);

                if ((int) $interval->format('%R%a days') < 0) {
                    $err = 1;
                } elseif ($tab_dir == null) {
                    $err = 1;
                } elseif ($tab_inst == null) {
                    $err = 1;
                } elseif ($txt_delais == null) {
                    $err = 1;
                } else {
                    $err = 0;
                    $nbrepers = count($tab_dir);
                }

                if (($txtInstr != null)) {
                    $txtInstr = $txtInstr;
                } else {
                    $txtInstr = '';
                }

                //verifier si c'est multiple imputation
                if (strlen($coordinateur) == 24 || empty($coordinateur)) {
                    if ($nbrepers == 1) {
                        $coordinateur = $tab_dir[0];
                    } else {
                        // $coordinateur = 'DC0013';
                        // $rep_cood = 1;
                        $err = 1;
                    } //dga1
                } else {
                    $coordinateur = $coordinateur;
                }

                if ($err == 0) {
                    $imputation = $em->getRepository('EdiligenceBundle:Timputations_i')->findOneBy(array('courrier' => $id, 'matriculeImput' => $this->getUser()->getAgent()->getMatricule()));

                    if (!$imputation) {
                        $imputation = new Timputations_i();
                        //2 remplir les objets
                        $imputation->setDateImput(new \DateTime());
                        $imputation->setMatriculeImput($matriculeImput);
                        $imputation->setServiceImput($this->getUser()->getAgent()->retour_service()['service']);
                        $imputation->setPrioriteImput($priorite);
                        $imputation->setDelaiImput($txt_delais);
                        $imputation->setCoordinateur($coordinateur);
                        $imputation->setInstPart($txtInstr);
                        $imputation->setEtatImput(0);
                        $imputation->setEtatTrait(0);
                        $imputation->setNbrePers($nbrepers);
                        $imputation->setCourrier($entities);

                        $entities->setEtatcourrier(1);
                        $em->persist($imputation);
                        $em->persist($entities);
                        $imp = 1;

                        //timput_dir
                        for ($n = 0; $n < $nbrepers; $n++) {
                            //trouver le superieur de la direction
                            $impute_matricule = $em->getRepository('AgentBundle:Agent')->find_sup($tab_dir[$n]);
                            // dump($impute_matricule);die;
                            $imputdir = new TimputDir_i();
                            $imputdir->setImputation($imputation);
                            $imputdir->setServiceImput($tab_dir[$n]);
                            $imputdir->setImputMatricule($matriculeImput);
                            $imputdir->setEtatImputDir(0);
                            if ($impute_matricule != null) {
                                $imputdir->setMatriculeimpute($impute_matricule[0]);
                            } else {
                                $imputdir->setMatriculeimpute(null);
                            }
                            $em->persist($imputdir);
                            $dir = 1;
                        }
                        //timput_instruction
                        foreach ($tab_inst as $instruc) {
                            //trouver les instructions
                            $instruc_cle = $em->getRepository('EdiligenceBundle:Tinstruction')->findOneBy(array('id' => $instruc));
                            $din[$instruc] = $request->request->get('dIn' . $instruc);
                            if ($din[$instruc] != null) {
                                foreach ($din[$instruc] as $dinn) {
                                    $imputInstruction = new TimputInstruction_i();
                                    $imputInstruction->setIdImputDir($dinn);
                                    $imputInstruction->setEtatInst(0);
                                    $imputInstruction->setImputation($imputation);
                                    $imputInstruction->setImputMatricule($matriculeImput);
                                    $imputInstruction->setInstImput($instruc_cle);
                                    $em->persist($imputInstruction);
                                    $inst = 1;
                                }
                            }
                        }

                        if ($imp == 1 && $dir == 1 && $inst == 1) {
                            $em->flush();
                            $msg = "Courrier imputé avec succès";
                            $this->addFlash('notice', $msg);
                            return $this->redirect($this->generateUrl('interne'));
                        } else {
                            $msg = "Erreur imputation 1";
                            $this->addFlash('error', $msg);
                        }
                    } else {
                        $msg = "Erreur imputation 2";
                        $this->addFlash('error', $msg);
                    }
                }
            }

            $array = array('id' => $id, 'entities' => $entities, 'all_inst' => $inst_all, 'agent_srv' => $dir_imput);
            return $this->render('EdiligenceBundle:Interne:' . $vue, $array);
        }
    }

    public function listAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'listecourrier.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $agent = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier_i')->registre($service_sup['service'], $agent);
        return $this->render('EdiligenceBundle:Interne:' . $vue, array('entities' => $entities));
    }

    public function diligAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'diligence.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $agent = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier_i')->diligence($service_sup['service'], $agent);
        return $this->render('EdiligenceBundle:Interne:' . $vue, array('entities' => $entities));
    }

    public function delAction($id) {
        $em = $this->getDoctrine()->getManager();
        //verifier l'existence de l'imputation
        $imputation = $em->getRepository('EdiligenceBundle:Timputations_i')->find($id);
        if ($imputation) {
            $courrier = $em->getRepository('EdiligenceBundle:Tcourrier_i')->find($imputation->getCourrier()->getId());
            $imputdir = $em->getRepository('EdiligenceBundle:TimputDir_i')->find($imputation->getId());
            $imputinstruction = $em->getRepository('EdiligenceBundle:TimputInstruction_i')->find($imputation->getId());

            //supprimer
            $em->remove($courrier);
            $em->remove($imputation);
            $em->remove($imputdir);
            $em->remove($imputinstruction);

            $em->flush();
        }
        return $this->redirect($this->generateUrl('interne_list'));
    }

    public function traiterAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();

        $entities = $em->getRepository('EdiligenceBundle:Timputations_i')->findOneBy(array('id' => $id));
        $instruction = $em->getRepository('EdiligenceBundle:TimputInstruction_i')->findBy(array('imputation' => $entities, 'idImputDir' => $matuser));
        $imputdir = $em->getRepository('EdiligenceBundle:TimputDir_i')->find_imputdir($service_sup['service'], $matuser, $entities->getId());
        dump($imputdir);die;
        if (strcmp($entities->getCoordinateur(), $service_sup['service']) == 0) {
            $coordinateur = 1;
        } elseif (strcmp($entities->getCoordinateur(), $matuser) == 0) {
            $coordinateur = 1;
        } else {
            $coordinateur = 0;
        }
        
        $name_coord = $em->getRepository('EdiligenceBundle:TimputDir_i')->findBy(array('imputation' => $entities, 'serviceImput' => $entities->getCoordinateur())); 
        $rejettrt = $em->getRepository('EdiligenceBundle:Tmp_traitement_i')->findBy(array('imputdir'=>$name_coord[0]->getId()));
        
        $vue = 'traiter.html.twig';
        $array = array('id' => $id, 'entities' => $entities, 'instruction' => $instruction, 'coord' => $coordinateur, 'NbrePers' => $entities->getNbrePers(), 'idimputdir' => $imputdir, 'rejet' => $rejettrt);

        return $this->render('EdiligenceBundle:Interne:' . $vue, $array);
    }

}

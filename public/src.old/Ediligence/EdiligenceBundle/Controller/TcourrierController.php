<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ediligence\EdiligenceBundle\Entity\Tcourrier;
use Ediligence\EdiligenceBundle\Entity\Timputations;
use Ediligence\EdiligenceBundle\Entity\TimputDir;
use Ediligence\EdiligenceBundle\Entity\TimputInstruction;
use Ediligence\EdiligenceBundle\Form\TcourrierType;
use Ediligence\EdiligenceBundle\Entity\Ttraitement;
use Ediligence\EdiligenceBundle\Entity\Tmp_traitement;
use Ediligence\EdiligenceBundle\Entity\Tarchive;
use Ediligence\EdiligenceBundle\Form\TarchiveType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Agent\AgentBundle\Form\PjRType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Tcourrier controller.
 *
 */
class TcourrierController extends Controller {

    /**
     * Lists all Tcourrier entities.
     *
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        switch (strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase())) {
            case 'ROLE_DGE': {
                    $vue = 'dge/index.html.twig';
                    $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0));
                } break;
            case 'ROLE_Courrier_Interne': {
                    $vue = 'sce_interne/index.html.twig';
                    $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 1));
                } break;
            default: {
                    $vue = 'index.html.twig';
                    $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->findAll();
                }
        }


        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities));
    }

    /**
     * Creates a new Tcourrier entity.
     *
     */
    public function createAction(Request $request, $todo = 1) {
        $entity = new Tcourrier();
        $form = $this->createCreateForm($entity, $todo);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $serviceagent = $this->getUser()->getAgent()->retour_service()['service'];
            //verifier l'existence du numero enregistrement par nature de courrier
            $check = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('numenregistrements' => $entity->getNumenregistrements(), 'typecourrier' => $todo, 'servicesaisi' => $serviceagent));

            if ($check) {
                $msg = "Courrier déjà enregistré";
                $this->addFlash('error', $msg);
                //return $this->redirect($this->generateUrl('courrier_new', array('todo' => $todo)));
                return $this->render('EdiligenceBundle:Tcourrier:new.html.twig', array(
                            'entity' => $entity,
                            'form' => $form->createView(),
                            'todo' => $todo,
                ));
            } else {
                $typecourrier = $em->getRepository('EdiligenceBundle:Ttypecourrier')->findOneBy(array('id' => $todo));
                $entity->setTypecourrier($typecourrier);

                $entity->setIdIdentifiant($this->getUser()->getAgent()->getMatricule());

                $maxenreg = $em->getRepository('EdiligenceBundle:Tcourrier')->max_courrier();
                if ($maxenreg == null) {
                    $maxenreg = 1;
                } else {
                    $maxenreg = intval($maxenreg) + 1;
                }

                $entity->setNumenregistrement($maxenreg);
                //$entity->setNumenregistrement($maxenreg);

                if ($entity->getPiecejointe() != null) {
                    $entity->getPiecejointe()->setUtilisateur($this->getUser());
                }
                $entity->setServicesaisi($serviceagent);
                $em->persist($entity);
                $em->flush();
                $msg = "Courrier Enregistré avec succès";

                /* begin notification  */
                if ($todo == 1) {
                    $this->get('ediligence.board')->addNotification($this->getDoctrine()->getManager(), $entity->getDestCour()->getMatricule(), '<b>Nouveau Courrier</b><br>' . $entity->getSourceCour(), 'EdiligenceBundle:Tcourrier', $entity->getId(), 'courrier_imput');
                }
                /* end notification  */

                // $pusher = $this->get('gos_web_socket.wamp.pusher');
                // $pusher->push("vous avez reçu une nouvelle diligence", 'topic_notification', ['matricule' => '435']);

                $this->addFlash('notice', $msg);

                if ($this->getUser()->hasRole("ROLE_SERVICE_COURRIER")) {//in_array('ROLE_SERVICE_COURRIER',$this->getUser()->getRoles()
                    return $this->redirect($this->generateUrl('courrier_new', array('todo' => $todo)));
                } else {
                    if ($entity->getTypecourrier()->getId() == 3) {
                        return $this->redirect($this->generateUrl('courrier_depart_imput', array('id' => $entity->getId())));
                    } else {
                        return $this->redirect($this->generateUrl('courrier_interne_imput', array('id' => $entity->getId())));
                    }
                }
            }

            //return $this->redirect($this->generateUrl('courrier_show', array('id' => $entity->getId())));
        }

        return $this->render('EdiligenceBundle:Tcourrier:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Tcourrier entity.
     *
     * @param Tcourrier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Tcourrier $entity, $todo = 1, $enregistrement=null) {
        switch ($todo) {
            case 1://Arrivée
                $formtype = new \Ediligence\EdiligenceBundle\Form\ArriveeType($enregistrement);
                break;
            case 2://Diligence
                $formtype = new \Ediligence\EdiligenceBundle\Form\DiligenceType($enregistrement);
                break;
            case 3://Départ
                $formtype = new \Ediligence\EdiligenceBundle\Form\DepartType($enregistrement);
                break;
            default :///Arrivée
                $formtype = new \Ediligence\EdiligenceBundle\Form\ArriveeType();
                break;
        }
        $form = $this->createForm($formtype, $entity, array(
            'action' => $this->generateUrl('courrier_create', array('todo' => $todo)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('attr' => array('class' => 'btn btn-sm btn-primary'), 'label' => '>Transmettre'));

        return $form;
    }

    /**
     * Displays a form to create a new Tcourrier entity.
     *
     */
    public function newAction($todo) {
        $entity = new Tcourrier();
        $entity->setObservationscecour("RAS");

        $em = $this->getDoctrine()->getManager();
        $recover_enr = $em->getRepository('EdiligenceBundle:Tcourrier')->recover_enreg($todo);
        $form = $this->createCreateForm($entity, $todo, $recover_enr);
        
        return $this->render('EdiligenceBundle:Tcourrier:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'recover_enr' => $recover_enr,
        ));
    }

    /**
     * Finds and displays a Tcourrier entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EdiligenceBundle:Tcourrier:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tcourrier entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        }

        $editForm = $this->createEditForm($entity, $entity->getTypecourrier()->getId());
        $deleteForm = $this->createDeleteForm($id);
        $recover_enr = $em->getRepository('EdiligenceBundle:Tcourrier')->recover_enreg($entity->getTypecourrier()->getId());


        return $this->render('EdiligenceBundle:Tcourrier:edit.html.twig', array(
                    'entity' => $entity, 'recover_enr' => $recover_enr,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Tcourrier entity.
     *
     * @param Tcourrier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Tcourrier $entity, $todo = 1) {
        switch ($todo) {
            case 1://Arrivée
                $formtype = new \Ediligence\EdiligenceBundle\Form\ArriveeType();
                break;
            case 2://Diligence
                $formtype = new \Ediligence\EdiligenceBundle\Form\DiligenceType();
                break;
            case 3://Départ
                $formtype = new \Ediligence\EdiligenceBundle\Form\DepartType();
                break;
            default :///Arrivée
                $formtype = new \Ediligence\EdiligenceBundle\Form\ArriveeType();
                break;
        }
        $form = $this->createForm($formtype, $entity, array(
            'action' => $this->generateUrl('courrier_update', array('todo' => $todo, 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        /* $form = $this->createForm(new TcourrierType(), $entity, array(
          'action' => $this->generateUrl('courrier_update', array('id' => $entity->getId())),
          'method' => 'PUT',
          )); */

        $form->add('submit', 'submit', array('label' => 'Modifier Courrier'));

        return $form;
    }

    /**
     * Edits an existing Tcourrier entity.
     *
     */
    public function updateAction(Request $request, $id, $todo = 1) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $entity->getTypecourrier()->getId());
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //MISE A JOUR DE LA DATE DE MODIF
            $entity->setDateModif(new \DateTime());
            //$entity->setNumenregistrements($this->getUser()->getAgent()->getMatricule());
            $em->persist($entity);

            $em->flush();
            $msg = "Courrier modifié avec succès";
            $this->addFlash('notice', $msg);
            return $this->redirect($this->generateUrl('courrier_emis', array('todo' => $entity->getTypecourrier()->getId())));
            /* return $this->redirect($this->generateUrl('courrier_edit', array('id' => $id))); */
        }


        return $this->render('EdiligenceBundle:Tcourrier:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tcourrier entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('courrier'));
    }

    /**
     * Creates a form to delete a Tcourrier entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('courrier_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function imputAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $matriculeImput = $this->getUser()->getAgent();
        //verifier l'existence du courrier
        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            $msg = "Erreur imputation";
            $this->addFlash('error', $msg);
        } else {
            $fonctionimputation = $this->imputation_arrivee($entity, $id);
            if ($entity->getTypecourrier()->getId() == 1) {
                $vue = 'dge/imput.html.twig';
            } elseif ($entity->getTypecourrier()->getId() == 2) {
                $vue = 'dge/imputdiligence.html.twig';
            }

            //soumission du formulaire
            if ($request->isMethod('POST') && $entity->getEtatcourrier() == 0) {
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
                if ($txt_delais == null && !$txt_delais) {
                    $err = 1;
                } else {
                    $txt_delais = $this->get('ediligence.fonctiondebase')->getWorkDays($txt_delais);
                    $interval = $entity->getDateCreat()->diff($txt_delais);
                    if ((int) $interval->format('%R%a days') < 0) {
                        $err = 1;
                    }/* else{
                      $err = 1;
                      } */ elseif ($tab_dir == null) {
                        $err = 1;
                    } /* else {
                      $err = 0;
                      $nbrepers = count($tab_dir);
                      } */ elseif ($tab_inst == null) {
                        $err = 1;
                    } /* else {
                      $err = 0;
                      } */ elseif ($txt_delais == null) {
                        $err = 1;
                    } else {
                        $err = 0;
                        $nbrepers = count($tab_dir);
                    }
                }



                //$txt_delais = $request->request->get('txt_delais');
                $txtInstr = $request->request->get('txtInstr');
                //dump($txt_delais);dump($request->request->get('txt_delais'));




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
                        $coordinateur = 'DC0013';
                        $rep_cood = 1;
                    } //dga1
                } else {
                    $coordinateur = $coordinateur;
                }

                if ($err == 0) {
                    //verifier que le courrier n'a pas fais objet d'imputation
                    $imputation = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('courrier' => $id, 'matriculeImput' => $this->getUser()->getAgent()->getMatricule()));
                    //var_dump($imputation);var_dump($id);var_dump($this->getUser()->getAgent()->getMatricule());
                    if (!$imputation) {
                        $imputation = new Timputations();
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
                        $imputation->setCourrier($entity);

                        $entity->setEtatcourrier(1);
                        $em->persist($imputation);
                        $em->persist($entity);
                        $imp = 1;
                        //timput_dir
                        for ($n = 0; $n < $nbrepers; $n++) {
                            //trouver le superieur de la direction
                            $impute_matricule = $em->getRepository('AgentBundle:Agent')->find_sup($tab_dir[$n]);
                            // dump($impute_matricule);die;
                            $imputdir = new TimputDir();
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
                                    $imputInstruction = new TimputInstruction();
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

                        if ($rep_cood == 1) {
                            //$matriculeImput=$this->getUser()->getAgent()->getMatricule();
                            $matriculeImput = $em->getRepository('AgentBundle:Agent')->findBy(array('matricule' => $this->getUser()->getAgent()->getMatricule()));
                            $matricule_cord = $em->getRepository('AgentBundle:Agent')->findBy(array('code_dc' => 'DC0013'));
                            //timput_dir
                            $imputdir1 = new TimputDir();
                            $imputdir1->setImputation($imputation);
                            $imputdir1->setServiceImput('DC0013');
                            $imputdir1->setImputMatricule($matriculeImput[0]->getMatricule());
                            $imputdir1->setEtatImputDir(0);
                            $imputdir1->setMatriculeimpute($matricule_cord[0]);
                            /* if ($impute_matricule != null) {
                              $imputdir1->setMatriculeimpute($matricule_cord[0]);
                              } else {
                              $imputdir1->setMatriculeimpute('');
                              } */
                            $em->persist($imputdir1);

                            //timput_instruction
                            $instruc_cle1 = $em->getRepository('EdiligenceBundle:Tinstruction')->findOneBy(array('id' => 15));
                            $imputInstruction1 = new TimputInstruction();
                            $imputInstruction1->setIdImputDir('DC0013');
                            $imputInstruction1->setEtatInst(0);
                            $imputInstruction1->setImputation($imputation);
                            $imputInstruction1->setImputMatricule($matriculeImput[0]);
                            $imputInstruction1->setInstImput($instruc_cle1);
                            $em->persist($imputInstruction1);
                        }

                        if ($imp == 1 && $dir == 1 && $inst == 1) {
                            $em->flush();
                            if ($entity->getTypecourrier()->getId() == 1) {
                                /* begin notification  */
                                for ($x = 0; $x < $nbrepers; $x++) {
                                    //trouver le superieur de la direction
                                    $impute_matricule = $em->getRepository('AgentBundle:Agent')->find_sup($tab_dir[$x]);
                                    if ($impute_matricule != null) {
                                        $this->get('ediligence.board')->addNotification($this->getDoctrine()->getManager(), $impute_matricule[0], '<b>Nouvelle Diligence</b><br>' . $matriculeImput, 'EdiligenceBundle:Timputations', $imputation->getId(), 'courrier_cstraiter');
                                    }
                                }
                                $this->get('ediligence.board')->disableNotification($this->getDoctrine()->getManager(), $matriculeImput, 'EdiligenceBundle:Tcourrier', $imputation->getCourrier()->getId());
                            }
                            /* end notification  */

                            $msg = "Courrier imputé avec succès";
                            $this->addFlash('notice', $msg);
                            return $this->redirect($this->generateUrl('courrier_dge'));
                        } else {
                            $msg = "Erreur imputation 1";
                            $this->addFlash('error', $msg);
                        }
                    } else {
                        $msg = "Erreur imputation 2";
                        $this->addFlash('error', $msg);
                    }
                } else {
                    $msg = "Erreur imputation 3";
                    $this->addFlash('error', $msg);
                }
            }

            return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $fonctionimputation);
        }
    }

    public function emisAction($todo) {
        $em = $this->getDoctrine()->getManager();

        switch ($todo) {
            case 1: $vue = 'index.html.twig';
                break;
            case 2: $vue = 'diligence.html.twig';
                break;
            case 3: $vue = 'depart.html.twig';
                break;
            default:$vue = 'index.html.twig';
                break;
        }
        $service_imput = $this->getUser()->getAgent()->retour_service();
        $matriculeImput = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->allfind($todo, $service_imput['service']);
        //$timputdir = $em->getRepository('EdiligenceBundle:TimputDir')->finddest($matriculeImput);
        //, 'timputdir'=>$timputdir
        $dir_service = $em->getRepository('AgentBundle:Direction')->tserviceListe();
        $tservice = null;
        foreach ($dir_service as $value_service) {
            $tservice[$value_service['code_dc']] = $value_service['sigle'];
        }

        //$apercu = $this->get('ediligence.board')->apercu('/images/document/test2.docx');
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'tservice' => $tservice));
    }

    public function dgeAction($todo) {

        $matriculeImput = $this->getUser()->getAgent();
        $fonction = $this->getUser()->getAgent()->getFonction()->getId();
        $service_imput = $this->getUser()->getAgent()->retour_service();
        $em = $this->getDoctrine()->getManager();
        switch ($todo) {
            case 1: $vue = 'dge/index.html.twig';
                break;
            case 2: $vue = 'dge/listediligence.html.twig';
                break;
            default:$vue = 'dge/index.html.twig';
                break;
        }
        if (in_array($fonction, array(10, 9))) {
            if ($fonction == 10) {
                $array = array('etatcourrier' => 0, 'typecourrier' => $todo, 'servicesaisi' => 'DC0018');
            } else {
                if (in_array('ROLE_DGE', $this->getUser()->getRoles())) {
                    $array = array('etatcourrier' => 0, 'typecourrier' => $todo, 'servicesaisi' => 'DC0018');
                } else {
                    $array = array('etatcourrier' => 0, 'typecourrier' => $todo, 'servicesaisi' => $service_imput['service']);
                }
            }
        } else {
            $array = array('etatcourrier' => 0, 'typecourrier' => $todo, 'servicesaisi' => $service_imput['service']);
        }

        $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy($array, array('id' => 'Desc'));

        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities));
    }

    public function dgedelAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EdiligenceBundle:Timputations')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        } else {
            //delete the rows in the table timputations
            $imputdirs = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $id));
            $imputinstructions = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $id));

            $courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($entity->getCourrier()->getId());
            $courrier->setEtatcourrier(0);
            $em->persist($courrier);

            foreach ($imputdirs as $imputdir) {
                $em->remove($imputdir);
            }

            foreach ($imputinstructions as $imputinstruction) {
                $em->remove($imputinstruction);
            }

            $em->remove($entity);

            $em->flush();
            /* begin desactivation notification */
            $this->get('ediligence.board')->addNotification($this->getDoctrine()->getManager(), $courrier->getDestCour(), '<b>Nouveau Courrier</b><br>' . $courrier->getSourceCour(), 'EdiligenceBundle:Tcourrier', $courrier->getId(), 'courrier_imput');
            $this->get('ediligence.board')->disableNotification($this->getDoctrine()->getManager(), null, 'EdiligenceBundle:Timputations', $id);
            /* begin desactivation notification */
            $msg = "Diligence supprimée avec succès";
            $this->addFlash('notice', $msg);

            return $this->redirect($this->generateUrl('courrier_suivi'));
        }
    }

    public function suiviAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'dge/suivi.html.twig';
        $service_imput = $this->getUser()->getAgent()->retour_service();
        $matricule = $this->getUser()->getAgent()->getMatricule();
        $jauge = null;
        //$entity = $em->getRepository('EdiligenceBundle:Timputations')->imput($service_imput['service'], $matricule);
        $entity = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_imput['service'], $matricule, $this->getUser());
        //dump($entity);die;
        $tab_dir = '';

        foreach ($entity as $entits) {
            if ($entits[0] != null) {
                $jauges = $em->getRepository('EdiligenceBundle:Timputations')->jauge($entits[0]->getDateImput(), $entits[0]->getDelaiImput(), new \DateTime());
                $jauge[$entits['id']] = $jauges;
                $tab_dir .= $entits[0]->getId() . ',';
            }
        }
        //dump($jauge); die();
        $tab_dir = substr($tab_dir, 0, (strlen($tab_dir) - 1));

        $entity1 = $em->getRepository('EdiligenceBundle:TimputDir')->service_dest($tab_dir);

        // $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier'=>1)); 'entities' => $entities,
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entity' => $entity, 'entity1' => $entity1, 'jauge' => $jauge));
    }

    public function intAction() {
        //var_dump($this->getUser()->getAgent()->getMatricule());
        $em = $this->getDoctrine()->getManager();
        $vue = 'sce_interne/index.html.twig';
        //$service_sup = $this->getUser()->getAgent()->findservice();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        //var_dump($this->getUser()->getAgent()->retour_service()); var_dump($service_sup['abrv']);die;
        $jauge = null;
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->reception($service_sup); //$this->getUser()->getAgent()->getMatricule()
        foreach ($entities as $entits) {
            $jauges = $em->getRepository('EdiligenceBundle:Timputations')->jauge($entits->getDateImput(), $entits->getDelaiImput(), new \DateTime());
            $jauge[$entits->getId()] = $jauges;
        }
        //var_dump($this->getUser()->getAgent()->retour_service());
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'jauge' => $jauge));
    }

    public function csrecuAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'cs_recu/index.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $jauge = null;

        $entities = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matuser);

        foreach ($entities as $entits) {
            $jauges = $em->getRepository('EdiligenceBundle:Timputations')->jauge($entits[0]->getDateImput(), $entits[0]->getDelaiImput(), new \DateTime());
            $jauge[$entits[0]->getId()] = $jauges;
        }
        //$entities = $em->getRepository('EdiligenceBundle:Timputations')->cs_traiter($service_sup);
        //dump($entities);die;
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'jauge' => $jauge));
    }

    public function cstraiterAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->findBy(array('id' => $id));

        if ($entities) {
            /*
              switch (strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase())) {
              case 'ROLE_DGE': {
              if (strcmp($entities[0]->getCoordinateur(), $service_sup['service']) == 0) { $coordinateur = 1; } else {$coordinateur = 0;}
              $instruction = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $entities, 'idImputDir' => $service_sup['service']));
              $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $entities, 'serviceImput' => $service_sup['service']));
              }break;
              default: {
              $instruction = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $entities, 'idImputDir' => $this->getUser()->getAgent()->getMatricule()));
              $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $entities, 'serviceImput' => $this->getUser()->getAgent()->getMatricule()));
              $coordinateur=1;
              }
              } */

            if (strcmp($entities[0]->getCoordinateur(), $service_sup['service']) == 0) {
                $coordinateur = 1;
            } elseif (strcmp($entities[0]->getCoordinateur(), $matuser) == 0) {
                $coordinateur = 1;
            } else {
                $coordinateur = 0;
            }

            //$instruction = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $entities, 'idImputDir' => $service_sup['service']));
            //$imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $entities, 'serviceImput' => $service_sup['service']));
            $instruction = $em->getRepository('EdiligenceBundle:TimputInstruction')->find_inst($entities[0]->getId(), $service_sup['service'], $matuser);
            $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->find_imputdir($service_sup['service'], $matuser, $entities[0]->getId());
            //dump($entities[0]->getId());dump($imputdir);die; 
            //find the name of the coordinateur
            $name_coord = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $entities, 'serviceImput' => $entities[0]->getCoordinateur()));
            //return the directions of the imputation
            //$direction = $em->getRepository('EdiligenceBundle:TimputDir')->dir_imput($id, $service_sup['service']); 
            $rejettrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array('imputdir' => $name_coord[0]->getId()));
//dump($name_coord);dump($rejettrt);die;
            $vue = 'cs_recu/traiter.html.twig';
            $array = array('id' => $id, 'entities' => $entities, 'instruction' => $instruction, 'imputdir' => $imputdir, 'coord' => $coordinateur, 'NbrePers' => $entities[0]->getNbrePers(), 'idimputdir' => $imputdir[0]->getId(), 'rejet' => $rejettrt); //, 'dir'=>$direction

            if ($request->request->get('imputer') == 'imputer') {

                $inst_all = $em->getRepository('EdiligenceBundle:Tinstruction')->findAll();
                $vue = 'cs_recu/cs_imputer.html.twig';

                switch ($service_sup['abrv']) {
                    case 'DG':
                        $dir_imput = $em->getRepository('AgentBundle:Agent')->findBy(array('code_dg' => $service_sup['service']));
                        break;
                    case 'DC':
                        $dir_imput = $em->getRepository('AgentBundle:Agent')->findBy(array('code_dc' => $service_sup['service']));
                        break;
                    case 'SD':
                        $dir_imput = $em->getRepository('AgentBundle:Agent')->findBy(array('code_sd' => $service_sup['service']));
                        break;
                    case 'SC':
                        $dir_imput = $em->getRepository('AgentBundle:Agent')->findBy(array('code_sc' => $service_sup['service']));
                        break;
                }

                $array = array('id' => $id, 'entities' => $entities, 'instruction' => $instruction, 'imputdir' => $imputdir,
                    'all_inst' => $inst_all, 'agent_srv' => $dir_imput);
            }

            if ($request->request->get('traiter') == 'traiter') {
                //  if(!empty($request->request->get('imputdir'))){$dir_imput= implode(',',$request->request->get('imputdir'));} else {$dir_imput = null;}
                //nbre de traitement pour ce courrier et pour ce chef de service
                $traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->max_traitement($entities[0]->getCourrier()->getId(), $id);
                $vue = 'cs_recu/cs_traiter.html.twig';

                if ($traitement['max_enreg'] != null || $traitement['max_enreg'] == 0) {
                    $trt = $traitement['max_enreg'] + 1;
                } else {
                    $trt = 1;
                }

                $task = new Tmp_traitement();
                $form = $this->createFormBuilder($task)
                        ->add('libtraitement', TextareaType::class, array('attr' => array('class' => 'textarea-editor', 'rows' => '5')))
                        ->add('pjtraitement', new PjRType(), ['required' => true])
                        ->setAction($this->generateUrl('courrier_cstraiter', array('id' => $id)))
                        ->setMethod('POST')
                        ->getForm();

                $array = array('id' => $id, 'entities' => $entities, 'instruction' => $instruction, 'imputdir' => $imputdir, 'traitement' => $trt, 'coord' => $coordinateur, 'form' => $form->createView(), 'NbrePers' => $entities[0]->getNbrePers(), 'name_coord' => $name_coord); //, 'dirimput'=>$dir_imput
                $form->handleRequest($request);

                if ($form->isValid() && $request->isMethod('POST')) {
                    $nbrediligence = 0;
                    $cle_imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findOneBy(array('id' => $request->request->get('imputdir')));
                    $cle_imput = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('id' => $request->request->get('id_imput')));
                    $diligence = $em->getRepository('EdiligenceBundle:TimputDir')->findOneBy(array('id' => $request->request->get('id_imput'), 'etatImputDir' => '0'));
                    $nbrediligence = count($diligence);
                    //dump($request->request); die;

                    if ($request->request->get('nbrePers') == 1 && $request->request->get('coord') == 1) {
                        //enregistrement dans tmp_traitement
                        $task->setDatetraitement(new \DateTime());
                        $task->setLibtraitement($request->request->get('form')['libtraitement']);
                        $task->setTxttraitement($request->request->get('form')['libtraitement']);
                        $task->setEtattraitement(0);
                        $task->setNumtraitement($trt);
                        $task->setMatriculeimpute($this->getUser()->getAgent()->getMatricule());
                        $task->setMatriculeimputeur($entities[0]->getMatriculeImput()->getMatricule());
                        $task->setCodecourrier($request->request->get('id_courrier'));
                        $task->setIdImput($cle_imput->getId());
                        $task->setEtataff(1);
                        $task->setImputdir($cle_imputdir);
                        $task->setDesactive(1);
                        $em->persist($task);

                        //si est directeur, chef de service rattache
                        //verifier le nbre imputation de la diligence
                        //if(in_array($this->getUser()->getAgent()->getFonction()->getId(), array(5,7,8,9,10)))
                        if ($nbrediligence == 1) {
                            //enregistrement dans ttraitement
                            $task1 = new Ttraitement();
                            $task1->setDatetraitement(new \DateTime());
                            $task1->setLibtraitement($task->getLibtraitement());
                            $task1->setTxttraitement($task->getTxttraitement());
                            $task1->setEtattraitement(0);
                            $task1->setNumtraitement($task->getNumtraitement());
                            $task1->setMatriculeimpute($task->getMatriculeimpute());
                            $task1->setMatriculeimputeur($task->getMatriculeimputeur());
                            $task1->setCodecourrier($task->getCodecourrier());
                            $task1->setIdImput($cle_imput->getId());
                            $task1->setPjtraitement($task->getPjtraitement());
                            $task1->setEtataff(1);

                            $em->persist($task1);

                            $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($request->request->get('id_courrier'));
                            $update_courrier->setEtataff(1);
                            $em->persist($update_courrier);
                        }

                        $update_imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($request->request->get('id_imput'));
                        $update_imputation->setEtatTrait(1);
                        $em->persist($update_imputation);
                        //Desactive l'ancienne imputation dans imputdir
                        $cle_imputdir->setDesactive(1);
                        $cle_imputdir->setEtatImputDir(1);
                        $em->persist($cle_imputdir);

                        $em->flush();

                        $msg = "Diligence transmise avec succès";
                        $this->addFlash('notice', $msg);
                        return $this->redirect($this->generateUrl('courrier_csrecu'));
                    } else {

                        $count = $em->getRepository('EdiligenceBundle:Tmp_traitement')->max_traitements($entities[0]->getCourrier()->getId(), $id, $request->request->get('imputdir'));
                        if ($count['max_enreg'] != null || $count['max_enreg'] == 0) {
                            $counts = 0;
                        } else {
                            $counts = $count['max_enreg'];
                        }
                        //enregistrement dans tmp_traitement
                        $task->setDatetraitement(new \DateTime());
                        $task->setLibtraitement($request->request->get('form')['libtraitement']);
                        $task->setTxttraitement($request->request->get('form')['libtraitement']);
                        $task->setEtattraitement(1);
                        $task->setNumtraitement($trt);
                        $task->setMatriculeimpute($this->getUser()->getAgent()->getMatricule());
                        $task->setMatriculeimputeur($entities[0]->getMatriculeImput()->getMatricule());
                        $task->setCodecourrier($request->request->get('id_courrier'));
                        $task->setIdImput($cle_imput->getId());
                        $task->setEtataff(1);
                        $task->setImputdir($cle_imputdir);
                        $task->setDesactive(1);

                        $em->persist($task);

                        if ($counts == $request->request->get('nbrePers')) {
                            $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($request->request->get('id_courrier'));
                            $update_courrier->setEtataff(1);
                            $em->persist($update_courrier);

                            $update_imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($request->request->get('id_imput'));
                            $update_imputation->setEtatTrait(1);
                            $em->persist($update_imputation);
                        }

                        //Desactive l'ancienne imputation dans imputdir
                        $cle_imputdir->setDesactive(1);
                        $cle_imputdir->setEtatImputDir(1);
                        $em->persist($cle_imputdir);

                        $em->flush();

                        $msg = "Diligence transmise avec succès";
                        $this->addFlash('notice', $msg);
                        return $this->redirect($this->generateUrl('courrier_csrecu'));
                    }
                    die;
                }
            }
        }

        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
    }

    public function diligtrtAction() {
        $em = $this->getDoctrine()->getManager();
        $role = strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase());
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        //$entities = $em->getRepository('EdiligenceBundle:Ttraitement')->diligence_traite();
        $entities = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matuser, $service_sup['service'], $role);
        $vue = 'dge/diligence.html.twig';
        $array = array('entities' => $entities);



        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);

        /*
          $i=0;$tab_imput='';$tab_trt='';$agent=array();$piecejointe=array();$imputdir='';

          foreach($entities as $commun){dump($commun);
          $agent[]=array('imputation'=>$commun[$i]->getIdImput(),
          'coordinateur'=>$commun['nom'].' '.$commun['prenoms'].' '.$commun['nomJeuneFille'],
          'contenu'=>$commun['objet'],
          'datetraitement'=>$commun[$i]->getDatetraitement(),
          'idtraitement'=>$commun[$i]->getId()
          );

          $piecejointe[]=array('imputation'=>$commun[$i]->getIdImput(),'telecharger'=>$commun[$i]->getPjtraitement());
          $tab_imput.=$commun[$i]->getIdImput().',';
          $tab_trt.=$commun[$i]->getId().',';
          //$i++;
          }

          if(!empty($tab_imput))
          {
          $tab_imput = substr($tab_imput,0, (strlen($tab_imput)-1));
          $tab_trt = substr($tab_trt,0, (strlen($tab_trt)-1));
          $imputdir = $em->getRepository('EdiligenceBundle:TimputDir')->diligence($tab_imput, $tab_trt);
          }

          if($role=='ROLE_DGE'){
          $vue = 'dge/diligence.html.twig';
          }else{
          $vue = 'dge/diligence.html.twig';
          }

          return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('agent' => $agent, 'piecejointee' => $piecejointe, 'imputdir' => $imputdir));
         */
    }

    public function regAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'sce_interne/reg.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $agent = $this->getUser()->getAgent()->getMatricule();
        $entities = $em->getRepository('EdiligenceBundle:Treception')->registre($service_sup['service'], $agent);
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities));
    }

    public function archiveAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $entity = $em->getRepository('EdiligenceBundle:Ttraitement')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        }

        $archive = new Tarchive();
        $form = $this->createForm(new TarchiveType(), $archive, array(
            'action' => $this->generateUrl('courrier_archive', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($request->request->get('traiter') == 'renvoyer') {
                $obsr = $request->request->get('ediligence_ediligencebundle_Tarchive')['obsrv'];

                $traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->find($id);
                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Tcourrier entity.');
                } else {
                    if ($obsr == null or $obsr == '') {
                        $ob = 0;
                        $librejet = null;
                    } else {
                        $ob = 1;
                        $librejet = $obsr;
                    }
                    if (!$archive->getNomFichier()) {
                        $fil = 0;
                        $pj = $traitement->getPjtraitement();
                    } else {
                        $fil = 1;
                        $pj = $archive->getNomFichier();
                    }

                    //modifier traitement
                    $traitement->setModif(1);
                    $traitement->setDaterejet(new \DateTime());
                    $traitement->setMatriculecord($this->getUser()->getAgent()->getMatricule());
                    $traitement->setLibrejet($librejet);
                    $traitement->setPjrejet($pj);
                    $em->persist($traitement);

                    $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($traitement->getCodecourrier());
                    $update_courrier->setEtataff(0);
                    $em->persist($update_courrier);

                    $update_imputation = $em->getRepository('EdiligenceBundle:Timputations')->find($traitement->getIdImput());
                    $update_imputation->setEtatTrait(0);
                    $em->persist($update_imputation);

                    $em->flush();
                    $msg = "Diligence renvoyée avec succès";
                    $this->addFlash('notice', $msg);
                    //modifier tmp_traitement
                }
            } elseif ($request->request->get('traiter') == 'traiter') {
                if ($request->request->get('ediligence_ediligencebundle_Tarchive')['obsrv'] == null or $request->request->get('ediligence_ediligencebundle_Tarchive')['obsrv'] == '') {
                    $msg = "Erreur validation";
                    $this->addFlash('error', $msg);
                    return $this->redirect($this->generateUrl('courrier_archive', array('id' => $id)));
                } else {
                    $update_traitement = $em->getRepository('EdiligenceBundle:Ttraitement')->find($entity->getId());
                    if (!$update_traitement) {
                        $msg = "Erreur validation";
                        $this->addFlash('error', $msg);
                        return $this->redirect($this->generateUrl('courrier_archive', array('id' => $id)));
                    } else {
                        if (!$archive->getNomFichier()) {
                            $archive->setNomFichier($update_traitement->getPjtraitement());
                        }
                        //$request->request->get('ediligence_ediligencebundle_Tarchive')['obsrv']
                        //Enregistrement dans la table archive
                        $archive->setDateArchive(new \DateTime());
                        $archive->setMatriculeArchiveur($this->getUser()->getAgent()->getMatricule());
                        $archive->setNumtraitement($entity->getNumtraitement());
                        $archive->setServiceArchive($service_sup['service']);
                        $archive->setCodecourrier($entity->getCodecourrier());
                        $archive->setTraitements($entity);
                        $em->persist($archive);
                        //desactivation du traitement et du courrier
                        $update_traitement->setEtattraitement(1);
                        $em->persist($update_traitement);

                        $update_tmptraitements = $em->getRepository('EdiligenceBundle:Tmp_traitement')->findBy(array('codecourrier' => $entity->getCodecourrier()));
                        foreach ($update_tmptraitements as $update_tmptraitement) {
                            $update_tmptraitement->setEtattraitement(1);
                            $em->persist($update_tmptraitement);
                        }

                        $update_courrier = $em->getRepository('EdiligenceBundle:Tcourrier')->find($entity->getCodecourrier());
                        $update_courrier->setEtataff(1);
                        $em->persist($update_courrier);

                        $em->flush();
                        $msg = "Diligence archivée avec succès";
                        $this->addFlash('notice', $msg);
                        return $this->redirect($this->generateUrl('courrier_diligtrt'));
                    }
                }
            }
        }
        // $form->add('submit', 'submit', array('attr' => array('class' => 'btn btn-sm btn-primary'), 'label' => 'Archiver Diligence'));
        // return $form;

        $vue = 'dge/archive.html.twig';

        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('form' => $form->createView()));
    }

    public function csimputAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $entities = $em->getRepository('EdiligenceBundle:Timputations')->findBy(array('id' => $id));

        if ($request->getMethod() == 'POST' && $entities && $request->request->get('ok') == 'ok') {
            //recuperer les elements du formulaire
            $err = 0;
            $nbrepers = 0;
            $imp = 0;
            $dir = 0;
            $up = 0;
            $inst = 0;
            $rep_cood = 0;
            $tab_dir = $request->request->get('DestHide');
            $tab_inst = $request->request->get('In');
            $coordinateur = $request->request->get('lstcoordon');
            $priorite = $request->request->get('priorite');
            $txtInstr = $request->request->get('txtInstr');

            $txt_delais = (\DateTime::createFromFormat('d/m/Y', $request->request->get('txt_delais')));
            if ($txt_delais == null && !$txt_delais) {
                $err = 1;
            } else {
                $txt_delais = $this->get('ediligence.fonctiondebase')->getWorkDays($txt_delais);
                if ($tab_dir == null) {
                    $err = 1;
                } else {
                    $err = 0;
                    $nbrepers = count($tab_dir);
                }
                if ($tab_inst == null) {
                    $err = 1;
                } else {
                    $err = 0;
                }
                if ($txt_delais == null) {
                    $err = 1;
                } else {
                    $err = 0;
                }
                if (($txtInstr != null)) {
                    $txtInstr = $txtInstr;
                } else {
                    $txtInstr = '';
                }
                if (strlen($coordinateur) == 24 || empty($coordinateur)) {
                    $err = 1;
                } else {
                    $err = 0;
                }
                //$interval = $entity->getDateCreat()->diff($txt_delais);
            }




            if ($err == 1) {
                $msg = "Erreur imputation";
                $this->addFlash('error', $msg);
                return $this->redirect($this->generateUrl('courrier_cstraiter', array('id' => $id)));
            } elseif ($err == 0) {
                //verifier que le courrier n'a pas fais objet d'imputation
                $imputation = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('courrier' => $entities[0]->getCourrier()->getId(), 'matriculeImput' => $this->getUser()->getAgent()->getMatricule()));
                $matriculeImput = $this->getUser()->getAgent();
                //dump($imputation);dump($entities[0]->getCourrier()->getId()); dump($this->getUser()->getAgent()->getMatricule());die;
                if ($imputation) {
                    $msg = "Erreur imputation";
                    $this->addFlash('error', $msg);
                    return $this->redirect($this->generateUrl('courrier_cstraiter', array('id' => $id)));
                } else {
                    //le nbre imputations du courrier
                    $nbrecourrier = $em->getRepository('EdiligenceBundle:Timputations')->findBy(array('courrier' => $entities[0]->getCourrier()->getId()));

                    if ($nbrecourrier) {
                        $indice = count($nbrecourrier) - 1;
                    } else {
                        $indice = 0;
                    }
                    $imputations = new Timputations();
                    //2 remplir les objets
                    $imputations->setDateImput(new \DateTime());
                    $imputations->setMatriculeImput($matriculeImput);
                    $imputations->setServiceImput($this->getUser()->getAgent()->retour_service()['service']);
                    $imputations->setPrioriteImput($priorite);
                    $imputations->setDelaiImput($txt_delais);
                    $imputations->setCoordinateur($coordinateur);
                    $imputations->setInstPart($txtInstr);
                    $imputations->setEtatImput(count($nbrecourrier));
                    $imputations->setEtatTrait(0);
                    $imputations->setNbrePers($nbrepers);
                    $imputations->setCourrier($entities[0]->getCourrier());

                    $em->persist($imputations);
                    $imp = 1;
                    //timput_dir
                    for ($n = 0; $n < $nbrepers; $n++) {
                        //trouver le superieur de la direction
                        $impute_matricule = $em->getRepository('AgentBundle:Agent')->findOneBy(array('matricule' => $tab_dir[$n]));

                        //$tab_fonction[]=$impute_matricule->getFonction()->getId();
                        if (in_array($impute_matricule->getFonction()->getId(), array(3, 4, 5, 6, 7, 8, 9, 10))) {
                            $oui = 1;
                        } else {
                            $oui = 0;
                        }
                        if (in_array($impute_matricule->getFonction()->getId(), array(1, 2))) {
                            $oui = 1;
                        } else {
                            $oui = 0;
                        }

                        $imputdir = new TimputDir();
                        $imputdir->setImputation($imputations);
                        $imputdir->setServiceImput($tab_dir[$n]);
                        $imputdir->setImputMatricule($matriculeImput);
                        $imputdir->setEtatImputDir(count($nbrecourrier));
                        $imputdir->setMatriculeimpute($impute_matricule);

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
                                $imputInstruction = new TimputInstruction();
                                $imputInstruction->setIdImputDir($dinn);
                                $imputInstruction->setEtatInst(count($nbrecourrier));
                                $imputInstruction->setImputation($imputations);
                                $imputInstruction->setImputMatricule($matriculeImput);
                                $imputInstruction->setInstImput($instruc_cle);
                                $em->persist($imputInstruction);
                                $inst = 1;
                            }
                        }
                    }

                    //mise a jour de imputdir
                    $service_sup = $this->getUser()->getAgent()->retour_service();
                    $matuser = $this->getUser()->getAgent()->getMatricule();
                    /*
                      switch (strtoupper($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase())) {
                      case 'ROLE_DGE': { $update_timputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('matriculeimpute'=>$this->getUser()->getAgent()->getMatricule(), 'serviceImput'=>$service_sup['service'], 'imputation'=>$nbrecourrier[$indice]->getId()));}break;
                      default: {$update_timputdir = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('matriculeimpute'=>$this->getUser()->getAgent()->getMatricule(), 'serviceImput'=>$this->getUser()->getAgent()->getMatricule(), 'imputation'=>$nbrecourrier[$indice]->getId()));}
                      }
                     */
                    //dump($id);dump($nbrecourrier);dump($nbrecourrier[$indice]->getId());die;$nbrecourrier[$indice]->getId(), 
                    $update_timputdir = $em->getRepository('EdiligenceBundle:TimputDir')->find_imputdir($service_sup['service'], $matuser, $entities[0]->getId());
                    //dump($update_timputdir);die;
                    if ($update_timputdir) {
                        $update_timputdir = $update_timputdir[0];
                        $update_timputdir->setEtatImputDir(1);
                        $update_timputdir->setDesactive(1);
                        $em->persist($update_timputdir);
                        $up = 1;
                    }
                    //dump($imp); dump($dir );dump($inst); dump($up);dump($oui) ; die;           
                    //dump($update_timputdir); dump($this->getUser()->getAgent()->getMatricule()); dump($service_sup['service']); dump($nbrecourrier[0]->getId());die; 
                    if ($imp == 1 && $dir == 1 && $inst == 1 && $up == 1) {  //&& $oui == 0
                        $em->flush();
                        /* begin notification  */
                        for ($x = 0; $x < $nbrepers; $x++) {
                            //trouver le superieur de la direction
                            $impute_matricule = $em->getRepository('AgentBundle:Agent')->find_sup($tab_dir[$x]);
                            if ($impute_matricule != null) {
                                $this->get('ediligence.board')->addNotification($this->getDoctrine()->getManager(), $impute_matricule[0], '<b>Nouvelle Diligence</b><br>' . $matriculeImput, 'EdiligenceBundle:Timputations', $imputations->getId(), 'courrier_cstraiter');
                            }
                        }
                        $this->get('ediligence.board')->disableNotification($this->getDoctrine()->getManager(), $matriculeImput, 'EdiligenceBundle:Timputations', $id);

                        /* end notification  */

                        $msg = "Courrier imputé avec succès";
                        $this->addFlash('notice', $msg);
                        return $this->redirect($this->generateUrl('courrier_csrecu'));
                    } else {
                        /*
                          dump($imp);dump($dir);dump($inst);dump($up); die;
                         */
                        $msg = "Erreur imputation";
                        $this->addFlash('error', $msg);
                        return $this->redirect($this->generateUrl('courrier_cstraiter', array('id' => $id)));
                    }
                }
            }
        }
    }

    public function interne_imputAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $matriculeImput = $this->getUser()->getAgent();
        //verifier l'existence du courrier
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);
        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            $msg = "Erreur imputation";
            $this->addFlash('error', $msg);
            return $this->redirect($this->generateUrl('courrier_new', array('todo' => $entity->getTypecourrier()->getId())));
        } else {
            if ($this->getUser()->hasRole('ROLE_DGE')) {
                $fonctionimputation = $this->imputation_arrivee($entities, $id);
                $vue = 'cs_recu/imputdge.html.twig';
                $array = $fonctionimputation;
            } else {
                $vue = 'cs_recu/imput.html.twig';
                $inst_all = $em->getRepository('EdiligenceBundle:Tinstruction')->findinstruction();
                $dir_imput = $em->getRepository('AgentBundle:Agent')->getlistepersonnel($service_sup['abrv'], $service_sup['service']);
                $array = array('id' => $id, 'entities' => $entities, 'all_inst' => $inst_all, 'agent_srv' => $dir_imput);
            }

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

                if ($txt_delais == null && !$txt_delais) {
                    $err = 1;
                } else {
                    $txt_delais = $this->get('ediligence.fonctiondebase')->getWorkDays($txt_delais);
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
                    $imputation = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('courrier' => $id, 'matriculeImput' => $this->getUser()->getAgent()->getMatricule()));

                    if (!$imputation) {
                        $imputation = new Timputations();
                        //2 remplir les objets
                        $imputation->setDateImput(new \DateTime());
                        $imputation->setMatriculeImput($matriculeImput);
                        $imputation->setServiceImput($this->getUser()->getAgent()->retour_service()['service']);
                        $imputation->setPrioriteImput($priorite);
                        $imputation->setDelaiImput($txt_delais);
                        $imputation->setCoordinateur($coordinateur);
                        $imputation->setInstPart($txtInstr);
                        $imputation->setEtatImput(1);
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
                            $imputdir = new TimputDir();
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
                                    $imputInstruction = new TimputInstruction();
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
                            return $this->redirect($this->generateUrl('courrier_new', array('todo' => $entities->getTypecourrier()->getId())));
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


            return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
        }
    }

    public function imput_delAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        } else {
            $imputations = $em->getRepository('EdiligenceBundle:Timputations')->findOneBy(array('courrier' => $id, 'serviceImput' => $service_sup['service'], 'matriculeImput' => $matuser));
            if (!$imputations) {
                throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            } else {
                //delete the rows in the table timputations
                $imputdirs = $em->getRepository('EdiligenceBundle:TimputDir')->findBy(array('imputation' => $imputations->getId()));
                $imputinstructions = $em->getRepository('EdiligenceBundle:TimputInstruction')->findBy(array('imputation' => $imputations->getId()));

                $entity->setEtatcourrier(0);
                $em->persist($entity);

                foreach ($imputdirs as $imputdir) {
                    $em->remove($imputdir);
                }

                foreach ($imputinstructions as $imputinstruction) {
                    $em->remove($imputinstruction);
                }

                $em->remove($imputations);

                $em->flush();

                $msg = "Diligence supprimée avec succès";
                $this->addFlash('notice', $msg);

                return $this->redirect($this->generateUrl('courrier_emis', array('todo' => $entity->getTypecourrier()->getId())));
            }
        }
    }

    function imputation_arrivee($objet, $id) {
        $em = $this->getDoctrine()->getManager();
        $conseiller_tech = $em->getRepository('AgentBundle:Direction')->find_sce1(8);
        $charge_etudes = $em->getRepository('AgentBundle:Direction')->find_sce1(2);
        $assistant = $em->getRepository('AgentBundle:Direction')->find_sce1(11);
        $dg_imput = $em->getRepository('AgentBundle:Direction')->find_sce();
        $dc_imput = $em->getRepository('AgentBundle:Direction')->finddirectioncentrale();
        $scerattache_imput = $em->getRepository('AgentBundle:Direction')->findserviceratache();
        $instruction = $em->getRepository('EdiligenceBundle:Tinstruction')->findinstruction();

        return array('id' => $id,
            'entity' => $objet,
            'instruction' => $instruction,
            'dg_imput' => $dg_imput,
            'dc_imput' => $dc_imput,
            'scerattache_imput' => $scerattache_imput,
            'conseiller_imput' => $conseiller_tech,
            'charge_etudes' => $charge_etudes,
            'assistant' => $assistant);
    }

    public function depart_imputAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $matriculeImput = $this->getUser()->getAgent();
        //verifier l'existence du courrier
        $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);

        if (!$entities) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
            $msg = "Erreur imputation";
            $this->addFlash('error', $msg);
            return $this->redirect($this->generateUrl('courrier_new', array('todo' => $entities->getTypecourrier()->getId())));
        } else {
            $vue = 'cs_recu/depart_imput.html.twig';
            //RECUPERER LE NIVEAU DU SERVICE DU CONNECTE
            $dc = $this->getUser()->getAgent()->getDirection();
            if ($dc) {
                $niveau = $dc->getEtatDirection();
                $dir_service = $em->getRepository('AgentBundle:Direction')->findBy(array('etatDirection' => [0, 1, 2]));

                if ($request->isMethod('POST') && $entities->getEtatcourrier() == 0 && $request->request->get('ok') == 'ok') {

                    $desthide = implode($request->request->get('Dest'), ',');
                    $entities->setDepartdest($desthide);
                    $entities->setEtatcourrier(1);
                    $entities->setEtataff(1);
                    $em->persist($entities);
                    $em->flush();
                    $msg = "Courrier Départ imputé envoyé avec succès";
                    $this->addFlash('notice', $msg);

                    return $this->redirect($this->generateUrl('courrier_new', array('todo' => $entities->getTypecourrier()->getId())));
                }

                $array = array('id' => $id, 'entities' => $entities, 'niveauservice' => $niveau, 'dirservice' => $dir_service);
                return $this->render('EdiligenceBundle:Tcourrier:' . $vue, $array);
            } else {
                return $this->redirect($this->generateUrl('courrier_new', array('todo' => $entities->getTypecourrier()->getId())));
            }
        }
    }

    public function depart_delAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        } else {
            $entity->setEtatcourrier(0);
            $entity->setEtataff(0);
            $entity->setDepartdest(null);
            $em->persist($entity);
            $em->flush();
            $msg = "Destinataires supprimé avec succès";
            $this->addFlash('notice', $msg);

            return $this->redirect($this->generateUrl('courrier_emis', array('todo' => $entity->getTypecourrier()->getId())));
        }
    }

    public function recu_departAction() {
        $em = $this->getDoctrine()->getManager();
        $vue = 'cs_recu/depart_recu.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $dir_service = $em->getRepository('AgentBundle:Direction')->tserviceListe();
        $tservice = null;
        foreach ($dir_service as $value_service) {
            $tservice[$value_service['code_dc']] = $value_service['sigle'];
        }

        $entities = $em->getRepository('EdiligenceBundle:Tcourrier')->find_depart_recu($service_sup['service']);


        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $entities, 'tservice' => $tservice));
    }

    public function recap_traitAction($id) {
        $em = $this->getDoctrine()->getManager();
        $vue = 'recap_trait.html.twig';
        $service_sup = $this->getUser()->getAgent()->retour_service();
        $matuser = $this->getUser()->getAgent()->getMatricule();
        $recap_trait = $em->getRepository('EdiligenceBundle:Tmp_traitement')->recap_trait($matuser, $id);


        //dump($recap_trait);die;
        return $this->render('EdiligenceBundle:Tcourrier:' . $vue, array('entities' => $recap_trait));
    }

    public function dgedel1Action($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EdiligenceBundle:Tcourrier')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tcourrier entity.');
        } else {
            $em->remove($entity);
            $em->flush();

            $msg = "Diligence supprimée avec succès";
            $this->addFlash('notice', $msg);

            return $this->redirect($this->generateUrl('courrier_suivi'));
        }
    }

}

<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\Mutation;
use Agent\AgentBundle\Form\MutationType;
use Agent\AgentBundle\Form\MutationDgType;
use Demandes\DemandesBundle\Controller\Demande;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Agent\AgentBundle\Form\MutationNumerisationType;
use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Form\ChangeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Agent\AgentBundle\Form\InterimType;
use Agent\AgentBundle\Entity\Interimaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Agent\AgentBundle\Entity\Saaf;

/**
 * Mutation controller.
 *
 */
class MutationController extends Controller {

    /**
     * Lists all Mutation entities.
     *
     *
      public function retour_superieur() {
      $em = $this->getDoctrine()->getManager();
      $direction = $this->getUser()->getAgent()->getDirection();
      $tab_service = $this->getUser()->getAgent()->retour_service()['tab_imput'];
      //var_dump($direction);// die;
      $superieur1 = "";
      $superieur2 = "";
      $superieur3 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 5, 'Direction' => 3]);
      /////////////Envoi de Demande Pour Un Service Rattaché //////////
      if ($direction->getEtatDirection() == 0) {
      //Responsable Ressources Humaines
      if (($this->getUser()->hasRole('ROLE_RESPO_SRHMG')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 5)) {
      //Sup 1 & 2 DG
      $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
      $superieur2 = $superieur1;
      }
      //Chef de Service Rattaché
      elseif (($this->getUser()->hasRole('ROLE_RESPO')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 5)) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
      $superieur2 = $superieur1;
      }
      //Chef de Section
      elseif (($this->getUser()->hasRole('ROLE_RESPO')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 3)) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 5,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      $superieur2 = $superieur1;
      }
      //Agent
      else {

      //Agent Dans une Section
      if (stristr($tab_service, 'SD') == TRUE) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 3,
      'code_sd' => $this->getUser()->getAgent()->getCodeSd()
      ]);
      $superieur2 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 5,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      }
      //AGent Rattaché au Chef de Service
      elseif (stristr($tab_service, 'SD') == FALSE) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 5,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      $superieur2 = $superieur1;
      }
      }
      }
      /////////////Fin Envoi de Demande Pour Un Service Rattaché //////////
      /////////////Envoi de Demande Pour Une Direction //////////
      elseif ($direction->getEtatDirection() == 1) {
      //Directeur

      if (($this->getUser()->hasRole('ROLE_RESPO')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 7)) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
      $superieur2 = $superieur1;
      }
      //Sous-Directeur
      elseif (($this->getUser()->hasRole('ROLE_RESPO')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 6)) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 7,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      $superieur2 = $superieur1;
      }
      //Chef de Service
      elseif (($this->getUser()->hasRole('ROLE_RESPO')) and ( $this->getUser()->getAgent()->getFonction()->getId() == 4)) {
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 6,
      'code_sd' => $this->getUser()->getAgent()->getCodeSd()
      ]);
      $superieur2 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 7,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      }
      //Agent
      else {

      //Agent dans un Service
      if (stristr($tab_service, 'SD') == TRUE and stristr($tab_service, 'SC') == TRUE) {
      /*
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 4,
      'code_sc' => $this->getUser()->getAgent()->getCodeSc()
      ]);
      $superieur2 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 6,
      'code_sd' => $this->getUser()->getAgent()->getCodeSd()
      ]);
      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 6,
      'code_sd' => $this->getUser()->getAgent()->getCodeSd()
      ]);
      $superieur2 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 7,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      }
      //Agent Rattaché à une sous Direction et n'appartenant pas à un Service
      //Secrétaire Sous Directeur, Chargé d'Etudes, etc.
      elseif (stristr($tab_service, 'SD') == TRUE and stristr($tab_service, 'SC') == FALSE) {

      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 6,
      'code_sd' => $this->getUser()->getAgent()->getCodeSd()
      ]);
      $superieur2 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 7,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      }
      //Agent Rattaché au Directeur: CT, Secretaire......
      elseif (stristr($tab_service, 'SD') == FALSE and stristr($tab_service, 'SC') == FALSE) {

      $superieur1 = $em->getRepository('AgentBundle:Agent')
      ->findOneBy(
      ['Fonction' => 7,
      'Direction' => $this->getUser()->getAgent()->getDirection()->getId()
      ]);
      $superieur2 = $superieur1;
      }
      }
      }
      return array(
      'sup1' => $superieur1,
      'sup2' => $superieur2,
      'sup3' => $superieur3);
      ;
      }
     */
    public function sendAction() {
        $em = $this->getDoctrine()->getManager();

        $agent = $this->getUser()->getAgent();
        $entities = $em->getRepository('AgentBundle:Mutation')->mutationSend($agent);
        //dump($this->retour_superieur($this->getUser())['sup2']); die;
        //dump($entities); die();
        //  $entiti = $em->getRepository('AgentBundle:Mutation')->demandeSendOther($agent);
        return $this->render('AgentBundle:Mutation:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function indexAction() {
        // $em = $this->getDoctrine()->getManager();
        //      $ok= new Demande();
        // dump($this->forward('DemandesBundle:Demande:retour_superieur')); die;

        $entities = $em->getRepository('AgentBundle:Mutation')->findAll();

        return $this->render('AgentBundle:Mutation:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    /**
     * Creates a new Mutation entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Mutation();
        $agent = $this->getUser()->getAgent();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);



        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $fonctionId = $this->getUser()->getAgent()->getFonction()->getId();
            $idDirection = $form->getData()->getDestination()->getId();
             $validateur = $this->get('ediligence.fonctiondebase')->returnConnect();
            //dump($fonctionId);
            //die();
             $validateur = $this->get('ediligence.fonctiondebase')->returnConnect();
            if ($fonctionId == 10 or in_array('ROLE_RESPO_SRHMG', $this->getUser()->getRoles())) {
                $agent_emmmeteur = $em->getRepository('AgentBundle:Agent')->findOneBy(['matricule' => $entity->getEmmeteur()->getMatricule()]);
                $entity->setOrigine($agent_emmmeteur->getDirection());
                $entity->setMatValidGrh($validateur);
                $entity->setMatValidSupDir($validateur);
                $entity->setMatValidDest($validateur);
                $entity->setEtatRepGrh(1);
                // $entity->setEtatMutation(0);
              
                // $entity->setdateRepGrh(new \DateTime());
                // $agent_emmmeteur->setDirection($entity->getDestination());
                // $agent_emmmeteur->setCodeDc($entity->getDestination()->getCodeDc());
                // $agent_emmmeteur->setCodeSd(null);
                // $agent_emmmeteur->setCodeSc(null);

                // //dump($agent_emmmeteur);
                // //die();

                // $entity->setTypeMutation(2);
                // $em->persist($agent_emmmeteur);
                // $em->flush($agent_emmmeteur);
                // $em->persist($entity);
                // $em->flush($entity);
                $entity->setGrh($this->getUser()->getAgent());
                // Etat temporaire
                $entity->setEtatMutation(1); 
                

                $entity->setdateRepGrh(new \DateTime());

                // NE PAS toucher à l'agent ici

                // Type mutation
                $entity->setTypeMutation(2);

                // Sauvegarde uniquement la mutation
                $em->persist($entity);
                $em->flush();
                $this->addFlash(
                        'notice', 'la mutation de l\'agent est enregistree et en attente de la note');

                return $this->redirect($this->generateUrl('mutation_send'));
            } else {
                $supDest = $em->getRepository('AgentBundle:Agent')->supDest($idDirection); //die;
                $supDirect = $this->get('ediligence.fonctiondebase')->retour_superieur()['sup2'];
                $supGrh = $this->get('ediligence.fonctiondebase')->retour_superieur()['sup3'];
                //dump($supDest);
                // $entity->setDateCreation(new \DateTime());
                $entity->setOrigine($agent->getDirection());
                $entity->setSupDir($supDirect);
                $entity->setEmmeteur($agent);
                $entity->setGrh($supGrh);
                $entity->setSupDest($supDest);
                $entity->setTypeMutation(1);
                $em->persist($entity);
                $em->flush();
                $this->addFlash(
                        'notice', 'Votre demande de mutation a été prise en compte');

                return $this->redirect($this->generateUrl('mutation_send'));
            }
        }

        return $this->render('AgentBundle:Mutation:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }


    // public function createAction(Request $request) {
    //     $entity = new Mutation();
    //     $agent = $this->getUser()->getAgent();
    //     $form = $this->createCreateForm($entity);
    //     $form->handleRequest($request);



    //     if ($form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $fonctionId = $this->getUser()->getAgent()->getFonction()->getId();
    //         $idDirection = $form->getData()->getDestination()->getId();
    //          $validateur = $this->get('ediligence.fonctiondebase')->returnConnect();
    //         //dump($fonctionId);
    //         //die();
    //          $validateur = $this->get('ediligence.fonctiondebase')->returnConnect();
    //         if ($fonctionId == 10 or in_array('ROLE_RESPO_SRHMG', $this->getUser()->getRoles())) {
    //             $agent_emmmeteur = $em->getRepository('AgentBundle:Agent')->findOneBy(['matricule' => $entity->getEmmeteur()->getMatricule()]);
    //             $entity->setOrigine($agent_emmmeteur->getDirection());
    //             $entity->setMatValidGrh($validateur);
    //             $entity->setMatValidSupDir($validateur);
    //             $entity->setMatValidDest($validateur);
    //             $entity->setEtatRepGrh(1);
    //             $entity->setEtatMutation(1);
              
    //             $entity->setdateRepGrh(new \DateTime());
    //             $agent_emmmeteur->setDirection($entity->getDestination());
    //             $agent_emmmeteur->setCodeDc($entity->getDestination()->getCodeDc());
    //             $agent_emmmeteur->setCodeSd(null);
    //             $agent_emmmeteur->setCodeSc(null);

    //             //dump($agent_emmmeteur);
    //             //die();

    //             $entity->setTypeMutation(2);
    //             $em->persist($agent_emmmeteur);
    //             $em->flush($agent_emmmeteur);
    //             $em->persist($entity);
    //             $em->flush($entity);
    //             $this->addFlash(
    //                     'notice', 'la mutation de l\'agent s\'est effectuée avec succès');

    //             return $this->redirect($this->generateUrl('mutation_send'));
    //         } else {
    //             $supDest = $em->getRepository('AgentBundle:Agent')->supDest($idDirection); //die;
    //             $supDirect = $this->get('ediligence.fonctiondebase')->retour_superieur()['sup2'];
    //             $supGrh = $this->get('ediligence.fonctiondebase')->retour_superieur()['sup3'];
    //             //dump($supDest);
    //             // $entity->setDateCreation(new \DateTime());
    //             $entity->setOrigine($agent->getDirection());
    //             $entity->setSupDir($supDirect);
    //             $entity->setEmmeteur($agent);
    //             $entity->setGrh($supGrh);
    //             $entity->setSupDest($supDest);
    //             $entity->setTypeMutation(1);
    //             $em->persist($entity);
    //             $em->flush();
    //             $this->addFlash(
    //                     'notice', 'Votre demande de mutation a été prise en compte');

    //             return $this->redirect($this->generateUrl('mutation_send'));
    //         }
    //     }

    //     return $this->render('AgentBundle:Mutation:new.html.twig', array(
    //                 'entity' => $entity,
    //                 'form' => $form->createView(),
    //     ));
    // }

    public function receiveAction($action) {

        $em = $this->getDoctrine()->getManager();

        $Direction = $this->getUser()->getAgent()->getDirection();
        $user = $this->getUser();
       /* if (!$user->hasRole("ROLE_RESPO")) {
            throw $this->createNotFoundException('Vous n\'avez pas accès a cette page');
        }*/
        switch ($action) {
            case 'others':
                $rh = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(0);
                $archive = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(1);
                return $this->render('AgentBundle:Mutation:receiveOther.html.twig', array(
                            'rh' => $rh,
                            'archive' => $archive,
                ));

                break;
            case 'print':
                $print = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(2);

                return $this->render('AgentBundle:Mutation:receivePrint.html.twig', array(
                            'print' => $print,
                ));

                break;
            case 'scan':
                $scan = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(2);

                return $this->render('AgentBundle:Mutation:receiveScan.html.twig', array(
                            'scan' => $scan,
                ));

                break;
            default:
                $entities = $em->getRepository('AgentBundle:Mutation')->findMutationReceive($user, 0);
                $archive = $em->getRepository('AgentBundle:Mutation')->findMutationReceive($user, 1);

                return $this->render('AgentBundle:Mutation:receive.html.twig', array(
                            'entities' => $entities,
                            'archive' => $archive,
                ));
                break;
        }
    }

    public function numeriseAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);
        //$agent = $em->getRepository('AgentBundle:Agent')->find($entity->getEmmeteur()->getMatricule());
        $agent = $entity->getEmmeteur();
        //dump($agent);die;

        $form = $this->createNumeriseForm($entity, $id);
        $form->handleRequest($request);


        if ($form->isValid()) {

            $documentNote = $entity->getMutationNote();
            $documentNote->setMatricule($agent);
            $documentNote->setLibelle("Note de mutation");
            $documentNote->setEtat(3);
            $em->persist($documentNote);
            $em->flush($documentNote);

            $entity->setMutationNote($documentNote);
            $entity->setSigneNote(1);

            // IMPACTER L’AGENT ICI
            $agent->setDirection($entity->getDestination());
            $agent->setCodeDc($entity->getDestination()->getCodeDc());
            $agent->setCodeSd(null);
            $agent->setCodeSc(null);

            // Mettre la mutation comme terminée
            $entity->setEtatMutation(2); 

            $em->persist($entity);
            $em->persist($agent);
            $em->flush();
            $this->addFlash('notice', 'document numeriser avec succes');
            return $this->redirect($this->generateUrl('mutation_receive', ['action' => 'scan']));
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        return $this->render('AgentBundle:Mutation:numerise.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function validAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);
        $trc_mat = $this->getUser()->getAgent();
        $trc_route = 'mutation_valid';
        $trc_entite = 'AgentBundle:Mutation';
        $trc_id = $entity->getId();
        $validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
        $emmeteur = $entity->getEmmeteur()->getMatricule() . "+" . $entity->getEmmeteur()->concatNom();

        //validation RH
        if ($entity->getEtatRepDest() == 1) {
            //Bon rh
            if ($entity->getGrh() == $this->getUser()->getAgent()) {
                $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['matricule' => $entity->getEmmeteur()->getMatricule()]);
                $trc_lib = "Validation mutation RH +" . $emmeteur . "+par+" . $validateur;
                //dump($trc_lib); die;
                $entity->setEtatRepGrh(1);
                $entity->setEtatMutation(1);
                $entity->setdateRepGrh(new \DateTime());
                //$entity->setOrigine($agent->getDirection());
                $agent->setDirection($entity->getDestination());
                $agent->setCodeDc($entity->getDestination()->getCodeDc());
                $agent->setCodeSd(null);
                $agent->setCodeSc(null);
                $em->persist($agent);
                $em->flush($agent);
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                $notif = $this->addFlash(
                        'notice', 'La Validation de la Demande a été éffectuée avec Succès');
            } else {
                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Valider cette Demande'
                );
            }
            //validation niveau 2 Sup Destination
        } elseif ($entity->getEtatRepSupDir() == 1) {
            # code...
            if ($entity->getSupDest() == $this->getUser()->getAgent()) {
                $entity->setEtatRepDest(1);
                $entity->setDateRepDest(new \DateTime());
                $trc_lib = "Validation mutation 2 +" . $emmeteur . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                if ($entity->getDestination()->getId() == 3) {
                    $entity->setEtatRepGrh(1);
                    $entity->setEtatMutation(1);
                    $entity->setdateRepGrh(new \DateTime());
                    //$entity->setOrigine($agent->getDirection());
                    $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['matricule' => $entity->getEmmeteur()->getMatricule()]);
                    $agent->setDirection($entity->getDestination());
                    $em->persist($agent);
                    $em->flush($agent);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                }
                $notif = $this->addFlash(
                        'notice', 'La Validation de la Demande a été éffectuée avec Succès');
            } else {

                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Valider cette Demande'
                );
            }
        }
        //validation niveau 1 sup direct
        elseif ($entity->getEtatRepSupDir() == 0) {
            # code...
            if ($entity->getSupDir() == $this->getUser()->getAgent()) {
                $entity->setEtatRepSupDir(1);
                $entity->setDateRepSupDir(new \DateTime());
                $trc_lib = "Validation mutation 1 +" . $emmeteur . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                $notif = $this->addFlash(
                        'notice', 'La Validation de la Demande a été éffectuée avec Succès');
            } else {

                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Valider cette Demande'
                );
            }
        }

        $em->persist($entity);
        $em->flush();
        $notif;
        return $this->redirect($this->generateUrl('mutation_receive'));
    }

    public function rejectAction($id) {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);
        $trc_mat = $this->getUser()->getAgent();
        $trc_route = 'mutation_reject';
        $trc_entite = 'AgentBundle:Mutation';
        $trc_id = $entity->getId();
        $validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
        $emmeteur = $entity->getEmmeteur()->getMatricule() . "+" . $entity->getEmmeteur()->concatNom();
        //validation RH
        if ($entity->getEtatRepDest() == 1) {
            //Rejet rh
            if ($entity->getGrh() == $this->getUser()->getAgent()) {
                $trc_lib = "Refus mutation 3 +" . $emmeteur . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                $entity->setEtatRepGrh(2);
                $entity->setEtatMutation(1);
                $entity->setdateRepGrh(new \DateTime());
                $notif = $this->addFlash(
                        'notice', 'Le rejet de la Demande a été éffectuée avec Succès');
            } else {
                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Rejeter cette Demande'
                );
            }
            //Rejet niveau 2 superieur de destination
        } elseif ($entity->getEtatRepSupDir() == 1) {
            # code...
            if ($entity->getSupDest() == $this->getUser()->getAgent()) {
                $trc_lib = "Refus mutation 2 +" . $emmeteur . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                $entity->setEtatRepDest(2);
                $entity->setEtatMutation(1);
                $entity->setDateRepDest(new \DateTime());
                $notif = $this->addFlash(
                        'notice', 'Le rejet de la Demande a été éffectuée avec Succès');
            } else {

                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Rejeter cette Demande'
                );
            }
            //Rejet niveau 1 superieur de direct
        } elseif ($entity->getEtatRepSupDir() == 0) {
            # code...
            if ($entity->getSupDir() == $this->getUser()->getAgent()) {
                $trc_lib = "Refus mutation 1 +" . $emmeteur . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                $entity->setEtatRepSupDir(2);
                $entity->setEtatMutation(1);
                $entity->setDateRepDest(new \DateTime());
                $notif = $this->addFlash(
                        'notice', 'Le rejet de la Demande a été éffectuée avec Succès');
            } else {

                $notif = $this->addFlash(
                        'error', 'Vous n\'êtes pas Autorisé à Rejeter cette Demande'
                );
            }
        }

        $em->persist($entity);
        $em->flush();
        $notif;
        return $this->redirect($this->generateUrl('mutation_receive'));
    }

    public function viewAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'demande-' . $id . '-' . $user, -2, -2, 'black', [-2, -2, -2, -2], 'white');
        //die;
        $etat = 1;
        return $this->render('AgentBundle:Mutation:preview_pdf.html.twig', array(
                    'qr' => $qr,
                    'entity' => $entity,
                    'etat' => $etat,
        ));
    }

    public function printAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Cette demande n\'existe pas');
        }

        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'mutation-' . $id . '-' . $this->getUser()->getAgent()->getMatricule(), -2, -2, 'black', [-2, -2, -2, -2], 'white');
        $action = 'AgentBundle:Mutation:note_mutation_pdf.html.twig';
        $filename = "mutation" . $entity->getEmmeteur()->getNom();

        $filename = $filename . ".pdf";
        $snappy = $this->get('knp_snappy.pdf');
        $footer = $this->renderview('DemandesBundle:Demande:footer_pdf.html.twig', array('qr' => $qr));
        $html = $this->renderview($action, array('entity' => $entity));


        $snappy->setOption('margin-top', 10);
        $snappy->setOption('margin-bottom', 12);

        $snappy->setOption('footer-center', utf8_decode('Página [page] de [topage] - Impresso em '));


        $snappy->setOption('footer-html', $footer);

        $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8',
            'footer-html' => $footer,
        ];

        return new PdfResponse(
                $snappy->getOutputFromHtml($html, $options), $filename
        );
    }

    /**
     * Creates a form to create a Mutation entity.
     *
     * @param Mutation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mutation $entity) {
        if ($this->getUser()->getAgent()->getFonction()->getId() == 10 or in_array('ROLE_RESPO_SRHMG', $this->getUser()->getRoles())) {
            $form = $this->createForm(new MutationDgType(), $entity, array(
                'action' => $this->generateUrl('mutation_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Valider la mutation', 'attr' => ['class' => 'btn btn-success']));
        } else {
            $form = $this->createForm(new MutationType($this->getUser()), $entity, array(
                'action' => $this->generateUrl('mutation_create'),
                'method' => 'POST',
            ));

            $form->add('submit', 'submit', array('label' => 'Faire sa demande', 'attr' => ['class' => 'btn btn-success']));
        }


        return $form;
    }

    /**
     * Displays a form to create a new Mutation entity.
     *
     */
    public function newAction() {
        $entity = new Mutation();
        $form = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Mutation:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mutation entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mutation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Mutation:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mutation entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mutation entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Mutation:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Mutation entity.
     *
     * @param Mutation $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Mutation $entity) {
        $form = $this->createForm(new MutationType(), $entity, array(
            'action' => $this->generateUrl('mutation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Mutation entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Mutation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mutation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mutation_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Mutation:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Mutation entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Mutation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mutation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mutation'));
    }

    /**
     * Creates a form to delete a Mutation entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('mutation_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    private function createNumeriseForm(Mutation $entity, $id) {
        $form = $this->createForm(new MutationNumerisationType(), $entity, array(
            'action' => $this->generateUrl('mutation_scan', array('id' => $id)),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Numériser la note de mutation', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

    public function changesrvAction() {
        $em = $this->getDoctrine()->getManager();

        //$entity = new Agent();
        $users = $this->getUser();
        $form = $this->Formchangesrv($users);

        if (!empty($users->getAgent()->getCodeSc())) {
            $code = 'code_sc';
            $valeur = $users->getAgent()->getCodeSc();
        } elseif (!empty($users->getAgent()->getCodeSd())) {
            $code = 'code_sd';
            $valeur = $users->getAgent()->getCodeSd();
        } elseif (!empty($users->getAgent()->getCodeDc())) {
            $code = 'code_dc';
            $valeur = $users->getAgent()->getCodeDc();
        } elseif (!empty($users->getAgent()->getCodeDg())) {
            $code = 'code_dg';
            $valeur = $users->getAgent()->getCodeDg();
        }
        $allagent = $em->getRepository('AgentBundle:Agent')->findBy([$code => $valeur, 'Fonction' => [1, 2]]);
//dump($form);die;
        return $this->render('AgentBundle:Mutation:changesrv.html.twig', array('form' => $form->createView(), 'DecisionAgents' => $allagent));
    }

    private function Formchangesrv($users) {
        $form = $this->createForm(new changeType($users), null, array(
            'action' => $this->generateUrl('mutation_createchange'),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'MUTER'));
        return $form;
    }

    public function createchangeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $users = $this->getUser();
        //$entity = new Agent();
        $form = $this->Formchangesrv($users);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $agentids = $request->request->get('id');
            $srvconnecte = $users->getAgent()->retour_service()['service'];

            if ($agentids) {
                foreach ($agentids as $agentid) {
                    $DecisionAgent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('matricule' => $agentid));
                    //dump($form->getData());die;
                    if ($DecisionAgent && in_array($srvconnecte, explode(',', $DecisionAgent->retour_service()['tab_imput']))) {

                        if (isset($form->getData()['code_sc'])) {
                            $DecisionAgent->setCodeDg($form->getData()['code_sc']->getCodeSousDir()->getCodeDc()->GetDirectionGle());
                            $DecisionAgent->setCodeDc($form->getData()['code_sc']->getCodeSousDir()->getCodeDc()->getCodeDc());
                            $DecisionAgent->setCodeSd($form->getData()['code_sc']->getCodeSousDir());
                            $direction = $form->getData()['code_sc']->getCodeSousDir()->getCodeDc();
                            $DecisionAgent->setCodeSc($form->getData()['code_sc']);
                        } elseif (isset($form->getData()['code_sd'])) {
                            $DecisionAgent->setCodeDg($form->getData()['code_sd']->getCodeDc()->GetDirectionGle());
                            $DecisionAgent->setCodeDc($form->getData()['code_sd']->getCodeDc()->getCodeDc());
                            $direction = $form->getData()['code_sd']->getCodeDc();
                            $DecisionAgent->setCodeSd($form->getData()['code_sd']);
                            $DecisionAgent->setCodeSc(null);
                        } elseif (isset($form->getData()['dc'])) {
                            $DecisionAgent->setCodeDg($form->getData()['dc']->getDirectionGle());
                            $DecisionAgent->setCodeDc($form->getData()['dc']->getCodeDc());
                            $direction = $form->getData()['dc'];
                            $DecisionAgent->setCodeSd(null);
                            $DecisionAgent->setCodeSc(null);
                        } else {
                            throw $this->createNotFoundException('Unable to find Mutation entity.');
                        }

                        $DecisionAgent->setDirection($direction);
                        $em->persist($DecisionAgent);



                        /*


                          if(isset($form->getData()['dc'])){
                          $DecisionAgent->setCodeDg($form->getData()['dc']->getDirectionGle());
                          $DecisionAgent->setCodeDc($form->getData()['dc']->getCodeDc());
                          $direction = $form->getData()['dc'];
                          }//else{

                          if(isset($form->getData()['sd'])){
                          $DecisionAgent->setCodeDg($form->getData()['sd']->getCodeDc()->GetDirectionGle());
                          $DecisionAgent->setCodeDc($form->getData()['sd']->getCodeDc()->getCodeDc());
                          $direction = $form->getData()['sd']->getCodeDc();
                          $DecisionAgent->setCodeSd($form->getData()['sd']);
                          }//else{

                          if(isset($form->getData()['sc'])){
                          $DecisionAgent->setCodeDg($form->getData()['sc']->getCodeSousDir()->getCodeDc()->GetDirectionGle());
                          $DecisionAgent->setCodeDc($form->getData()['sc']->getCodeSousDir()->getCodeDc()->getCodeDc());
                          $DecisionAgent->setCodeSd($form->getData()['sc']->getCodeSousDir());
                          $direction = $form->getData()['sc']->getCodeSousDir()->getCodeDc();
                          $DecisionAgent->setCodeSc($form->getData()['sc']);
                          //dump($form->getData()['sc']->getCodeSousDir());
                          }
                          // }

                          // }

                          if(isset($form->getData()['sd'])){$DecisionAgent->setCodeSd($form->getData()['sd']);}
                          else{if(isset($form->getData()['sc'])){ $DecisionAgent->setCodeSd($form->getData()['sc']->getCodeSousDir()); } else{$DecisionAgent->setCodeSd(null);}}
                          if(isset($form->getData()['sc'])){$DecisionAgent->setCodeSc($form->getData()['sc']); }else{$DecisionAgent->setCodeSc(null);}

                         */

                        //dump($DecisionAgent);die;
                    }
                }

                $this->addFlash('notice', 'Agent(s) muté(s) avec succès');
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('mutation_changesrv'));
    }
     public function interimviewAction($id = null) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('AgentBundle:Interimaire')->find($id);
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'interime-' . $id . '-' . $user, -2, -2, 'black', [-2, -2, -2, -2], 'white');
        //die;
        $etat = 0;
        return $this->render('AgentBundle:Mutation:preview_pdf.html.twig', array(
                    'qr' => $qr,
                    'entity' => $entity,
                    'etat' => $etat,
        ));
        die;
     }

    
    public function interimeAction(){
      //die;
      $em = $this->getDoctrine()->getManager();
      $interime = $em->getRepository('AgentBundle:Interimaire')->findBy(array('etatcloture'=>0),array('datesys' => 'DESC'));
      return $this->render('AgentBundle:Mutation:interimPrint.html.twig', array('tab' => $interime));

    }
        public function interimAction(Request $request, $id = null, $modif=null) {
        $em = $this->getDoctrine()->getManager();
        $users = $this->getUser();
        $interimaire = new Interimaire();
        $interime = $users->getAgent()->getId();
        //dump($modif); die;
        if ($id > 0) {

            $check = $em->getRepository('AgentBundle:Interimaire')->findOneBy(['id' => $id, 'interime' => $interime]);
            if ($check and !$modif) {
                
                $arracher = $check->getInterimaire()->getUsers();
                //arracher les droits
                if (in_array('ROLE_ALLOWED_TO_SWITCH', $arracher->getRoles())) {
                    $arracher->removeRole("ROLE_ALLOWED_TO_SWITCH");
                    $em->persist($arracher);
                }
                //desactiver linterim
                $check->setEtatcloture(2);
                $em->persist($check);

                $em->flush();
            }elseif ($check and $modif=="edit") {
              $interimaire=$check;
            }
        }

        $form = $this->Forminterimaire($interimaire, $users, $modif, $id);
        $form->handleRequest($request);
        $interimairess = $em->getRepository('AgentBundle:Interimaire')->findBy(['interime' => $interime, 'etatcloture' => [0, 1]]);

        if ($form->isValid()) {
            $frm = $form->getData();
            $interimaires = $em->getRepository('AgentBundle:Interimaire')->controle_etatinterim($interimaire->getInterimaire()->getMatricule(), $interime, 1); //'interime'=>$interime,
            if ($interimaires == false or $modif=="edit") {
                $interimaire->setInterime($users->getAgent());
               
                if($modif=="edit" and $check){
                   $arracher = $check->getInterimaire()->getUsers();
                    //arracher les droits
                    if (in_array('ROLE_ALLOWED_TO_SWITCH', $arracher->getRoles())) {
                        $arracher->removeRole("ROLE_ALLOWED_TO_SWITCH");
                        $em->persist($arracher);
                    }
                    //desactiver linterim
                    //$check->setEtatcloture(2);
                    $em->persist($check);

                    $em->flush($check);
                }
                 $em->persist($interimaire);
                $em->flush($interimaire);
                return $this->redirect($this->generateUrl('mutation_interim'));
            } elseif ($interimaires == true) {
                $this->addFlash('error', 'Vous avez dejà un interimaire défini ');
            }
        }
        return $this->render('AgentBundle:Mutation:interim.html.twig', array('form' => $form->createView(), 'tab' => $interimairess));
    }

    private function Forminterimaire(Interimaire $interimaire, $users = null, $modif=null, $id=null) {
     
      if($modif=="edit"){
        $route="mutation_interim_edit";
        $label="MODIFIER INTERIMAIRE";
      }else{
        $route="mutation_interim";
        $label="DESIGNER INTERIMAIRE";
      }
        $form = $this->createForm(new InterimType($users), $interimaire, array(
            'action' => $this->generateUrl($route,['id'=>$id,'modif'=>$modif]),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => $label, 'attr' => ['class' => 'form-control btn-success']));
        return $form;
    }

     public function saafAction(Request $request, $id = null) {

        $em = $this->getDoctrine()->getManager();

        if($id>0){

           $saaf = $em->getRepository('AgentBundle:Saaf')->findOneById($id);
           $designer = $saaf->getDesigner()->getUsers();

           $designer->removeRole('ROLE_SAAF');
           $em->persist($designer);
           $em->flush($designer);
//dump($saaf->getDesigner()->getUsers());die;
           $saaf->setEtat(2);
           $em->persist($saaf);
           $em->flush($saaf);

          $this->addFlash('notice', 'Agent retiré avec Succès' );
          return $this->redirect($this->generateUrl('mutation_saaf'));
        }

        $users = $this->getUser();
        $idagent = $this->getUser()->getAgent()->getId();
        $saaf = new Saaf();
//dump($this->getUser()->getAgent()); die;
        $form = $this->createFormBuilder($saaf, array())
                    ->add('agent', NULL, ['attr' => [
                        'style' => 'color:green',
                        'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir l\'agent'], 'label' => ' ',
                    'choice_label' => 'concatNommatricule',
                    'class' => 'AgentBundle:Agent',
                    'group_by' => 'Direction',
                    'query_builder' => function(EntityRepository $repo) use ($users) {
                        $respo = $repo->createQueryBuilder('a')
                                    ->leftJoin('a.users', 'u')
                                    ->where('a.Direction = :service')
                                    ->andWhere('u.roles not like :roles')
                                    ->setParameter('service', $users->getAgent()->getDirection())
                                    ->setParameter('roles', '%ROLE_SAAF%');
                                    //->groupBy('a.code_sd, a.code_sc');  
                                    
                                    $respo = $respo->orderBy('a.Direction,a.code_sd,a.nom, a.prenoms', 'ASC');
                        
                        return $respo;
                    }])
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer SAAF'])
            ->getForm(); 

         $form->handleRequest($request);
         $liste_saaf = $em->getRepository('AgentBundle:Saaf')->findBy(['agent'=>$this->getUser()->getAgent(), 'etat'=>1]);
         //dump($liste_saaf); die;
         //die;
         if ($form->isValid() && (empty($liste_saaf) ||  $liste_saaf == null )) {
          $userss = $form->getData()->getAgent();
          //$userManager = $this->container->get('fos_user.user_manager');
          //$usersss= $userManager->findUserBy(array('agent'=>$userss));
          $usersss =  $em->getRepository('UsersBundle:Users')->findByAgent($userss);
          $usersss = $usersss[0];
          $agentss =  $em->getRepository('AgentBundle:Agent')->findOneById($idagent);
            //dump($agentss);die;
            //attribue le role saaf a lagent
          if(!$usersss->hasRole('ROLE_SAAF')){//die;
//dump($usersss->addRole("ROLE_SAAF")); dump($userss);die;
            $usersss->addRole('ROLE_SAAF');

            //$userss->setUsers($usersss);
            $em->persist($usersss);
            $em->flush($usersss); 
            //$usersss->setAgent($userss);
            //$em->persist($usersss);
            //$usersss->setRoles(array("ROLE_SAAF"));
           
            //$userManager->updateUser($usersss,false);
           // dump($this->getUser()); die;
            $saaf = new Saaf();
           $saaf->setAgent($agentss);
           $saaf->setDesigner($userss);
            $saaf->setEtat(1);
            $em->persist($saaf);
            $em->flush($saaf); 
          // die;

            $this->addFlash('notice', 'Enregistré avec Succès' );
            return $this->redirect($this->generateUrl('mutation_saaf'));
           }
         }

        return $this->render('AgentBundle:Mutation:saaf.html.twig', array('form' => $form->createView(), 'listesaaf'=>$liste_saaf));
     }

}

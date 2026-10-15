<?php

namespace Demandes\DemandesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Dompdf\Options;
use Dompdf\Dompdf;
use Agent\AgentBundle\Entity\Avis;
use Demandes\DemandesBundle\Entity\Demande;
use Demandes\DemandesBundle\Form\DemandeOkType;
use Demandes\DemandesBundle\Form\DemandeEditType;
use Demandes\DemandesBundle\Form\DemandeType;
use Demandes\DemandesBundle\Form\DemandeNumeriseType;
use Demandes\DemandesBundle\Form\DemandeSaafType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\Security\Core\Role\SwitchUserRole;
use Agent\AgentBundle\Entity\Agent;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Demandes\DemandesBundle\Form\AbscencerecordType;
use Agent\AgentBundle\Form\CongesResearchType;


/**
 * Demande controller.
 *
 */
class DemandeController extends Controller
{

    private function getDeleguation($route, $param = null)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getAgent();
        $deleguations = $em->getRepository('AgentBundle:Deleguation')->checkRoute($id, $route, $param);
        $tab = [];
        foreach ($deleguations as $deleguation) {
            # code...
            array_push($tab, $deleguation->getArrayServices());

            //  dump($deleguation->getArrayServices());
        }
        $service = implode(",", $tab);
        //   die;

        if ($deleguations) {
            /////Success
            $retour = 0;
        } else {
            //echec
            $retour = 1;
        }

        return ['retour' => $retour, 'service' => $service];
    }

    private function returnConnecte()
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->isGranted('ROLE_PREVIOUS_ADMIN')) {

            foreach ($this->container->get('security.context')->getToken()->getRoles() as $role) {
                if ($role instanceof SwitchUserRole) {
                    $interimaire = $role->getSource()->getUser();

                    break;
                }
            }

            $agent_interim = $em->getRepository('AgentBundle:Agent')->findOneByMatricule($interimaire->getUsername());
            $validateur = $trc_mat = null;

            if ($agent_interim) {
                //$validateur = $agent_interim->getMatricule() . "+" . $agent_interim->concatNom();
                $trc_mat = $agent_interim;
            }
        } else {
            //$validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
            $trc_mat = $this->getUser()->getAgent();
        }
        return $trc_mat;
    }

    /**
     * Lists all Demande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DemandesBundle:Demande')->findAll();
        // dump($this->get('ediligence.fonctiondebase')->retour_superieur()); die;
        return $this->render('DemandesBundle:Demande:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    public function viewAction($id, $autres = 0)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'demande-' . $id . '-' . $user, -2, -2, 'black', [-2, -2, -2, -2], 'white');
        //die;
        return $this->render('DemandesBundle:Demande:preview_pdf.html.twig', array(
            'qr' => $qr,
            'entity' => $entity,
            'autres' => $autres,
        ));
    }

    public function listPrintAction()
    {
        $em = $this->getDoctrine()->getManager();

        $absence = $em->getRepository('DemandesBundle:Demande')->listPrint(1);
        $attestation = $em->getRepository('DemandesBundle:Demande')->listPrint(3);
        $certificat = $em->getRepository('DemandesBundle:Demande')->listPrint(4);

        return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
            'absence' => $absence,
            'attestation' => $attestation,
            'certificat' => $certificat,
        ));
    }

    public function printEtatAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);
        $entity->setEtatImpression(2);
        $em->persist($entity);
        $em->flush();
        return new Response("Print Sucess");
    }

    public function printAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Cette demande n\'existe pas');
        }

        $typedemande = $entity->getTypeDemande();
        switch ($typedemande->getId()) {
            case 1:
                # code...
                $action = 'DemandesBundle:Demande:demande_absence_pdf.html.twig';
                break;

            default:
                # code...
                $action = 'DemandesBundle:Demande:demande_autres_pdf.html.twig';
                break;
        }

        ///////////////////Génération PDF/////////////////////////
        //////////////////////////////////////////////////////////

        $agent = $entity->getEmmeteur()->getNom();
        $filename = $agent . "_" . $typedemande . ".pdf";
        $snappy = $this->get('knp_snappy.pdf');

        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'demande-' . $id . '-' . $this->getUser()->getAgent()->getMatricule(), -2, -2, 'black', [-2, -2, -2, -2], 'white');
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
            $snappy->getOutputFromHtml($html, $options),
            $filename
        );

        /*
          return new PdfResponse(
          $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
          'zzzz.pdf'
          ); */
        /*
         */

        /////////////////////////////
    }

    /**
     * Lists all Demande by Agent
     *
     */
    public function sendAction()
    {
        $em = $this->getDoctrine()->getManager();

        $agent = $this->getUser()->getAgent()->getMatricule();
        //  $entities = $em->getRepository('DemandesBundle:Demande')->findBy(['typeDemande'=>1],array('datecreation' => 'desc'),array('emmeteur'=>$agent));//;
        $entities = $em->getRepository('DemandesBundle:Demande')->demandeSendAutorisation($agent);
        //dump($entities); die;
        $entiti = $em->getRepository('DemandesBundle:Demande')->demandeSendOther($agent);
        return $this->render('DemandesBundle:Demande:index.html.twig', array(
            'entities' => $entities,
            'entiti' => $entiti,
        ));
    }

    /**
     * Lists all Demande receive
     *
     */
    public function receivesAction($action)
    {
        $em = $this->getDoctrine()->getManager();
        $deleguation = $this->getDeleguation("demande_receive", "action:default");
        $deleguation_other = $this->getDeleguation("demande_receive", "action:other");
        $deleguation_print = $this->getDeleguation("demande_receive", "action:print");
        $deleguation_scan = $this->getDeleguation("demande_receive", "action:scan");

        $Direction = $this->getUser()->getAgent()->getDirection();
        $user = $this->getUser();


        //die;
        /*
          if (!$user->hasRole("ROLE_RESPO") or $deleguation_other==0 or $deleguation_print==0 or $deleguation_print==0) {
          throw $this->createAccessDeniedException('Vous n\'avez pas accès a cette pages !');
          } */
        $typeD = $em->getRepository('DemandesBundle:TypeDemande')->findAll();
        $tab = [];
        foreach ($typeD as $t) {
            # code...
            $tab[] = $t->getId();
        }
        //dump($tab); die;
        switch ($action) {
            case 'other':
                $absence = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 1, $user, 0, $deleguation_other);
                $attestation = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 3, $deleguation_other);
                $certificat = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 4, $deleguation_other);
                $hors = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 5, $deleguation_other);
                $archive = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 3, $user, 0, $deleguation_other);
                $cabinet = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 6, $user, 1, $deleguation_other);
                return $this->render('DemandesBundle:Demande:receiveOther.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'archive' => $archive,
                    'deleguation' => $deleguation_other['retour'],
                    'cabinet' => $cabinet,
                    'hors' => $hors,
                ));
                break;
            case 'print':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 1, $deleguation_print, 1);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 3, $deleguation_print, 1);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 4, $deleguation_print, 1);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 5, $deleguation_print, 1);
                $reimprimer = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, $tab, $deleguation_print, 2);
                //dump($reimprimer); //die;
                //$reimprimer = null;
                return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'reimprimer' => $reimprimer,
                    'deleguation' => $deleguation_print['retour'],
                    'hors' => $hors,
                ));
                break;
            case 'scan':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 1, $deleguation_scan);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 3, $deleguation_scan);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 4, $deleguation_scan);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 5, $deleguation_scan);

                return $this->render('DemandesBundle:Demande:demande_scan_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'deleguation' => $deleguation_scan['retour'],
                    'hors' => $hors,
                ));
                break;
            case 'print':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 1, $deleguation_print);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 3, $deleguation_print);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 4, $deleguation_print);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 5, $deleguation_print);

                return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'deleguation' => $deleguation_print['retour'],
                    'hors' => $hors,
                ));
                break;
            default:
                $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(2, 1, $user, 0, $deleguation);
                $archive = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(2, 2, $user, 0, $deleguation);
                //dump($entities); die;
                return $this->render('DemandesBundle:Demande:receive.html.twig', array(
                    'entities' => $entities,
                    'archive' => $archive,
                    'deleguation' => $deleguation['retour'],
                ));
                break;
        }
        /* $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive($user);
          $entitie = $em->getRepository('DemandesBundle:Demande')->findDemandeReceiveSRHMG();
          $entiti = $em->getRepository('DemandesBundle:Demande')->findDemandeReceiveSRHMG2(); */



        //dump($entitie); dump($entities);
    }

    /*
      public function receiveAction($action) {
      $em = $this->getDoctrine()->getManager();
      $deleguation=$this->getDeleguation("demande_receive","action:default");
      $deleguation_other=$this->getDeleguation("demande_receive","action:other");
      $deleguation_print=$this->getDeleguation("demande_receive","action:print");
      $deleguation_scan=$this->getDeleguation("demande_receive","action:scan");

      $Direction = $this->getUser()->getAgent()->getDirection();
      $user = $this->getUser();


      //die;

      $typeD=$em->getRepository('DemandesBundle:TypeDemande')->findAll();
      $tab=[];
      foreach ($typeD as $t) {
      # code...
      $tab[]=$t->getId();

      }
      //dump($tab); die;
      switch ($action) {
      case 'other':
      $absence = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 1, $user, 0, $deleguation_other);
      $attestation = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 3,$deleguation_other);
      $certificat = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 4, $deleguation_other);
      $archive = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 3, $user, 0 , $deleguation_other);

      return $this->render('DemandesBundle:Demande:receiveOther.html.twig', array(
      'absence' => $absence,
      'attestation' => $attestation,
      'certificat' => $certificat,
      'archive' => $archive,
      'deleguation'=> $deleguation_other['retour'],
      ));
      break;
      case 'print':
      $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 1, $deleguation_print,1);
      $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 3, $deleguation_print,1);
      $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 4, $deleguation_print,1);
      $reimprimer =$em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, $tab, $deleguation_print,2);
      //dump($reimprimer); //die;
      //$reimprimer = null;
      return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
      'absence' => $absence,
      'attestation' => $attestation,
      'certificat' => $certificat,
      'reimprimer' => $reimprimer,
      'deleguation'=> $deleguation_print['retour'],
      ));
      break;
      case 'scan':
      $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 1, $deleguation_scan);
      $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 3, $deleguation_scan);
      $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 4, $deleguation_scan);

      return $this->render('DemandesBundle:Demande:demande_scan_print.html.twig', array(
      'absence' => $absence,
      'attestation' => $attestation,
      'certificat' => $certificat,
      'deleguation'=> $deleguation_scan['retour'],
      ));
      break;
      case 'print':
      $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 1, $deleguation_print);
      $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 3,$deleguation_print);
      $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 4, $deleguation_print);

      return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
      'absence' => $absence,
      'attestation' => $attestation,
      'certificat' => $certificat,
      'deleguation'=> $deleguation_print['retour'],
      ));
      break;
      default:
      $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(2, 1, $user, 0, $deleguation);
      $archive = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(2, 2, $user, 0, $deleguation);
      //dump($entities); die;
      return $this->render('DemandesBundle:Demande:receive.html.twig', array(
      'entities' => $entities,
      'archive' => $archive,
      'deleguation'=> $deleguation['retour'],
      ));
      break;
      }




      //dump($entitie); dump($entities);
      }
     */

    public function numeriseAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);
        $agent = $em->getRepository('AgentBundle:Agent')->find($entity->getEmmeteur()->getId());

        $form = $this->createNumeriseForm($entity, $id);
        $form->handleRequest($request);


        if ($form->isValid()) {

            $documentNote = $entity->getDemandeActe();
            $documentNote->setMatricule($agent);
            $documentNote->setLibelle("Acte administratif");
            $documentNote->setEtat(4);
            $em->persist($documentNote);
            $em->flush($documentNote);

            $entity->setDemandeActe($documentNote);
            $entity->setSigneActe(1);
            $entity->setDateAutoSignNote(new \DateTime());
            $entity->setMatSignNote($this->get('ediligence.fonctiondebase')->returnConnect());

            $em->persist($entity);
            $em->flush($entity);
            $this->addFlash('notice', 'document numeriser avec succes');
            return $this->redirectToroute('demande_receive', ['action' => 'scan']);
        }
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        return $this->render('DemandesBundle:Demande:numerise.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function rejectAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);
        $emmeteur = $entity->getEmmeteur();
        $validateur = $this->getUser()->getAgent();

        $direction = $this->getUser()->getAgent()->getDirection();

        $superieur = $em->getRepository('AgentBundle:Agent')->findSuperieurSD("ROLE_RESPO_SRHMG", $direction);

        $form = $this->createRejectForm($entity, 99, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            //Refus Authorisation d'absence
            if ($entity->getTypeDemande()->getId() == 1) {
                $trc_mat = $this->returnConnecte();
                $trc_route = 'demande_reject';
                $trc_entite = 'DemandesBundle:Demande';
                $trc_id = $entity->getId();
                $trc_lib = "Refus autorisation absence " . $emmeteur . "+par+" . $validateur;
                //Niveau 3
                if ($entity->getEtatRepSupDir2() == 1) {
                    // echo "3"; die;
                    if ($entity->getGrh() == $this->getUser()->getAgent()) {
                        $entity->setEtatRepGrh(2);
                        $entity->setDateRepGrh(new \DateTime());
                        $entity->setEtatNotification(0);
                        $entity->setEtatEmmission(2);
                        $entity->setEtatEncours(1);
                        $entity->setMatValidRh($this->returnConnecte());
                        $em->persist($entity);
                        $em->flush();
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                        $notif = $this->addFlash(
                            'error',
                            'La Demande a été rejetée avec succès'
                        );
                    } else {
                        $notif = $this->addFlash(
                            'error',
                            'Vous n\'êtes pas Autorisé à Refuser cette Demande'
                        );
                    }
                    # code...
                }
                //Niveau 2
                elseif ($entity->getEtatRepSupDir() == 1) {

                    if ($entity->getSupDir2() == $this->getUser()->getAgent()) {

                        $entity->setEtatRepSupDir2(2);
                        $entity->setEtatEmmission(2);
                        $entity->setEtatNotification(0);
                        $entity->setDateRepSupDir2(new \DateTime());
                        $entity->setEtatEncours(1);
                        $entity->setMatValidSup2($this->returnConnecte());
                        $em->persist($entity);
                        $em->flush();
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                        $notif = $this->addFlash(
                            'error',
                            'La Demande a été rejetée avec succès'
                        );
                    } else {
                        //echo "21";
                        //die;
                        $notif = $this->addFlash(
                            'error',
                            'Vous n\'êtes pas Autorisé à Refuser cette Demande'
                        );
                    }
                }
                //Refus Supérieur 1
                elseif ($entity->getEtatRepSupDir() == 0) {
                    //echo "1"; die;
                    if (
                        $entity->getSupDir() == $this->getUser()->getAgent() or ($entity->getSupDir() == $this->getUser()->getAgent() and $entity->getSupDir() == $entity->getSupDir2()) or
                        $entity->getSupDir2() == $this->getUser()->getAgent()
                    ) {
                        $entity->setEtatRepSupDir(2);
                        $entity->setEtatEmmission(2);
                        $entity->setEtatNotification(0);
                        $entity->setDateRepSupDir(new \DateTime());
                        $entity->setEtatEncours(1);
                        $entity->setMatValidSup1($this->returnConnecte());
                        $em->persist($entity);
                        $em->flush();
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                        $notif = $this->addFlash(
                            'error',
                            'La Demande a été rejetée avec succès'
                        );
                    } else {
                        $notif = $this->addFlash(
                            'error',
                            'Vous n\'êtes pas Autorisé à Refuser cette Demande'
                        );
                    }
                }

                //Refus Supérieur 3
            }
            /*
              else {
              $entity->setEtatRepSupDir(2);
              //  $entity->setEtatEmmission(1);
              $entity->setEtatNotification(0);
              $entity->setDateRepSupDir(new \DateTime());

              $em->persist($entity);
              $em->flush();
              # code...
              } */

            return $this->redirect($this->generateUrl('demande_receive'));
        }
        return $this->render('DemandesBundle:Demande:demande_reject.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function validAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

        $direction = $this->getUser()->getAgent()->getDirection();

        $superieur = $em->getRepository('AgentBundle:Agent')->findSuperieurSD("ROLE_RESPO_SRHMG", $direction);
        $deleguationRespo = $this->getDeleguation("demande_receive", "action:default")['retour'];
        $deleguationRh = $this->getDeleguation("demande_receive", "action:other")['retour'];

        if ($this->isGranted('ROLE_PREVIOUS_ADMIN')) {

            foreach ($this->container->get('security.context')->getToken()->getRoles() as $role) {
                if ($role instanceof SwitchUserRole) {
                    $interimaire = $role->getSource()->getUser();

                    break;
                }
            }

            $agent_interim = $em->getRepository('AgentBundle:Agent')->findOneByMatricule($interimaire->getUsername());
            $validateur = $trc_mat = null;

            if ($agent_interim) {
                $validateur = $agent_interim->getMatricule() . "+" . $agent_interim->concatNom();
                $trc_mat = $agent_interim;
                $entity->setEtatInterim(1);
            }
        } else {
            $validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
            $trc_mat = $this->getUser()->getAgent();
        }
        $emmeteur = $entity->getEmmeteur()->getMatricule() . "+" . $entity->getEmmeteur()->concatNom();
        //Validation Authorisation d'absence
        if ($entity->getTypeDemande()->getId() == 1) {


            $trc_route = 'demande_valid';
            $trc_entite = 'DemandesBundle:Demande';
            $trc_id = $id;
            $trc_lib = "Validation autorisation absence " . $emmeteur . "+par+" . $validateur;
            //dump($trc_mat); die;
            //Si 3ème niveau de Validation
            if ($entity->getEtatRepSupDir2() == 1) {
                if ($entity->getGrh() == $this->getUser()->getAgent() or $deleguationRh == 0) {
                    //die;
                    # code...
                    $entity->setEtatRepGrh(1);
                    $entity->setdateRepGrh(new \DateTime());
                    $entity->setEtatEmmission(2);
                    $entity->setEtatNotification(0);
                    $entity->setEtatEncours(1);
                    $entity->setMatValidRh($trc_mat);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                    $em->persist($entity);
                    $em->flush();
                    return $this->redirect($this->generateUrl('demande_receive', ['action' => 'other']));
                } else {
                    $notif = $this->addFlash(
                        'error',
                        'Vous n\'êtes pas Autorisé à Valider cette Demande'
                    );
                }
            }
            //Si 2ème niveau de Validation
            elseif ($entity->getEtatRepSupDir() == 1) {
                if ($entity->getSupDir2() == $this->getUser()->getAgent() or $deleguationRespo == 0) {
                    //die;
                    # code...
                    $entity->setEtatRepSupDir2(1);
                    $entity->setEtatEmmission(1);
                    $entity->setEtatNotification(0);
                    $entity->setDateRepSupDir2(new \DateTime());
                    $entity->setEtatRepGrh(0);
                    $entity->setdateRepGrh(null);
                    $entity->setMatValidSup2($trc_mat);
                    if (
                        in_array('ROLE_RESPO_SRHMG', $entity->getEmmeteur()->getUsers()->getRoles())
                        or $entity->getEmmeteur()->getDirection()->getId() == 3
                    ) {
                        //dump("ok");
                        $entity->setEtatRepGrh(1);
                        $entity->setdateRepGrh(new \DateTime());
                        $entity->setEtatEmmission(2);
                        $entity->setEtatNotification(0);
                        $entity->setEtatEncours(1);
                        $entity->setMatValidRh($trc_mat);
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                    }

                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                    // $entity->setEtatEncours(1);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                } else {
                    $notif = $this->addFlash(
                        'error',
                        'Vous n\'êtes pas Autorisé à Valider cette Demande'
                    );
                }
            }
            //Si 1er niveau de Validation
            if ($entity->getEtatRepSupDir() == 0) {
                //1er niveau
                // si supérieur 1 == superieur 2
                if ((($entity->getSupDir() == $this->getUser()->getAgent()) and ($entity->getSupDir() == $entity->getSupDir2())) or ($deleguationRespo == 0 and $deleguationRh == 0)) {

                    //validation niveau 1 & 2
                    $entity->setEtatRepSupDir(1);
                    $entity->setEtatRepSupDir2(1);
                    $entity->setEtatEmmission(1);
                    $entity->setEtatNotification(0);
                    $entity->setDateRepSupDir(new \DateTime());
                    $entity->setDateRepSupDir2(new \DateTime());
                    $entity->setEtatRepGrh(0);
                    $entity->setdateRepGrh(null);
                    $entity->setMatValidSup1($trc_mat);
                    $entity->setMatValidSup2($trc_mat);
                    //Si la personne ayant fait la demande
                    // RESPO_RH
                    //ou agent des RH(cad Chef de section)
                    //ou chef de service rattaché ou directeur
                    //on valid au 3eme niveau
                    if (
                        in_array('ROLE_RESPO_SRHMG', $entity->getEmmeteur()->getUsers()->getRoles())
                        or $entity->getEmmeteur()->getDirection()->getId() == 3
                        or $entity->getEmmeteur()->getFonction()->getId() == 5
                        or $entity->getEmmeteur()->getFonction()->getId() == 7
                        or $entity->getEmmeteur()->getFonction()->getId() == 9
                        or $this->getUser()->getAgent()->getFonction()->getId() == 10
                    ) {
                        //dump("ok");
                        $entity->setEtatRepGrh(1);
                        $entity->setdateRepGrh(new \DateTime());
                        $entity->setEtatEmmission(2);
                        $entity->setEtatNotification(0);
                        $entity->setEtatEncours(1);
                        $entity->setMatValidRh($trc_mat);
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                    }



                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                    //validateur sup 1//
                    //nieau 1
                } elseif ($entity->getSupDir() == $this->getUser()->getAgent() or $deleguationRespo == 0) {
                    //var_dump("1er Niveau 2"); die;
                    $entity->setEtatRepSupDir(1);
                    $entity->setEtatEmmission(1);
                    $entity->setEtatNotification(0);
                    $entity->setDateRepSupDir(new \DateTime());
                    $entity->setEtatRepGrh(0);
                    $entity->setdateRepGrh(null);
                    $entity->setMatValidSup1($trc_mat);
                    //$entity->setEtatArchive(1);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                    //validation directe du supérieur 2 sans validation préalable du superieur 1
                } elseif ($entity->getSupDir2() == $this->getUser()->getAgent() or $deleguationRespo == 0) {
                    //validation niveau 1 & 2
                    $entity->setEtatRepSupDir(1);
                    $entity->setEtatRepSupDir2(1);
                    $entity->setEtatEmmission(1);
                    $entity->setEtatNotification(0);
                    $entity->setDateRepSupDir(new \DateTime());
                    $entity->setDateRepSupDir2(new \DateTime());
                    $entity->setEtatRepGrh(0);
                    $entity->setdateRepGrh(null);
                    $entity->setEtatVal(1);
                    $entity->setMatValidSup1($trc_mat);
                    $entity->setMatValidSup2($trc_mat);
                    //si agent ayant fait la demande est du service des RH
                    //on effectue le 3eme niveau de validation
                    if ($entity->getEmmeteur()->getDirection()->getId() == 3) {
                        //dump("ok");
                        $entity->setEtatRepGrh(1);
                        $entity->setdateRepGrh(new \DateTime());
                        $entity->setEtatEmmission(2);
                        $entity->setEtatNotification(0);
                        $entity->setEtatEncours(1);
                        $entity->setMatValidRh($trc_mat);
                        $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                    }


                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                } elseif (($entity->getSupDir2()->getId() == "326" or $entity->getSupDir()->getId() == "326") and (in_array('ROLE_RESPO_SRHMG', $this->getUser()->getRoles()) or $deleguationRh = 0)) {
                    $entity->setEtatRepSupDir(1);
                    $entity->setEtatRepSupDir2(1);
                    $entity->setEtatEmmission(1);
                    $entity->setEtatNotification(0);
                    $entity->setDateRepSupDir(new \DateTime());
                    $entity->setDateRepSupDir2(new \DateTime());
                    $entity->setEtatRepGrh(1);
                    $entity->setdateRepGrh(new \DateTime());
                    $entity->setEtatVal(1);
                    $entity->setMatValidSup1($trc_mat);
                    $entity->setMatValidSup2($trc_mat);
                    $entity->setEtatEncours(1);
                    $entity->setMatValidRh($trc_mat);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 2);
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 3);
                    $notif = $this->addFlash(
                        'notice',
                        'La Validation de la Demande a été éffectuée avec Succès'
                    );
                } else {
                    $notif = $this->addFlash(
                        'error',
                        'Vous n\'êtes pas Autorisé à Valider cette Demande'
                    );
                }
            }


            $em->persist($entity);
            $em->flush();
        }
        //Validation Autres Type de Demande
        else {
            # code...
            if ($entity->getGrh() == $this->getUser()->getAgent() or $deleguationRh == 0) {
                $trc_mat = $this->getUser()->getAgent();
                $trc_route = 'demande_valid';
                $trc_entite = 'DemandesBundle:Demande';
                $trc_id = $id;
                //$trc_lib="Validation autres types";
                $trc_lib = "Validation " . $entity->getTypeDemande() . " " . $emmeteur . "+par+" . $validateur;
                $entity->setEtatRepGrh(1);
                $entity->setEtatEmmission(1);
                $entity->setEtatNotification(0);
                $entity->setDateRepGrh(new \DateTime());
                $entity->setEtatEncours(1);
                $entity->setMatValidRh($trc_mat);
                $em->persist($entity);
                $em->flush();
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 1);
                $notif = $this->addFlash(
                    'notice',
                    'La Validation de la Demande a été éffectuée avec Succès'
                );
            } else {
                $notif = $this->addFlash(
                    'error',
                    'Vous n\'êtes pas Autorisé à Valider cette Demande'
                );
            }
            return $this->redirect($this->generateUrl('demande_receive', ['action' => 'other']));
        }

        $notif;
        return $this->redirect($this->generateUrl('demande_receive'));
    }

    /**
     * Creates a new Demande entity.
     *
     */
    /* public function retour_superieur() {
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

    public function replyAction(Request $request, $r = 1)
    {

        $em = $this->getDoctrine()->getManager();

        $agent = $this->getUser()->getAgent();

        $form = $this->createFormBuilder($agent, array('validation_groups' => array('foobar')))
            ->add('datePremierService', 'datetime', array(
                'widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                'label' => 'Date de première prise de service', 'required' => false,
                'attr' => array('class' => 'form-control datetimepicker')
            ))
            ->add('datePriseServiceDge', 'datetime', array(
                'widget' => 'single_text', 'format' => 'dd-MM-yyyy',
                'label' => 'Date de prise de service DGE', 'attr' => array('class' => 'form-control')
            ))
            ->add('Emploi', NULL, [
                'class' => 'AgentBundle:Emploi',
                'query_builder' => function (EntityRepository $er) {
                    $querybuilder = $er->triEmploi();
                    return $querybuilder;
                },
                'attr' => [
                    'style' => 'color:green',
                    'class' => 'selectpicker', 'data-live-search' => 'true', 'title' => 'Choisir'
                ],
            ])
            ->add('Confirmer', SubmitType::class, ['label' => 'Confirmer vos informations'])
            ->getForm();


        $form->handleRequest($request);

        if ($form->isValid()) {

            $agent->setConfirms(1);
            $em->persist($agent);
            $em->flush();

            if ($r == 1) {
                $routes = 'demande_do';
            } else {
                $routes = 'conges_new';
            }
            $this->addFlash('notice', 'Confirmation enregistrée avec Succès');

            return $this->redirect($this->generateUrl($routes));
        }

        return $this->render('DemandesBundle:Demande:reply.html.twig', array('form' => $form->createView()));
    }

    public function createoldAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$prive=$em->getRepository('DemandesBundle:TypeDemande')->findTypeDemandePrive($matricule);
        $entity = new Demande();
        $matricule = $this->getUser()->getAgent()->getId(); ///Recevra l'action à effectuer en focntion du type choisi

        $form = $this->createDoForm($entity, $matricule);
        $form->handleRequest($request);
        //
        if ($form->isValid()) {


            $ok = new \DateTime();
            $today = new \DateTime($ok->format('Y-m-d'));

            $type = $form->getData()->getTypeDemande()->getId();

            if ($type == 1) {
                $datedebut = $form->getData()->getDateDeb();
                $datefin = $form->getData()->getDateFin();
                $interval = $datedebut->diff($datefin)->format('%R%a');

                $interval2 = $today->diff($datedebut)->format('%R%a');
                $delai = $em->getRepository('DemandesBundle:Quota')->findOneBy(['typeDemande' => $type])->getNbreJoursAvant();
            } else {
                $interval = null;
                $interval2 = null;
                $delai = null;
            }

            if ($interval < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas choisir de date de fin antérieur à la date de début'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval2 < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas choisir de date antérieur à aujourd\'hui'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval2 < $delai) {
                $this->addFlash(
                    'error',
                    'Vous devez faire votre demande ' . $delai . ' jour(s) avant votre départ'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval > 2) {
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas Demander plus de 03 jours d\'absence'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
                ));
            } else {
                $em = $this->getDoctrine()->getManager();

                $entity->setEmmeteur($this->getUser()->getAgent());
                $entity->setEtatEmmission(0); //Etat de base de l'émission
                $entity->setEtatNotification(0);
                //Retrouver le Supérieur de l'agent en fonction du rôle et de la direction de l'agent
                //En fonction de sa demande
                $superieur = $this->get('ediligence.fonctiondebase')->retour_superieur();

                switch ($type) {
                        //Autorisation d'absence
                    case 1:
                        $entity->setSupDir($superieur['sup1']);
                        $entity->setEtatRepSupDir(0);

                        $entity->setSupDir2($superieur['sup2']);
                        $entity->setEtatRepSupDir2(0);

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;


                    case 2:

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;

                    case 3:

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;

                    default:
                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;
                }

                if (!$superieur) {
                    throw $this->createNotFoundException(':-( Aucun Supérieur trouvé pour ce Agent');
                }



                $em->persist($entity);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Demande enregistrée avec Succès'
                );
                return $this->redirect($this->generateUrl('demande_send'));
            }
        }

        return $this->render('DemandesBundle:Demande:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    //Gérer l'affichage du formulaire de choix du type de Demande
    public function doCreateAction(Request $request)
    {

        $entity = new Demande();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createCreateForm($entity, 0);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $todo = $entity->getTypeDemande()->getId();
            $form = $this->createCreateForm($entity, $todo);
            $form->handleRequest($request);
            return $this->render('DemandesBundle:Demande:new.html.twig', array(
                'entity' => $entity,
                'form' => $form->createView(),
            ));
            exit;
        }
    }

    /**
     * Creates a form to create a Demande entity.
     *
     * @param Demande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Demande $entity, $todo)
    {
        $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DemandeType($securityContext, $todo), $entity, array(
            'action' => $this->generateUrl('demande_create', array('todo' => $todo)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Valider la Demande', 'attr' => array('class' => 'btn-success')));

        return $form;
    }

    private function createDoForm(Demande $entity, $matricule)
    {
        //  $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DemandeOkType($matricule), $entity, array(
            'action' => $this->generateUrl('demande_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Enregistrer la Demande', 'attr' => array('class' => 'btn-success col-md-push-4 col-md-4 col-lg-4 col-sm-4')));

        return $form;
    }

    private function createRejectForm(Demande $entity, $todo, $id)
    {
        $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DemandeType($securityContext, $todo), $entity, array(
            'action' => $this->generateUrl('demande_reject', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'REJETER LA DEMANDE', 'attr' => array('class' => 'btn-danger col-md-5 col-lg-5 col-sm-5', 'data-confirm' => 'Etes-vous <strong>certain</strong> de vouloir rejeter cette demande ?')))
            ->add('button', 'reset', array('label' => 'ANNULER', 'attr' => array('class' => 'btn-warning col-md-5 col-lg-5 col-sm-5', 'onClick' => '/')));

        return $form;
    }

    /**
     * Displays a form to create a new Demande entity.
     *
     */
    public function newAction()
    {

        $entity = new Demande();
        $form = $this->createCreateForm($entity);


        return $this->render('DemandesBundle:Demande:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function doAction()
    {

        if ($this->getUser()->getAgent()->getConfirms() == 0) {
            return $this->redirect($this->generateUrl('demande_reply'));
        }
        //$em = $this->getDoctrine()->getManager();
        //$matricule=$this->getUser()->getAgent()->getMatricule();
        //$prive=$em->getRepository('DemandesBundle:TypeDemande')->findTypeDemandePrive($matricule);
        //var_dump($prive->getQuery()->getResult());
        //Etat 1 ppour identifier une Demande d'autorisation
        // var_dump($this->getUser()->getRoles());
        //var_dump(explode(",", $this->getUser()->getAgent()->retour_service()['tab_imput']));

        $entity = new Demande();
        $matricule = $this->getUser()->getAgent()->getId();
        $form = $this->createDoForm($entity, $matricule);

        //$em = $this->getDoctrine()->getManager();
        //$exclus=$em->getRepository('DemandesBundle:TypeDemande')->findTypeDemandePrive($matricule);
        //var_dump($exclus->getQuery()->getResult());
        //die;
        return $this->render('DemandesBundle:Demande:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    public function doRejectAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);
        $form = $this->createRejectForm($entity, 99, $id);
        return $this->render('DemandesBundle:Demande:demande_reject.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Demande entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Cette demande n\'existe pas');
        }
        if ($this->getUser()->getAgent()->getMatricule() == $entity->getEmmeteur()->getMatricule()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setEtatNotification(1);
            $em->persist($entity);
            $em->flush();
            // die;
        }
        $typedemande = $entity->getTypeDemande();
        switch ($typedemande->getId()) {
            case 1:
                # code...
                $action = 'DemandesBundle:Demande:show_absence.html.twig';
                break;

            default:
                # code...
                $action = 'DemandesBundle:Demande:show.html.twig';
                break;
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render($action, array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Demande entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demande entity.');
        }
        $matricule = $this->getUser()->getAgent()->getMatricule();

        $editForm = $this->createEditForm($entity, $matricule);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DemandesBundle:Demande:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Demande entity.
     *
     * @param Demande $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Demande $entity, $matricule)
    {
        //$todo=$entity->getTypeDemande()->getId();
        // $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DemandeEditType($matricule), $entity, array(
            'action' => $this->generateUrl('demande_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Demande entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Demande entity.');
        }
        $matricule = $entity->getEmmeteur()->getMatricule();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $matricule);
        // dump($entity); die;
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $ok = new \DateTime();
            $today = new \DateTime($ok->format('Y-m-d'));
            //dump($today);
            //$type=$entity->getTypeDemande()->getId();
            $type = $editForm->getData()->getTypeDemande()->getId();

            if ($type == 1) {
                $datedebut = $editForm->getData()->getDateDeb();
                $datefin = $editForm->getData()->getDateFin();
                $interval = $datedebut->diff($datefin)->format('%R%a');

                $interval2 = $today->diff($datedebut)->format('%R%a');
                $delai = $em->getRepository('DemandesBundle:Quota')->findOneBy(['typeDemande' => $type])->getNbreJoursAvant();
            } else {
                $interval = null;
                $interval2 = null;
                $delai = null;
            }

            //dump($interval);
            //die;
            if ($interval < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne Pouvez pas choisir de date de Fin antérieur à la date de Début'
                );
                return $this->render('DemandesBundle:Demande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                ));
            } elseif ($interval2 < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne Pouvez pas choisir de date Antérieur à la Date du Jour'
                );
                return $this->render('DemandesBundle:Demande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                ));
            } elseif ($interval2 < $delai) {
                $this->addFlash(
                    'error',
                    'Vous Devez faire votre Demande ' . $delai . ' Jour avant votre Départ'
                );
                return $this->render('DemandesBundle:Demande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                ));
            } elseif ($interval > 2) {
                $this->addFlash(
                    'error',
                    'Vous ne Pouvez pas Demandé plus de 3 jours d\'absence'
                );
                return $this->render('DemandesBundle:Demande:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView()
                ));
            } else {
                // die();
                $em->flush();

                // return $this->redirect($this->generateUrl('demande_edit', array('id' => $id)));
                $this->addFlash(
                    'notice',
                    'Demande modifiée avec Succès'
                );
                return $this->redirect($this->generateUrl('demande_send'));
            }
        }

        return $this->render('DemandesBundle:Demande:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Demande entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DemandesBundle:Demande')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Demande entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('demande'));
    }

    /**
     * Creates a form to delete a Demande entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demande_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function testAction()
    {
        $this->addFlash(
            'notice',
            'Test'
        );
        return $this->redirect($this->generateUrl('demande'));
    }

    private function createNumeriseForm(Demande $entity, $id)
    {
        $form = $this->createForm(new DemandeNumeriseType(), $entity, array(
            'action' => $this->generateUrl('demande_numerise', array('id' => $id)),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Numériser la demande', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

    /**
     * Displays a form to create a new Demande entity.
     *
     */
    public function saafnewAction(Request $request)
    {

        $demande = new Demande();
        $securityContext = $this->container->get('security.context');
        $form = $this->createForm(new DemandeSaafType(), $demande, array(
            'action' => $this->generateUrl('demande_saaf_new'),
            'method' => 'POST',
            'agent' => $this->getUser()->getAgent(),
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Enregistrer la demande',
            'attr' => array('class' => 'btn btn-success col-md-6')
        ));


        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $avis = new Avis();
            $avis->setDemande($demande);
            $avis->setAgent($this->getUser()->getAgent());
            $avis->setEtat(3); //Initi� et approuv� Saaf
            $em->persist($avis);
            $demande->setAvis($avis);


            $msg = $this->checkDemande($em, $demande, $this->getUser()->getRoles());
            if ($msg) {
                $this->addFlash(
                    'error',
                    $msg
                );
            }

            $demande->setEtatEmmission(0); //Etat de base de l'émission
            $demande->setEtatNotification(0);
            //Retrouver le Supérieur de l'agent en fonction du rôle et de la direction de l'agent
            //En fonction de sa demande
            $superieur = $this->get('ediligence.fonctiondebase')->retour_superieur();
            //dump($superieur); die;
            /////////////Envoi de Demande Pour Une Direction //////////

            $type = $demande->getTypeDemande()->getId();

            switch ($type) {
                    //Autorisation d'absence
                case 1:
                    $demande->setSupDir($superieur['sup1']);
                    $demande->setEtatRepSupDir(0);

                    $demande->setSupDir2($superieur['sup2']);
                    $demande->setEtatRepSupDir2(0);

                    $demande->setGrh($superieur['sup3']);
                    $demande->setEtatRepGrh(0);
                    break;

                default:
                    $demande->setGrh($superieur['sup3']);
                    $demande->setEtatRepGrh(0);
                    break;
            }

            //$superieur=$em->getRepository('AgentBundle:Agent')->find('989609M');
            /*if (!$superieur) {
                throw $this->createNotFoundException(':-( Aucun Supérieur trouvé pour ce Agent');
            }*/

            $positionnment = $this->get('Ediligence.fonctiondebase')->positionnement();
            $demande->setPositionnement($positionnment);
            $em->flush();
            return $this->redirect($this->generateUrl('demande_initier_liste'));
        }


        return $this->render('DemandesBundle:Demande:saafnew.html.twig', array(
            'demande' => $demande,
            'form' => $form->createView(),
        ));
    }
    public function initAction()
    {
        $em = $this->getDoctrine()->getManager();


        $liste = $em->getRepository('DemandesBundle:Demande')->findInit($this->getUser());
        return $this->render('DemandesBundle:Demande:listInit.html.twig', array(
            'liste' => $liste,

        ));
    }
    public function checkDemande($em, $demande, $role = null)
    {

        $ok = new \DateTime();
        $today = new \DateTime($ok->format('Y-m-d'));
        $msg = null;
        $type = $demande->getTypeDemande()->getId();

        $datedebut = $demande->getDateDeb();
        $datefin = $demande->getDateFin();
        $interval = 3;
        $interval2 = -1;
        if ($datedebut && $datefin) {
            $interval = $datedebut->diff($datefin)->format('%R%a');
        }
        if ($datedebut) {
            $interval2 = $today->diff($datedebut)->format('%R%a');
        }

        $delai = $em->getRepository('DemandesBundle:Quota')->findOneBy(['typeDemande' => $type])->getNbreJoursAvant();

        $err = 0;
        if ($interval < 0) {
            $msg = "Vous ne pouvez pas choisir de date de fin antérieur à la date de début";
            $err = 1;
        } elseif ($interval > 2) {
            $msg = "Vous ne pouvez pas Demander plus de 03 jours d\'absence";
            $err = 1;
        } elseif ($interval2 < 0) {
            $msg = "Vous ne pouvez pas choisir de date antérieur à aujourd\'hui";
            $err = 1;
        } elseif ($interval2 < $delai) {
            $msg = "Vous devez faire votre demande ' . $delai . ' jour(s) avant votre départ";
            $err = 2;
        }

        if ($err == 2 && $role != null && in_array('ROLE_SAAF', $role)) {
            $msg = null;
        }
        return $msg;
    }

    public function abscenceAction($id = 0, request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $superieur = $this->get('ediligence.fonctiondebase')->retour_superieur();

        $listeabscence = $em->getRepository('DemandesBundle:Demande')->findexceptabscence($this->getUser());
        if ($id != 0) {
            $entity = $em->getRepository('DemandesBundle:Demande')->findOneBy(['id' => $id]);
        } else {
            $entity = new Demande();
        }

        $matricule = $this->getUser();
        $form = $this->createexceptionabsForm($entity, $matricule, $superieur);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($entity->getTypeDemande()->getId() == 6) {
                $entity->setPiecejointe(null);
            }

            if ($this->getUser()->hasRole('ROLE_SAAF')) {
                $SupDir = $superieur['sup1'];
                $SupDir2 = $superieur['sup2'];
                $entity_avis = new Avis();
                $entity_avis->setDate(new \DateTime('now'));
                $entity_avis->setAgent($matricule->getAgent());
                $entity_avis->setConge(null);
                $entity_avis->setDemande($entity);
                $entity_avis->setEtat(1);
                $em->persist($entity_avis);
            } else {
                $SupDir = $this->getUser()->getAgent();
                $SupDir2 = $superieur['sup2'];
            }

            if ($entity->getTypeDemande()->getId() == 6) { //exceptionnelle
                $s = $this->get('ediligence.fonctiondebase')->calculdate($entity->getDateDeb()->format('Y-m-d'), 1, 1);
                $entity->setDateFin($s);
            }

            $Grh = $em->getRepository('AgentBundle:Agent')->findgrh();
            $positionnment = $this->get('Ediligence.fonctiondebase')->positionnement();

            $entity->setEtatEmmission(2);
            $entity->setGrh($Grh);
            $entity->setDateRepSupDir(new \DateTime('now'));
            $entity->setEtatRepSupDir(1);
            $entity->setDateRepSupDir2(new \DateTime('now'));
            $entity->setEtatRepSupDir2(1);
            $entity->setDateRepGrh(new \DateTime('now'));
            $entity->setEtatRepGrh(1);
            $entity->setEtatEncours(1);
            $entity->setEtatArchive(0);
            $entity->setSigneActe(0);
            $entity->setEtatVal(0);
            $entity->setSupDir($SupDir);
            $entity->setSupDir2($SupDir2);
            $entity->setEtatInterim(0);
            $entity->setMatValidSup1($SupDir);
            $entity->setMatValidSup2($SupDir2);
            $entity->setMatValidRh($Grh);
            $entity->setEtatDeleguation(0);
            $entity->setEtatImpression(2);
            $entity->setPositionnement($positionnment);
            if ($this->getUser()->hasRole('ROLE_SAAF')) {
                $entity->setAvis($entity_avis);
            }
            $entity->setEtatNotification(0);

            $em->persist($entity);
            $em->flush();

            $this->addFlash('notice', 'demande validée avec succès');
            return $this->redirectToroute('demande_abscence');
        }

        return $this->render('DemandesBundle:Demande:abscencerecord.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'listeabscence' => $listeabscence,
        ));
    }

    private function createexceptionabsForm(Demande $entity, $matricule, $superieur)
    {
        $form = $this->createForm(new AbscencerecordType($matricule, $superieur), $entity, array(
            'action' => $this->generateUrl('demande_abscence'),
            'method' => 'POST',
        ));

        return $form;
    }

    public function receiveAction($action)
    {
        //die;
        $em = $this->getDoctrine()->getManager();
        $deleguation = $this->getDeleguation("demande_receive", "action:default");
        $deleguation_other = $this->getDeleguation("demande_receive", "action:other");
        $deleguation_print = $this->getDeleguation("demande_receive", "action:print");
        $deleguation_scan = $this->getDeleguation("demande_receive", "action:scan");

        $Direction = $this->getUser()->getAgent()->getDirection();
        $user = $this->getUser();


        //die;
        /*
          if (!$user->hasRole("ROLE_RESPO") or $deleguation_other==0 or $deleguation_print==0 or $deleguation_print==0) {
          throw $this->createAccessDeniedException('Vous n\'avez pas accès a cette pages !');
          } */
        $typeD = $em->getRepository('DemandesBundle:TypeDemande')->findAll();
        $tab = [];
        foreach ($typeD as $t) {
            # code...
            $tab[] = $t->getId();
        }
        //dump($tab); die;
        switch ($action) {
            case 'other':
                $absence = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 1, $user, 0, $deleguation_other);
                $attestation = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 2, $user, 3, $deleguation_other);
                $certificat = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 2, $user, 4, $deleguation_other);
                $hors = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 2, $user, 5, $deleguation_other);
                $archive = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 3, $user, 0, $deleguation_other);
                $cabinet = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 6, $user, 1, $deleguation_other);
                //dump($absence); dump($archive);die;
                return $this->render('DemandesBundle:Demande:receiveOther.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'archive' => $archive,
                    'deleguation' => $deleguation_other['retour'],
                    'cabinet' => $cabinet,
                    'hors' => $hors,
                ));
                break;
            case 'print':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 1, $deleguation_print, 1);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 3, $deleguation_print, 1);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 4, $deleguation_print, 1);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 5, $deleguation_print, 1);
                $reimprimer = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, $tab, $deleguation_print, 2);
                //dump($reimprimer); //die;
                //$reimprimer = null;
                return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'reimprimer' => $reimprimer,
                    'deleguation' => $deleguation_print['retour'],
                    'hors' => $hors,
                ));
                break;
            case 'scan':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 5, $user, 1, $deleguation_scan);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 5, $user, 3, $deleguation_scan);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 5, $user, 4, $deleguation_scan);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 5, $user, 5, $deleguation_scan);

                return $this->render('DemandesBundle:Demande:demande_scan_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'deleguation' => $deleguation_scan['retour'],
                    'hors' => $hors,
                ));
                break;
            case 'print':
                $absence = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 1, $deleguation_print);
                $attestation = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 3, $deleguation_print);
                $certificat = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 4, $deleguation_print);
                $hors = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(1, 4, $user, 5, $deleguation_print);

                return $this->render('DemandesBundle:Demande:demande_list_print.html.twig', array(
                    'absence' => $absence,
                    'attestation' => $attestation,
                    'certificat' => $certificat,
                    'deleguation' => $deleguation_print['retour'],
                    'hors' => $hors,
                ));
                break;
            default:
                $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(2, 1, $user, 0, $deleguation);
                $archive = $em->getRepository('DemandesBundle:Demande')->findDemandeReceives(2, 2, $user, 0, $deleguation);
                //dump($entities); die;
                return $this->render('DemandesBundle:Demande:receive.html.twig', array(
                    'entities' => $entities,
                    'archive' => $archive,
                    'deleguation' => $deleguation['retour'],
                ));
                break;
        }
        /* $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive($user);
          $entitie = $em->getRepository('DemandesBundle:Demande')->findDemandeReceiveSRHMG();
          $entiti = $em->getRepository('DemandesBundle:Demande')->findDemandeReceiveSRHMG2(); */



        //dump($entitie); dump($entities);
    }

    public function researchAction($matricule = null)
    {
        $em = $this->getDoctrine()->getManager();
        $delegu = -1;


        if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('demande_research')['retour'] == 0) {
            $delegu = 0;
        } else {
            throw $this->createNotFoundException('Vous n\'avez pas droit à cette page.');
        }

        $form = $this->createForm(new CongesResearchType(), array(
            'action' => $this->generateUrl('demande_research'),
            'method' => 'POST',
        ));


        $request = $this->getRequest();

        $demandes = null;
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            //On vérifie que les valeurs entrées sont correctes

            if ($form->isValid()) {
                $data = $this->getRequest()->request->get('conges_research_form');
                $demandes = $em->getRepository('DemandesBundle:Demande')->findBy(['emmeteur' => $data['agent']], ['datecreation' => 'DESC']);
            }
        }

        return $this->render('DemandesBundle:Demande:research.html.twig', array(
            'demandes' => $demandes,
            'delegu' => $delegu,
            'form' => $form->createView()
        ));
    }


    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$prive=$em->getRepository('DemandesBundle:TypeDemande')->findTypeDemandePrive($matricule);
        $entity = new Demande();
        $matricule = $this->getUser()->getAgent()->getId(); ///Recevra l'action à effectuer en focntion du type choisi

        $form = $this->createDoForm($entity, $matricule);
        $form->handleRequest($request);
        //
        if ($form->isValid()) {

            // $form_agent = $this->createAgentForm(new Agent(), $matricule);
            //dump($form_agent);
            // die;
            // return $this->redirect($this->generateUrl('demande_reply', array('id'=>$entity->getTypeDemande()->getId())));

            $ok = new \DateTime();
            $today = new \DateTime($ok->format('Y-m-d'));
            //dump($today);
            //$type=$entity->getTypeDemande()->getId();
            $type = $form->getData()->getTypeDemande()->getId();

            if ($type == 1 || $type == 5) {
                $datedebut = $form->getData()->getDateDeb();
                $datefin = $form->getData()->getDateFin();
                $interval = $datedebut->diff($datefin)->format('%R%a');

                $interval2 = $today->diff($datedebut)->format('%R%a');
                $delai = $em->getRepository('DemandesBundle:Quota')->findOneBy(['typeDemande' => $type]);
                if ($delai && $this->getUser()->getAgent()->getFonction()->getPriorite() > 7) {
                    $delai = $delai->getNbreJoursAvant();
                }
            } else {
                $interval = null;
                $interval2 = null;
                $delai = null;
            }

            if ($interval < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas choisir de date de fin antérieur à la date de début'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval2 < 0) {
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas choisir de date antérieur à aujourd\'hui'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval2 < $delai && $this->getUser()->getAgent()->getFonction()->getPriorite() > 7) {
                $this->addFlash(
                    'error',
                    'Vous devez faire votre demande ' . $delai . ' jour(s) avant votre départ'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
            } elseif ($interval > 2 && $type != 5 && $this->getUser()->getAgent()->getFonction()->getPriorite() > 7) { //autorisation de sortir du teritoire
                $this->addFlash(
                    'error',
                    'Vous ne pouvez pas Demander plus de 03 jours d\'absence'
                );
                return $this->render('DemandesBundle:Demande:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
                ));
            } else {
                $em = $this->getDoctrine()->getManager();

                $entity->setEmmeteur($this->getUser()->getAgent());
                $entity->setEtatEmmission(0); //Etat de base de l'émission
                $entity->setEtatNotification(0);
                //Retrouver le Supérieur de l'agent en fonction du rôle et de la direction de l'agent
                //En fonction de sa demande
                $superieur = $this->get('ediligence.fonctiondebase')->retour_superieur();
                //dump($superieur); die;
                /////////////Envoi de Demande Pour Une Direction //////////
                // dump($this->retour_superieur()); die;

                switch ($type) {
                        //Autorisation d'absence
                    case 1:
                        $entity->setSupDir($superieur['sup1']);
                        $entity->setEtatRepSupDir(0);

                        $entity->setSupDir2($superieur['sup2']);
                        $entity->setEtatRepSupDir2(0);

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;


                    case 2:

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;

                    case 3:

                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;

                    default:
                        $entity->setGrh($superieur['sup3']);
                        $entity->setEtatRepGrh(0);
                        break;
                }

                //$superieur=$em->getRepository('AgentBundle:Agent')->find('989609M');
                if (!$superieur) {
                    throw $this->createNotFoundException(':-( Aucun Supérieur trouvé pour ce Agent');
                }

                /* ajout silue */
                // $positionnement = Positionnement();
                $positionnment = $this->get('Ediligence.fonctiondebase')->positionnement();
                $entity->setPositionnement($positionnment);
                //dump($positionnment);die;
                /* fin ajout silue */

                $em->persist($entity);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Demande enregistrée avec Succès'
                );
                return $this->redirect($this->generateUrl('demande_send'));
            }
            // dump($interval2);
            //die;
            //var_dump($entity->getTypeDemande()->getId()); die;
        }

        return $this->render('DemandesBundle:Demande:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }
}

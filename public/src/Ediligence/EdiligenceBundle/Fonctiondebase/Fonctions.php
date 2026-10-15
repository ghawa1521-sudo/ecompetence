<?php

namespace Ediligence\EdiligenceBundle\Fonctiondebase;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
//use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Agent\AgentBundle\Entity\Tracing;
use Symfony\Component\Security\Core\Role\SwitchUserRole;
use Demandes\DemandesBundle\Entity\Positionnement;

//use Symfony\Component\HttpFoundation\Session\Session;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Fonctions
 *
 * @author simdge
 */
class Fonctions extends Controller
{

    //put your code here
    protected $request;
    protected $em;
    protected $container;
    private $securityContext;
    private $fosUserManager;

    // private $agentMailer;

    public function __construct(EntityManager $entityManager, SecurityContext $securityContext, $request, $fosUserManager, $container)
    {
        $this->em = $entityManager;
        $this->securityContext = $securityContext;
        $this->request = $request;
        $this->fos_user_manager = $fosUserManager;
        $this->container = $container;
        // $this->sentMail=$agentMailer;
    }

    public function retourNotif($req, $tabName)
    {


        return [$tabName => ['list' => $req, 'count' => count($req)]];
    }

    public function getElementAutorisation($agent, $start, $end)
    {

        $em = $this->em;
        $conge = null;
        $conge = $em->getRepository('DemandesBundle:Demande')->getConges($agent, $start, $end);
        $presence = $em->getRepository('DemandesBundle:Demande')->findOneBy(['signeActe' => 1, 'typeDemande' => 3, 'emmeteur' => $agent], ['id' => 'DESC']);

        // return 0;
        return compact('conge', 'presence');
    }

    public function returnSignAut()
    {
        $em = $this->em;
        $user = $this->securityContext->getToken()->getUser();
        $interimeActif = $em->getRepository('AgentBundle:interimaire')->interimDgEncours();
        $retour = null;
        if ($interimeActif) {
            //dump($interimeActif[0]->getInterimaire());
            if ($interimeActif->getInterimaire()->getNomSignature()) {
                $signataire = $interimeActif->getInterimaire()->getNomSignature();
            } else {
                $signataire = $interimeActif->getInterimaire()->concatNom();
            }
            $retour['signataire'] = $signataire;
            $retour['entete'] = "P. le " . $interimeActif->getInterime()->getFonction() . "<br> et par Intérim";
        } else {
            $retour['signataire'] = "SAIN Oguié";
            $retour['entete'] = "Le Directeur Général";
        }
        // dump($retour);
        return $retour;
        //dump($interimaireActif); die;
    }

    public function returnConnect()
    {
        $em = $this->em;
        $user = $this->securityContext->getToken()->getUser();
        if ($this->securityContext->isGranted('ROLE_PREVIOUS_ADMIN')) {

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
        /*
          $em = $this->em;
          $user = $this->securityContext->getToken()->getUser();
          dump($this->container);

          dump($user);
          die;
          if ($user->hasRole('ROLE_PREVIOUS_ADMIN')) {

          foreach ($this->securityContext->getToken()->getRoles() as $role) {
          if ($role instanceof SwitchUserRole) {
          die;
          $interimaire = $role->getSource()->getUser();
          break;
          }
          }

          $agent_interim = $em->getRepository('AgentBundle:Agent')->findOneByMatricule($interimaire->getUsername());
          $validateur = $trc_mat = null;

          if ($agent_interim) {
          $trc_mat = $agent_interim;
          }
          } else {
          //$validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
          $trc_mat = $this->getUser()->getAgent();
          }

          return $trc_mat; */
    }

    public function getTableau($p)
    {
        $tabs = null;
        $tabss = explode(',', $p);
        foreach ($tabss as $t) {

            if (isset($tt) && count($tt) > 2) {
                $tabs[explode(':', $t)[0]] = explode(':', $t)[1];
            }
        }
        return $tabs;
    }

    public function checkDeleguationActive()
    {
        die;
        $em = $this->em;
        $result = 3;
        if ($this->securityContext->getToken() && $this->securityContext->getToken()->getUser() != 'anon.' && $this->securityContext->getToken()->getUser() && !$this->securityContext->getToken()->getUser()->hasRole("ROLE_RESPO_SRHMG")) {
            $route = $routeName = null;
            $request = $this->container->get('request');
            $routeName = $request->get('_route'); //route courante sur laquelle nous sommes
            //$em = $this->loginServ->getEm();
            //Check USer
            $agent = null;
            if ($this->securityContext->getToken()->getUser()) {
                $agent = $this->securityContext->getToken()->getUser()->getAgent();
            } //dump($routeName);


            $rSecure = null;
            $rSecure = $em->getRepository('AgentBundle:Rubriques')->findBy(['route' => $routeName]);
            dump($rSecure);
            die;
            if ($rSecure and $rSecure != null) {

                $routes = $em->getRepository('AgentBundle:Deleguation')->checkRoute($agent->getId(), $routeName);
                $p = null;
                foreach ($routes as $key => $r) {
                    $p .= $r->getRubriques()->getRoute();
                }

                if (count($routes) > 0) {
                    //récupération des paramètre
                    $search_array = $request->attributes->get('_route_params');
                    //Ecrire la Fonction de restiction
                    if (count($p) > 0) {
                        $tabs = $this->getTableau($p);
                        if (isset($tabs)) {



                            foreach ($tabs as $key => $value) {

                                if (isset($search_array[$key])) {
                                    if ($search_array[$key] && $search_array[$key] == $value) {
                                        dump($search_array[$key]);
                                        dump($value);
                                        $result = 0;
                                    }
                                } else {
                                    //throw new NotFoundHttpException("Pas d'accès");
                                    $result = 1;
                                }
                            }
                        }
                    }
                } else {
                    if ($request->get('_route') == null) {
                        $result = 0;
                    } else {
                        //throw new NotFoundHttpException("PAS DE DROIT POUR CETTE PAGE");
                        $result = 1;
                    }
                }
            }
        }
        return $result;
    }

    public function notifErh()
    {
        $em = $this->em;
        $user = $this->securityContext->getToken()->getUser();

        $fonction = $user->getAgent()->getFonction()->getId();

        $agent = $user->getAgent();
        $service_sup = $user->getAgent()->retour_service();
        $matricule = $user->getAgent()->getMatricule();
        //ensemble des Info de Service de l'agent
        $infoService = ($agent->retour_service());
        //Tableau de l'arborscence des service de l'agent
        $TabServ = explode(',', $infoService['tab_imput']);

        //Code Service de l'agent
        $serviceId = $infoService['service'];
        //Libellé du Service
        $serviceLib = $infoService['lib'];
        $niveau = count($TabServ) - 1; //-1 pour retirer la valeur de la Direction

        $Direction = $this->getUser()->getAgent()->getDirection();
        //dump($this); die;

        $role = strtoupper($user->getAgent()->getFonction()->getTypeCompte()->getRoleBase());

        $tab = [];
        $tab['sum_affectation'] = 0;
        $tab['sum_mutation'] = 0;
        $tab['sum_cong_respo'] = 0;
        $tab['sum_demande'] = 0;

        if ($user->hasRole("ROLE_RESPO_SRHMG")) {
            /////////////////////////////////Demande///////////////////////////////
            ///1/Other
            $absence_other = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 1, $user);
            $tab['demande_other_absence']['list'] = $absence_other;
            $tab['demande_other_absence']['count'] = count($absence_other);

            $attestation_other = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 3);
            $tab['demande_other_attestation']['list'] = $attestation_other;
            $tab['demande_other_attestation']['count'] = count($attestation_other);

            $certificat_other = $entities = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 2, $user, 4);
            $tab['demande_other_certificat']['list'] = $certificat_other;
            $tab['demande_other_certificat']['count'] = count($certificat_other);

            $tab['demande_other'] = count($absence_other) + count($attestation_other) + count($certificat_other);

            ///2/print
            $absence_print = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 1, null, 1);
            $tab['demande_print_absence']['list'] = $absence_print;
            $tab['demande_print_absence']['count'] = count($absence_print);

            $attestation_print = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 3, null, 1);
            $tab['demande_print_certificat']['list'] = $attestation_print;
            $tab['demande_print_certificat']['count'] = count($attestation_print);

            $certificat_print = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 4, $user, 4, null, 1);
            $tab['demande_print_certificat']['list'] = $certificat_print;
            $tab['demande_print_certificat']['count'] = count($certificat_print);

            $tab['demande_print'] = count($absence_print) + count($attestation_print) + count($certificat_print);


            ///3/scan
            $absence_scan = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 1);
            $tab['demande_scan_absence']['list'] = $absence_scan;
            $tab['demande_scan_absence']['count'] = count($absence_scan);

            $attestation_scan = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 3);
            $tab['demande_scan_certificat']['list'] = $attestation_scan;
            $tab['demande_scan_certificat']['count'] = count($attestation_scan);

            $certificat_scan = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(1, 5, $user, 4);
            $tab['demande_scan_certificat']['list'] = $certificat_scan;
            $tab['demande_scan_certificat']['count'] = count($certificat_scan);

            $tab['demande_scan'] = count($absence_scan) + count($attestation_scan) + count($certificat_scan);

            $tab['sum_demande'] = $tab['demande_other'] + $tab['demande_print'] + $tab['demande_scan'];
            //::::::::::::::::::::::::::::::Fin Demande:::::::::::::::::::::::::::
            /////////////////////////////////Mutation///////////////////////////////////
            $mutation_rh = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(0);
            $tab['mutation_valid_rh']['list'] = $mutation_rh;
            $tab['mutation_valid_rh']['count'] = count($mutation_rh);


            //imprimer
            $mutation_print = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(2);
            $tab['mutation_print']['list'] = $mutation_print;
            $tab['mutation_print']['count'] = count($mutation_print);

            //imprimer
            $mutation_scan = $em->getRepository('AgentBundle:Mutation')->findMutationReceiveSRHMG(2);
            $tab['mutation_scan']['list'] = $mutation_scan;
            $tab['mutation_scan']['count'] = count($mutation_scan);



            $tab['sum_mutation'] = count($mutation_rh) + count($mutation_print) + count($mutation_scan);

            /////////////////////////////////Fin Mutation///////////////////////////////////
            /////////////////////////////////Conge/////////////////////////////////////////
            //RÃ©cupÃ©rer Le matricule de DGE
            $dge = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
            $conge_agentdge = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $dge->getCodeDg()->getCodeDg(), 0, [0, 1, 3], 1, $dge); //1 pour dire encour //Service du Responsable
            $tab['conge_agentdge']['list'] = $conge_agentdge;
            $tab['conge_agentdge']['count'] = count($conge_agentdge);
            //$tab['sum_cong_respo'] += count($conge_agentdge);
            //$conge_autre_service = $em->getRepository('AgentBundle:Conges')->findCongeParam(1, $serviceId, $niveau, [0, 1], 1); //1 pour dire encour //Service du Responsable //Service du Responsable;
            //$tab['conge_autre_service']['list'] = $conge_autre_service;
            //$tab['conge_autre_service']['count'] = count($conge_autre_service) + count($conge_agentdge);
            //$tab['sum_cong_respo'] += count($conge_autre_service) + count($conge_agentdge);
            $conge_autre_service = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 2); //1 pour dire encour //Service du Responsable //Service du Responsable;
            $tab['conge_autre_service']['list'] = $conge_autre_service;
            $tab['conge_autre_service']['count'] = count($conge_autre_service);

            $conge_respo_service = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 10); //1 pour dire encour //Service du Responsable //Service du Responsable;
            $conge_mon_service_repriseo = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11);
            $tab['conge_respo_service']['list'] = $conge_respo_service;
            $tab['conge_respo_service']['count'] = count($conge_respo_service) + count($conge_mon_service_repriseo);

            //
            $conge_autre_joindre = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 8); //1 pour dire encour //Service du Responsable //Service du Responsable;
            $tab['conge_autre_joindre']['list'] = $conge_autre_joindre;
            $tab['conge_autre_joindre']['count'] = count($conge_autre_joindre);

            $conge_autre_bac = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 7); //1 pour dire encour //Service du Responsable //Service du Responsable;
            $tab['conge_autre_bac']['list'] = $conge_autre_bac;
            $tab['conge_autre_bac']['count'] = count($conge_autre_bac);


            $tab['sum_cong_respo'] += count($conge_autre_service) + count($conge_autre_joindre) + count($conge_autre_bac) + count($conge_respo_service) + count($conge_mon_service_repriseo);;
            ////////////////////////////////Fin Conges///////////////////////////////////
            //
            ///////////////////////////////////Affectation////////////////////////////////
            $affectation_attente = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($user, 0, 0);
            $tab['affectation_attente']['list'] = $affectation_attente;
            $tab['affectation_attente']['count'] = count($affectation_attente);

            //impression note
            $affectation_impression = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0);
            $tab['affectation_impression']['list'] = $affectation_impression;
            $tab['affectation_impression']['count'] = count($affectation_impression);

            //num_note
            $affectation_num_note = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0);
            $tab['affectation_num_note']['list'] = $affectation_num_note;
            $tab['affectation_num_note']['count'] = count($affectation_num_note);


            //impression note
            $affectation_imprim_cert = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, 0);
            $tab['affectation_imprim_note']['list'] = $affectation_imprim_cert;
            $tab['affectation_imprim_note']['count'] = count($affectation_imprim_cert);

            //numerisation certificat
            $affectation_num_cert = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, 0);
            $tab['affectation_num_cert']['list'] = $affectation_num_cert;
            $tab['affectation_num_cert']['count'] = count($affectation_num_cert);

            $tab['sum_affectation'] = count($affectation_attente) + count($affectation_impression) + count($affectation_num_note) + count($affectation_imprim_cert) + count($affectation_num_cert);
        }

        if ($user->hasRole("ROLE_RESPO") || $user->hasRole("ROLE_RESPO_SRHMG")) {

            /////**********************************Affectation****************************************************** */
            //validation prise de service
            $affectation_valid = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 1, 0, 1);
            //$em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 1, 0, 1, $this->getDeleguation("affecter_list_valid"))
            //dump($affectation_valid); die;
            $tab['affectation_valid']['list'] = $affectation_valid;
            $tab['affectation_valid']['count'] = count($affectation_valid);
            $tab['sum_affectation'] += count($affectation_valid);
            ///*********************************Fin Affectation****************************************************** */
            ////////////////////////////////////Demande//////////////////////////////////////////////////////////
            $demande_perso = $em->getRepository('DemandesBundle:Demande')->findDemandeReceive(2, 1, $user);
            $tab['demande_perso']['list'] = $demande_perso;
            $tab['demande_perso']['count'] = count($demande_perso);

            $tab['sum_demande'] += count($demande_perso);
            ////////////////////////////////////Fin Demande/////////////////////////////////////////////////////
            //Mutation
            $mutation_respo = $em->getRepository('AgentBundle:Mutation')->findMutationReceive($user, 0);
            $tab['mutation_valid_respo']['list'] = $mutation_respo;
            $tab['mutation_valid_respo']['count'] = count($mutation_respo);
            $tab['sum_mutation'] += count($mutation_respo);

            /*             * **************************** */
            //Conge
            //cour_arr
            //$conge_mon_service = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $serviceId, $niveau, [0, 1, 3], 1, $agent);
            $conge_mon_service = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent);
            if ($agent && $agent->getFonction() && $agent->getFonction()->getId() == 10) {
                $conge_mon_service = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 10);
            }
            //Service du Responsable;
            $tab['conge_mon_service']['list'] = $conge_mon_service;
            $tab['conge_mon_service']['count'] = count($conge_mon_service);
            $conge_mon_service_reprise = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 4);

            if ($agent && $agent->getFonction() && $agent->getFonction()->getId() == 10) {
                $conge_mon_service_reprise = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11);
            }

            //Service du Responsable;
            $tab['conge_mon_service_reprise']['list'] = $conge_mon_service_reprise;
            $tab['conge_mon_service_reprise']['count'] = count($conge_mon_service_reprise);



            $tab['sum_cong_respo'] += count($conge_mon_service) + count($conge_mon_service_reprise);
        }
        if ($user->hasRole("ROLE_AGENT") || $user->hasRole("ROLE_RESPO") || $user->hasRole("ROLE_RESPO_SRHMG")) {


            //Demande

            /*             * **************************** */
            //Mutation

            /*             * **************************** */
            //Conge
            //conge_actif
            $conge_actif = $em->getRepository('AgentBundle:Conges')->findBy(array('agent' => $agent, 'etat' => [0, 1]), array('id' => 'desc'));
            $tab['conge_actif']['list'] = $conge_actif;
            $tab['conge_actif']['count'] = count($conge_actif);
            $tab['sum_cong_perso'] = count($conge_actif);
        }
        return $tab;
    }

    public function countNotifErh()
    { }

    public function superieur_agent()
    {

        $user = $this->securityContext->getToken()->getUser();
        $fonction = $user->getAgent()->getFonction()->getId();
        $service = $user->getAgent()->retour_service();

        $sup = null;

        if ($fonction > 0) {
            switch ($fonction) {
                case '1':
                    $critere = 'a.Fonction >2';
                    break;
                case '2':
                    $critere = 'a.Fonction >2';
                    break;
                case '3':
                    $critere = 'a.Fonction >3';
                    break;
                case '4':
                    $critere = 'a.Fonction >5';
                    break;
                case '5':
                    $critere = 'a.Fonction >5';
                    break;
                case '6':
                    $critere = 'a.Fonction >6';
                    break;
                case '7':
                    $critere = 'a.Fonction >7';
                    break;
                case '8':
                    $critere = 'a.Fonction = 10';
                    break;
                case '9':
                    $critere = 'a.Fonction = 10';
                    break;
                case '10':
                    $critere = 'a.Fonction = 10';
                    break;
            }

            $criter = '';
            foreach (explode(',', $service['tab_imput']) as $tab) {
                switch (substr($tab, 0, 2)) {
                    case 'DG':
                        $criter = $criter . " a.code_dg = '" . $tab . "' And ";
                        break;
                    case 'DC':
                        $criter = $criter . " a.code_dc = '" . $tab . "' And ";
                        break;
                    case 'SD':
                        $criter = $criter . " a.code_sd = '" . $tab . "' And ";
                        break;
                    case 'SC':
                        $criter = $criter . " a.code_sc = '" . $tab . "' And ";
                        break;
                }
            }

            $crit = $criter . $critere;
            $tri = "a.Fonction";

            $em = $this->em;
            $sup = $em->getRepository('AgentBundle:Agent')->findsupBy($crit, $tri, $service['tab_imput'], $critere);
        }

        return $sup;
    }

    public function countNotif($state = 0)
    {
        $em = $this->em;
        $user = $this->securityContext->getToken()->getUser();
        $fonction = $user->getAgent()->getFonction()->getId();
        $service_sup = $user->getAgent()->retour_service();
        $matricule = $user->getAgent()->getMatricule();
        $role = strtoupper($user->getAgent()->getFonction()->getTypeCompte()->getRoleBase());

        $tab = [];
        $tabb = [];

        $tab['cour_arr'] = 0; //
        //$tab['dilig_arr'] = 0;
        $tab['diligtrt'] = 0; //
        $tab['dilig'] = 0; //
        $tab['diligrecu'] = 0; //
        //$tab['coord'] = 0;
        $tab['suivre_dilig'] = 0; //
        //$tab['recu_depart'] = 0;

        $cour_arr = [];
        $diligtrt = [];
        $dilig = [];
        $diligrecu = [];
        $suivre_dilig = [];

        if ($user->hasRole("ROLE_DGE") || $user->hasRole("ROLE_DGA")) {
            $cour_arr = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0, 'typecourrier' => 1, 'servicesaisi' => 'DC0018'));
            $tab['cour_arr'] = count($cour_arr);
        }
        if ($user->hasRole("ROLE_Directeur") || $user->hasRole("ROLE_Sous_Dir_Chef_Sec") || $user->hasRole("ROLE_Charge_etudes") || $user->hasRole("ROLE_Conseillers")) {
            $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
            $tab['diligrecu'] = count($diligrecu);
        }

        if ($user->hasRole("ROLE_DGE") || $user->hasRole("ROLE_DGA") || $user->hasRole("ROLE_Directeur") || $user->hasRole("ROLE_Sous_Dir_Chef_Sec") || $user->hasRole("ROLE_Conseillers")) {
            $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
            $tab['suivre_dilig'] = count($suivre_dilig);
        }
        if ($user->hasRole("ROLE_DGE") || $user->hasRole("ROLE_DGA") || $user->hasRole("ROLE_Directeur") || $user->hasRole("ROLE_Sous_Dir_Chef_Sec") || $user->hasRole("ROLE_Conseillers")) {
            $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
            $tab['diligtrt'] = count($diligtrt);
        }
        if ($user->hasRole("ROLE_Courrier_Interne")) {
            $dilig = $em->getRepository('EdiligenceBundle:Timputations')->reception($service_sup);
            $tab['dilig'] = count($dilig);
        }








        if ($state == 0) {
            return $tab;
        } elseif ($state == 1) {
            $contglobale = count($cour_arr) + count($diligtrt) + count($dilig) + count($diligrecu) + count($suivre_dilig);
            return array(
                'cour_arr' => $cour_arr,
                'diligtrt' => $diligtrt,
                'dilig' => $dilig,
                'diligrecu' => $diligrecu,
                'suivre_dilig' => $suivre_dilig,
                'compteur' => $contglobale
            );
        }

        /*
          if ($user->hasRole("ROLE_DGE")) {

          //cour_arr
          $cour_arr = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0, 'typecourrier' => 1, 'servicesaisi' => 'DC0018'));
          $tab['cour_arr'] = count($cour_arr);

          //dilig_arr
          $dilig_arr = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0, 'typecourrier' => 2, 'servicesaisi' => 'DC0018'));
          $tab['dilig_arr'] = count($dilig_arr);

          //diligtrt
          $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
          $tab['diligtrt'] = count($diligtrt);
          //suivre_dilig
          $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
          $tab['suivre_dilig'] = count($suivre_dilig);
          } elseif ($user->hasRole("ROLE_Courrier_Interne")) {

          $dilig = $em->getRepository('EdiligenceBundle:Timputations')->reception($service_sup);
          $tab['dilig'] = count($dilig);

          $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
          $tab['suivre_dilig'] = count($suivre_dilig);
          } elseif ($user->hasRole('ROLE_SOUS_DIR_CHEF_SEC')||$user->hasRole('ROLE_DIRECTEUR')||$user->hasRole( 'ROLE_DGA')) {

          //diligtrt
          $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
          $tab['diligrecu'] = count($diligrecu);

          $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
          $tab['diligtrt'] = count($diligtrt);

          //$coord = $em->getRepository('EdiligenceBundle:Timputations')->compiler($service_sup['service'], $matricule);
          //$tab['coord'] = count($coord);

          $recu_depart = $em->getRepository('EdiligenceBundle:Tcourrier')->find_depart_recu($service_sup['service']);
          $tab['recu_depart'] = count($recu_depart);

          $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
          $tab['suivre_dilig'] = count($suivre_dilig);
          } elseif ($user->hasRole("ROLE_Charge_etudes")) {

          //diligtrt
          $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
          $tab['diligtrt'] = count($diligtrt);

          //diligtrt
          $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
          $tab['diligrecu'] = count($diligrecu);

          $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
          $tab['suivre_dilig'] = count($suivre_dilig);
          }elseif ($user->hasRole("ROLE_Conseillers")) {

          //diligtrt
          $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
          $tab['diligtrt'] = count($diligtrt);

          //diligtrt
          $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
          $tab['diligrecu'] = count($diligrecu);

          $suivre_dilig = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_sup['service'], $matricule, $user);
          $tab['suivre_dilig'] = count($suivre_dilig);
          }
         */
    }

    public function Notif()
    {

        $em = $this->em;
        $user = $this->securityContext->getToken()->getUser();
        $fonction = $user->getAgent()->getFonction()->getId();
        $service_sup = $user->getAgent()->retour_service();
        $matricule = $user->getAgent()->getMatricule();
        $role = strtoupper($user->getAgent()->getFonction()->getTypeCompte()->getRoleBase());

        $tab = [];


        if ($user->hasRole("ROLE_DGE")) {

            //cour_arr
            $cour_arr = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0, 'typecourrier' => 1, 'servicesaisi' => 'DC0018'));
            $tab['tcourrier'] = $cour_arr;

            //dilig_arr
            $dilig_arr = $em->getRepository('EdiligenceBundle:Tcourrier')->findBy(array('etatcourrier' => 0, 'typecourrier' => 2, 'servicesaisi' => 'DC0018'));
            $tab['tcourrier'] = array_merge($tab['tcourrier'], $dilig_arr);

            //diligtrt
            $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
            $tab['tmp_traitement'] = $diligtrt;
        } elseif ($user->hasRole("ROLE_Courrier_Interne")) {

            $dilig = $em->getRepository('EdiligenceBundle:Timputations')->reception($service_sup);
            $tab['dilig'] = count($dilig);
        } elseif ($user->hasRole('ROLE_SOUS_DIR_CHEF_SEC', 'ROLE_DIRECTEUR', 'ROLE_DGA')) {

            //diligtrt
            $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
            $tab['diligrecu'] = count($diligrecu);

            $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
            $tab['diligtrt'] = count($diligtrt);

            $coord = $em->getRepository('EdiligenceBundle:Timputations')->compiler($service_sup['service'], $matricule);
            $tab['coord'] = count($coord);

            $recu_depart = $em->getRepository('EdiligenceBundle:Tcourrier')->find_depart_recu($service_sup['service']);
            $tab['recu_depart'] = count($recu_depart);
        } elseif ($user->hasRole("ROLE_Charge_etudes")) {

            //diligtrt
            $diligtrt = $em->getRepository('EdiligenceBundle:Tmp_traitement')->diligence_traite($matricule, $service_sup['service'], $role);
            $tab['diligtrt'] = count($diligtrt);

            //diligtrt
            $diligrecu = $em->getRepository('EdiligenceBundle:Timputations')->csrecu_traiter($service_sup['service'], $matricule);
            $tab['diligrecu'] = count($diligrecu);
        }

        return $tab;
    }

    public function testonline($file = null, $chemin = null)
    {
        $ip = $this->request->getCurrentRequest();
        $apercu_doc = "apercu";
        $remote_addr = $this->request->getCurrentRequest()->server->get('REMOTE_ADDR');
        $server_name = $this->request->getCurrentRequest()->server->get('SERVER_NAME');
        $class = '<i class="ace-icon fa fa-eye bigger-130"></i>';
        if ($server_name != "e-rh.local") {
            $lien = "https://docs.google.com/viewer?url=https://e-agent.dge.ci/web" . $chemin . "&embedded=true";
            return '<a href="#" onclick=pop_apercu("' . $lien . '")>' . $class . $apercu_doc . '</a>';
        } else {
            $lien = "http://e-rh.local/web/images/document/DGE/#../" . $file;
            return '<a href="#" onclick=pop_apercu("' . $lien . '")>' . $class . $apercu_doc . '</a>';
        }
    }

    /**


     * */
    public function calculdate($date = null, $nbre = 1, $state = 0)
    {
        $date1 = new \Datetime($date);
        $date1->add(new \DateInterval('P' . $nbre . 'D'));

        //Coversion vers le jour ouvrable le plus proche
        $date2 = $this->getWorkDays($date1);
        if ($state == 1) {
            return $date1;
        }
        $date2 = $date2->format('Y-m-d');
        return $date2;
    }

    //Get work Day d-m
    // le paramètre à 0 retourne le jour ouvrable le plus proche
    //le paramètre à 1 retourne
    //true si un jour ouvrable et
    //false si un jour ferrier
    function getWorkDays(\DateTime $date, $state = 0)
    {

        $em = $this->em;

        $rs = true;
        //echo $date->format('Y-m-d');
        //Vérifier les weekend (Dimanche et Samedi)
        $weekDay = date('w', strtotime($date->format('Y-m-d')));
        if ($weekDay == 0 || $weekDay == 6) {
            $rs = false;
            if ($state == 0) {
                $this->getWorkDays($date->modify('+1 day'));
            } //relancer la fonction
        };
        //Vérifier jour ferrier
        //Tableau à charger avec les jours ferier sous le format d-m|d-m
        $joursferrier = [];
        $jfs = $em->getRepository('UsersBundle:Holidays')->findAll();


        foreach ($jfs as $jf) {
            $joursferrier = array_merge($joursferrier, explode('|', $jf->getJours()));
        }

        if (in_array($date->format("d-m"), $joursferrier)) {
            $rs = false;
            if ($state == 0) {
                $this->getWorkDays($date->modify('+1 day'));
            }
        }
        if ($state == 0) {
            return $date;
        } else {
            return $rs;
        }
    }

    /*
      This library includes utility PHP classes to generate linear and bidimensional barcodes:

      C39 : CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9
      C39+ : CODE 39 with checksum
      C39E : CODE 39 EXTENDED
      C39E+ : CODE 39 EXTENDED + CHECKSUM
      C93 : CODE 93 - USS-93
      S25 : Standard 2 of 5
      S25+ : Standard 2 of 5 + CHECKSUM
      I25 : Interleaved 2 of 5
      I25+ : Interleaved 2 of 5 + CHECKSUM
      C128 : CODE 128
      C128A : CODE 128 A
      C128B : CODE 128 B
      C128C : CODE 128 C
      EAN2 : 2-Digits UPC-Based Extension
      EAN5 : 5-Digits UPC-Based Extension
      EAN8 : EAN 8
      EAN13 : EAN 13
      UPCA : UPC-A
      UPCE : UPC-E
      MSI : MSI (Variation of Plessey code)
      MSI+ : MSI + CHECKSUM (modulo 11)
      POSTNET : POSTNET
      PLANET : PLANET
      RMS4CC : RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
      KIX : KIX (Klant index - Customer index)
      IMB : IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200
      IMBPRE : IMB - Intelligent Mail Barcode - Onecode - USPS-B-3200- pre-processed
      CODABAR : CODABAR
      CODE11 : CODE 11
      PHARMA : PHARMACODE
      PHARMA2T : PHARMACODE TWO-TRACKS
      DATAMATRIX : DATAMATRIX (ISO/IEC 16022)
      PDF417 : PDF417 (ISO/IEC 15438:2006)
      QRCODE : QR-CODE
      RAW : 2D RAW MODE comma-separated rows
      RAW2 : 2D RAW MODE rows enclosed in square parentheses

      Output Formats

      PNG Image
      SVG Image
      HTML DIV
      Unicode String
      Binary String

     *
     *      */

    //$barcode= $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'www.safric.xyz', -4, -4, 'black', [-2,-2,-2,-2],'white');

    function barcode($qrcode, $value, $barheight, $barwidth, $color, $tab, $bgcolor)
    {
        $barecode = new \Com\Tecnick\Barcode\Barcode();


        $bobj = $barecode->getBarcodeObj(
            $qrcode, // barcode type and additional comma-separated parameters
            $value, // data string to encode
            $barheight, // bar width (use absolute or negative value as multiplication factor)
            $barwidth, // bar height (use absolute or negative value as multiplication factor)
            $color, // foreground color
            $tab           // padding (use absolute or negative values as multiplication factors)
        )->setBackgroundColor($bgcolor); // background color

        return $bobj->getHtmlDiv();
    }

    function addTracing($libelle = null, $matricule = null, $route = null, $entites = null, $id = null, $level = 0)
    {
        $em = $this->em;
        $ip = $this->get_ip(); //HTTP_USER_AGENT

        $os = $this->get_device() . ' ' . $this->get_os() . ' ' . $this->get_browser();
        //$ip=$this->request->headers->get('User-Agent');
        // dump($ip);
        // dump($os);
        //die();
        $entity = new Tracing();

        $entity->setLibelleAction($libelle);
        $entity->setMatricule($matricule);
        $entity->setRoute($route);
        $entity->setLevel($level);
        $entity->setEntite($entites);
        $entity->setEntityId($id);
        $entity->setSystemeExploitation($os);
        $entity->setAddresseIp($ip);
        //  die;
        $em->persist($entity);
        // dump($entity);die;
        $em->flush($entity);

        return true;
    }

    private function get_user_agent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function get_ip()
    {
        $mainIp = '';
        if (getenv('HTTP_CLIENT_IP'))
            $mainIp = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $mainIp = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $mainIp = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $mainIp = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $mainIp = getenv('REMOTE_ADDR');
        else
            $mainIp = 'UNKNOWN';
        return $mainIp;
    }

    public function get_os()
    {

        $user_agent = $this->get_user_agent();
        //dump($user_agent);
        $os_platform = "Unknown OS Platform";
        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android 8/i' => 'Android 8 Oreo',
            '/android 7/i' => 'Android 7 Nougat',
            '/android 6/i' => 'Android 6 Marshmallow',
            '/android 5/i' => 'Android 5 Lollipop',
            '/android 4.4/i' => 'Android 4.4 KitKat',
            '/android 4.3/i' => 'Android 4.3 Jelly Bean',
            '/android 4.2/i' => 'Android 4.2 Jelly Bean',
            '/android 4.1/i' => 'Android 4.1 Jelly Bean',
            '/android 4.0/i' => 'Android 4.0 Ice Cream Sandwich',
            '/android 3/i' => 'Android 3 Honeycomb',
            '/android 2/i' => 'Android 2',
            '/android 1/i' => 'Android 1',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }
        return $os_platform;
    }

    public function get_browser()
    {

        $user_agent = $this->get_user_agent();

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/Trident/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Google Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/ubrowser/i' => 'UC Browser',
            '/mobile/i' => 'Navigateur Mobile'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

    public function get_device()
    {

        $tablet_browser = 0;
        $mobile_browser = 0;

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $tablet_browser++;
        }

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($this->get_user_agent(), 0, 4));
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda ', 'xda-'
        );

        if (in_array($mobile_ua, $mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($this->get_user_agent()), 'opera mini') > 0) {
            $mobile_browser++;
            //Check for tablets on opera mini alternative headers
            $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']) ? $_SERVER['HTTP_X_OPERAMINI_PHONE_UA'] : (isset($_SERVER['HTTP_DEVICE_STOCK_UA']) ? $_SERVER['HTTP_DEVICE_STOCK_UA'] : ''));
            if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
                $tablet_browser++;
            }
        }

        if ($tablet_browser > 0) {
            // do something for tablet devices
            return 'Tablette';
        } else if ($mobile_browser > 0) {
            // do something for mobile devices
            return 'Mobile';
        } else {
            // do something for everything else
            return 'Ordinateur';
        }
    }

    public function passwordCreate()
    {
        for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != 8; $x = rand(0, $z), $s .= $a{
            $x}, $i++);
        return $s;
    }

    public function creerUser($agent, $param = null)
    {
        //die;
        // dump($this->get('agent_mailer'));
        //dump("a");
        $em = $this->em;
        $password = $this->passwordCreate();
        //dump($password);
        //return $password;

        $userManager = $this->fos_user_manager;
        $user_agent = $userManager->createUser();
        //dump($user_agent);
        //die;
        $user_agent->setUsername($agent->getMatricule());
        $user_agent->setEmail($agent->getEmail());
        $user_agent->setPlainPassword($password);
        $user_agent->setEnabled(TRUE);
        // dump($agent); die;
        //$agent->getRole()->getRoleBase()
        switch ($agent->getFonction()->getId()) {

            case 5:
                $user_agent->addRole("ROLE_RESPO");
                break;

            case 7:
                $user_agent->addRole("ROLE_RESPO");
                break;

            default:
                $user_agent->addRole("ROLE_AGENT");
                break;
        }

        $user_agent->addRole("ROLE_ERH");
        $user_agent->addRole("ROLE_BIBLIO");
        $user_agent->addRole("ROLE_EDILIGENCE");
        $agent->setUsers($user_agent);
        $em->persist($agent);

        $user_agent->setAgent($agent);
        $em->flush();

        //envoi E-mail
        $mailer = $this->container->get('agent_mailer')->agentConfirm($user_agent, $password, $param);
        //die;
        return $mailer;
    }

    public function retour_superieur($user = null)
    {



        $em = $this->em;
        if ($user == null) {
            $user = $this->securityContext->getToken()->getUser();
        }


        $direction = $user->getAgent()->getDirection();
        $tab_service = $user->getAgent()->retour_service()['tab_imput'];
        //dump($user->getAgent()->retour_service());die;
        $superieur1 = "";
        $superieur2 = "";
        $superieur3 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 5, 'Direction' => 3]);
        /////////////Envoi de Demande Pour Un Service Rattaché //////////
        if ($direction->getEtatDirection() == 0) {
            //Responsable Ressources Humaines
            if (($user->hasRole('ROLE_RESPO_SRHMG')) and ($user->getAgent()->getFonction()->getId() == 5)) {
                //Sup 1 & 2 DG
                $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                $superieur2 = $superieur1;
            }
            //Chef de Service Rattaché
            elseif (($user->hasRole('ROLE_RESPO')) and ($user->getAgent()->getFonction()->getId() == 5)) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                $superieur2 = $superieur1;
            }
            //Chef de Section
            elseif (($user->hasRole('ROLE_RESPO')) and ($user->getAgent()->getFonction()->getId() == 3)) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 5,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $superieur1;
            }
            //Agent
            else {

                //Agent Dans une Section
                if (stristr($tab_service, 'SD') == TRUE) {
                    $superieur1 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 3,
                                'code_sd' => $user->getAgent()->getCodeSd()
                            ]
                        );
                    $superieur2 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 5,
                                'Direction' => $user->getAgent()->getDirection()->getId()
                            ]
                        );
                }
                //AGent Rattaché au Chef de Service
                elseif (stristr($tab_service, 'SD') == FALSE) {
                    $superieur1 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 5,
                                'Direction' => $user->getAgent()->getDirection()->getId()
                            ]
                        );
                    $superieur2 = $superieur1;
                }
            }
            if ($superieur1 == null) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 5,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $superieur1;
            }
        }
        /////////////Fin Envoi de Demande Pour Un Service Rattaché //////////
        /////////////Envoi de Demande Pour Une Direction //////////
        elseif ($direction->getEtatDirection() == 1) {
            //Directeur

            if (($user->hasRole('ROLE_RESPO')) and ($user->getAgent()->getFonction()->getId() == 7)) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                $superieur2 = $superieur1;
            }
            //Sous-Directeur
            elseif (($user->hasRole('ROLE_RESPO')) and ($user->getAgent()->getFonction()->getId() == 6)) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 7,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $superieur1;
            }
            //Chef de Service
            elseif (($user->hasRole('ROLE_RESPO')) and ($user->getAgent()->getFonction()->getId() == 4)) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 6,
                            'code_sd' => $user->getAgent()->getCodeSd()
                        ]
                    );
                $superieur2 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 7,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
            }
            //Agent
            else {

                //Agent dans un Service
                if (stristr($tab_service, 'SD') == TRUE and stristr($tab_service, 'SC') == TRUE) {

                    $superieur1 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 6,
                                'code_sd' => $user->getAgent()->getCodeSd()
                            ]
                        );
                    $superieur2 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 7,
                                'Direction' => $user->getAgent()->getDirection()->getId()
                            ]
                        );
                }
                //Agent Rattaché à une sous Direction et n'appartenant pas à un Service
                //Secrétaire Sous Directeur, Chargé d'Etudes, etc.
                elseif (stristr($tab_service, 'SD') == TRUE and stristr($tab_service, 'SC') == FALSE) {

                    $superieur1 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 6,
                                'code_sd' => $user->getAgent()->getCodeSd()
                            ]
                        );
                    $superieur2 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 7,
                                'Direction' => $user->getAgent()->getDirection()->getId()
                            ]
                        );
                }
                //Agent Rattaché au Directeur: CT, Secretaire......
                elseif (stristr($tab_service, 'SD') == FALSE and stristr($tab_service, 'SC') == FALSE) {

                    $superieur1 = $em->getRepository('AgentBundle:Agent')
                        ->findOneBy(
                            [
                                'Fonction' => 7,
                                'Direction' => $user->getAgent()->getDirection()->getId()
                            ]
                        );
                    $superieur2 = $superieur1;
                }
            }
            if ($superieur1 == null) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 7,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $superieur1;
            }
        }
        //Agent au cabinet
        else {
            //respo ou membre direct du cabinet//CT
            if ($user->hasRole('ROLE_RESPO') or in_array($user->getAgent()->getDirection()->getId(), [16, 14])) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                $superieur2 = $superieur1;
                //colabo des DGA
            } elseif (in_array($user->getAgent()->getDirection()->getId(), [12, 13])) {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 9,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $superieur1;
                //Agent dans un SR au cabinet
            } else {
                $superieur1 = $em->getRepository('AgentBundle:Agent')
                    ->findOneBy(
                        [
                            'Fonction' => 5,
                            'Direction' => $user->getAgent()->getDirection()->getId()
                        ]
                    );
                $superieur2 = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                if ($superieur1 == null or $superieur1 == '') {
                    $superieur1 = $superieur2;
                }
            }
        }

        return array(
            'sup1' => $superieur1,
            'sup2' => $superieur2,
            'sup3' => $superieur3
        );;
    }

    public function delegationCheck()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        return $routeName;
    }

    public function genererateUrl($route, $param)
    {
        $router = $this->container->get('router');
        $context = $router->getContext();
        $context->setHost('test.economie-ivoirienne.ci');
        $context->setScheme('https');
        $context->setBaseUrl('web/app_dev.php');

        $url = $router->generate($route, $param);
        return $url;
    }

    public function getSignataire($now)
    {
        $em = $this->em;
        $interimeActif = $em->getRepository('AgentBundle:interimaire')->interimEncours($now);
        if ($interimeActif) {
            $retour['signataire'] = $interimeActif->getInterimaire()->concatNom();
            $retour['entete'] = "P. le " . $interimeActif->getInterime()->getFonction() . "<br> et par Intérim";
            return $retour;
        } else {
            return 1;
        }
    }
    public function getSignataireDg($now = null)
    {

        $em = $this->em;
        $interimeActif = $em->getRepository('AgentBundle:interimaire')->interimDgEncours();
        //dump($interimeActif);die;
        if ($interimeActif) {
            $retour['signataire'] = $interimeActif->getInterimaire()->concatNom();
            $retour['entete'] = "P. le " . $interimeActif->getInterime()->getFonction() . " de l'Economie";
            if ($interimeActif->getInterimaire()->getFonction() and $interimeActif->getInterimaire()->getFonction()->getId() == 9) {
                # code...
                $directeur=$interimeActif->getInterimaire()->getFonction();
            }else{
                $directeur=$interimeActif->getInterimaire()->getDirection();
            }
            
            $retour['directeur'] = str_replace("Direction", "Directeur", $directeur);
            return $retour;
        } else {
            return 1;
        }
    }
    public function positionnement()
    {
        $agent = $this->securityContext->getToken()->getUser()->getAgent();
        $codedg = $agent->getCodeDg();
        $codedc = $agent->getDirection();
        $codesd = $agent->getCodeSd();
        $codesc = $agent->getCodeSc();

        $em = $this->em;
        $positionnement = $em->getRepository('DemandesBundle:Positionnement')->findOneBy(['code_dg' => $codedg, 'Direction' => $codedc, 'code_sd' => $codesd, 'code_sc' => $codesc]);

        if (!$positionnement) {
            $positionnement = new Positionnement();
            $positionnement->setCodedg($codedg);
            $positionnement->setDirection($codedc);
            $positionnement->setCodesd($codesd);
            $positionnement->setCodesc($codesc);
            $em->persist($positionnement);
            $em->flush();
        }

        return $positionnement;
    }

    public function positionnementAgent($agent)
    {
        // $agent = $this->securityContext->getToken()->getUser()->getAgent();
        $codedg = $agent->getCodeDg();
        $codedc = $agent->getDirection();
        $codesd = $agent->getCodeSd();
        $codesc = $agent->getCodeSc();

        $em = $this->em;
        $positionnement = $em->getRepository('DemandesBundle:Positionnement')->findOneBy(['code_dg' => $codedg, 'Direction' => $codedc, 'code_sd' => $codesd, 'code_sc' => $codesc]);
        // die;
        if (!$positionnement) {
            $positionnement = new Positionnement();
            $positionnement->setCodedg($codedg);
            $positionnement->setDirection($codedc);
            $positionnement->setCodesd($codesd);
            $positionnement->setCodesc($codesc);
            $em->persist($positionnement);
            $em->flush();
        }

        return $positionnement;
    }

    public function compareServiceDemande($position = null)
    {



        $niveau = null;
        if ($position->getCodeSc()) {
            // $service = $position->getCodeSc();
            $niveau = 0;
        } elseif ($position->getCodeSd()) {
            //$service = $position->getCodeSd();
            $niveau = 1;
        } elseif ($position->getCodeDc()) {
            //$service = $position->getDirection();
            $niveau = 2;
        } elseif ($position->getCodeDg()) {
            // $service = $position->getCodeDg();
            $niveau = 3;
        }
        return $niveau;
    }
}

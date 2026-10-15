<?php

namespace Agent\AgentBundle\Controller;

use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Entity\Provenance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Demandes\DemandesBundle\Form\rechercheStatType;

class DefaultController extends Controller {

    public function notificationAction() {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser();
        $temps = date("Y-m-d H:i:s");

        //var_dump($utilisateur);
        $direction = $this->getUser()->getAgent()->getDirection();
        $notifs = $em->getRepository('DemandesBundle:Demande')->notification($direction, $utilisateur);

        $cnotif = count($notifs);

        return $this->render('sections_app/notification.html.twig', array(
                    'notifs' => $notifs,
                    'cnotif' => $cnotif,
                    'temps' => $temps,
        ));
    }

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $etat = $em->getRepository('AgentBundle:Conges')->EtatConge($this->getUser()->getAgent()->getMatricule());

        if (!$this->getUser()->hasRole("role_conge")) {
            if ($etat['maxid']) {
                $user = $this->getUser();
                //$users->removeRole($role);
                $user->addRole('role_conge');
                $em->flush();
            }
        }


        return $this->render('default/list_aplli.html.twig');

        #return $this->redirect($this->generateUrl('agent_show', array('id' => $this->getUser()->getAgent()->getMatricule())));
    }

    public function tableauAction($id) {
        $em = $this->getDoctrine()->getManager();
        $nbre = $em->getRepository('DemandesBundle:Demande')->nbreDemande($id);

        //en attente d'affectation
        $attente_affectation = $em->getRepository('AgentBundle:Classe')->enattente_affectation('affectation_no');
        //affecter dans un service et sans prise de service
        $affectation_sansprise = $em->getRepository('AgentBundle:Classe')->enattente_affectation('affectation_yes');

        //affecter dans un service ayant prise de service et en attente de signature certificat
        $certificat = $em->getRepository('AgentBundle:Classe')->enattente_affectation('certificat');

        //liste des demandes d'actes en cours de traitement
        $demande = $em->getRepository('DemandesBundle:Demande')->statsdemande();


        //liste des mutations en cours de traitement
        $mutations = $em->getRepository('DemandesBundle:Demande')->statsmutation();

        $utilisateur = $this->getUser();
        if ($utilisateur->hasRole("ROLE_RESPO_SRHMG")) {
            $demembrement = null;
        } elseif ($utilisateur->hasRole("ROLE_RESPO") == true && $utilisateur->getAgent()->getFonction()->getId() == 10) {
            $demembrement = null;
        } else {
            $demembrement = explode(',', $utilisateur->getAgent()->retour_service()['tab_imput']);
        }

        //statistique grade
        $req['grade'] = $em->getRepository('AgentBundle:Classe')->statsgrade(1, $demembrement);
        $req['categorie'] = $em->getRepository('AgentBundle:Classe')->statsgrade(2, $demembrement);
        $req['effectif'] = $em->getRepository('AgentBundle:Classe')->statsgrade(3, $demembrement);
        $req['emploi'] = $em->getRepository('AgentBundle:Classe')->statsgrade(4, $demembrement);
        $req['direction'] = $em->getRepository('AgentBundle:Classe')->statsgrade(5, $demembrement);
        $req['direction_emploi'] = $em->getRepository('AgentBundle:Classe')->statsgrade(6, $demembrement);
        $req['syndicat'] = $em->getRepository('AgentBundle:Classe')->statsgrade(7, $demembrement);

        $autoabscence = $em->getRepository('DemandesBundle:Demande')->cumuldemandes();
        //dump($autoabscence);
        //die;

        return $this->render('AgentBundle:Tableau:index.html.twig', array(
                    'entities' => $nbre, 'attente_affectation' => $attente_affectation, 'affectation_sansprise' => $affectation_sansprise, 'certificat' => $certificat, 'demande' => $demande, 'mutation' => $mutations
                    , 'stats' => $req
        ));
        // die();
        # code...
    }

    public function detailsTabAction($id = null, $names = null, $cat = null, $lbl = null) {

        $em = $this->getDoctrine()->getManager();

        if (!in_array($id, range(1, 8))) {
            return $this->redirectToroute('agent_tableau');
        }
        $utilisateur = $this->getUser();
        if ($utilisateur->hasRole("ROLE_RESPO_SRHMG")) {
            $demembrement = null;
        } elseif ($utilisateur->hasRole("ROLE_RESPO") == true && $utilisateur->getAgent()->getFonction()->getId() == 10) {
            $demembrement = null;
        } else {
            $demembrement = explode(',', $utilisateur->getAgent()->retour_service()['tab_imput']);
        }
        $req['grade'] = $em->getRepository('AgentBundle:Classe')->statsgrade(1, $demembrement);
        $req['categorie'] = $em->getRepository('AgentBundle:Classe')->statsgrade(2, $demembrement);
        $req['effectif'] = $em->getRepository('AgentBundle:Classe')->statsgrade(3, $demembrement);
        $req['emploi'] = $em->getRepository('AgentBundle:Classe')->statsgrade(4, $demembrement);
        $req['direction'] = $em->getRepository('AgentBundle:Classe')->statsgrade(5, $demembrement);
        $req['direction_emploi'] = $em->getRepository('AgentBundle:Classe')->statsgrade(6, $demembrement);
        $req['syndicat'] = $em->getRepository('AgentBundle:Classe')->statsgrade(7, $demembrement);

        if ($lbl != null) {
           
            $req['listestats'] = $em->getRepository('AgentBundle:Classe')->listestats($id, $names, $cat, $lbl, $demembrement);

            $vue = "AgentBundle:Tableau:suiteliste.html.twig";
            $array = array('stats' => $req, 'id' => $id, 'names' => $names, 'cat' => $cat, 'lbl' => $lbl);
        } else {
            $data=null;
                $form = $this->createForm(new rechercheStatType());
                $request = $this->getRequest();

            if ($request->getMethod() == 'POST') {

                $form->bind($request);

                if ($form->isValid()) {
                    $data = $this->getRequest()->request->get('demande_statistique_rechercher');
                    //dump($data); die;
                }
            }
            $autoabscence = $em->getRepository('DemandesBundle:Demande')->cumuldemandes($data);
            $vue = "AgentBundle:Tableau:details.html.twig";
            $array = array('stats' => $req, 'id' => $id, 'names' => $names, 'cat' => $cat, 'lbl' => $lbl, 'autoabscence'=>$autoabscence, 'form'=>$form->createView());
            //dump($autoabscence);
        }

        return $this->render($vue, $array);
    }

    public function listestatsAction($id = null, $names = null, $cat = null) {
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $this->getUser();
        if ($utilisateur->hasRole("ROLE_RESPO_SRHMG")) {
            $demembrement = null;
        } elseif ($utilisateur->hasRole("ROLE_RESPO") == true && $utilisateur->getAgent()->getFonction()->getId() == 10) {
            $demembrement = null;
        } else {
            $demembrement = explode(',', $utilisateur->getAgent()->retour_service()['tab_imput']);
        }
        $req = $em->getRepository('AgentBundle:Classe')->listestats($id, $names, $cat, null, $demembrement);

        return $this->render('AgentBundle:Tableau:list.html.twig', array('req' => $req['req'], 'libelle' => $req['libelle']));
    }

    public function notifAndMenuAction() {
        $em = $this->getDoctrine()->getManager();
        $interimaires = $em->getRepository('AgentBundle:Interimaire')->gestion_menu($this->getUser()->getAgent());

        $menu = $this->get('ediligence.fonctiondebase')->notifErh();
        //die;
        $menu_delegation = null;
        //$menu_delegation = $em->getRepository('AgentBundle:Deleguation')->menuDeleguation($this->getUser()->getAgent());
        $fonctionalites = $em->getRepository('AgentBundle:Fonctionalite')->findAll();
        foreach ($fonctionalites as $key => $value) {
            $respo = $em->getRepository('AgentBundle:Deleguation')->menuDeleguationSpec($this->getUser()->getAgent(), $value->getId());
            if ($respo) {

                $menu_delegation[$value->getId()][] = $respo;
                $menu_delegation[$value->getId()]['fonctionalite'] = $value;
            }
        }
        $menutwig = "sections_app/sidebar_unique.html.twig";
        //dump($menu);
        //die;
        return $this->render($menutwig, array('menu' => $menu, 'interim' => $interimaires, 'menu_delegation' => $menu_delegation));
    }

    public function menuinterimAction() {
        $em = $this->getDoctrine()->getManager();
        $interimaires = $em->getRepository('AgentBundle:Interimaire')->gestion_menu($this->getUser()->getAgent());
        $user = $this->getUser();


        $user->setEtat(1); //menu administrateur
        $em->persist($user);
        $em->flush();

        return new response('');
    }

}

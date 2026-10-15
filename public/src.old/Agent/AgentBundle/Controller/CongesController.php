<?php

namespace Agent\AgentBundle\Controller;

use Agent\AgentBundle\Entity\Conges;
use Agent\AgentBundle\Entity\Exercice;
use Agent\AgentBundle\Entity\Validation;
use Agent\AgentBundle\Form\CongesType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Agent\AgentBundle\Form\CongesResearchType;

/**
 * Conges controller.ede
 */
class CongesController extends Controller
{

    //Get work Day d-m
    // le paramètre à 0 retourne le jour ouvrable le plus proche
    //le paramètre à 1 retourne
    //true si un jour ouvrable et
    //false si un jour ferrier
    public function getWorkDays(\DateTime $date, $state = 0)
    {
        $rs = true;
        echo $date->format('Y-m-d');
        $em = $this->getDoctrine()->getManager();
        //Vérifier les weekend (Dimanche et Samedi)
        $weekDay = date('w', strtotime($date->format('Y-m-d')));
        if ($weekDay == 0 || $weekDay == 6) {
            $rs = false;
            if ($state == 0) {
                $this->getWorkDays($date->modify('+1 day'));
            } //relancer la fonction
        }
        //Vérifier jour ferrier
        //Tableau à charger avec les jours ferier sous le format d-m|d-m
        $joursferrier = [];
        $jfs = $em->getRepository('UsersBundle:Holidays')->findAll();
        foreach ($jfs as $jf) {
            $joursferrier = array_merge($joursferrier, explode('|', $jf->getJours()));
        }

        if (in_array($date->format('d-m'), $joursferrier)) {
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

    /**
     * Lists all Conges entities.
     */
    //retrouve les congés transmis à un responsable en fonction du service de celui-ci
    public function TrouverConge($typeConge = 1, $serviceId, $niveau)
    {
        //Définir le type congé
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG')) {
            $entities = $em->getRepository('AgentBundle:Conges')->findBy($Direction, 0); //Service du Responsable
            $entitiesServices = null;
        }
    }

    public function generateAction($id, $choice)
    {
        $em = $this->getDoctrine()->getManager();

        if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges_generate')) {
            $entity = $em->getRepository('AgentBundle:Conges')->findOneBy(array('id' => $id));
            if ($entity) {
                switch ($choice) {
                    case 0: //Accepter
                        if (($this->getUser()->getAgent()->getDirection() && $this->getUser()->getAgent()->getDirection()->getId() == 3) || ($this->getUser()->hasRole('ROLE_RESPO')) || ($this->getUser()->hasRole('ROLE_RESPO_SRHMG')) || $this->getUser()->getAgent()->getFonction()->getId() == 10) {
                            $entity->setEtat(1); //Etat Accepté
                            if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getUser()->getAgent()->getFonction()->getId() == 10) {
                                $entity->setNiveau(0); //Etat Accepté
                                $Validation = new Validation();
                                $Validation->setAgent($this->get('ediligence.fonctiondebase')->returnConnect()); //Récuparation de l'agent Validateur
                                $Validation->setNiveau($entity->getNiveau());
                                $Validation->setConges($entity);
                                //Réduction du Niveau de 1(Passage au niveau Inférieur--au supérieur hiérarchique)

                                $entity->addValidation($Validation);
                            }
                            $msg = 'Certificat de cessation généré';
                            $this->addFlash('notice', $msg);
                        }
                        break;
                    case 1: //refuser
                        if (($this->getUser()->getAgent()->getDirection() && $this->getUser()->getAgent()->getDirection()->getId() == 3) || ($this->getUser()->hasRole('ROLE_RESPO')) || ($this->getUser()->hasRole('ROLE_RESPO_SRHMG')) || $this->getUser()->getAgent()->getFonction()->getId() == 10) {
                            $entity->setEtat(2); //Etat Refusé
                            $msg = 'Congé Refusé';
                            $this->addFlash('notice', $msg);
                        }
                        break;
                    default:
                        $msg = 'Mauvais Choix Rééssayez SVP';
                        $this->addFlash('error', $msg);
                        break;
                }

                //Attribution de l'état approuvé au congé

                $em->persist($entity);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('conges_show', array('id' => $id)));
    }

    public function indexAction($action)
    {

        $em = $this->getDoctrine()->getManager();

        //ensemble des Info de Service de l'agent
        $infoService = ($this->getUser()->getAgent()->retour_service());
        //Tableau de l'arborscence des service de l'agent
        $TabServ = explode(',', $infoService['tab_imput']);
        //Code Service de l'agent
        $serviceId = $infoService['service'];
        //Libellé du Service
        $serviceLib = $infoService['lib'];
        $niveau = count($TabServ) - 1; //-1 pour retirer la valeur de la Direction

        $Direction = $this->getUser()->getAgent()->getDirection();
        $agent = $this->getUser()->getAgent();
        $Ttodo = ['default', 'other', 'reprises', 'joindre', 'bac', 'respo'];

        $entities = null;
        $entitiesServices = null;
        $actionpage = 'index';
        $agentDge = $archives = $valides = $reprises = $cessations = $bac = $bacold = $actes = $service = null;
        $delegu = -1;
        if (in_array($action, $Ttodo) == false) {
            $action = 'default';
        }
        switch ($action) {
            case 'default':
                if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:default')['retour'] == 0) {
                    if ($this->getDeleguation('conges', 'action:default')['retour'] == 0) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:default')["service"];
                    }

                    //$entities = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $serviceId, $niveau, [0, 1, 3], 1, $agent); //Service du Responsable
                    $entities = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent);
                    $valides = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 1, $service);  //;
                    if ($this->getUser()->getAgent()->getFonction()->getId() == 10) {
                        $entities = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 10, $service);  //;
                        $valides = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11, $service);  //;
                    }
                }
                $actionpage = 'index';
                break;
            case 'joindre':
                if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:joindre')['retour'] == 0) {
                    if ($this->getDeleguation('conges', 'action:joindre')['retour'] == 0) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:joindre')["service"];
                    }
                    $actes = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 8, $service);  //;
                }
                $actionpage = 'actes';
                break;
            case 'reprises':
                if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_SAAF')  || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                    $service = null;

                    if ($this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                        $delegu = 0;
                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:reprises')["service"];
                    }
                    if ($this->getUser()->hasRole('ROLE_SAAF') || $this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup2"];
                    }


                    $reprises = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 4, $service);  //;
                    $archives = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 5, $service);  //;
                    if ($this->getUser()->getAgent()->getFonction()->getId() == 10) {
                        $reprises = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11, $service);  //;
                        $archives = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 12, $service);  //;
                    } elseif ($this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                        ///
                        //

                        $reprises = array_merge(array_values($reprises), array_values($em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11, $service)));
                        $archives = array_merge(array_values($archives), array_values($em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 12, $service)));
                    }
                    //;

                    //$archives = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $serviceId, $niveau, [2, 3, 4], 0, $agent);  //;
                }
                $actionpage = 'repriselist';
                break;
            case 'bac':
                if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:bac')['retour'] == 0) {
                    if ($this->getDeleguation('conges', 'action:bac')['retour'] == 0) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:bac')["service"];
                    }


                    $bac = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 7, $service);
                    $bacold = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 9, $service);
                }
                $actionpage = 'bac';
                //  echo 1111111111
                break;
            case 'other':
                if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:other')['retour'] == 0) {
                    if ($this->getDeleguation('conges', 'action:other')['retour'] == 0 || $this->getUser()->hasRole('ROLE_RESPO_SRHMG')) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:other')["service"];
                    }
                    //$entitiesServices = $em->getRepository('AgentBundle:Conges')->findCongeParam(1, $serviceId, $niveau, [0, 1], 1); //1 pour dire encour //Service du Responsable
                    $entitiesServices = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 2, $service);

                    //imprimer Cessation et Numériser
                    $cessations = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 3, $service);
                    $reprises = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 6, $service); //reprises
                    //GetDGE
                    $dge = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
                    if ($dge) {
                        $agentDge = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $dge->getCodeDg()->getCodeDg(), 0, [0, 1, 3], 1, $dge); //1 pour dire encour //Service du Responsable
                    }

                    $archives = $em->getRepository('AgentBundle:Conges')->findCongeParam(1, $serviceId, $niveau, [2, 3, 4], 0); //0 pour dire inacif archivé //Service du Responsable
                    $bac = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 7, $service);
                    //0 Etat en Attente
                    ////1 ETat de Approuvé
                    //2 Etat Refusé
                    //3 Etat Confirmé
                    //4 Etat Finalisé pour partir en congé
                }
                $actionpage = 'other';
                break;
            case 'respo':
                if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:respo')['retour'] == 0 || $this->getUser()->getAgent()->getFonction()->getId() == 10) {
                    if ($this->getDeleguation('conges', 'action:respo')['retour'] == 0 || $this->getUser()->hasRole('ROLE_RESPO_SRHMG')) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:respo')["service"];
                    }
                    $entitiesServices = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 10, $service);

                    //imprimer Cessation et Numériser
                    $cessations = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 11, $service);
                    $reprises = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 12, $service); //reprises
                    //GetDGE
                    $bac = $em->getRepository('AgentBundle:Conges')->monserviceWork($agent, 13, $service);
                }
                $actionpage = 'respo';
                break;
            default:
                if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:other')['retour'] == 0) {
                    if ($this->getDeleguation('conges', 'action:other')['retour'] == 0) {

                        $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers())["sup3"];
                        $service = $this->getDeleguation('conges', 'action:other')["service"];
                    }
                    //Role DGE
                    if ($this->getUser()->getAgent()->getFonction()->getId() == 10 || $this->getUser()->hasRole('ROLE_DGE')) {
                        $entities = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $serviceId, $niveau, [3, 4]); //Service du Responsable
                        $entitiesServices = null;
                        $archives = null;
                    } else {
                        $entities = $em->getRepository('AgentBundle:Conges')->findCongeParam(0, $serviceId, $niveau, [3, 4]); //Service du Responsable
                        $entitiesServices = null;
                        $archives = null;
                    }
                }
                break;
        }
        //dump($this->get('ediligence.fonctiondebase')->getSignataireDg());
        return $this->render('AgentBundle:Conges:' . $actionpage . '.html.twig', array(
            'entities' => $entities, 'entitiesServices' => $entitiesServices, 'archives' => $archives,
            'agentDge' => $agentDge,
            'valides' => $valides,
            'reprises' => $reprises,
            'cessations' => $cessations,
            'bac' => $bac,
            'bacold' => $bacold,
            'actes' => $actes,
            'delegu' => $delegu,

        ));
    }

    /**
     * Lists all Conges entities.
     */
    public function activeAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('AgentBundle:Conges')->findAll();
        $agent = $this->getUser()->getAgent();
        $entities = $em->getRepository('AgentBundle:Conges')->findBy(array('agent' => $agent, 'etat' => [0, 1]), array('id' => 'desc')); //Actif
        $archives = $em->getRepository('AgentBundle:Conges')->findBy(array('agent' => $agent, 'etat' => [2, 3]), array('id' => 'desc')); //;

        return $this->render('AgentBundle:Conges:active.html.twig', array(
            'entities' => $entities, 'archives' => $archives,
        ));
    }

    /**
     * Creates a new Conges entity.
     */
    public function createAction(Request $request)
    {
        $agent = $this->getUser()->getAgent();
        $entity = new Conges();
        $entity->setAgent($this->getUser()->getAgent());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            //Récupération du nombre de jour de congé consommé
            $congeConsommee = $em->getRepository('AgentBundle:Conges')->sumConge($agent->getMatricule(), 1, 1); ///;
            $congeConsommee = $congeConsommee['somme'];
            //dump($congeConsommee);die;
            //Identification des périodes de congés possibles
            $periodes = $em->getRepository('AgentBundle:PeriodeConges')->periodes($entity->getTypeConges()->getId(), ($entity->getTypeConges()->getJours() - $congeConsommee), $entity->getTypeConges()->getId());
            $cperiodes = count($periodes);

            //Date de départ doit être supérieur à la date de reprise de la dernière période de congé
            $MaxDateReprise = $em->getRepository('AgentBundle:Conges')->MaxDateReprise($agent->getMatricule());

            if ($MaxDateReprise[0] != null && $entity->getTypeConges()->getId() == 1) {
                if ($entity->getDatedebut() < $MaxDateReprise[0]->getDateFin()) {
                    $this->addFlash('error', 'La date de départ  ne doit pas être inférieure à la date de votre dernière reprise de service');
                    if ($cperiodes > 0) {
                        return $this->render('AgentBundle:Conges:new.html.twig', array(
                            'entity' => $entity,
                            'form' => $form->createView(),
                        ));
                    } else {
                        return $this->render('AgentBundle:Conges:new.html.twig', array(
                            'entity' => $entity,
                            'form' => $form->createView(),
                        ));
                    }
                }
            }

            //Vérifié si il e
            if ($cperiodes > 0 && $entity->getNbrejours() == null) {
                if ($entity->getNbrejours() == 0 && $entity->getTypeConges()->getId() > 0) {
                    return $this->render('AgentBundle:Conges:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
                    ));
                }
            }

            //$entity->setNbrejours($entity->getNbrejours()->getDuree());
            if ($entity->getNbrejours() instanceof \Agent\AgentBundle\Entity\PeriodeConges) {
                $entity->setNbrejours($entity->getNbrejours()->getDuree());
            }
            $Tjours = $entity->getTypeConges();
            if (intval($entity->getNbrejours()) > 0) {
                $jours = intval($entity->getNbrejours()) - 1;
            } else {
                $jours = $entity->getTypeConges()->getJours() - 1;
            }

            //Controle sur le type conge annuel
            if ($entity->getNbrejours() && $entity->getTypeConges()->getId() == 1) {
                if (in_array($entity->getNbrejours(), [1, 2])) {
                    $periodes = $em->getRepository('AgentBundle:PeriodeConges')->find($entity->getNbrejours());
                    $jours = $periodes->getDuree() - 1;
                }
            } else {
                if ($entity->getTypeConges()->getId() != 6 && $entity->getTypeConges()->getId() != 1) {
                    $jours = $entity->getTypeConges()->getJours() - 1;
                }
            }

            $date1 = $entity->getDatedebut();
            $datefin = date('Y-m-d', strtotime('+' . $jours + 1 . ' day', strtotime($date1->format('Y-m-d'))));
            $datefin = new \DateTime($datefin);
            $datefin = $this->getWorkDays($datefin);

            $entity->setDateFin($datefin);
            //Création et récupération de l'exercice actif
            $anexercice = intval(date('Y'));
            $exercice = $em->getRepository('AgentBundle:Exercice')->findOneBy(array('annee' => $anexercice, 'etat' => 0));
            if (!$entity->getExercice()) {
                if (!$exercice) {
                    $exercice = new Exercice();
                    $exercice->setAnnee($anexercice);
                    $em->persist($exercice);
                }
            } else {
                $exercice = $entity->getExercice();
            }

            //récupération des congés de l'utilisateur
            /*
             *
              1 Annuel    30
              2    Mariage    2
              3    Naissance d'un enfant    3
              4    Décès du conjoint, d'un ascendant ou descendant    5
              5    Congé pour couche ou allaitement (14 semaines)    98
              6    Congé maladie courte duréee (15 jrs à 06 mois)    180
              7    Congé maladie longue durée (36 mois Maximum)    1080
             */
            //ensemble des Infos de Service de l'agent
            $infoService = ($this->getUser()->getAgent()->retour_service());

            //Tableau de l'arborscence des service de l'agent
            $TabServ = explode(',', $infoService['tab_imput']);
            $niveau = count($TabServ) - 1;
            //Niveau de Service de l'argent dans l'arborscence
            //if ($this->getUser()->hasRole("ROLE_RESPO") || $this->getUser()->hasRole("ROLE_RESPO_SRHMG")) {

            if ($entity->getTypeConges()->getId() == 1) {
                //En cours pour Congé annuel
                $encours = $em->getRepository('AgentBundle:Conges')->findOneBy(array('agent' => $agent, 'niveau' => $niveau, 'etat' => 0, 'typeConges' => $entity->getTypeConges()->getId()));

                if (((intval($congeConsommee) + $jours) > $entity->getTypeConges()->getJours())) {
                    $this->addFlash('error', 'Le cumul de vos jours de congé ' . $entity->getTypeConges()->getLibelle() . ' ne peux excéder ' . $entity->getTypeConges()->getJours() . ' jours');
                    //  return $this->redirect($this->generateUrl('conges_new'));
                    return $this->render('AgentBundle:Conges:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
                    ));
                }
            } else {
                //En cours pour Congé standard transmis au RH
                $encours = $em->getRepository('AgentBundle:Conges')->findOneBy(array('agent' => $agent, 'niveau' => 0, 'etat' => 0, 'typeConges' => $entity->getTypeConges()->getId()));
                //Transmettre au RH
                $niveau = 0;
                $entity->setEtat(0);
                $entity->setNiveau($niveau);
            }

            if ($encours) {
                $entity = $encours;
                $entity->setDatedebut($date1);
                $entity->setDateFin($datefin);
                $entity->setNbrejours($jours + 1);
                $entity->setTypeConges($Tjours);
                $em->merge($entity);
            }

            $entity->setAgent($agent);
            $entity->setDateFin($datefin);
            $entity->setExercice($exercice);
            $entity->setNbrejours($jours + 1);
            $entity->setDatereprise(null);

            if ($entity->getTypeConges()->getId() == 1) {
                if ($this->getUser()->hasRole('ROLE_RESPO') && count($TabServ) > 2) {
                    $niveau = $niveau - 1;
                } elseif ($this->getUser()->hasRole('ROLE_RESPO_SRHMG')) { } else { }
            }
            $entity->setNiveau($niveau); //Atrribution du niveau de transmission de la demande

            $em->persist($entity);
            $this->addFlash('notice', 'Période de congé créée avec succès');
            $em->flush();

            return $this->redirect($this->generateUrl('conges_show', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Conges:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Conges entity.
     *
     * @param Conges $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Conges $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $agent = $this->getUser()->getAgent();

        //Récupération du nombre de jour de congé consommé
        $congeConsommee = $em->getRepository('AgentBundle:Conges')->sumConge($agent->getMatricule(), 1, 1); ///;
        $congeConsommee = $congeConsommee['somme'];

        //Identification des périodes de congés possibles
        //$periodes = $em->getRepository('AgentBundle:PeriodeConges')->periodes($entity->getTypeConges()->getId(), ($entity->getTypeConges()->getJours() - $congeConsommee), $entity->getTypeConges()->getId());
        $periodes = $em->getRepository('AgentBundle:PeriodeConges')->periodes(1, (30 - $congeConsommee));
        $cperiodes = count($periodes);

        $form = $this->createForm(new CongesType(0, $this->getUser()->getAgent(), $periodes), $entity, array(
            'action' => $this->generateUrl('conges_create'),
            'method' => 'POST',
            'user' => $this->getUser()
        ));

        $form->add('submit', 'submit', array('label' => 'Valider'));

        return $form;
    }

    /**
     * Displays a form to create a new Conges entity.
     */
    public function newAction()
    {

        if ($this->getUser()->getAgent()->getConfirms() == 0) {
            return $this->redirect($this->generateUrl('demande_reply', array('r' => 2)));
        }

        $entity = new Conges();
        $entity->setAgent($this->getuser()->getAgent());
        $form = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Conges:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Conges entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);

        //Effectuer des controle en fonction du service et des agents validateurs.
        if (!$entity) {
            throw $this->createNotFoundException('Vous n\'avez pas droit à cette page.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Conges:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function approuvviewAction($id, $choice)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Ce congé n\'est plus accessible'); //penser à un test sur l'état du congé
        }

        return $this->render('AgentBundle:Conges:approuvview.html.twig', array(
            'entity' => $entity, 'choice' => $choice,
        ));
    }

    public function printstatusAction($id, $status)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Ce congé n\'existe pas');
        }

        switch ($status) {
            case 2:
                $entity->setEtatImpression($status);
                break;

            case 4:
                $entity->setEtatImpression($status);
                break;
        }
        $em->persist($entity);
        $em->flush();
        return new Response("Succès");
    }

    public function printAction($id, $conge)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($conge);

        if (!$entity) {
            throw $this->createNotFoundException('Ce congé n\'existe pas');
        }

        switch ($id) {
            case 1:
                //Certificat de cessation
                $typeDOC = 'CESSATION--';
                $action = 'AgentBundle:Conges:cessation_pdf.html.twig';
                break;

            default:
                //Autre Type de Congés
                $typeDOC = 'REPRISE--';
                $action = 'AgentBundle:Conges:reprise_pdf.html.twig';
                break;
        }

        $agent = $entity->getAgent();
        $nom = $entity->getAgent()->getNom();
        /////////////////////////////
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'conge-' . $id . '-' . $this->getUser()->getAgent()->getMatricule(), -2, -2, 'black', [-2, -2, -2, -2], 'white');
        $filename = $typeDOC . 'CONGE-' . $agent->getMatricule() . '--' . $nom . '.pdf';
        $snappy = $this->get('knp_snappy.pdf');
        $footer = $this->renderview('DemandesBundle:Demande:footer_pdf.html.twig', array('qr' => $qr));
        $html = $this->renderview($action, array('entity' => $entity, 'qr' => $qr));

        $snappy->setOption('margin-top', 10);
        $snappy->setOption('margin-bottom', 10);

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
    }

    public function approuvAction($id, $choice)
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges_approuv')) {
            //ensemble des Info de Service de l'agent
            $infoService = ($this->getUser()->getAgent()->retour_service());
            $TabServ = explode(',', $infoService['tab_imput']);
            $serviceId = $infoService['service'];
            $serviceLib = $infoService['lib'];
            $niveau = count($TabServ) - 1; //-1 pour retirer la valeur de la Direction
            //Récupération du congé à traiter et Contrôle
            $entity = $em->getRepository('AgentBundle:Conges')->findCongeParamId($id, $serviceId, $niveau);

            $typeConges = $em->getRepository('AgentBundle:typeConges')->findOneBy(array('id' => $entity->getTypeConges()->getId()));

            if ($entity) {
                if (count($entity->getValidation()) < $entity->getTypeConges()->getNiveau()) { }

                /*
                  if (($entity->getNiveau()) > 0 && ($entity->getNiveau() <= $entity->getTypeConges()->getNiveau())) { */
                if ($entity->checkValidateur($this->getUser())) {
                    //sauvegarde de la Validation
                    $Validation = new Validation();
                    $Validation->setAgent($this->get('ediligence.fonctiondebase')->returnConnect()); //Récuparation de l'agent Validateur
                    $Validation->setNiveau($entity->getNiveau());
                    $Validation->setConges($entity);
                    //Réduction du Niveau de 1(Passage au niveau Inférieur--au supérieur hiérarchique)
                    $niveauvalideur = $this->getUser()->getAgent()->retour_service();
                    $niveauvalideur = count($niveauvalideur['tab_lib']) - 1;
                    $entity->setNiveau($niveauvalideur - 1);
                    $entity->addValidation($Validation);

                    //récupération Arborscence de l'utilisateur demandeur
                    $infoServiceA = ($this->getUser()->getAgent()->retour_service());
                    $TabServA = explode(',', $infoServiceA['tab_imput']);
                    $niveauA = count($TabServA) - 1; //-1 pour retirer la valeur de la Direction
                    //transmission au ressources humaines
                    if (count($entity->getValidation()) == $entity->getTypeConges()->getNiveau() || $niveauA == count($entity->getValidation())) {
                        $Validation->setNiveau(0);
                    }
                    $em->persist($Validation);
                }
                /* elseif (count($entity->getValidation()) == $entity->getTypeConges()->getNiveau()) {

                  } */
            }

            $action = 'conges';
            if (($this->getUser()->hasRole('ROLE_RESPO')) || ($this->getUser()->hasRole('ROLE_RESPO_SRHMG'))) {
                $entity->setEtat(0);
                $msg = 'Période de Congée validée avec succès'; // . $serviceLib;
                $this->addFlash('notice', $msg);
            }

            $em->merge($entity);
            $em->flush();
        } else { }
        //0 Etat en Attente
        //1 ETat de Approuvé
        //2 Etat Refusé
        //3 Etat Confirmé
        //4 Etat Finalisé pour partir en congé
        return $this->redirect($this->generateUrl($action));
    }

    /**
     * Displays a form to edit an existing Conges entity.
     */
    public function editAction($id, $todo = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conges entity.');
        }

        $editForm = $this->createEditForm($entity, $todo);
        $deleteForm = $this->createDeleteForm($id);

        switch ($todo) {
            case 1: //Refus
                $url = 'AgentBundle:Conges:edit.html.twig';
                break;
            case 2: //Reprise
                $url = 'AgentBundle:Conges:reprise.html.twig';
                break;
            case 3: //Numerisation
                $url = 'AgentBundle:Conges:numerisation.html.twig';
                break;
            case 4:
                $url = 'AgentBundle:Conges:numerisationR.html.twig';
                break;
            default:
                $url = 'AgentBundle:Conges:edit.html.twig';
                break;
        }

        return $this->render($url, array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Conges entity.
     *
     * @param Conges $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Conges $entity, $todo = 1)
    {
        $form = $this->createForm(new CongesType(intval($todo), $this->getUser()->getAgent()), $entity, array(
            'action' => $this->generateUrl('conges_update', array('id' => $entity->getId(), 'todo' => intval($todo))),
            'method' => 'PUT',
            'user' => $this->getUser()
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Conges entity.
     */
    public function updateAction(Request $request, $id, $todo = 1)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Conges entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $todo);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ((1 == 1) ||  $this->getUser()->hasRole('ROLE_SAAF') || $this->getUser()->hasRole('ROLE_RESPO') || $this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getUser()->hasRole('ROLE_DGE') || $this->getUser()->getAgent()->getFonction()->getId() == 10 || $this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                switch ($todo) {
                    case 1: //refuser
                        $entity->setEtat(2);
                        $em->persist($entity);
                        $msg = 'Période de Congée Refusée';
                        $this->addFlash('notice', $msg);
                        break;
                    case 2: //Certificat de reprise
                        $entity->setEtat(3);
                        $entity->setMatValidReprise($this->get('ediligence.fonctiondebase')->returnConnect());
                        $entity->setDateAutoValidReprise(new \DateTime('now'));
                        //retrait du rôle congé après génération du certificat de reprise de l'agent

                        $em->persist($entity);
                        $msg = 'Reprise validée avec succès';
                        $em->flush();
                        $this->addFlash('notice', $msg);

                        if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges', 'action:reprises')['retour'] == 0) {
                            return $this->redirect($this->generateUrl('conges_view', array('id' => $id)));
                        }


                        break;
                    case 3:
                        $originalName = $entity->getNumCessation()->getPj()->getImageFile()->getClientOriginalName();
                        $entity->getNumCessation()->setMatAjoutDec($this->get('ediligence.fonctiondebase')->returnConnect());
                        $entity->getNumCessation()->getPj()->setNomOrigine($originalName);
                        $em->persist($entity);
                        $msg = 'Numérisation & Signature effectuée avec succès';
                        $this->addFlash('notice', $msg);
                        break;
                    case 4:
                        $originalName = $entity->getNumReprise()->getPj()->getImageFile()->getClientOriginalName();
                        $entity->getNumCessation()->setMatAjoutDec($this->get('ediligence.fonctiondebase')->returnConnect());
                        $entity->getNumReprise()->getPj()->setNomOrigine($originalName);
                        $em->persist($entity);
                        $msg = 'Numérisation & Signature effectuée avec succès';
                        $this->addFlash('notice', $msg);
                        break;
                    default:
                        break;
                }
            }

            $em->flush();

            return $this->redirect($this->generateUrl('conges_show', array('id' => $id)));
        }
        switch ($todo) {
            case 1: //Refus
                $url = 'AgentBundle:Conges:edit.html.twig';
                break;
            case 2: //Reprise
                $url = 'AgentBundle:Conges:reprise.html.twig';
                break;
            case 3: //Numerisation
                $url = 'AgentBundle:Conges:numerisation.html.twig';
                break;
            case 4:
                break;
            default:
                $url = 'AgentBundle:Conges:edit.html.twig';
                break;
        }

        return $this->render($url, array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Conges entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Conges')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Conges entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('conges'));
    }

    /**
     * Creates a form to delete a Conges entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conges_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('AgentBundle:Conges')->find($id);
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'conges-' . $id . '-' . $user, -2, -2, 'black', [-2, -2, -2, -2], 'white');

        return $this->render('AgentBundle:Conges:preview_pdf.html.twig', array(
            'qr' => $qr,
            'entity' => $entity,
        ));
    }

    public function researchAction($matricule = null)
    {
        $em = $this->getDoctrine()->getManager();

        $delegu = -1;
        if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges_research')['retour'] == 0) {
            $delegu = 0;
        } else {
            throw $this->createNotFoundException('Vous n\'avez pas droit à cette page.');
        }

        $form = $this->createForm(new CongesResearchType(), array(
            'action' => $this->generateUrl('conges_research'),
            'method' => 'POST',
        ));


        $request = $this->getRequest();

        $conges = null;
        if ($request->getMethod() == 'POST') {

            $form->bind($request);

            //On vérifie que les valeurs entrées sont correctes

            if ($form->isValid()) {

                $data = $this->getRequest()->request->get('conges_research_form');

                $conges = $em->getRepository('AgentBundle:Conges')->findBy(['agent' => $data['agent']], ['datedebut' => 'DESC']);
            }
        }

        return $this->render('AgentBundle:Conges:research.html.twig', array(
            'conges' => $conges,
            'delegu' => $delegu,
            'form' => $form->createView()
        ));
    }


    /**
     * Finds and displays a Conges entity.
     */
    public function regulAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Conges')->find($id);


        //Effectuer des controle en fonction du service et des agents validateurs.
        if (!$entity) {
            throw $this->createNotFoundException('Vous n\'avez pas droit à cette page.');
        }
        if ($entity->getTypeConges() && $entity->getTypeConges()->getId() == 1 && $entity->getEtat() == 1 && $entity->getExercice()) {

            $exercice = $em->getRepository('AgentBundle:Exercice')->findOneBy(['annee' => (date("Y") - 1)]);
            if ($exercice) {

                $decag = $em->getRepository('AgentBundle:Conges')->getDecAgent($entity->getAgent()->getId(), $entity->getExercice()->getAnnee());
                if ($decag) {
                    $decision = $decag->getDecision();
                    if ($decision) {

                        if ((int) ($decision->getDate()->format('Y')) == ((int) ($exercice->getAnnee() + 1))) {
                            // $decision->setExercice($exercice);
                            // $em->persist($decision);
                        }
                    }
                }

                $entity->setExercice($exercice);
                $em->persist($entity);
                $em->flush();
            }
        }

        return $this->redirect($this->generateUrl('conges_view', array('id' => $id)));
    }

    /**
     * Lists all Conges entities.
     */
    public function suiviAction($action = 'default')
    {
        $em = $this->getDoctrine()->getManager();
        $agent = $this->getUser();
        if ($this->getUser()->hasRole('ROLE_RESPO_SRHMG') || $this->getDeleguation('conges_suivi', 'action:default')['retour'] == 0) {
            $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['Fonction' => 10]);
            $agent = $agent->getUsers();
        }
        if ($this->getUser()->hasRole('ROLE_SAAF')) {
            $agent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent);
            $agent = ($agent['sup2']->getUsers());
        }


        switch ($action) {
            case 'default':

                //Pour congés
                $enconges = $em->getRepository('AgentBundle:Conges')->findEnConge($agent, 0);
                $stats = $em->getRepository('AgentBundle:Conges')->findEnConge($agent, 1);
                $avenir = $em->getRepository('AgentBundle:Conges')->findEnConge($agent, 3);

                //pour Demande
                $encongesAb = $em->getRepository('DemandesBundle:Demande')->findEnAbsence($agent, 0);
                $statsAb = $em->getRepository('DemandesBundle:Demande')->findEnAbsence($agent, 1);
                $avenirAb = $em->getRepository('DemandesBundle:Demande')->findEnAbsence($agent, 3);


                return $this->render('AgentBundle:Conges:suivi.html.twig', array(
                    'enconges' => $enconges, 'stats' => $stats, 'avenir' => $avenir,
                    'encongesAb' => $encongesAb, 'statsAb' => $statsAb, 'avenirAb' => $avenirAb
                ));

                break;
            case in_array($action, range(1, 12)):

                $entities = $em->getRepository('AgentBundle:Conges')->findEnConge($agent, 2, $action);
                $entitiesAb = $em->getRepository('DemandesBundle:Demande')->findEnAbsence($agent, 2, $action);

                return $this->render('AgentBundle:Conges:suivi_detail.html.twig', array(
                    'entities' => $entities, 'entitiesAb' => $entitiesAb, 'action' => $action,
                ));
                break;
            default:
                return $this->redirect($this->generateUrl('conges_suivi', array('action' => 'default')));
                break;
        }
    }

    private function getDeleguation($route, $param = null)
    {

        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getAgent();
        $deleguations = $em->getRepository('AgentBundle:Deleguation')->checkRoute($id, $route, $param);

        $tab = [];
        // $service=null;
        if (!$this->getUser()->hasRole("ROLE_RESPO")) {
            foreach ($deleguations as $deleguation) {
                array_push($tab, $deleguation->getArrayServices());
            }
        }
        $service = implode(",", $tab);

        if ($deleguations) {
            /////Success
            $retour = 0;
        } else {
            //echec
            $retour = 1;
        }

        return ['retour' => $retour, 'service' => $service];
    }
}

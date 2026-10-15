<?php

namespace PasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\Exercice;
use PasBundle\Entity\Axes;
use PasBundle\Entity\Actions;
use PasBundle\Entity\Objectifs;
use PasBundle\Entity\Pas;
use PasBundle\Entity\Resultats;
use PasBundle\Entity\Indicateurs;
use PasBundle\Entity\Sources;
use PasBundle\Entity\Budget;
use PasBundle\Entity\Partenaires;
use PasBundle\Entity\Notes;
use Agent\AgentBundle\Entity\Pj;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PasBundle:Pas')->findAll();

        return $this->render('PasBundle:Default:index.html.twig', array('entities' => $entities));
    }

    public function ajoutAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $exercices = $em->getRepository('AgentBundle:Exercice')->findAll();
        $directions = $em->getRepository('AgentBundle:Direction')->findBy(array('etatDirection' => [0, 1]), array('etatDirection' => 'DESC'));
        $nature = $em->getRepository('PasBundle:Naturepas')->findAll();


        if ($request->isMethod('POST')) {

            $exerciceid = $request->request->get('exercice');
            $directionid = $request->request->get('direction');
            $natureid = $request->request->get('nature');

            $exercice = $em->getRepository('AgentBundle:Exercice')->findOneBy(['id' => $exerciceid]);
            $direction = $em->getRepository('AgentBundle:Direction')->findOneBy(['id' => $directionid]);
            $nature = $em->getRepository('PasBundle:Naturepas')->findOneBy(['id' => $natureid]);
            /*
              $exercice = $em->getRepository('AgentBundle:Exercice')->findOneBy(['etat' => 0]);
              if (!$exercice) {
              $exercice = new Exercice();
              $exercice->setAnnee(intval(date('Y')));
              $em->persist($exercice);
              }
             */
            $pas = $em->getRepository('PasBundle:Pas')->findOneBy(['direction' => $direction, 'exercice' => $exercice, 'naturepas' => $nature]);
            if (!$pas) {
                $pas = new Pas();
                $pas->setExercice($exercice);
                $pas->setDirection($direction);
                $pas->setNaturepas($nature);
                $em->persist($pas);
            }
            if ($request->request->get('Axe')) {
                foreach ($request->request->get('Axe') as $key_axe => $value_axe) {
                    $axe = new Axes();
                    $axe->setPas($pas);
                    $axe->setExercice($exercice);
                    $axe->setLibelle($value_axe);
                    $em->persist($axe);
                    //objectifs
                    if ($request->request->get('obj_axe' . $key_axe)) {
                        foreach ($request->request->get('obj_axe' . $key_axe) as $key_obj => $value_obj) {
                            $objectif = new Objectifs();
                            $objectif->setAxes($axe);
                            $objectif->setLibelleobj($value_obj);
                            $em->persist($objectif);
                            //actions
                            if ($request->request->get('act_obj_axe' . $key_axe . 'objectif' . $key_obj)) {
                                foreach ($request->request->get('act_obj_axe' . $key_axe . 'objectif' . $key_obj) as $key_act => $value_act) {
                                    $action = new Actions();
                                    $action->setObjectifs($objectif);
                                    $action->setLibelleaction($value_act);
                                    $em->persist($action);
                                }
                            }
                        }
                    }
                }
            }
            $em->flush();

            return $this->redirect($this->generateUrl('pas_evaluer', array('id' => $pas->getId())));
        }
        return $this->render('PasBundle:Default:ajout.html.twig', array('request' => $request->request, 'natures' => $nature, 'exercices' => $exercices, 'directions' => $directions));
    }

    public function evaluerAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pas = $em->getRepository('PasBundle:Pas')->find($id);

        if ($request->isMethod('POST')) {

            $resultats = $request->request->get('resultat');
            $indicateurs = $request->request->get('indicateur');
            $sources = $request->request->get('source');
            $budgets = $request->request->get('budget');
            $calendars = $request->request->get('calendar');
            $partenaires = $request->request->get('partenaire');

            //Axes
            foreach ($pas->getAxes() as $axe) {

                //Objectifs
                foreach ($axe->getObjectifs() as $objectif) {

                    //Actions
                    foreach ($objectif->getActions() as $action) {
                        $a = $axe->getId();
                        $o = $objectif->getId();
                        $act = $action->getId();

                        if ($resultats[$a][$o][$act] != null && $resultats[$a][$o][$act] != '') {
                            //resultat
                            $resultat = new Resultats();
                            $resultat->setLibelleresult($resultats[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $action->setResultats($resultat);
                            //$resultat->setActions($action);
                            $em->persist($resultat);
                        }
                        if ($indicateurs[$a][$o][$act] != null && $indicateurs[$a][$o][$act] != '') {
                            //indicateur
                            $indicateur = new Indicateurs();
                            $indicateur->setLibelleind($indicateurs[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $action->setIndicateurs($indicateur);
                            //$indicateur->setActions($action);
                            $em->persist($indicateur);
                        }
                        if ($sources[$a][$o][$act] != null && $sources[$a][$o][$act] != '') {
                            //source
                            $source = new Sources();
                            $source->setLibellesrc($sources[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $action->setSources($source);
                            //$source->setActions($action);
                            $em->persist($source);
                        }
                        if ($budgets[$a][$o][$act] != null && $budgets[$a][$o][$act] != '') {
                            //budget
                            $budget = new Budget();
                            $budget->setBudget($budgets[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $action->setBudget($budget);
                            //$budget->setActions($action);
                            $em->persist($budget);
                        }
                        if ($partenaires[$a][$o][$act] != null && $partenaires[$a][$o][$act] != '') {
                            //partenaire
                            $partenaire = new Partenaires();
                            $partenaire->setNompart($partenaires[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $action->setPartenaires($partenaire);
                            //$partenaire->setActions($action);
                            $em->persist($partenaire);
                        }
                        $calendar = implode(',', $calendars[$axe->getId()][$objectif->getId()][$action->getId()]);
                        if ($calendar != null && $calendar != '') {
                            //calendar
                            $action->setCalendar($calendar);
                            $em->persist($action);
                        }
                    }
                }
            }
            $em->flush();
        }
        return $this->render('PasBundle:Default:evaluer.html.twig', array('pas' => $pas, 'request' => $request->request));
    }

    public function ficheAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pas = $em->getRepository('PasBundle:Pas')->find($id);

        return $this->render('PasBundle:Default:fiche.html.twig', array('pas' => $pas));
    }

    public function baremeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pas = $em->getRepository('PasBundle:Pas')->find($id);
        if ($request->isMethod('POST')) {

            $criterenotes = $request->request->get('criterenote');
            foreach ($pas->getAxes() as $axe) {
                //Objectifs
                foreach ($axe->getObjectifs() as $objectif) {

                    //Actions
                    foreach ($objectif->getActions() as $action) {
                        $a = $axe->getId();
                        $o = $objectif->getId();
                        $act = $action->getId();

                        if ($criterenotes[$a][$o][$act] != null && $criterenotes[$a][$o][$act] != '') {
                            //resultat
                            $action->setCriterenote($criterenotes[$axe->getId()][$objectif->getId()][$action->getId()]);
                            $em->persist($action);
                        }
                    }
                }
            }
            $em->flush();
            return $this->redirect($this->generateUrl('pas_homepage'));
        }
        return $this->render('PasBundle:Default:bareme.html.twig', array('pas' => $pas, 'request' => $request->request));
    }

    public function noterAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pas = $em->getRepository('PasBundle:Pas')->find($id);
        
        if ($request->isMethod('POST')) {

            $tnote = $request->request->get('note');
            $pjs = $request->files->get('pj');

            foreach ($pas->getAxes() as $axe) {
                //Objectifs
                foreach ($axe->getObjectifs() as $objectif) {

                    //Actions
                    foreach ($objectif->getActions() as $action) {
                        $a = $axe->getId();
                        $o = $objectif->getId();
                        $act = $action->getId();


                        if (isset($tnote[$a][$o][$act])) {
                            if ($tnote[$a][$o][$act] != null && $tnote[$a][$o][$act] != '') {
                                //resultat



                                $note = new Notes();
                                $note->setNote($tnote[$a][$o][$act]);
                                $note->setValidateur($this->getUser()->getAgent());
                                $note->setActions($action);
                                $em->persist($note);
                                $action->addNote($note);
                                $em->persist($action);
                            }
                        }
                        if (isset($pjs[$a][$o][$act])) {
                            if ($pjs[$a][$o][$act] != null && $pjs[$a][$o][$act] != '') {
                                //resultat
//dump($pjs[$a][$o][$act]->getClientOriginalName()); die;
                                $pj = new Pj();
                                $pj->setImageFile($pjs[$a][$o][$act]);
                                $pj->setImageName($pjs[$a][$o][$act]);
                                $pj->setNomOrigine($pjs[$a][$o][$act]->getClientOriginalName());
                                $pj->setUpdatedAt(new \DateTime());
                                $pj->setUtilisateur($this->getUser());


                                $em->persist($pj);
                                $action->setPiecejointe($pj);
                            }
                        }
                    }
                }
            }
            $em->flush();
        }
        if($request->request->get('preuve')=='ok'){
            return $this->redirect($this->generateUrl('pas_preuve', array('id' => $pas->getId())));
        }else{
        return $this->redirect($this->generateUrl('pas_fiche', array('id' => $pas->getId())));}
    }

    public function preuveAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $pas = $em->getRepository('PasBundle:Pas')->find($id);
        if ($request->isMethod('POST')) {
            
        }
        return $this->render('PasBundle:Default:preuve.html.twig', array('pas' => $pas));
    }

    public function bilanAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PasBundle:Pas')->bilan();
       
        return $this->render('PasBundle:Default:bilan.html.twig', array('entities' => $entities));
    }
    
    
}

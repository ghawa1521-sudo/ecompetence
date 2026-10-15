<?php

namespace Agent\IdentificationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Agent\IdentificationBundle\Form\PassifcongeType;
use Agent\AgentBundle\Entity\Conges;
use Agent\AgentBundle\Entity\Decision;
use Agent\AgentBundle\Entity\DecisionAgent;
use Agent\AgentBundle\Entity\Validation;
use Agent\AgentBundle\Entity\Numerisation;

class DefaultController extends Controller {

    public function indexAction(Request $request, int $id = null) {

        if (!$entity) {

        }
        throw $this->createNotFoundException('Veuillez contactez votre responsable pour la reprise de l\'agent.');

        $em = $this->getDoctrine()->getManager();
        if ($id > 0) {
            $conges = $em->getRepository('AgentBundle:Conges')->find($id);
        } else {
            $conges = new Conges();
        }

        $listeconge = $em->getRepository('AgentBundle:Conges')->regularisationconges($this->getUser()->getAgent()->getId());

        $form = $this->createcongeForm($conges);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $exercice = $conges->getExercice();
            $agent = $conges->getAgent();
            $typeconge = $conges->getTypeConges();
            $nbrejours = $conges->getNbrejours();
            if ($typeconge->getId() == 1) {
                $checkconge = $em->getRepository('AgentBundle:Conges')->checkconges($exercice, $agent, $typeconge, $nbrejours, $id);
            } else {
                $checkconge['t'] = 1;
            }
//dump($checkconge['t']); die;
            if ($checkconge['t'] == 1) {
                //conges
                $conges->setEtat(3);
                $conges->setNiveau(0);
                $conges->setSaafactor($this->getUser()->getAgent());
                $conges->setEtatImpression(3);
                //decision
                // dump($exercice);

                $decision = $em->getRepository('AgentBundle:Decision')->findOneByExercice($exercice);
                if (!$decision) {
                    $decision = new Decision();
                    $decision->setDate(new \DateTime('Now'));
                    $decision->setNumero('Dec-auto-' . $exercice->getAnnee());
                    $decision->setExercice($exercice);
                    $em->persist($decision);
                }

                //decision agent
                $decisionagent = $em->getRepository('AgentBundle:DecisionAgent')->findOneBy(['decision' => $decision, 'agent' => $agent]);
                if (!$decisionagent) {
                    $decisionagent = new DecisionAgent();
                    $decisionagent->setDecision($decision);
                    $decisionagent->setAgent($agent);
                    $em->persist($decisionagent);
                }

                //validation
                if ($agent->getUsers()) {
                    $serviceagent = $this->get('ediligence.fonctiondebase')->retour_superieur($agent->getUsers());
                    if ($serviceagent != null) {
                        $serviceagent = $serviceagent['sup2'];
                    } else {
                        $serviceagent = $this->getUsers()->getAgent();
                    }

                    $validation = new Validation();
                    $validation->setDate(new \DateTime('Now'));
                    $validation->setNiveau(0);
                    $validation->setAgent($serviceagent);
                    $validation->setConges($conges);
                    $em->persist($validation);

                    $conges->addValidation($validation);

                    //numerisation
                    $numerisation = new Numerisation();
                    $numerisation->setDate(new \DateTime('Now'));
                    $em->persist($numerisation);

                    $em->persist($conges);
                    $em->flush();
                    $this->addFlash('notice', 'DOSSIER A ETE PRIS EN COMPTE AVEC SUCCES');

                    return $this->redirect($this->generateUrl('agent_identification_home'));
                }
            }
        }

        return $this->render('AgentBundle:Conges:congeauto.html.twig', array(
                    'form' => $form->createView(), 'listeconges' => $listeconge
        ));
    }

    private function createcongeForm($conges = null) {

        $form = $this->createForm(new PassifcongeType($conges), $conges, array('users' => $this->getUser()
        )); // 'action' => $this->generateUrl('mutation_scan', array('id' => '')),'method' => 'PUT',

        $form->add('submit', 'submit', array('label' => 'Numériser la note de mutation', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

}

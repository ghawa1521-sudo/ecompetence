<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Agent\AgentBundle\Entity\Decision;
use Agent\AgentBundle\Entity\DecisionAgent;
use Agent\AgentBundle\Form\DecisionType;
use Agent\AgentBundle\Form\DecisionAgentType;

/**
 * Decision controller.
 *
 */
class DecisionController extends Controller {

    private function getDeleguation($route, $param = null) {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getAgent();
        $deleguation = $em->getRepository('AgentBundle:Deleguation')->checkRoute($id, $route, $param);
        //dump($deleguation);
        if ($deleguation) {
            $retour = 0;
        } else {
            $retour = 1;
        }

        return $retour;
    }

    /**
     * Lists all Decision entities.
     *
     */
    public function indexAction($todo) {
        $Ttodo = ['consulter', 'ajouter', 'retirer'];
        if (in_array($todo, $Ttodo) == FALSE) {
            $todo = "consulter";
        }
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Decision')->findAll();

        return $this->render('AgentBundle:Decision:index.html.twig', array(
                    'entities' => $entities,
                    'todo' => $todo,
        ));
    }

    public function deleteListAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Decision')->find($id);

        //récupérer la liste des agents nétant pas lié encore à la décision
        //$agents = $em->getRepository('AgentBundle:Agent')->findBy(array('Direction' => $entity->getDirection()->getId()));
        //Liste des agents de la décision
        $DecisionAgents = $em->getRepository('AgentBundle:DecisionAgent')->findBy(array('decision' => $entity->getId()));

        //$agents = $em->getRepository('AgentBundle:Decision')->FindAgentOnDecision($id,$entity->getDirection()->getId());
        //$agents=$agents;

        if (!$entity) {
            throw $this->createNotFoundException('Cette décision n\'existe pas.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Decision:deletelist.html.twig', array(
                    'entity' => $entity,
                    'DecisionAgents' => $DecisionAgents,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    private function returnConnecte() {
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
     * Creates a new Decision entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Decision();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            /*
              if ($id > 0) {
              $oldDec = $em->getRepository('AgentBundle:Decision')->find($id);
              if (!$oldDec) {
              throw $this->createNotFoundException('Unable to find Decision entity.');
              }
              $em->remove($oldDec);
              }
              foreach ($entity->getAgent() as $agent) {
              $agent->setDecision($entity);
              }
              $em = $this->getDoctrine()->getManager(); */
            $entity->setMatAjoutDec($this->returnConnecte());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('decision_edit', array('id' => $entity->getId())));
        }

        return $this->render('AgentBundle:Decision:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Decision entity.
     *
     * @param Decision $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Decision $entity, $id = null) {
        $form = $this->createForm(new DecisionType(), $entity, array(
            'action' => $this->generateUrl('decision_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Decision entity.
     *
     */
    public function newAction($id = null) {
        $entity = new Decision();
        $form = $this->createCreateForm($entity);

        return $this->render('AgentBundle:Decision:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Decision entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Decision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Decision entity.');
        }
        //Liste des agents de la décision
        $DecisionAgents = $em->getRepository('AgentBundle:DecisionAgent')->findBy(array('decision' => $entity->getId()));

        //var_dump($DecisionAgents);
        //die;

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Decision:show.html.twig', array(
                    'entity' => $entity,
                    'DecisionAgents' => $DecisionAgents,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Decision entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Decision')->find($id);

        //récupérer la liste des agents nétant pas lié encore à la décision
        //$agents = $em->getRepository('AgentBundle:Agent')->findBy(array('Direction' => $entity->getDirection()->getId()));
        $agents = $em->getRepository('AgentBundle:Decision')->FindAgentOnDecision($entity->getExercice());
        //$agents=$agents;

        if (!$entity) {
            throw $this->createNotFoundException('Cette décision n\'existe pas.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Decision:edit.html.twig', array(
                    'entity' => $entity,
                    'agents' => $agents,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Decision entity.
     *
     * @param Decision $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Decision $entity) {
        $form = $this->createForm(new DecisionAgentType(), $entity, array(
            'action' => $this->generateUrl('decision_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Decision entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Decision')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Decision entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            //Récupérer Objet Décision Agent

            $agentids = $request->request->get('id');
            foreach ($agentids as $agentid) {
                $DecisionAgent = $em->getRepository('AgentBundle:DecisionAgent')->findOneBy(array('decision' => $entity->getId(), 'agent' => $agentid));
                if (!$DecisionAgent) {
                    $DecisionAgent = new DecisionAgent();
                }
                $agent = $em->getRepository('AgentBundle:Agent')->find($agentid);
                if (!$agent) {

                    throw $this->createNotFoundException('Cet agent n\'existe pas.');
                }
                //$DecisionAgent($this->returnConnecte());
                $DecisionAgent->setAgent($agent);
                $DecisionAgent->setDecision($entity);
                $em->persist($DecisionAgent);
                //echo $agentid;
            }
            //var_dump($entity);
            //die;
            $this->addFlash('notice', 'Agent ajouté à la décision :' . $entity->getNumero() . ' avec succès');
            $em->flush();


            return $this->redirect($this->generateUrl('decision_edit', array('id' => $id)));
        }

        return $this->render('AgentBundle:Decision:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Decision entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AgentBundle:Decision')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Cette décision n\'existe pas.');
            }

            //Récupérer Objet Décision Agent
            $agentids = $request->request->get('id');

            foreach ($agentids as $agentid) {
                $DecisionAgent = $em->getRepository('AgentBundle:DecisionAgent')->findOneBy(array('decision' => $entity->getId(), 'agent' => $agentid));
                if ($DecisionAgent) {
                    $em->remove($DecisionAgent);
                }

                //echo $agentid;
            }

            $this->addFlash('notice', 'Agent retiré de la décision: ' . $entity->getNumero() . ' avec succès');


            $em->flush();
        }

        return $this->redirect($this->generateUrl('decision_deletelist', array('id' => $id)));

        // return $this->redirect($this->generateUrl('decision'));
    }

    /**
     * Creates a form to delete a Decision entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('decision_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'retirer', 'attr' => array('class' => 'btn btn-danger')))
                        ->getForm()
        ;
    }

}

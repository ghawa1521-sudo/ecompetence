<?php

namespace Agent\AgentBundle\Controller;
use Agent\AgentBundle\Entity\Imputation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ImputationController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
    	//$entities=$this->agentListByObject("245362R","AgentBundle:Affecter",0);
        //ensemble des affectations pouvant faire l'objet d'une imputation
        $affecter= $em->getRepository('AgentBundle:Affecter')->AffecterImputer(1, $this->getUser());
        
        //ensemble des colaborateur pouvant recevoir une imputation 
        $agent=$em->getRepository('AgentBundle:Agent')->findBy(['Direction'=>$this->getUser()->getAgent()->getDirection()],['nom'=>'ASC']);


        //si le formulaire est valide
         if (($request->getMethod() == "POST") and ($request->request->get('btn_valider'))) {
            $type=$request->request->get('hidden_value');
            $coche=$request->request->get('id'); 
            $agent_imputer=$em->getRepository('AgentBundle:Agent')->findOneBy(['matricule'=>$request->request->get('nom')]); 

         
           //die;

            //die;
            switch ($type) {
                //Imputation d'une affectation
                    #1 Affecter
                    #2 Demande
                    #3 Mutation
                    #4 Congé
                case 1:
                    # code...
                    #
                    $trc_mat=$this->getUser()->getAgent();
                    $trc_route='imputation';
                    $trc_entite='AgentBundle:Imputation';
                   
                    foreach ($coche as $affecter) {
                        
                        # code...
                    /////creation de l'imputation de l'affectation a un colaborateur
                        
                    $entity = new Imputation();
                    $entity->setDateImputation(new \DateTime('now'));
                    $entity->setObjetImputation("AgentBundle:Affecter");
                    $entity->setObjetId($affecter);
                    $entity->setEtat(1);
                    $entity->setMatImputateur($this->getUser()->getAgent());
                    $entity->setMatImputer($agent_imputer);
                    $entity->setActions("affecter_direction");
                    $em->persist($entity);
                    $em->flush($entity);

                    //inscription de la marque de l'imputation dans la table affecter
                    $entite=$em->getRepository('AgentBundle:Affecter')->findOneBy(['id'=>$affecter]);
                    $entite->setImputer($agent_imputer);
                    $em->persist($entite);
                    $em->flush($entite);

                    //trace systeme
                    $agent_a_affecter=$em->getRepository('AgentBundle:Agent')->findOneBy(['affecter'=>$affecter]);
                    $trc_id=$entity->getId();
                    $trc_lib="Imputer Affectation de ".$agent_a_affecter->concatNom()." à ".$agent_imputer->concatNom();

                    $trace=$this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id,0);

                    }
                   
                    break;
                
                default:
                    # code...
                    break;
            }
            
           // die;
             # code...
            return $this->redirect($this->generateUrl('imputation'));

         }
         //return new RedirectResponse($this->generateUrl('CanopyAbcBundle_crud_success'));

        return $this->render('AgentBundle:Imputation:index.html.twig', array(
                // ...
                'agent'=>$agent,
        	//	'entities'=>$entities,
                'affecter'=>$affecter,
            ));   
    }

    public function suiviAction()
    {
        $entities=$this->agentListByObject("245362R","AgentBundle:Affecter",0);
        return $this->render('AgentBundle:Imputation:suivi.html.twig', array(
            // ...
                
                'entities'=>$entities,
            ));
            }
         

        /**
			
			DemandesBundle:Demande
			AgentBundle:Affecter
			AgentBundle:Conges

        */
	public function demandeAction()
	{
		$matImputer=$this->getUser()->getAgent()->getMatricule();
		$entities=$this->agentListByObject($matImputer,"DemandesBundle:Demande",0);
        return $this->render('AgentBundle:Imputation:demande.html.twig', array(
                // ...
        		'entities'=>$entities,
            ));
	}
	public function affecterAction()
	{
        //var_dump("okkk");
        $em = $this->getDoctrine()->getManager();
		$matImputer=$this->getUser()->getAgent()->getMatricule();
		$entities=$this->agentListByObject($matImputer,"AgentBundle:Affecter",1);
       
         $attente = $em->getRepository('AgentBundle:Affecter')->AffecterImputer(2, $this->getUser());
         //dump($attente); die;
        return $this->render('AgentBundle:Imputation:affecter.html.twig', array(
                // ...
        		'affecter'=>$attente,
            ));
	}

    public function agentListByObject($matImputer=null, $objet=null, /*$idObjet=null,*/ $etat=0){
    	$em = $this->getDoctrine()->getManager();
    	$list=$em->getRepository('AgentBundle:Imputation')->findBy(['objetImputation'=>$objet,'matImputer'=>$matImputer,'etat'=>$etat]);
        $tab=null;
    	foreach ($list as $liste) {
    		# code...
    		$tab[]=['affecter'=>$em->getRepository($objet)->find($liste->getObjetId()),'action' => $liste];
    	}

		//dump($list); die;
    	//dump($tab);
    	//die;
    	return $tab;

    }
    public function test(){
        return "manger";
    }

}

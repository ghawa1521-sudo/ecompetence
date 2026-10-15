<?php

namespace gbaneBundle\Controller;

use AgentBundle\Entity\Agent;
use Agent\AgentBundle\Entity\Historiq_promo;
use gbaneBundle\Entity\Regles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller {

    public function decisionAction($id){
       
        $em = $this->getDoctrine()->getManager();
        if($id){

        $agent=$em->getRepository('AgentBundle:Agent')->find($id);
        if($agent){
            return $this->render('gbaneBundle:Default:decision.html.twig', array('agent' => $agent, 'qr'=>NULL ));
        }
        }
        
        
        

    } 
    
    public function promotionAction($agt, $id) {
        //dump($agent);
             /*$request=$this->getRequest();
             dump($request);
        return $this->forward('gbaneBundle:Default:index',['request'=>$request]);
        dump($request->request);
        die;*/
        $em = $this->getDoctrine()->getManager();
        $agent=$em->getRepository('AgentBundle:Agent')->find($agt);
        $fonctass=$em->getRepository('gbaneBundle:FonctionAssimilees')->find($id);

        $historiq=new Historiq_promo();
        $historiq->setIdFonctionAssimilees($agent->getFonctionAssimilees());
        $historiq->setIdAgent($agent);
        $em->persist($historiq);
        //dump($historiq);

        $agent->setFonctionAssimilees($fonctass);
        $em->persist($agent);

        $em->flush();

        return $this->redirect($this->generateUrl('gbane_homepage'));
        //dump($agent->getFonctionAssimilees()->getLibFonctAss());
       
       // die;

    }

    public function rechercheagentAction(Request $request) {
        //dump(124);die; 

        $form = $this->createForm(new \gbaneBundle\Form\RechercheAgentType());
        $form->handleRequest($request);
        $regles = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $grade = $fonctionassimilees = $anciennetedge = $anciennetegrade =  $ancienneteagent =0;
            $agent = null;

            if ($request->request->get('gbanebundle_regles')['agent'])
             {
                $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $request->request->get('gbanebundle_regles')['agent']]);
                 //dump($agent);die;
                $grade = $agent->getEmploi()->getGrade()->getId();
                $fonctionassimilees = $agent->getFonctionAssimilees()->getId();
                $anciennetedge = intval($agent->anciennete()['anciennetedge']['years']);
                $anciennetegrade = intval($agent->anciennete()['anciennetegrade']['years']);
                $ancienneteagent = intval($agent->anciennete()['ancienneteagent']['years']); 
                
            }

           /* if ($request->request->get('gbanebundle_regles')['fonctionassimilees']) {
                $fonctionassimilees = $request->request->get('gbanebundle_regles')['fonctionassimilees'];
            }

            if ($request->request->get('gbanebundle_regles')['grade']) {
                $grade = $request->request->get('gbanebundle_regles')['grade'];
            }
            if ($request->request->get('gbanebundle_regles')['ancienneteGrade']) {
                $anciennetegrade = $request->request->get('gbanebundle_regles')['ancienneteGrade'];
            }
            if ($request->request->get('gbanebundle_regles')['ancienneteDge']) {
                $anciennetedge = $request->request->get('gbanebundle_regles')['ancienneteDge'];
            }
            if ($request->request->get('agentbundle_agent')['ancienneteAgent']) {
                $ancienneteagent = $request->request->get('agentbundle_agent')['ancienneteAgent'];
            }*/

            
            if ($grade != 0 || $fonctionassimilees != 0 || $anciennetedge != 0 || $anciennetegrade != 0)
                $regleso = $em->getRepository('gbaneBundle:Regles')->findByregles($grade, $fonctionassimilees, $anciennetedge, $anciennetegrade, $agent);

            //dump($regleso); die;
            foreach ($regleso as $r) {
                $regles[$r->getId()] = $r;
            }

              /*  dump($regles);
                 dump($fonctionassimilees);
                 dump($anciennetedge);
                 dump($anciennetegrade);

                die;*/

            $rechercheagent = [];
            #dump($rechercheagent);
            //dump($grade); dump($fonctionassimilees); dump($anciennetedge); dump($anciennetegrade); dump($agent);
            //dump($regles); die;
            if ($agent == null && $regles) {
                foreach ($regles as $key => $value) {
                    $grade = $value->getGrade()->getId();
                    $anciennetedge = $value->getAncienneteDge();
                    $anciennetegrade = $value->getAncienneteGrade();
                    $rechercheagenttemp = $em->getRepository('AgentBundle:Agent')->findByrechercheagent(
                            $grade, $anciennetedge, $anciennetegrade, $value->getId(), $value->getFonctionAssimilees()->getPoidsFonctAss(),0
                    );
                    $rechercheagent = array_merge($rechercheagent, $rechercheagenttemp);
                    $rechercheagenttemp = [];
                }


            }

            //dump($rechercheagent); die; $rechercheagent=($this->array_sort($rechercheagent,'poids',SORT_ASC));



            $rechercheagent = ($this->array_orderby($rechercheagent, 'matricule', SORT_ASC, 'poids', SORT_ASC));
             

            return $this->render('gbaneBundle:Default:resultatagent.html.twig', array('agent' => $agent, 'agents' => $rechercheagent, 'regles' => $regles, 'form' => $form->createView()));
        }

        return $this->render('gbaneBundle:Default:rechercheagent.html.twig', array(/*'regles' => $regles,*/ 'form' => $form->createView()));
    }

    public function indexAction(Request $request) {
        //dump(124);die; 

        $form = $this->createForm(new \gbaneBundle\Form\RechercheType());
        $form->handleRequest($request);
        $regles = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $grade = $fonctionassimilees = $anciennetedge = $anciennetegrade =  $ancienneteagent =0;
            $agent = null;

           /* if ($request->request->get('gbanebundle_regles')['agent'])
             {
                $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $request->request->get('gbanebundle_regles')['agent']]);
                // dump($agent);die;
                $grade = $agent->getEmploi()->getGrade()->getId();
                $fonctionassimilees = $agent->getFonctionAssimilees()->getId();
                $anciennetedge = intval($agent->anciennete()['anciennetedge']['years']);
                $anciennetegrade = intval($agent->anciennete()['anciennetegrade']['years']);
                $ancienneteagent = intval($agent->anciennete()['ancienneteagent']['years']); 

            }*/

            if ($request->request->get('gbanebundle_regles')['fonctionassimilees']) {
                $fonctionassimilees = $request->request->get('gbanebundle_regles')['fonctionassimilees'];
            }

            if ($request->request->get('gbanebundle_regles')['grade']) {
                $grade = $request->request->get('gbanebundle_regles')['grade'];
            }
            if ($request->request->get('gbanebundle_regles')['ancienneteGrade']) {
                $anciennetegrade = $request->request->get('gbanebundle_regles')['ancienneteGrade'];
            }
            if ($request->request->get('gbanebundle_regles')['ancienneteDge']) {
                $anciennetedge = $request->request->get('gbanebundle_regles')['ancienneteDge'];
            }
            if ($request->request->get('agentbundle_agent')['ancienneteAgent']) {
                $ancienneteagent = $request->request->get('agentbundle_agent')['ancienneteAgent'];
            }

            //
            if ($grade != 0 || $fonctionassimilees != 0 || $anciennetedge != 0 || $anciennetegrade != 0)
                $regleso = $em->getRepository('gbaneBundle:Regles')->findByregles($grade, $fonctionassimilees, $anciennetedge, $anciennetegrade, $agent);

            //dump($regleso); die;
            foreach ($regleso as $r) {
                $regles[$r->getId()] = $r;
            }

              /*  dump($regles);
                 dump($fonctionassimilees);
                 dump($anciennetedge);
                 dump($anciennetegrade);

                die;*/

            $rechercheagent = [];
            #dump($rechercheagent);
            //dump($grade); dump($fonctionassimilees); dump($anciennetedge); dump($anciennetegrade); dump($agent);

            if ($agent == null && $regles) {
                foreach ($regles as $key => $value) {
                    $grade = $value->getGrade()->getId();
                    $anciennetedge = $value->getAncienneteDge();
                    $anciennetegrade = $value->getAncienneteGrade();
                    $rechercheagenttemp = $em->getRepository('AgentBundle:Agent')->findByrechercheagent(
                            $grade, $anciennetedge, $anciennetegrade, $value->getId(), $value->getFonctionAssimilees()->getPoidsFonctAss(),0
                    );
                    $rechercheagent = array_merge($rechercheagent, $rechercheagenttemp);
                    $rechercheagenttemp = [];
                }


            }

            //dump($rechercheagent); die; //$rechercheagent=($this->array_sort($rechercheagent,'poids',SORT_ASC));



            $rechercheagent = ($this->array_orderby($rechercheagent, 'matricule', SORT_ASC, 'poids', SORT_ASC));


            return $this->render('gbaneBundle:Default:resultat.html.twig', array('agent' => $agent, 'agents' => $rechercheagent, 'regles' => $regles, 'form' => $form->createView()));
        }

        return $this->render('gbaneBundle:Default:recherche.html.twig', array('regles' => $regles, 'form' => $form->createView()));
    }

    public function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function array_orderby() {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    public function profilAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $regles=[];
        // $touslesagents = $em->getRepository('AgentBundle:Agent')->findBy([],['nom'=>'ASC']);
        $regleso = $em->getRepository('gbaneBundle:Regles')->findBy([]);
       
        foreach ($regleso as $r) {
                $regles[$r->getId()] = $r;
            }

        
        //$regles = $em->getRepository('gbaneBundle:Regles')->findByregles($grade,$fonctionassimilees,$anciennetedge,$anciennetegrade,$agent); 
        $rechercheagent = [];
        if ($regles) {
           
            /*foreach ($regles as $key => $value) {

                $grade = $value->getGrade()->getId();
                $anciennetedge = $value->getAncienneteDge();
                $anciennetegrade = $value->getAncienneteGrade();
                $rechercheagent[$value->getId()] = $em->getRepository('AgentBundle:Agent')->findByrechercheagent(
                        $grade, $anciennetedge, $anciennetegrade
                );
            }*/

            foreach ($regles as $key => $value) {
                    $grade = $value->getGrade()->getId();
                    $anciennetedge = $value->getAncienneteDge();
                    $anciennetegrade = $value->getAncienneteGrade();
                    $rechercheagenttemp = $em->getRepository('AgentBundle:Agent')->findByrechercheagent(
                            $grade, $anciennetedge, $anciennetegrade, $value->getId(), $value->getFonctionAssimilees()->getPoidsFonctAss()
                    );
                    $rechercheagent = array_merge($rechercheagent, $rechercheagenttemp);
                    $rechercheagenttemp = [];
                }
        }
        $rechercheagent = ($this->array_orderby($rechercheagent, 'matricule', SORT_ASC, 'poids', SORT_ASC));
        $agts=$table=[];
        foreach($rechercheagent as $agt){
         if(!in_array($agt['matricule'],$table)){
         $table[]= $agt['matricule']; 
         $agts[]=$agt;
         }       
        }
        
       //dump($rechercheagent);
       // die;
       
        return $this->render('gbaneBundle:Default:profil.html.twig', array('regles' => $regles, 'agents' => $agts));
    }

}

/*
namespace gbaneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name=0)
    {
        return $this->render('gbaneBundle:Default:index.html.twig', array('name' => $name));
    }
}*/

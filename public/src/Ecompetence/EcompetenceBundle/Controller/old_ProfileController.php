<?php
namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ecompetence\EcompetenceBundle\Form\CompetenceRechercheType;
class ProfileController extends Controller
{    use \Ecompetence\EcompetenceBundle\Entity\traitfuncion ;
    public $domaine=array();
    public function profileAction(Request $request)
    { 
        $agent=[];
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AgentBundle:Agent')->AfficherAgentExp();
        $i=0;
        foreach ($entities as $entity)
        { $structure=null;
            //$Agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $entity->getId()]);
          if($entity && $entity->getdirection())
          {
              $structure=$entity->getDirection()->getSigle();
          }
           $expdebut = $em->getRepository('EcompetenceBundle:Experience')->findDateMin($entity->getId());
           $expfin = $em->getRepository('EcompetenceBundle:Experience')->findDateMax($entity->getId());
           
           if(!$expdebut)
           {
            $anexp=null;
         
           }
           else
           {
          // $structure=$expfin[0]->getStructure()->getLibStructure(); 
           $datedebut=$expdebut[0]->getDateDebExp();
           $datefin=$expfin[0]->getDateFinExp();
           
           if($datefin==null)
           {
              $datefin=new \DateTime('now');
           }
           $interval = $datefin->diff($datedebut);
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $anexp=$interval->format('%y an');
           }
           else
           {
            $anexp= $age=$interval->format('%y ans');  
           }
           }
           $anexpdge=null;
           $datePdge=$entity->getDatePriseServiceDge();
           if($datePdge){
           $datefindge=new \DateTime('now');
           $interval = $datefindge->diff($datePdge);          
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $anexpdge=$interval->format('%y an');
           }
           else
           {
            $anexpdge=$interval->format('%y ans');  
           }
           }
           
          
           $age=null;
           $datenais=$entity->getDateNaiss();
           if($datenais){
           $datejour=new \DateTime('now');
           $interval = $datejour->diff($datenais);
           
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $age=$interval->format('%y an');
           }
           else
           {
            $age=$interval->format('%y ans');  
           }
           }
        
            $agent[$i]=array('id'=>$entity->getId(),
                            'matricule'=>$entity->getMatricule(),
                            'nom'=>$entity->getNom(),
                            'prenoms'=>$entity->getPrenoms(),
                            'situationMatri'=>$entity->getSituationMatri(),
                            'NomJeuneFille'=>$entity->getNomJeuneFille(),
                            'age'=>$age,
                            'anexp'=>$anexp,
                             'employeur'=>$structure,
                            'emploi'=>$entity->getEmploi()->getLibEmpl(),
                            'poste'=>$entity->getFonction()->getLibFonc(),
                            'anexpdge'=>$anexpdge                          
        );
          
                           
         $i++;

        }  
       // $entities = $em->getRepository('EcompetenceBundle:Experience')->findProfileByParametres();
        $form = $this->createForm(new CompetenceRechercheType());     
        $request = $this->getRequest();
        $this->domaine=[];
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $agent=[];$i=0;
                $domain=array();
                $results=array();
                $em = $this->getDoctrine()->getManager();
                $data = $this->getRequest()->request->get('comptence_ecompetencebundle_rechercher');
                $data1 = $request->request->get('competences');
                if($data1)
                {
                foreach($data1 as $tree){
                $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]) ; 
                $domain[]=$domaines;
                $this->domaine[]=$domaines->getId(); 
                }
                $results = $this->tree_recherche_parent($domain);  
                foreach($results as $result)
                {
                      $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$result]);
                      $this->domaine[]=$competence->getId(); 
                }
                }
                $entities = $em->getRepository('AgentBundle:Agent')->findProfileByParametres($data,$data1);
                if($data1)
                {
                $entit=array();
                $n=0;
                foreach ($entities as $entity)
                { 
                    $comps= $em->getRepository('EcompetenceBundle:Agentcompetence')->findBy(['agent'=>$entity->getId()]);
                    $i=0;
                    $compces=array();
                    foreach ($comps as $comp)
                    {
                       $compces[$i]=strval($comp->getCompetence()->getId());
                       $i++;
                    }   
                   $trouve=false;
                 
                   foreach ($data1 as $donnee)
                   { 
                      if(!in_array($donnee,$compces)) 
                      {
                        $trouve=true;
                      }
                   }
                   
                   if ($trouve==false) 
                   {
                    $entit[$n]= $entity; 
                    $n++;
                   }
                   }
                   $entities=$entit;
               
                   }
           foreach ($entities as $entity)
           { $structure=null;
            //$Agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $entity->getId()]);
            if($entity && $entity->getdirection())
            {
              $structure=$entity->getDirection()->getSigle();
            }
           $expdebut = $em->getRepository('EcompetenceBundle:Experience')->findDateMin($entity->getId());
           $expfin = $em->getRepository('EcompetenceBundle:Experience')->findDateMax($entity->getId());
         
           if(!$expdebut)
           {
            $anexp=null;  
           }
           else
           {
           //$structure=$expfin[0]->getStructure()->getLibStructure(); 
           $datedebut=$expdebut[0]->getDateDebExp();
           $datefin=$expfin[0]->getDateFinExp();
           
           if($datefin==null)
           {
              $datefin=new \DateTime('now');
           }
           $interval = $datefin->diff($datedebut);
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $anexp=$interval->format('%y an');
           }
           else
           {
            $anexp= $age=$interval->format('%y ans');  
           }
           }
           $anexpdge=null;
           $datePdge=$entity->getDatePriseServiceDge();
           if($datePdge){
           $datefindge=new \DateTime('now');
           $interval = $datefindge->diff($datePdge);
           
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $anexpdge=$interval->format('%y an');
           }
           else
           {
            $anexpdge=$interval->format('%y ans');  
           }
           }
           
          
           $age=null;
           $datenais=$entity->getDateNaiss();
           if($datenais){
           $datejour=new \DateTime('now');
           $interval = $datejour->diff($datenais);
           
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $age=$interval->format('%y an');
           }
           else
           {
            $age=$interval->format('%y ans');  
           }
           }
          
              
            $agent[$i]=array('id'=>$entity->getId(),
                            'matricule'=>$entity->getMatricule(),
                            'nom'=>$entity->getNom(),
                            'prenoms'=>$entity->getPrenoms(),
                            'situationMatri'=>$entity->getSituationMatri(),
                            'NomJeuneFille'=>$entity->getNomJeuneFille(),
                            'age'=>$age,
                            'anexp'=>$anexp,
                            'employeur'=>$structure,
                            'emploi'=>$entity->getEmploi()->getLibEmpl(),
                            'poste'=>$entity->getFonction()->getLibFonc(),
                            'anexpdge'=>$anexpdge
                       
                            
            );
        
                           
               $i++;
            }
      
           
               $competences= $em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>null],['libDomaine'=>'asc']);
                return $this->render('EcompetenceBundle:Agent:rechercheprofil.html.twig', array(
                            'entities' => $entities,'agents'=>$agent,'competences'=>$competences,
                            'form' => $form->createView(),
                            'name' => $this->domaine,
                        ));
         }  
        }
       
        $competences= $em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>null],['libDomaine'=>'asc']);
        return $this->render('EcompetenceBundle:Agent:rechercheprofil.html.twig', array(
                    'entities' => $entities,'competences'=>$competences,'agents'=>$agent,
                    'form' => $form->createView(),
                    'name' =>$this->domaine,
        ));
    
}

public function competenceapiAction(Request $request)
{
    $cmp=array();
    $response = new JsonResponse();
    if( $request->request->get('champ')=="")
    {
       $cmp=[]; 
    }
    else
    { $cmp=explode(',',$request->request->get('champ'));
    }
   
    $em = $this->getDoctrine()->getManager();
    $domaines=$em->getRepository('EcompetenceBundle:Domaine')->Listedomaine();
    $tab = array();
    $i= 0;
    foreach ($domaines as $key => $domaine) {
         if($domaine->getParent())
         {
         $parent=$domaine->getParent()->getId();
                 
         }
         else
         {
         $parent=Null;    
         }
         if(in_array($domaine->getId(),$cmp))
         {
          $checked=true;   
         }
         else
         {
          $checked=false;
         }
        $tab[$key] = array('id' => $domaine->getId(),
                         'parent_id' =>$parent,
                         'label' => $domaine->getLibDomaine(),
                         'value' => $domaine->getId(),
                         'checked'=>$checked
                )
                         ;
        
    }
    //dump($tab); die;
    
  $result = $this->buildTree($tab);
  
  
  // dump(json_encode($result)); die;
  
 // $response->setData($result);
 
  
  return $response->setData(json_encode($result)); 
}
}

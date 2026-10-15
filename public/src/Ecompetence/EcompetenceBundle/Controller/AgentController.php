<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AgentController extends Controller
{
  use \Ecompetence\EcompetenceBundle\Entity\traitfuncion ;
    
        public function indexAction() {    
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AgentBundle:Agent')->afficherAgent();     
        return $this->render('EcompetenceBundle:Agent:index.html.twig', array(
                    'entities' => $entities          
        ));
    }
    
    
     public function cvAction(Request $request,$id)
     {     $em = $this->getDoctrine()->getManager();
           $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
      
        return $this->render('EcompetenceBundle:Experience:cv.html.twig', array(
                    'id' => $id, 'entit'=>$agent
        )); 
     }
     
    
     public function cv1Action($id)
    {
        $em = $this->getDoctrine()->getManager();
        $domaines=  $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>Null]);
        $listedomaine[]=Null;
   
        $competences= $em->getRepository('EcompetenceBundle:Agentcompetence')->findBy(['agent'=>$id]);
       
        $peres=[];
        foreach ($competences as $value) {
            if($value->getCompetence() && $value->getCompetence()->getParent()==null){
                            $peres[]=$value;

            }
        }
        $i=0;
        $cp=[];
        if($competences)
        {    
           
          foreach($competences as $competence)
          {
           $cp[$competence->getCompetence()->getId()]=$competence->getCompetence()->getId();
           $dom=$em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$competence->getCompetence()->getId()]);
          $listedomaine[$i]=$dom;
           $i++;
          }
         
        }
        
        $niveaulangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id]);
        $entity = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent'=>$id],['dateDebExp'=>'desc']);
        $agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findBy(['agent'=>$id],['dateObtentiondiplo'=>'desc']);
        $connaissances = $em->getRepository('EcompetenceBundle:ConnaissanceInformatique')->findBy(['agent' => $id], ['libelle' => 'asc']);
        $decorations = $em->getRepository('EcompetenceBundle:Decoration')->findBy(['agent' => $id], ['annee' => 'desc']);
      
        return $this->render('EcompetenceBundle:Experience:preview_pdf.html.twig', array(
                    'exprs' => $entity,'id'=>$id,'formation'=> $formation,'niveaulangue'=>$niveaulangue,'domaines'=>$domaines,
                    'listedomaines'=>$listedomaine,'competences'=>$competences,'peres'=>$peres,'cp'=>$cp,'agent'=>$agent,'connaissances'=>$connaissances,
                    'decorations'=>$decorations,
                    
        ));
     
    }
    
    public function cvapiAction($id)
    {
             $response = new JsonResponse();
        $cmp=array();
       // $entity = new Agent();
        $em = $this->getDoctrine()->getManager();
        $domaines=$em->getRepository('EcompetenceBundle:Domaine')->Listedomaine();
        $comps=$em->getRepository('EcompetenceBundle:Agentcompetence')->listecompetence($id);
         foreach ($comps as $comp) {
           $cmp[]=$comp['id'] ; 
         }
        
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

<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Form\AgentRechercheType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Ecompetence\EcompetenceBundle\Entity\Experience;
use Ecompetence\EcompetenceBundle\Entity\Agentcompetence;
use Ecompetence\EcompetenceBundle\Entity\Agent_Langue;
use Ecompetence\EcompetenceBundle\Entity\Formation;
use Symfony\Component\HttpFoundation\Request;

class AgentController extends Controller
{
  use \Ecompetence\EcompetenceBundle\Entity\traitfuncion ;
    
        public function indexAction() {
        //dump("z");
        //return $this->redirect($this->generateUrl('agent_identification_home'));
        //dump("a");
        //die;
            
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Agent')->afficherAgent();
      
       // $form = $this->createForm(new AgentRechercheType());
              
      //  $request = $this->getRequest();
      //  if ($request->getMethod() == 'POST') {

         //   $form->bind($request);

//On vérifie que les valeurs entrées sont correctes
//dump($form->isValid());die;
           // if ($form->isValid()) {
             
               // $em = $this->getDoctrine()->getManager();
//On récupère les données entrées dans le formulaire par l'utilisateur
              //  $data = $this->getRequest()->request->get('agent_ecompetencebundle_rechercheragent');
                //$entities = $em->getRepository('AgentBundle:Agent')->findAgentByParametres($data);
               // return $this->render('EcompetenceBundle:Agent:index.html.twig', array(
                          //  'entities' => $entities,
                           // 'form' => $form->createView()
              //  ));
           // }
      //  }

        return $this->render('EcompetenceBundle:Agent:index.html.twig', array(
                    'entities' => $entities
                   
        ));
    }
    
    
     public function cvAction(Request $request,$id)
     {  
         
      
        return $this->render('EcompetenceBundle:Experience:cv.html.twig', array(
                    'id' => $id
        )); 
     }
     
    
     public function cv1Action(Request $request,$id)
    {
       $frlire= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",      
         );
        $frecrire= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",     
         );
         $frparler= array(
  
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",    
         );
          $anglire= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",   
         );
           $angecrire= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",     
         );
           $angparler= array(
        
         "Faible"=>"Faible",
         "Passable"=>"Passable",
         "Courant"=>"Courant",
         "Excellent"=>"Excellent",     
         );
         $form3 = $this->createFormBuilder()
         ->add('frlire','choice', array(
                    'placeholder' => ' ',
                    'choices' => $frlire,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
         ->add('frecrire','choice', array(
                    'placeholder' => ' ',
                    'choices' => $frecrire,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
         ->add('frparler','choice', array(
                    'placeholder' => ' ',
                    'choices' => $frparler,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
         ->add('anglire','choice', array(
                    'placeholder' => ' ',
                    'choices' => $anglire,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
         ->add('angecrire','choice', array(
                    'placeholder' => ' ',
                    'choices' => $angecrire,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
         ->add('angparler','choice', array(
                    'placeholder' => ' ',
                    'choices' => $angparler,
                    'expanded' => false,
                    'multiple' => false,
                    'label' => ''))
          ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer le niveau de langue'))
          ->getForm();
           
               $form2 = $this->createFormBuilder()
               ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer les compétence'))
               ->getForm();
       // $entity = new Agent();
        $expr = new Experience();
        $format = new Formation();
        $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        $form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\ExperienceType::class,$expr);
        $form->handleRequest($request);
        $form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\FormationType::class,$format);
        $form1->handleRequest($request);
        $form2->handleRequest($request);
        $form3->handleRequest($request);
        $domaines=  $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>Null]);
       // $parents=$em->getRepository('EcompetenceBundle:Domaine')->findAll();
        $listedomaine[]=Null;
       /*  $request = $this->getRequest();
         
         if ($request->getMethod() == 'POST') {
           $form->bind($request);
           if ($form->isValid()) {
               dump(1233); die;
              $expr->setAgent($agent); 
              $em->persist($expr);
              $em->flush();
              $this->addFlash('notice', 'Expérience ajouté avec succès');
              return $this->redirectToRoute('agent_cv',['id'=>$id]);
           }
         }
         
          if ($request->getMethod() == 'POST') {
           $form1->bind($request);
           if ($form1->isValid()) {
             $format->setAgent($agent); 
                $em->persist($format);
                $em->flush();
                $this->addFlash('notice', 'Formation ajoutée avec succès');
                return $this->redirectToRoute('agent_cv',['id'=>$id]);
           }
          }

         
          if ($request->getMethod() == 'POST') {
           $form3->bind($request);
           if ($form3->isValid()) {
            $Langue = new Agent_Langue();
               $lang1= $em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>1]);
               $lang2= $em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>2]);
               $Langue->setAgent($agent);
               $Langue->setLangue($lang1);
               $Langue->setLire($request->request->get('frlire'));
               $Langue->setEcrire($request->request->get('frecrire'));
               $Langue->setParler($request->request->get('frparler'));
               $em->persist($Langue);
               $Langue = new Agent_Langue();
               $Langue->setAgent($agent);
               $Langue->setLangue($lang2);
               $Langue->setLire($request->request->get('anglire'));
               $Langue->setEcrire($request->request->get('angecrire'));
               $Langue->setParler($request->request->get('angparler'));
               $em->persist($Langue);  
               $em->flush();
               $this->addFlash('notice', 'Langue enregistré avec succès');
               return $this->redirectToRoute('agent_cv',['id'=>$id]);
           }
          }
          if ($request->getMethod() == 'POST') {
           $form2->bind($request);
           if ($form2->isValid()) {
               dump(1256);die;
            $trees=$request->request->get('tree');
            
               if ($trees)
               { $i=0;
               foreach($trees as $tree)
               {    
                $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]);
                $comp = new Agentcompetence();
                $comp->setAgent($agent);
                $comp->setCompetence($competence);
                $em->persist($comp);
                $em->flush();
                $this->addFlash('notice', 'Compétences actualisées avec succès');
                return $this->redirectToRoute('agent_cv',['id'=>$id]);   
           } 
           }

            
         }*/
        
            
        $bouton=$request->request->get('bouton');
        
        if ($bouton!=Null)
        {
           if ($bouton==1) 
           {  
  
           $expr->setAgent($agent); 
           $em->persist($expr);
           $em->flush();
            $this->addFlash('notice', 'Expérience ajouté avec succès');
           return $this->redirectToRoute('agent_cv',['id'=>$id]);
         }
           if ($bouton==2) 
           {  
              
                $format->setAgent($agent); 
                $em->persist($format);
                $em->flush();
                $this->addFlash('notice', 'Formation ajoutée avec succès');
                return $this->redirectToRoute('agent_cv',['id'=>$id]);
           }
            if ($bouton==3) 
           { /*     $frlire->$request->request->get('frlire');
                  $frecrire->$request->request->get('frecrire');
                  $frparler->$request->request->get('frparler');
                  $anglire->$request->request->get('anglire');
                  $angecrire->$request->request->get('angecrire');
                  $angparler->$request->request->get('angparler');
            if (isset($request->request->get('frlire')) && isset()$frecrire &$frparler && $anglire && $angecrire &$angparler)
            {*/
               $Langue = new Agent_Langue();
               $lang1= $em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>1]);
               $lang2= $em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>2]);
               $Langue->setAgent($agent);
               $Langue->setLangue($lang1);
               $Langue->setLire($request->request->get('frlire'));
               $Langue->setEcrire($request->request->get('frecrire'));
               $Langue->setParler($request->request->get('frparler'));
               $em->persist($Langue);
               $Langue = new Agent_Langue();
               $Langue->setAgent($agent);
               $Langue->setLangue($lang2);
               $Langue->setLire($request->request->get('anglire'));
               $Langue->setEcrire($request->request->get('angecrire'));
               $Langue->setParler($request->request->get('angparler'));
               $em->persist($Langue);  
               $em->flush();
               $this->addFlash('notice', 'Langue enregistré avec succès');
               return $this->redirectToRoute('agent_cv',['id'=>$id]);
          }
           
           if ($bouton==4) 
           { 
               $trees=$request->request->get('tree');
            
               if ($trees)
               { $i=0;
               foreach($trees as $tree)
               {    
                      $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]);
                      $comp = new Agentcompetence();
                      $comp->setAgent($agent);
                      $comp->setCompetence($competence);
                      $em->persist($comp);
                     
              /*    $trouve=false;
                   foreach($parents as $parent )
                   
                  { if ($parent->getParent()) 
                  {   if ($tree==$parent->getParent()->getId())
                    { 
                     $trouve=true;
                    }
                  }
                  }
                  if ($trouve==false)
                  {   $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]);
                      $comp = new Agentcompetence();
                      $comp->setAgent($agent);
                      $comp->setCompetence($competence);
                      $em->persist($comp);  
                    
                      
                  }  */
               
               }
              
           $em->flush();
           $this->addFlash('notice', 'Compétences actualisées avec succès');
           return $this->redirectToRoute('agent_cv',['id'=>$id]);   
           }  
         }
        }   
        
    /*  $tab = array();
        $i= 0;
        foreach ($domaines as $key => $domaine) {
               
            $tab[$key] = array('id' => $domaine->getId(),
                             'parent_id' => $domaine->getParent()->getId(),
                             'titre' => $domaine->getLibDomaine()
                    )
                             ;
            
        }
        
        
     dump($tab);die;
        
        
       $result = $this->buildTree($tab);*/
       
       // dump($result);die();
       //$this->recurse_tree($domaines, 0);
        
       
      // $tree[]=$this->recurse_tree($domaine[0]->getParent()->getId(), $domaine[0]->getLevel(), $domaine);
        // dump($tree); die;
        $formview=$form->createView();
        
        $formview1=$form1->createView();
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
      
        /* if (!$competence->getParent()) 
                      {    
                      
                      }*/
        $niveaulangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id]);
        $entity = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent'=>$id]);
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findBy(['agent'=>$id]);
        return $this->render('EcompetenceBundle:Experience:cv.html.twig', array(
                    'entity' => $entity,'id'=>$id,'formation'=> $formation,'niveaulangue'=>$niveaulangue,'domaines'=>$domaines,
                    'form' => $formview,'form1'=>$formview1,'form2'=>$form2->createView(),'form3'=>$form3->createView(),'listedomaines'=>$listedomaine,'competences'=>$competences,'peres'=>$peres,'cp'=>$cp
                    
        ));
     
    }
    
        public function cvapiAction()
    {
             $response = new JsonResponse();
   
       // $entity = new Agent();
        $em = $this->getDoctrine()->getManager();
        $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findAll();
        
        
      $tab = array();
        $i= 0;
        foreach ($domaines as $key => $domaine) {
               
            $tab[$key] = array('id' => $domaine->getId(),
                             'parent_id' => $domaine->getParent()->getId(),
                             'titre' => $domaine->getLibDomaine()
                    )
                             ;
            
        }    
        //dump($tab);die;  
      $result = $this->buildTree($tab);
      
      $response->setData($result);
      
      return $response; 
    }
    
    
   
}

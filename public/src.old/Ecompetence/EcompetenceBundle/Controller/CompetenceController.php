<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Entity\Agentcompetence;
use Ecompetence\EcompetenceBundle\Entity\Competence;
use Ecompetence\EcompetenceBundle\Form\CompetenceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Ecompetence\EcompetenceBundle\Entity\Domaine;
use Ecompetence\EcompetenceBundle\Form\DomaineType;

class CompetenceController extends Controller
{
  use \Ecompetence\EcompetenceBundle\Entity\traitfuncion ;
       
        public function newAction(Request $request, $id) {
       // $entities=null;
         
         $em = $this->getDoctrine()->getManager(); 
         $form = $this->createFormBuilder()
               ->add('enregistrer', 'submit', array('label' => '+  Enrégistrer les compétences'))
               ->getForm();
        $domaines=  $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>Null],['libDomaine'=>"asc"]);
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        $listedomaine[]=Null; 
        $bouton=$request->request->get('bouton');
        $domaine=null;
        if ($bouton!=Null)
        {
         if ($bouton==4) 
           {         $domain=array();
                     $results=array();
                    
                     $trees=$request->request->get('competences');
                     if($trees)
                     {
                     foreach($trees as $tree){
                     $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]) ; 
                     $domain[]=$domaines;
                     $domaine[]=$domaines; 
                     }
                     $results = $this->tree_recherche_parent($domain);  
                     $cmps=$em->getRepository('EcompetenceBundle:Agentcompetence')->findBy(['agent'=>$id]) ;
                     foreach($cmps as $cmp)
                     {
                         $em->remove($cmp); 
                         $em->flush();  
                     }
                    
                    foreach($results as $result)
                    {
                      $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$result]);
                      $domaine[]=$competence;
                      $comp = new Agentcompetence();
                      $comp->setAgent($agent);
                      $comp->setCompetence($competence);
                      $em->persist($comp);
                      $em->flush();
                    }
                    foreach($trees as $tree)
                    {
                      $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]);
                      $comp = new Agentcompetence();
                      $comp->setAgent($agent);
                      $comp->setCompetence($competence);
                      $em->persist($comp);
                      $em->flush();
                    }
                     $this->addFlash('notice', 'Compétences enregistrées avec succès');
                }
                else
                {
                     $cmps=$em->getRepository('EcompetenceBundle:Agentcompetence')->findBy(['agent'=>$id]) ;
                     foreach($cmps as $cmp)
                     {
                         $em->remove($cmp); 
                         $em->flush();  
                     }
                 
                 foreach ($results as $result) {
                        $competence = $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id' => $result]);
                        $domaine[] = $competence;
                        // Vérification si la compétence existe déjà pour l'agent
                        $existingComp = $em->getRepository('EcompetenceBundle:Agentcompetence')->findOneBy([
                            'agent' => $agent,
                            'competence' => $competence
                        ]);
                        if (!$existingComp) {
                            $comp = new Agentcompetence();
                            $comp->setAgent($agent);
                            $comp->setCompetence($competence);
                            $em->persist($comp);
                            $em->flush();
                        }
                    }

                  foreach ($trees as $tree) {
                        $competence = $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id' => $tree]);

                        // Vérification si la compétence existe déjà pour l'agent
                        $existingComp = $em->getRepository('EcompetenceBundle:Agentcompetence')->findOneBy([
                            'agent' => $agent,
                            'competence' => $competence
                        ]);

                        if (!$existingComp) {
                            $comp = new Agentcompetence();
                            $comp->setAgent($agent);
                            $comp->setCompetence($competence);
                            $em->persist($comp);
                            $em->flush();
                        }
                    }
                
                     $this->addFlash('notice', 'Compétences enregistées avec succès');
               }
            
               return $this->redirectToRoute('competence_recap',['id'=>$id]);

          }
        
        }
       
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
       
        
        return $this->render('EcompetenceBundle:Competence:new.html.twig', array(
                
                    'form'=>$form->createView(),'competences'=>$competences,'peres'=>$peres,'cp'=>$cp, 'id'=>$id,'entit'=>$agent
                    
        ));
        
    }


    public function recapAction($id) {
       
       $em = $this->getDoctrine()->getManager(); 
       $domaines=  $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>Null],['libDomaine'=>"asc"]);
       $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
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
      
       
       return $this->render('EcompetenceBundle:Competence:recap.html.twig', array(
               
                   'competences'=>$competences,'peres'=>$peres,'cp'=>$cp, 'id'=>$id,'entit'=>$agent
                   
       ));
       
   }



   /* public function ajoutCompetenceAction(Request $request)
    {
        /*$entity = new Competence();
         $form = $this->createForm(new competenceType(), $entity, array(
            'action' => $this->generateUrl('competence_ajoutCompetence'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $this->render('EcompetenceBundle:Competence:ajoutCompetence.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));*/
        
        
       /* $entity = new Domaine();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            //return $this->redirect($this->generateUrl('competence_ajoutCompetence', array('id' => $entity->getId())));
        }
        return $this->render('EcompetenceBundle:Competence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    private function createCreateForm(Domaine $entity)
    {
        $form = $this->createForm(new DomaineType(), $entity, array(
            'action' => $this->generateUrl('domaine_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }*/

    
}         
   

 
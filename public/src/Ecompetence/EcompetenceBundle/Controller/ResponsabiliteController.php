<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Entity\Agent_atout;
use Ecompetence\EcompetenceBundle\Entity\Agent;
use Ecompetence\EcompetenceBundle\Entity\Responsabilite;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;
class ResponsabiliteController extends Controller
{
 
    public function NewAction(Request $request,$id) { 
        
    $ag=$id;
    $em = $this->getDoctrine()->getManager();
    $agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
   
    $originalRespo = new ArrayCollection();

    // Create an ArrayCollection of the current Tag objects in the database
    foreach ($agent->getResponsabilite() as $resp) {
        $originalRespo->add($resp);
    }
    $form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\AgentRespoType::class, $agent);
    $form->handleRequest($request);
    if ($form->isValid()) {
        foreach ($originalRespo as $respo) {
            if (false === $agent->getResponsabilite()->contains($respo)) {

                $em->remove($respo);
            }
        }

        $em->flush();
        $this->addFlash('notice', 'Enregistrement effectué avec succès');
    }
             
      $formview=$form->createView();
      return $this->render('EcompetenceBundle:Responsabilte:new.html.twig',array(
      'entity'=>$agent,'id'=>$ag,'form' => $formview
      
        
));
    }
    
    
      
}

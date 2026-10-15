<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Entity\Agent_Langue;
use Ecompetence\EcompetenceBundle\Entity\Agent;
use Ecompetence\EcompetenceBundle\Entity\Langue;
use Ecompetence\EcompetenceBundle\Entity\TypeLangue;
use Symfony\Component\HttpFoundation\Request;
use Ecompetence\EcompetenceBundle\Form\LangueType;
use Symfony\Component\HttpFoundation\JsonResponse;

class LangueController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EcompetenceBundle:Langue')->findAll();

        return $this->render('EcompetenceBundle:Langue:index.html.twig', array(
            'entities' => $entities,
        ));
    }
 
    public function NewAction(Request $request,$id) {
        
         $lgue=array();
        // $typlang=new TypeLangue();
         $ag=$id;
         $agentlangue=new Agent_Langue();
         $em = $this->getDoctrine()->getManager();
         $langue=$em->getRepository('EcompetenceBundle:Langue')->findAll();
         $typeLangues=$em->getRepository('EcompetenceBundle:TypeLangue')->findAll();
         //$form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\Agent_LangueType::class,$agentlangue);
         $request = $this->get('request');
         if ($request->getMethod() == 'POST') {
          // $form->bind($request);  
           $lang=$request->request->get('langue');
           $aglangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id]);
           foreach ($aglangue as $aglg)
           {
               $lgue[]=strval($aglg->getLangue()->getId());
           }
         
           if ($lang)
           {
           // $typlang=$request->request->get('typelangue');
            $ecrire=$request->request->get('ecrire');
            $lire=$request->request->get('lire');
            $parler=$request->request->get('parler');
            //dump($parler);die;
         
            $i=0;
           
            foreach ($lang as $lg)
            {  
                if(in_array($lg,$lgue))
                 {  $aglangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findOneBy(['agent'=>$id,'langue'=>$lg]);
                    $em->remove($aglangue);
                    $em->flush(); 
                    $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
                    $langue=$em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>$lg]);
                    $agentlangue=new Agent_Langue();
                    $agentlangue->setAgent($agent);
                    $agentlangue->setLangue($langue);
                    //$agentlangue->setLangue($typlang);
                    $agentlangue->setLire($lire[$i]);
                    $agentlangue->setEcrire($ecrire[$i]);
                    $agentlangue->setParler($parler[$i]);
                    $em->persist($agentlangue);
                    $em->flush();

                 }
                 else
                 {
                    
                    $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
                    $langue=$em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>$lg]);
                    $agentlangue=new Agent_Langue();
                    $agentlangue->setAgent($agent);
                    $agentlangue->setLangue($langue);
                    //$agentlangue->setLangue($typlang);
                    $agentlangue->setLire($lire[$i]);
                    $agentlangue->setEcrire($ecrire[$i]);
                    $agentlangue->setParler($parler[$i]);
                    $em->persist($agentlangue);
                    $em->flush();  
                 }
                 $i++;

                   /* $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
                    $langue=$em->getRepository('EcompetenceBundle:Langue')->findOneBy(['id'=>$lg[$i]]);
                    $agentlangue=new Agent_Langue();
                    $agentlangue->setAgent($agent);
                    $agentlangue->setLangue($langue);
                    $agentlangue->setLire($lire[$i]);
                    $agentlangue->setEcrire($ecrire[$i]);
                    $agentlangue->setParler($parler[$i]);
                    $em->persist($agentlangue);
                    $em->flush();*/
              
                
            }
            
              $this->addFlash('notice', 'Enregistrement effectué avec succès');
                return $this->redirectToRoute('langue_new',['id'=>$id]);

           }
          
          // dump($lang);dump($ecrire);dump($lire);dump($parler); die;
           //$aglangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id,'langue'=>$agentlangue->getLangue()->getId()]);
  
       //On vérifie que les valeurs entrées sont correctes
           /*if ($form->isValid()) {
            dump($lang);dump($ecrire);dump($lire);dump($parler); die;
            $aglangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id,'langue'=>$agentlangue->getLangue()->getId()]);

            if($aglangue)  
            {
                $this->addFlash('notice', 'Cette langue a été déjà ajouté, cliquez sur modifier si vous souhaitez la modifier');
                return $this->redirectToRoute('langue_new',['id'=>$id]);
            }
            else
            {
                $agent=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
                $agentlangue->setAgent($agent);
                $em->persist($agentlangue);
                $em->flush();
                $this->addFlash('notice', 'Cette langue a été ajouté avec succès');
                return $this->redirectToRoute('langue_new',['id'=>$id]);
            }  

        }*/
        } 
        $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        $niveaulangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$id]);
         //dump($niveaulangue); die;
        return $this->render('EcompetenceBundle:Langue:new.html.twig', array(
                    'id'=>$id,'niveaulangue'=>$niveaulangue,'langue'=>$langue,'entity'=>$entity,'ag'=>$ag,'typeLangues'=>$typeLangues
                  
                    
        ));
     
    }
    
     public function suppAction($id,$ag) {
         $em = $this->getDoctrine()->getManager();
         $langue=$em->getRepository('EcompetenceBundle:Langue')->findAll();
         $agentlangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findOneBy(['id'=>$id]);
         if($agentlangue)
         {
            $em->remove($agentlangue);
            $em->flush();
         }
         $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$ag]);
         $niveaulangue=$em->getRepository('EcompetenceBundle:Agent_Langue')->findBy(['agent'=>$ag]);
         return $this->render('EcompetenceBundle:Langue:new.html.twig', array(
                    'id'=>$id,'niveaulangue'=>$niveaulangue,'entity'=>$entity ,'langue'=>$langue,'ag'=>$ag
                    /*'form' => $form->createView()*/
                    
        ));
     
    }
    
    /**
     * Creates a new Langue entity.
     *
     */
    public function newcreateAction(Request $request)
    {
        $entity = new Langue();
        $form   = $this->createCreateForm($entity);
        
        $form->handleRequest($request);
        // Vérifier si le formulaire est valide
        if ($form->isValid()) {
        // Récupérer le gestionnaire d'entité
        $em = $this->getDoctrine()->getManager();
        // Rechercher si une langue avec le même libellé existe déjà
        $existingLangue = $em->getRepository('EcompetenceBundle:Langue')
                             ->findOneBy(array('liblangue' => $entity->getLiblangue()));
        // Si une langue existe déjà, afficher un message d'erreur
        if ($existingLangue) {
            $this->get('session')->getFlashBag()->add('error', 'Cette langue existe déjà.');

            return $this->render('EcompetenceBundle:Langue:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
            ));
        }
        // Persister la nouvelle langue si elle n'existe pas
        $em->persist($entity);
        $em->flush();
        // Redirection après la création
        return $this->redirect($this->generateUrl('langue'));
    }
        return $this->render('EcompetenceBundle:Langue:newcreate.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Creates a form to create a Langue entity.
     *
     * @param Langue $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Langue $entity)
    {
        $form = $this->createForm(new LangueType(), $entity, array(
            'action' => $this->generateUrl('langue_newcreate'),
            'method' => 'POST',
        ));

       // $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }
    /**
     * Finds and displays a Langue entity.
     *
     */
    
    
    /**
     * Displays a form to edit an existing Langue entity.
     *
     */
    public function editlangAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Langue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Langue entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('EcompetenceBundle:Langue:editlang.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
    * Creates a form to edit a Langue entity.
    *
    * @param Langue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Langue $entity)
    {
        $form = $this->createForm(new LangueType(), $entity, array(
            'action' => $this->generateUrl('langue_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

       // $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
    * Creates a form to edit a Langue entity.
    *
    * @param Langue $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
   
    /**
     * Edits an existing Langue entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EcompetenceBundle:Langue')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Langue entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('langue_editlang', array('id' => $id)));
        }

        return $this->render('EcompetenceBundle:Langue:editlang.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    

    /**
     * Deletes a Langue entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EcompetenceBundle:Langue')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Langue entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('langue'));
    }
    /**
     * Creates a form to delete a Langue entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('langue_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
      
}

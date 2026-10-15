<?php

namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Entity\Formation;
use Ecompetence\EcompetenceBundle\Entity\Diplome;
use Ecompetence\EcompetenceBundle\Entity\Etablissement;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ecompetence\EcompetenceBundle\Form\EtablissementType;

class FormationController extends Controller
{
  public function newAction(Request $request, $id)
    { 
      
        $modif=0;
        $formation = new Formation();
        $diplome=new Diplome();
        $etablissement =new Etablissement();
        $em = $this->getDoctrine()->getManager();
        $agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        $form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\FormationType::class, $formation);
        $form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\DiplomeType::class,$diplome,['action'=>$this->generateUrl('ajout_diplome')]);
        $form2 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\EtablissementType::class,$etablissement,['action'=>$this->generateUrl('ajout_etablissement')]);
        //dump($form2 );die;
        //$request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
          if ($form->isValid()) {
              //Gestion du fichier uploadé
              $uploadedFile = $form['pjFile']->getData();
              if ($uploadedFile) {
              $pj = new \Agent\AgentBundle\Entity\Pj();
              $pj->setImageFile($uploadedFile);
              $pj->setNomOrigine($uploadedFile->getClientOriginalName());
              $pj->setUpdatedAt(new \DateTime());

              // Déplacer le fichier sur le disque (par exemple dans /uploads)
             /*  $uploadDir = $this->getParameter('kernel.root_dir') . '/../web/uploads';
              $uploadedFile->move($uploadDir, $pj->getNomOrigine()); */

              $formation->setPj($pj);
              $em->persist($pj);
             }      
            // Vérifier si une formation similaire existe déjà pour cet agent
            $existingFormation = $em->getRepository('EcompetenceBundle:Formation')->findOneBy([
                'agent' => $agent,
                'dateObtentiondiplo' => $formation->getDateObtentiondiplo(),  
                'diplome' => $formation->getDiplome(), 
                'niveauFormation' => $formation->getNiveauFormation(),
                'etablissement' =>   $formation->getEtablissement()    
            ]);

            if ($existingFormation) {
                // Si une formation similaire existe, on affiche un message d'erreur
                $this->addFlash('error', 'Cette formation existe déjà pour cet agent.');
            } else {
                // Sinon, on persiste la nouvelle formation
                $formation->setAgent($agent);
                $em->persist($formation);
                $em->flush();
                $this->addFlash('notice', 'Ajout de formation effectué avec succès');
                return $this->redirectToRoute('formation_liste', ['id' => $id]);
            
                     $em = $this->getDoctrine()->getManager();
                     $formation->setAgent($agent);
                     $em->persist($formation);
                     $em->flush();
                     $this->addFlash('notice', 'Ajout de formation effectué avec succès');
                     return $this->redirectToRoute('formation_liste',['id'=>$id]);
                }
            }
                 
            }
            
        
        $formview=$form->createView();
        $formview1=$form1->createView();
        $formview2=$form2->createView();
        
        return $this->render('EcompetenceBundle:Formation:new.html.twig', array(
                   // 'entity' => $experience,
                    'modif' => $modif,
                    'form' => $formview,'form1' => $formview1,'form2' => $formview2
        ));
          
    }
    
    /**
 * @Route("/ajax/ajout-etablissement", name="ajout_etablissement")
 */
/* public function ajoutEtablissementAjax(Request $request)
{
    $etablissement = new Etablissement();
    $form = $this->createForm(EtablissementType::class, $etablissement);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($etablissement);
        $em->flush();

        // Retourne l'ID et le nom pour mise à jour de la liste déroulante
        return $this->json([
            'message' => 'ok',
            'value' => json_encode([
                'id' => $etablissement->getId(),
                'nomEtablissement' => $etablissement->getNomEtablissement()
            ])
        ]);
    }

    // En cas d'erreur de validation
    return $this->json([
        'message' => 'Erreur de validation',
        'form' => $this->renderView('EcompetenceBundle:Etablissement:form.html.twig', [
            'form' => $form->createView()
        ])
    ], 400);
} */
    
     public function editAction(Request $request, $id,$ag)
    {    
        $modif=1;
        $diplome=new Diplome();
        $etablissement=new Etablissement();
        $em = $this->getDoctrine()->getManager();
        $agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$ag]);
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findOneBy(['id'=>$id]);
       // $typeformation= $em->getRepository('EcompetenceBundle:Typeformation')->findOneBy(['id'=>1]);
        $form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\FormationType::class, $formation);
        $form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\DiplomeType::class,$diplome,['action'=>$this->generateUrl('ajout_diplome')]);
        $form2 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\EtablissementType::class,$etablissement,['action'=>$this->generateUrl('ajout_etablissement')]);
        //$request = $this->get('request');
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        $formation->setAgent($agent);
        //dump($formation);die;
        $em->persist($formation);
        $em->flush();

        $this->addFlash('notice', 'Modification de la formation effectuée avec succès');
        return $this->redirectToRoute('formation_liste', ['id' => $ag]);
    }
 
        /* if ($request->getMethod() == 'POST') {
             dump($em);die;
           # $form->bind($request);  
          if ($form->isValid()) {
               
                     $em = $this->getDoctrine()->getManager();
                     
                     $formation->setAgent($agent);
                     $em->persist($formation);
                     $em->flush();
                     $this->addFlash('notice', 'Modification de formation effectué avec succès');
                     return $this->redirectToRoute('formation_liste',['id'=>$ag]);
                }
                 
            }  */
        
        $formview=$form->createView();
        $formview1=$form1->createView();
        $formview2=$form2->createView();
        
        return $this->render('EcompetenceBundle:Formation:new.html.twig', array(
                   // 'entity' => $experience,
                    'modif' => $modif,
                    'form' => $formview,'form1' => $formview1,'form2' => $formview2
        ));
          
    }

 public function detailAction($id)
    {  
       
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findBy(['agent'=>$id],['dateObtentiondiplo'=>'desc']);
        $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        
        return $this->render('EcompetenceBundle:Formation:detail.html.twig', array(
                    'formation' => $formation,'id'=>$id,'entity'=>$entity
        ));
     
    }

public function showAction($id)
{  
       
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findOneBy(['id'=>$id]);
       
        $ag= $formation->getAgent()->getId();
        $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$ag]);
        
        return $this->render('EcompetenceBundle:Formation:show_diplome.html.twig', array(
                    'formation' => $formation,'id'=>$id,'entity'=>$entity
        ));
     
}

public function validerAction($id)
{  
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findOneBy(['id'=>$id]);
        $formation->setEtat(1);
        $em->persist($formation);
        $em->flush();
        $ag= $formation->getAgent()->getId();
        $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$ag]);
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findBy(['agent'=>$ag],['dateObtentiondiplo'=>'desc']);
        return $this->render('EcompetenceBundle:Formation:liste.html.twig', array(
            'formation' => $formation,'id'=>$id, 'entit'=>$entity
     ));
     
}
    
    public function listeAction($id)
    {  
       
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository('EcompetenceBundle:Formation')->findBy(['agent'=>$id],['dateObtentiondiplo'=>'desc']);
        $entit=$em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        
        return $this->render('EcompetenceBundle:Formation:liste.html.twig', array(
                    'formation' => $formation,'id'=>$id, 'entit'=>$entit
        ));
     
    }
    
   public function listediplomeAction($id)
   {  
       
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $diplome = $em->getRepository('EcompetenceBundle:Diplome')->findBy(array('niveau' => $id),array('libDiplome'=>'ASC'));
      
        $tab = array();
        if (!empty($diplome)) {
            foreach ($diplome as $dipl) {
                $id = $dipl->getId();
                $lib = $dipl->getLibDiplome();
                $tab[] = array('0'=>$id,'1'=>mb_convert_encoding($lib, "UTF-8"));
              //  $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"));
                
            }
            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
     return $response;
    }


    public function listespecialiteAction($id)
   {  
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $specialite = $em->getRepository('EcompetenceBundle:Diplomespecialite')->findBy(array('diplome' => $id));
      
        $tab = array();
        $tabs=[];
        if (!empty($specialite)) {
            
            foreach ($specialite as $spec) {
                $id = $spec->getSpecialite()->getId();
                $lib = $spec->getSpecialite()->getLibspecialite();
                $tabs[] = array('0'=>$id,'1'=>mb_convert_encoding($lib, "UTF-8"));
                
               // $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"));     
            }

         // trier le tableau tabs
            $longi=count($tabs)-2;
            $longj=count($tabs)-1;
          

            for($i=0;$i<=$longi;$i++) {
                for($j=$i+1;$j<=$longj;$j++) {
                   $a=$tabs[$i][1];$b=$tabs[$j][1]; 
                   if(strcmp($a,$b)>0)
                   {  
                     $aux=$tabs[$i];
                     
                     $tabs[$i]=$tabs[$j];

                     $tabs[$j]=$aux;
                     
                   }
                 }
               }      
              
            $tab=$tabs;

            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
     return $response;
    }

      public function listeoptionAction($id)
   {    
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $option= $em->getRepository('EcompetenceBundle:Optiondiplome')->findBy(array('specialite' => $id),array('libOption'=>'ASC'));
        $tab = array();
        if (!empty($option)) {
            foreach ($option as $opt) {
                $id = $opt->getId();
                $lib = $opt->getLibOption();
                $tab[] = array('0'=>$id,'1'=>mb_convert_encoding($lib, "UTF-8"));
               // $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"));     
            }
    
            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
     return $response;
    }

     public function ajoutdiplomeAction(Request $request) {
      
        if (!$request->isXmlHttpRequest()) {
        return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
       }
        $entity = new Diplome();
        $form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\DiplomeType::class,$entity,['action'=>$this->generateUrl('ajout_diplome')]);
        $form1->handleRequest($request);
        if ($form1->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($entity, 'json');
       return new JsonResponse(array('message' => 'Success!','value'=>$jsonContent), 200);
      }
    
      $response = new JsonResponse(
            array(
       'message' => 'Veuillez renseigner correctement le formulaire' ), 400);
     
    return $response;
     }   

    
      public function ajoutetablissementAction(Request $request) {
      
        
        if (!$request->isXmlHttpRequest()) {
        return new JsonResponse(array('message' => 'You can access this only using Ajax!'), 400);
       }
        $entity = new Etablissement();
         
        $form2= $this->createForm(\Ecompetence\EcompetenceBundle\Form\EtablissementType::class,$entity,['action'=>$this->generateUrl('ajout_etablissement')]);
         # dump($request);
          #echo 21; die;
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            dump($request);
            echo 21; die;
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $jsonContent = $serializer->serialize($entity, 'json');
       return new JsonResponse(array('message' => 'Success!','value'=>$jsonContent), 200);
    }
    
    $response = new JsonResponse(
            array(
       'message' => 'Veuillez renseigner correctement le formulaire' ), 400);
     
    return $response;
     }  

}

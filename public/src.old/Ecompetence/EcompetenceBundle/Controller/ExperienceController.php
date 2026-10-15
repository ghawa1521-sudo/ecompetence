<?php

namespace Ecompetence\EcompetenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecompetence\EcompetenceBundle\Entity\Structure;
use Ecompetence\EcompetenceBundle\Entity\Experience;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Ecompetence\EcompetenceBundle\Form\ExperienceType;
use Ecompetence\EcompetenceBundle\Form\StructureType;
use Symfony\Component\HttpFoundation\Request;
use Ecompetence\EcompetenceBundle\Entity\Cv_directiongle;
use Ecompetence\EcompetenceBundle\Entity\Cv_direction;
use Agent\AgentBundle\Entity\Fonction;

class ExperienceController extends Controller
{
    public function newAction(Request $request, $id)
    {    $modif=false;
        $experience = new Experience();
        $structure=new Structure();
        $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$id]);
        
        // Récupération du repository Structure
        $structureRepo = $em->getRepository('EcompetenceBundle:Structure');

        
        //$form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\ExperienceType::class, $experience);
        // On passe le repository au formulaire comme option
        $form = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\ExperienceType(),$experience,['structure_repository' => $structureRepo]);
        //$form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\StructureType::class,$structure,['action'=>$this->generateUrl('ajout_structure')]);
        $form1 = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\StructureType(),$structure,['action' => $this->generateUrl('ajout_structure')]);
        $request = $this->get('request');

          if ($request->getMethod() == 'POST') {
        

            $form->handleRequest($request);// $form->bind($request);
            
             if ($form->isSubmitted() ) 
                {
                    $experience->setAgent($agent);
                    $em->persist($experience);
                    $em->flush();
                     $this->addFlash('notice', 'Ajout d\'expérience effectué avec succès');
                     return $this->redirectToRoute('experience_liste',['id'=>$id]);
                }


            //   $secteur = $experience->getSecteur() ? $experience->getSecteur()->getId() : null;
            //     $experience = $form->getData();
            //     // récupérer champs non mappés
            //         $libExp = $experience->getLibExp(); // ça marche maintenant
            //         $autreStructure = $experience->getAutrestructure();
            //   //dump($secteur,$libExp ,  $autreStructure, $experience  );die;
            //     // Sinon, on peut persister la nouvelle expérience
            //          $em = $this->getDoctrine()->getManager();
            //          $experience->setAgent($agent);
            //          $em->persist($experience);
            //          $em->flush();
            //          $this->addFlash('notice', 'Ajout d\'expérience effectué avec succès');
            //          return $this->redirectToRoute('experience_liste',['id'=>$id]);
                
                 
            //  }
            }
        $formview=$form->createView();
       // $formview1=$form1->createView();
        return $this->render('EcompetenceBundle:Experience:new.html.twig', array(
                   // 'entity' => $experience,
                    'modif' => $modif,
                    'form' => $formview
        ));
     
      
    }
   

// public function newAction(Request $request, $id)
// {
//     $modif = false;

//     $em = $this->getDoctrine()->getManager();
//     $agent = $em->getRepository('AgentBundle:Agent')->find($id);

//     $experience = new Experience();
//     $structure = new Structure();

//     // Repository pour vérifier les structures existantes
//     $structureRepo = $em->getRepository('EcompetenceBundle:Structure');

//     // Création du formulaire Experience avec injection du repository
//     $form = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\ExperienceType(), $experience, [
//         'structure_repository' => $structureRepo
//     ]);

//     // Formulaire modal pour ajout de structure
//     $form1 = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\StructureType(), $structure, [
//         'action' => $this->generateUrl('ajout_structure')
//     ]);
    
//     //  $libExp = $form->get('libExp')->getData();
//     // $dateDeb = $form->get('dateDebExp')->getData();
//     // $structure = $form->get('structure')->getData();
//     // $secteur = $form->get('secteur')->getData();
//     // //$nomEmployeur = $form->get('nomEmployeur')->getData();
//     // $posteOccupe = $form->get('fonction')->getData(); 
//     //  $mission = $form->get('mission')->getData();
//     //  dump($libExp, $dateDeb , $structure , $secteur , $posteOccupe , $mission ); 
//     // Gestion de la soumission
//     $form->handleRequest($request);
   
//     //dump($form->isSubmitted() , $form->isValid());
//     if ($form->isSubmitted() ) {
//         //dump($form);die;
//         // Injection de l'agent
//         $experience->setAgent($agent);

//         // Secteur sélectionné
//         $secteur = $experience->getSecteur() ? $experience->getSecteur()->getId() : null;
//         dump($secteur);
//         if ($secteur == 2) { // Privé
//             // Nom employeur libre
//             $autreStructure = $form->get('autrestructure')->getData();
//             dump($autreStructure);

//             if ($autreStructure) {
//                 $existingStructure = $structureRepo->findOneBy(['libStructure' => $autreStructure]);
//                 if (!$existingStructure) {
//                     $newStructure = new Structure();
//                     $newStructure->setLibStructure($autreStructure);
//                     $em->persist($newStructure);
//                     $experience->setStructure($newStructure);
//                 } else {
//                     $experience->setStructure($existingStructure);
//                 }
//             }

//             // Poste occupé libre
//             $libExp = $form->get('libExp')->getData();
//             dump($libExp);die;
//             if ($libExp) {
//                 $experience->setFonction(null); // pas de dropdown
//                 $experience->setLibExp($libExp);
//             }

//             // Direction générale libre
//             $cvdgLibre = $form->get('cvdirectiongle_txt')->getData();
//             if ($cvdgLibre) {
//                 $experience->setCvdirectiongle(null);
//                 $experience->setDirectionGenerale($cvdgLibre);
//             }

//             // Direction libre
//             $cvdcLibre = $form->get('cvdirection_txt')->getData();
//             if ($cvdcLibre) {
//                 $experience->setCvdirection(null);
//                 $experience->setDirectionLibre($cvdcLibre);
//             }
//         } else { // Public
//             // Tous les champs libres injectés si remplis
//             if ($form->get('libExp')->getData()) {
//                 $experience->setLibExp($form->get('libExp')->getData());
//             }
//             if ($form->get('cvdirectiongle_txt')->getData()) {
//                 $experience->setDirectionGenerale($form->get('cvdirectiongle_txt')->getData());
//             }
//             if ($form->get('cvdirection_txt')->getData()) {
//                 $experience->setDirectionLibre($form->get('cvdirection_txt')->getData());
//             }
//         }

//         // Persistance de l'expérience
//         $em->persist($experience);
//         $em->flush();

//         $this->addFlash('notice', 'Ajout d\'expérience effectué avec succès');

//         return $this->redirectToRoute('experience_liste', ['id' => $id]);
//     }

//     return $this->render('EcompetenceBundle:Experience:new.html.twig', [
//         'modif' => $modif,
//         'form' => $form->createView(),
//         'form1' => $form1->createView(),
//     ]);
// }



    public function editAction(Request $request, $id, $ag)
    {
        // $modif = true;
        // $structure = new Structure();
        // $em = $this->getDoctrine()->getManager();
        // $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $ag]);
        // $experience = $em->getRepository('EcompetenceBundle:Experience')->findOneBy(['id' => $id]);

        // //Récupération du repository Structure
        // $structureRepo = $em->getRepository('EcompetenceBundle:Structure');
        // //$form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\ExperienceType::class, $experience);
        // //On passe le repository au formulaire
        // $form = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\ExperienceType(), $experience, ['structure_repository' => $structureRepo]);
        // //dump($form);die;
        // //$form1 = $this->createForm(\Ecompetence\EcompetenceBundle\Form\StructureType::class,$structure,['action'=>$this->generateUrl('ajout_structure')]);
        // $form1 = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\StructureType(), $structure, ['action' => $this->generateUrl('ajout_structure')]);

        // $request = $this->get('request');
        // if ($request->getMethod() == 'POST') {
        //     $form->handleRequest($request);
        //     //$form->bind($request);
        //     if ($form->isValid()) {
        //         $em = $this->getDoctrine()->getManager();
        //         $experience->setAgent($agent);
        //         $em->persist($experience);
        //         $em->flush();
        //         $this->addFlash('notice', 'Modification d\'expérience effectué avec succès');
        //         return $this->redirectToRoute('experience_liste', ['id' => $ag]);
        //     }
        // }
        // $formview = $form->createView();
        // $formview1 = $form1->createView();
        // return $this->render('EcompetenceBundle:Experience:new.html.twig', array(
        //     // 'entity' => $experience,
        //     'modif' => $modif,
        //     'form' => $formview,
        //     'form1' => $formview1
        // ));

        $modif = true;

    $em = $this->getDoctrine()->getManager();

    $agent = $em->getRepository('AgentBundle:Agent')->find($ag);

    $experience = $em->getRepository('EcompetenceBundle:Experience')->find($id);

    $form = $this->createForm(
        new \Ecompetence\EcompetenceBundle\Form\ExperienceType(),
        $experience
    );

    if ($request->isMethod('POST')) {

        $form->handleRequest($request);
        if ($form->isValid()) {

            $experience->setAgent($agent);

            $em->persist($experience);
            $em->flush();

            $this->addFlash('notice', 'Modification d\'expérience effectuée avec succès');

            return $this->redirectToRoute('experience_liste', ['id' => $ag]);
        }
    }

    return $this->render('EcompetenceBundle:Experience:new.html.twig', [
        'modif' => $modif,
        'form'  => $form->createView()
    ]);
    }



    /*  $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['id'=>$ag]);
        $entity = $em->getRepository('EcompetenceBundle:Experience')->findOneBy(['id'=>$id]);
        $form = $this->createForm(\Ecompetence\EcompetenceBundle\Form\ExperienceType::class,$entity);
        $form->handleRequest($request);
        if ($form->isSubmitted()) 
        {   $entity->setAgent($agent); 
            $em->persist($entity);
            $em->flush();
            $this->addFlash('notice', 'Modification d\'expérience effectué avec succès');
           return $this->redirectToRoute('agent_cv',['id'=>$ag]);
        }
        $formview=$form->createView();
        return $this->render('EcompetenceBundle:Experience:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $formview,
        ));
     
    }*/

    public function detailAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $expr = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent' => $id], ['dateDebExp' => 'desc']);
        $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $id]);

        return $this->render('EcompetenceBundle:Experience:detail.html.twig', array(
            'exprs' => $expr,
            'id' => $id,
            'entity' => $entity
        ));
    }

    public function listeAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        // Récupération brute des expériences
        $entity = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent' => $id]/*,['dateDebExp'=>'desc']*/);

        // Tri du plus récent au plus ancien
        usort($entity, function ($a, $b) {
            $dateFinA = $a->getDateFinExp() ?: new \DateTime(); // Si null, on considère aujourd'hui
            $dateFinB = $b->getDateFinExp() ?: new \DateTime();

            if ($dateFinA == $dateFinB) {
                $dateDebA = $a->getDateDebExp() ?: new \DateTime();
                $dateDebB = $b->getDateDebExp() ?: new \DateTime();
                return $dateDebB <=> $dateDebA;
            }

            return $dateFinB <=> $dateFinA;
        });

        $entit = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $id]);
        return $this->render('EcompetenceBundle:Experience:liste.html.twig', array(
            'entity' => $entity,
            'id' => $id,
            'entit' => $entit
        ));
    }




    public function ListeEmployeurAction($id)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $structure = $em->getRepository('EcompetenceBundle:Structure')->findBy(array('secteur' => $id), array('libStructure' => 'asc'));
        $tab = array();

        if (!empty($structure)) {
            foreach ($structure as $str) {
                $id = $str->getId();
                $lib = $str->getLibStructure();

                $tab[] = array('0' => $id, '1' => mb_convert_encoding($lib, "UTF-8"));
            }


            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
        return $response;
    }


    public function  ListeDirectionGeneraleAction($id)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $cvdg = $em->getRepository('EcompetenceBundle:Cv_directiongle')->findBy(array('structure' => $id), array('libdirectiongle' => 'ASC'));

        $tab = array();
        if (!empty($cvdg)) {
            foreach ($cvdg as $dg) {
                $id = $dg->getId();
                $lib = $dg->getLibdirectiongle();

                $tab[] = array('0' => $id, '1' => mb_convert_encoding($lib, "UTF-8"));
            }

            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
        return $response;
    }

    public function  ListeDirectionAction($id)
    {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $cvdc = $em->getRepository('EcompetenceBundle:Cv_direction')->findBy(array('cvdirectiongle' => $id), array('libdirection' => 'ASC'));

        $tab = array();
        if (!empty($cvdc)) {
            foreach ($cvdc as $dc) {
                $id = $dc->getId();
                $lib = $dc->getLibdirection();

                $tab[] = array('0' => $id, '1' => mb_convert_encoding($lib, "UTF-8"));
            }
            //dump($tab); die;
            $response->setData($tab);
        } else {
        }

        return $response;
    }



    public function testAction($id)
    {
        echo ($id);
        die('<br> nous sommes dans la méthode test');
    }

    public function calculAction($num1, $num2)
    {
        echo ($num1);
        echo ('<br>');
        echo ($num2);
        die('<br>nous sommes dans la méthode calcul');
    }
}

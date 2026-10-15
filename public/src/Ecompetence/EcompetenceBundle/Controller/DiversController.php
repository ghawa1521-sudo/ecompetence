<?php

namespace Ecompetence\EcompetenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Ecompetence\EcompetenceBundle\Entity\ConnaissanceInformatique;
use Ecompetence\EcompetenceBundle\Entity\Decoration;
use Ecompetence\EcompetenceBundle\Form\ConnaissanceInformatiqueType;
use Ecompetence\EcompetenceBundle\Form\DecorationType;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class DiversController extends Controller
{

public function listeAction($id)
{  
    $em = $this->getDoctrine()->getManager();
    // Récupération brute des connaissances informatiques
    $connaissances = $em->getRepository('EcompetenceBundle:ConnaissanceInformatique')->findBy(['agent' => $id]);
    // Récupération brute des décorations
    $decorations = $em->getRepository('EcompetenceBundle:Decoration')->findBy(['agent' => $id]);
    // Récupération de l'agent
    $entit = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $id]);
    return $this->render('EcompetenceBundle:Divers:liste.html.twig',
        array(
            'connaissances' => $connaissances,
            'decorations'   => $decorations,
            'id'            => $id,
            'entit'         => $entit
        )
    );
}


public function newAction(Request $request, $id)
{
    $modif = 0;

    $em = $this->getDoctrine()->getManager();

    // Récupération de l'agent
    $agent = $em->getRepository('AgentBundle:Agent')->find($id);
    if (!$agent) {
        throw $this->createNotFoundException("Agent introuvable pour l'ID $id");
    }

    // Création des entités
    $connaissance = new \Ecompetence\EcompetenceBundle\Entity\ConnaissanceInformatique();
    $decoration   = new \Ecompetence\EcompetenceBundle\Entity\Decoration();

    // Création des formulaires
    $formConnaissance = $this->createForm(\Ecompetence\EcompetenceBundle\Form\ConnaissanceInformatiqueType::class, $connaissance);
    $formDecoration   = $this->createForm(\Ecompetence\EcompetenceBundle\Form\DecorationType::class, $decoration);

    // Gestion des requêtes séparées
    if ($request->getMethod() === 'POST') {
        // On vérifie quel formulaire a été soumis
        if ($request->request->has($formConnaissance->getName())) {
            $formConnaissance->handleRequest($request);

            if ($formConnaissance->isSubmitted() && $formConnaissance->isValid()) {
                $existingConnaissance = $em->getRepository('EcompetenceBundle:ConnaissanceInformatique')->findOneBy([
                    'agent'  => $agent,
                    'libelle'=> $connaissance->getLibelle(),
                    'niveau' => $connaissance->getNiveau()
                ]);

                if ($existingConnaissance) {
                    $this->addFlash('error', 'Cette connaissance existe déjà pour cet agent.');
                } else {
                    $connaissance->setAgent($agent);
                    $em->persist($connaissance);
                    $em->flush();

                    $this->addFlash('notice', 'Ajout de connaissance effectué avec succès.');
                    return $this->redirectToRoute('divers_liste', ['id' => $id]);
                }
            }
        }

        if ($request->request->has($formDecoration->getName())) {
         
            $formDecoration->handleRequest($request);
                    //dump($formDecoration->getErrors(true));die;
            if ($formDecoration->isSubmitted() && $formDecoration->isValid()) {
               
                $existingDecoration = $em->getRepository('EcompetenceBundle:Decoration')->findOneBy([
                    'agent' => $agent,
                    'libelle' => $decoration->getLibelle(),
                    'annee'   => $decoration->getAnnee()
                ]);

                if ($existingDecoration) {
                    $this->addFlash('error', 'Cette décoration existe déjà pour cet agent.');
                } else {
                    $decoration->setAgent($agent);
                    $em->persist($decoration);
                    $em->flush();

                    $this->addFlash('notice', 'Ajout de décoration effectué avec succès.');
                    return $this->redirectToRoute('divers_liste', ['id' => $id]);
                }
            }
        }
    }

    // Préparer les vues des formulaires
    return $this->render('EcompetenceBundle:Divers:new.html.twig', [
        'modif' => $modif,
        'formConnaissance' => $formConnaissance->createView(),
        'formDecoration'   => $formDecoration->createView(),
        'agent'            => $agent
    ]);
}

 public function detailAction($id)
{  
    $em = $this->getDoctrine()->getManager();
    // Récupération des connaissances informatiques
    $connaissances = $em->getRepository('EcompetenceBundle:ConnaissanceInformatique')->findBy(['agent' => $id],['libelle' => 'asc']);
    // Récupération des décorations
    $decorations = $em->getRepository('EcompetenceBundle:Decoration')->findBy(['agent' => $id], ['annee' => 'desc']);
    // Récupération de l’agent
    $entity = $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $id]);
    return $this->render('EcompetenceBundle:Divers:detail.html.twig',
        array(
            'connaissances' => $connaissances,
            'decorations'   => $decorations,
            'id'            => $id,
            'entity'        => $entity
        )
    );
}

public function editAction(Request $request, $id, $ag)
{
    $modif = 1; // signaler qu'on est en modification
    $em = $this->getDoctrine()->getManager();

    // Récupération de l'agent
    $agent = $em->getRepository('AgentBundle:Agent')->find($id);
    if (!$agent) {
        throw $this->createNotFoundException("Agent introuvable pour l'ID $id");
    }

    // Déterminer le type d'entité à modifier : 'connaissance' ou 'decoration'
    $type = $request->query->get('type');
    if (!$type || !in_array($type, ['connaissance', 'decoration'])) {
        $this->get('session')->getFlashBag()->add('error', 'Type d\'entité invalide.');
        return $this->redirect($this->generateUrl('divers_liste', ['id' => $id]));
    }

    $formConnaissance = null;
    $formDecoration = null;

    if ($type === 'connaissance') {
        $connaissance = $em->getRepository('EcompetenceBundle:ConnaissanceInformatique')->find($ag);
        if (!$connaissance) {
            $this->get('session')->getFlashBag()->add('error', 'Connaissance introuvable.');
            return $this->redirect($this->generateUrl('divers_liste', ['id' => $id]));
        }
        $formConnaissance = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\ConnaissanceInformatiqueType(), $connaissance);
    }

    if ($type === 'decoration') {
        $decoration = $em->getRepository('EcompetenceBundle:Decoration')->find($ag);
        if (!$decoration) {
            $this->get('session')->getFlashBag()->add('error', 'Décoration introuvable.');
            return $this->redirect($this->generateUrl('divers_liste', ['id' => $id]));
        }
        $formDecoration = $this->createForm(new \Ecompetence\EcompetenceBundle\Form\DecorationType(), $decoration);
    }

    // Gestion du POST
    if ($request->getMethod() === 'POST') {
        if ($formConnaissance && $request->request->has($formConnaissance->getName())) {
            $formConnaissance->handleRequest($request);
            if ($formConnaissance->isValid()) {
                $em->flush(); // juste flush, pas de persist
                $this->get('session')->getFlashBag()->add('notice', 'Connaissance modifiée avec succès.');
                return $this->redirect($this->generateUrl('divers_liste', ['id' => $id]));
            }
        }

        if ($formDecoration && $request->request->has($formDecoration->getName())) {
            $formDecoration->handleRequest($request);
            if ($formDecoration->isValid()) {
                $em->flush(); // juste flush
                $this->get('session')->getFlashBag()->add('notice', 'Décoration modifiée avec succès.');
                return $this->redirect($this->generateUrl('divers_liste', ['id' => $id]));
            }
        }
    }

    // Rendu de la vue
    return $this->render('EcompetenceBundle:Divers:edit.html.twig', [
        'modif' => $modif,
        'formConnaissance' => $formConnaissance ? $formConnaissance->createView() : null,
        'formDecoration'   => $formDecoration ? $formDecoration->createView() : null,
        'agent'            => $agent
    ]);
}

}



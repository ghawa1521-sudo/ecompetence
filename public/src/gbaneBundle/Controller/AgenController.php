<?php
// src/Agent/AgentBundle/Controller/AgentController.php

namespace Agent\AgentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Agent\AgentBundle\Form\SelectAgentsType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Agent\AgentBundle\Entity\Agent;

class AgenController extends Controller
{
    public function listAgents(Request $request): Response
    {
        // Récupérer les agents depuis la base de données
        $agents = $this->getDoctrine()->getRepository(Agent::class)->findAll();

        // Création du formulaire de sélection
        $form = $this->createForm(SelectAgentsType::class);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les agents sélectionnés
            $selectedAgentIds = $form->get('selected_agents')->getData();

            // Récupérer les détails complets des agents sélectionnés (si nécessaire)
            $selectedAgents = $this->getDoctrine()->getRepository(Agent::class)->findBy(['id' => $selectedAgentIds]);

            // Générer le contenu du PDF (vous devrez configurer KnpSnappyBundle pour cela)
            $pdfContent = $this->renderView('gbaneBundle:Agent:pdf.html.twig', [
                'selectedAgents' => $selectedAgents,
            ]);

            // Générer et renvoyer la réponse PDF
            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($pdfContent),
                'file.pdf'
            );
        }

        // Afficher le template avec le formulaire et la liste des agents
        return $this->render('gbaneBundle:Agent:list.html.twig', [
            'agents' => $agents,
            'form' => $form->createView(),
        ]);
    }

    public function promoteAgents(Request $request): Response
    {
        // Récupérer les agents depuis la base de données
        $agents = $this->getDoctrine()->getRepository(Agent::class)->findAll();

        // Création du formulaire de sélection
        $form = $this->createForm(SelectAgentsType::class);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les agents sélectionnés
            $selectedAgentIds = $form->get('selected_agents')->getData();

            // Récupérer les détails complets des agents sélectionnés
            $selectedAgents = $this->getDoctrine()->getRepository(Agent::class)->findBy(['id' => $selectedAgentIds]);

            // Générer le contenu du PDF de promotion
            $pdfContent = $this->renderView('gbaneBundle:Agent:promotion_pdf.html.twig', [
                'selectedAgents' => $selectedAgents,
            ]);

            // Générer et renvoyer la réponse PDF
            return new PdfResponse(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($pdfContent),
                'promotion_acte.pdf'
            );
        }

        // Afficher le template avec le formulaire et la liste des agents
        return $this->render('gbaneBundle:Agent:promote.html.twig', [
            'agents' => $agents,
            'form' => $form->createView(),
        ]);
    }
    public function profilAction($id): Response
    {
        $agent = $this->getDoctrine()->getRepository(Agent::class)->find($id);

        if (!$agent) {
            throw $this->createNotFoundException('Agent non trouvé pour l\'id ' . $id);
        }

        return $this->render('gbaneBundle:Default:profil.html.twig', [
            'agent' => $agent,
        ]);
    }

  /**
 * @Route("/promo", name="gbane_promo", methods={"POST"})
 */
public function promoteAction(Request $request)
{
    $agentId = $request->request->get('agentId');
    $selectedFunctionId = $request->request->get('selectedFunctionId');

    // Effectuez la promotion de l'agent avec la fonction sélectionnée
    // ...

    return $this->redirectToRoute('gbane_homepage');
}

public function generatePDFAction(Request $request)
    {
        // Récupérer les données envoyées par Ajax
        $matricule = $request->request->get('matricule');
        $nom = $request->request->get('nom');
        $fonctionPotentielle = $request->request->get('fonctionPotentielle');
        $fonctionAssimilee = $request->request->get('fonctionAssimilee');
        $directionService = $request->request->get('directionService');
        

        // Créer le contenu HTML du PDF
        $html = $this->renderView('pdf/promotion.html.twig', [
            'matricule' => $matricule,
            'nom' => $nom,
            'fonctionPotentielle' => $fonctionPotentielle,
            'fonctionAssimilee' => $fonctionAssimilee,
            'directionService' => $directionService,
        ]);

        // Générer le PDF avec mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Envoyer le PDF au navigateur
        $response = new Response($mpdf->Output('promotion.pdf', 'D'));

        return $response;
    }
   
}

    

    








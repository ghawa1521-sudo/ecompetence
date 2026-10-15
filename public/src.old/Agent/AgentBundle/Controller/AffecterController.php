<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response as httpResponse;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Bundle\SnappyBundle\Snappy\Response;
use Dompdf\Options;
use Dompdf\Dompdf;
use Agent\AgentBundle\Entity\Document;
use Agent\AgentBundle\Entity\Affecter;
use Agent\AgentBundle\Entity\Direction;
use Agent\AgentBundle\Form\AffecterType;
use Agent\AgentBundle\Form\DocumentType;
use Agent\AgentBundle\Form\AffecterNumeriseType;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Agent\AgentBundle\Entity\Imputation;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Security\Core\Role\SwitchUserRole;

/**
 * Affecter controller.
 *
 */
class AffecterController extends Controller {

    /**
     * Lists all Affecter entities.
     *
     */
    public function etatAction() {

        $em = $this->getDoctrine()->getManager();
        $attente = $em->getRepository('AgentBundle:Affecter')->findAll([''], ['id' => 'DESC']);

        return $this->render('AgentBundle:Affecter:index_etat.html.twig', array(
                    'attente' => $attente,
        ));
    }

    private function getDeleguation($route) {
        $em = $this->getDoctrine()->getManager();
        $id = $this->getUser()->getAgent();
        $deleguations = $em->getRepository('AgentBundle:Deleguation')->checkRoute($id, $route);
        $tab = [];
        // $service=null;
        if (!$this->getUser()->hasRole("ROLE_RESPO")) {
            foreach ($deleguations as $deleguation) {
                array_push($tab, $deleguation->getArrayServices());
            }
        }
        $service = implode(",", $tab);

        if ($deleguations) {
            /////Success
            $retour = 0;
        } else {
            //echec
            $retour = 1;
        }

        return ['retour' => $retour, 'service' => $service];
    }

    public function indexAction(Request $request) {
        //dump($request->request);
        // dump($request->request);
        //die;
        $barcode = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'https://www.dge.ci', -4, -4, 'black', [-2, -2, -2, -2], 'white');

        //echo $barcode; die;
        $em = $this->getDoctrine()->getManager();
        $agent = $em->getRepository('AgentBundle:Agent')->findBy(['Direction' => $this->getUser()->getAgent()->getDirection()], ['nom' => 'ASC']);



        /* $attente_imputer= $em->getRepository('AgentBundle:Affecter')->AffecterImputer($this->getUser(),0); */
        $attente = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 0, 0, 0, 0, 0, $this->getDeleguation("affecter"));
        $archive = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0, 0, 0, $this->getDeleguation("affecter"));
        //dump($attente);
        //die;
        return $this->render('AgentBundle:Affecter:index.html.twig', array(
                    'attente' => $attente,
                    // 'attente_imputer'  => $attente_imputer,
                    'archive' => $archive,
                    'deleguation' => $this->getDeleguation("affecter")['retour'],
        ));
    }

    public function listModifAction() {
        $em = $this->getDoctrine()->getManager();

        $attente = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0, 0, 0, $this->getDeleguation("affecter_list_modif"));
        //dump($attente); die;
        return $this->render('AgentBundle:Affecter:listModif.html.twig', array(
                    'attente' => $attente,
                    'deleguation' => $this->getDeleguation("affecter_list_modif")['retour'],
        ));
    }

    public function visualiserDocAction($mat) {
        $document = $em->getRepository('AgentBundle:Document')->afficherDocumentNote($mat);
    }

    public function listSaafAction() {
        $em = $this->getDoctrine()->getManager();
        $listSaaf = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0);
        //dump($listSaaf); die;
        $archive = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, null, 1);
        return $this->render('AgentBundle:Affecter:listSaaf.html.twig', array(
                    'affecter' => $listSaaf,
                    'archive' => $archive,
        ));
    }

    public function listSaafChoixAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('affecter' => $id));

        $dir = $entity->getAgent()->getDirection()->getId();
        $form = $this->createEditFormSaaf($entity, 3, 1, $dir);

        $form->handleRequest($request);
        if ($form->isValid()) {
            //dump($request->request); die;
            //dump($form->getData()->getAgent()->getCodeSd()); die;
            $entity->setEtatDemembrement(1);
            $entity->setDateAutoDemembrement(new \DateTime('now'));
            $entity->setMatDemembrement($this->getUser()->getAgent());
            $em->persist($entity);
            $em->flush($entity);
            $agent->setCodeSd($form->getData()->getAgent()->getCodeSd());
            $agent->setCodeSc($form->getData()->getAgent()->getCodeSc());
            $em->persist($agent);
            $em->flush($agent);
            $this->addFlash(
                    'notice', 'Agent affecté dans un service'
            );
            return $this->redirect($this->generateUrl('affecter_saaf'));
        }
        return $this->render('AgentBundle:Affecter:choix_direction_saaf.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function listValidAction() {
        $em = $this->getDoctrine()->getManager();

        //$d=1 dernier argument
        $affecter = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 1, 0, 1, $this->getDeleguation("affecter_list_valid"));
        $archive = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, null, 1, $this->getDeleguation("affecter_list_valid"));
        //dump($affecter); die;

        $listValid = null;
        foreach ($affecter as $aff) {
            # code...
            // dump($aff);
            //die;
            $document = $em->getRepository('AgentBundle:Document')->findOneBy(['Matricule' => $aff->getAgent()->getId(), 'etat' => 1]);
            $listValid[] = ['affecter' => $aff, 'doc' => $document];
        }


        return $this->render('AgentBundle:Affecter:listValid.html.twig', array(
                    'affecter' => $listValid,
                    'archive' => $archive,
                    'deleguation' => $this->getDeleguation("affecter_list_valid")['retour'],
        ));
    }

    public function listNoteAction() {
        $em = $this->getDoctrine()->getManager();


        $affecter = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0, 0, 0, $this->getDeleguation("affecter_list_print_note"));
        //dump($affecter);
        //die;
        return $this->render('AgentBundle:Affecter:listNote.html.twig', array(
                    'affecter' => $affecter,
        ));
    }

    public function numNoteAction() {
        $em = $this->getDoctrine()->getManager();


        $affecter = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 1, 0, 0, 0, 0, $this->getDeleguation("affecter_list_num_note"));
//dump($affecter); die;
        return $this->render('AgentBundle:Affecter:numNote.html.twig', array(
                    'affecter' => $affecter,
        ));
    }

    public function listCertifAction() {
        $em = $this->getDoctrine()->getManager();

        $valider = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, 0, 0, $this->getDeleguation("affecter_list_print_certif"));
        //dump($this->getDeleguation("affecter_list_print_certif")); die;
        return $this->render('AgentBundle:Affecter:listCertif.html.twig', array(
                    'valider' => $valider,
                    'deleguation' => $this->getDeleguation("affecter_list_print_certif")['retour'],
        ));
    }

    public function viewAction($id) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);
        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'affecter-' . $id . '-' . $user, -2, -2, 'black', [-2, -2, -2, -2], 'white');
        return $this->render('AgentBundle:Affecter:preview_pdf.html.twig', array(
                    'qr' => $qr,
                    'entity' => $entity,
        ));
    }

    public function numCertifAction() {
        $em = $this->getDoctrine()->getManager();

        $valider = $em->getRepository('AgentBundle:Affecter')->AffecterIndex($this->getUser(), 2, 0, 1, 0, 0, $this->getDeleguation("affecter_list_num_certif"));
        //dump($this->getDeleguation("affecter_list_num_certif"));
        return $this->render('AgentBundle:Affecter:numCertif.html.twig', array(
                    'valider' => $valider,
                    'deleguation' => $this->getDeleguation("affecter_list_num_certif")['retour'],
        ));
    }

    /**
     * Creates a new Affecter entity.
     *
     */
    private function returnConnecte() {
        $em = $this->getDoctrine()->getManager();
        if ($this->isGranted('ROLE_PREVIOUS_ADMIN')) {

            foreach ($this->container->get('security.context')->getToken()->getRoles() as $role) {
                if ($role instanceof SwitchUserRole) {
                    $interimaire = $role->getSource()->getUser();

                    break;
                }
            }

            $agent_interim = $em->getRepository('AgentBundle:Agent')->findOneByMatricule($interimaire->getUsername());
            $validateur = $trc_mat = null;

            if ($agent_interim) {
                //$validateur = $agent_interim->getMatricule() . "+" . $agent_interim->concatNom();
                $trc_mat = $agent_interim;
            }
        } else {
            //$validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
            $trc_mat = $this->getUser()->getAgent();
        }
        return $trc_mat;
    }

    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->returnConnecte();
        $entity = new Affecter();
        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        //$f1 = $em->getRepository('AgentBundle:Fonction')->find('2');
        $form = $this->createCreateForm($entity, 1);
        $form->handleRequest($request);
        //dump($form->isValid());
        //die;
        if ($form->isValid()) {
            //dump($form);
            //
            $id = $form->getData()->getAgent()->getMatricule();
            $user_exist = $em->getRepository('AgentBundle:Agent')->findByMatricule($id);
            //$affecter_id=$em->getRepository('AgentBundle:Affecter');

            if ($user_exist) {
                //$em->flush();
                $this->addFlash(
                        'error', 'le matricule ' . $id . ' que vous tentez d\'ajouter existe déjà dans la base de données'
                );
                //die;
                return $this->render('AgentBundle:Affecter:new.html.twig', array(
                            'entity' => $entity,
                            'emploi' => $emploi,
                            'form' => $form->createView(),
                ));
            }

            $email = $em->getRepository('UsersBundle:users')->findOneBy(array('email' => $entity->getAgent()->getEmail()));
            if ($email) {
                $this->addFlash(
                        'error', 'L\'émail ' . $entity->getAgent()->getEmail() . ' existe déjà dans la base de données'
                );
                return $this->render('AgentBundle:Affecter:new.html.twig', array(
                            'entity' => $entity,
                            'emploi' => $emploi,
                            'form' => $form->createView(),
                ));
            }



            //dump($tab_test);
            //die;
            $trc_mat = $user;
            $trc_route = 'affecter_create';
            $trc_entite = 'AgentBundle:Affecter';
            $validateur = $this->getUser()->getAgent()->getMatricule() . "+" . $this->getUser()->getAgent()->concatNom();
            $trc_lib = "Enregistrer un nouvel agent+" . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;

            $entity->setEtatAffectation(0);
            $entity->setMatEnreg($user);
            $entity->setDateEnregAgt(new \DateTime('now'));
            $agent = $entity->getAgent();
            //$agent->setFonction($f1);
            $agent->setAffecter($entity);

            $em->persist($agent);
            $em->persist($entity);

            $em->flush();
            $trc_id = $entity->getId();
            $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
            $this->addFlash(
                    'notice', 'L\'Agent a été enregistré avec succès');
            return $this->redirect($this->generateUrl('agent_show', array('id' => $agent->getId())));
        }
//die;
        $this->addFlash(
                'error', 'veuillez renseigner correctement le formulaire');
        return $this->render('AgentBundle:Affecter:new.html.twig', array(
                    'entity' => $entity,
                    'emploi' => $emploi,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Affecter entity.
     *
     * @param Affecter $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Affecter $entity, $todo) {

        $form = $this->createForm(new AffecterType($todo), $entity, array(
            'action' => $this->generateUrl('affecter_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'AFFECTER', 'attr' => array('class' => 'btn btn-success col-md-push-3 col-md-6', 'data-confirm' => 'Etes-vous <strong>certain</strong> de vouloir Valider cette demande ?')));

        return $form;
    }

    /**
     * Displays a form to create a new Affecter entity.
     *
     */
    public function newAction() {
        $em = $this->getDoctrine()->getManager();

        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        $entity = new Affecter();

        /*  $agent = new Agent();
          $entity->setAgent($agent); */
        $form = $this->createCreateForm($entity, 1);

        return $this->render('AgentBundle:Affecter:new.html.twig', array(
                    'entity' => $entity,
                    'emploi' => $emploi,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Affecter entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Affecter:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function directionAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('affecter' => $entity->getId()));
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $Form = $this->createEditFormDirection($entity, 2, 2);


        return $this->render('AgentBundle:Affecter:choix_direction.html.twig', array(
                    'entity' => $entity,
                    'agent' => $agent,
                    'edit_form' => $Form->createView(),
        ));
        # code...
    }

    /**
     * Displays a form to edit an existing Affecter entity.
     *
     */
    public function numeriseAction($id) {
        //die;
        $em = $this->getDoctrine()->getManager();

        $entity = new Document();
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['affecter' => $id]);
        $affecter = $em->getRepository('AgentBundle:Affecter')->find($id);
        $entity->setMatricule($agent);
        if ($affecter->getEtatAffectation() == 1) {
            $route = "affecter_list_num_note";
        } else {
            $route = "affecter_list_num_certif";
        }
        $docu = $em->getRepository('AgentBundle:Document')->findOneBy(['Matricule' => $agent->getMatricule(), 'etat' => 1]);
        //dump($entity);
        //die;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $form = $this->createNumeriseForm($affecter, $id, $this->getDeleguation($route)['retour']);
        //dump($form->getData()); //die;

        return $this->render('AgentBundle:Affecter:numerise.html.twig', array(
                    'docu' => $docu,
                    'entity' => $affecter,
                    'form_file' => '',
                    'form' => $form->createView(),
                    'deleguation' => $this->getDeleguation($route)['retour'],
        ));
    }

    public function testformAction() {
        //die;
        $em = $this->getDoctrine()->getManager();

        $entity = new Affecter();
        /*
          $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(['affecter' => $id]);
          $affecter = $em->getRepository('AgentBundle:Affecter')->find($id);
          $entity->setMatricule($agent);
          $docu = $em->getRepository('AgentBundle:Document')->findOneBy(['Matricule' => $agent->getMatricule(), 'etat' => 1]);
          //dump($entity);
          //die; */
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }
        $form = $this->createForm(new AffecterNumeriseType(), $entity, array(
            'action' => $this->generateUrl('affecter_test'), //array('id' => $id)),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Numériser l\'acte', 'attr' => array('class' => 'btn btn-warning')));
        // $form = $this->createTestForm($entity, $id);


        return $this->render('AgentBundle:Affecter:testform.html.twig', array(
                    //'docu' => $docu,
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $editForm = $this->createEditForm($entity, 3);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AgentBundle:Affecter:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Affecter entity.
     *
     * @param Affecter $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditFormDirection(Affecter $entity, $todo, $saaf = null) {
        $form = $this->createForm(new AffecterType($todo, $saaf), $entity, array(
            'action' => $this->generateUrl('affecter_update_dir', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'AFFECTER', 'attr' => array('class' => 'btn btn-success col-md-push-3 col-md-6')));

        return $form;
    }

    private function createEditFormSaaf(Affecter $entity, $todo, $saaf = null, $dir) {
        $form = $this->createForm(new AffecterType($todo, $saaf, $dir), $entity, array(
            'action' => $this->generateUrl('affecter_saaf_choix', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'AFFECTER', 'attr' => array('class' => 'btn btn-success col-md-push-3 col-md-6')));

        return $form;
    }

    private function createNumeriseForm(Affecter $entity, $id, $deleguation) {
        $form = $this->createForm(new AffecterNumeriseType($entity, $this->getUser(), $deleguation), $entity, array(
            'action' => $this->generateUrl('affecter_valid', array('id' => $id)),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Numériser l\'acte', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

    private function createEditForm(Affecter $entity, $todo) {
        $form = $this->createForm(new AffecterType($todo), $entity, array(
            'action' => $this->generateUrl('affecter_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier', 'attr' => array('class' => 'btn btn-warning')));

        return $form;
    }

    public function passwordCreate() {
        for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != 8; $x = rand(0, $z), $s .= $a{$x}, $i++)
            ;
        return $s;
    }

    public function validAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('affecter' => $entity->getId()));
        $document = new Document();
        $route = null;
        if ($entity->getEtatAffectation() == 1 and $entity->getSigneNote() == 1) {
            $route = "affecter_list_valid";
        }//////////////Debut Signature note d'affectation/////////////
        elseif ($entity->getEtatAffectation() == 1 and $entity->getSigneNote() == 0) {
            $route = "affecter_list_num_note";
        }///////////////Debut Signature Certificat prise de Service//////////
        elseif ($entity->getEtatAffectation() == 2 and $entity->getSigneCertificat() == 0) {
            $route = "affecter_list_num_certif";
        }
        $form = $this->createNumeriseForm($entity, $id, $this->getDeleguation($route)['retour']);
        $form->handleRequest($request);


        if ($form->isValid()) {


            $test = $em->getRepository('AgentBundle:Imputation')->testImputation("AgentBundle:Affecter", $id);

            $validateur = $this->returnConnecte()->getMatricule() . "+" . $this->returnConnecte()->concatNom();
            $trc_mat = $this->returnConnecte();
            //////Tracing Commun/////////
            $trc_route = 'affecter_valid';
            $trc_entite = 'AgentBundle:Affecter';
            $trc_id = $id;

            //dump($agent);
            //////////////Debut Validation Prise de service///////////////
            if ($entity->getEtatAffectation() == 1 and $entity->getSigneNote() == 1) {
                $entity->setEtatAffectation(2);
                $entity->setDateAutoPriseSce(new \DateTime('now'));
                $entity->setMatValidPriseSce($trc_mat);
                //$entity->setDateprise($date);

                $agent->setDatePriseServiceDge($form->getData()->getDateprise());
                //dump($agent);
                //die;


                $em->persist($entity);
                $em->persist($agent);

                $em->flush($entity);
                $em->flush($agent);

                $trc_lib = "Validation prise de service+" . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                $this->addFlash(
                        'notice', 'La Validation de la prise de Service a été Effectuée'
                );
                return $this->redirect($this->generateUrl('affecter_list_valid'));
            }//////////////Fin Validation Prise de service///////////////
            //////////////Debut Signature note d'affectation/////////////
            elseif ($entity->getEtatAffectation() == 1 and $entity->getSigneNote() == 0) {

                $entity->setSigneNote(1);

                $entity->setDateAutoSignNote(new \DateTime('now'));
                $entity->setMatSignNote($this->returnConnecte());

                $documentNote = $entity->getDocumentNote();
                $documentNote->setMatricule($entity->getAgent());
                $documentNote->setLibelle("Note d'Affectation");
                $documentNote->setEtat(1);
                $entity->setDocumentNote($documentNote);



                $em->persist($entity);
                $em->flush($entity);

                $this->addFlash(
                        'notice', 'La Numerisation de la Note d\'Affectation s\'est effectuée avec succès');
                if (!$test) {
                    $trc_lib = "Signature note affectation+" . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                    return $this->redirect($this->generateUrl('affecter_list_num_note'));
                } else {
                    $test->setEtatTraitement(1);
                    $test->setDateTraitement(new \DateTime('now'));
                    $em->persist($test);
                    $em->flush($test);
                    $imputer = new Imputation();
                    $imputer->setDateImputation(new \DateTime('now'));
                    $imputer->setObjetImputation("AgentBundle:Affecter");
                    $imputer->setObjetId($entity->getId());
                    $imputer->setEtat(1);
                    $imputer->setMatImputateur($test->getMatImputateur());
                    $imputer->setMatImputer($this->returnConnecte());
                    $imputer->setActions("affecter_valid");
                    $em->persist($imputer);
                    $em->flush($imputer);

                    $trc_lib = "(Imputer) Signature note affectation " . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                    return $this->redirect($this->generateUrl('imputation_affecter'));
                }
            }//////////////Fin Signature note d'affectation/////////////
            ///////////////Debut Signature Certificat prise de Service//////////
            elseif ($entity->getEtatAffectation() == 2 and $entity->getSigneCertificat() == 0) {
                //die;
                //$document->setMatricule($agent);
                //$document->setLibelle("Certificat de Prise de Service");
                //$document->setEtat(2);
                //$em->persist($document);
                $userOld = $em->getRepository('UsersBundle:Users')->findOneBy(['email' => $entity->getAgent()->getEmail()]);

                if (!$userOld) {
                    $documentCert = $entity->getDocumentCertif();
                    $documentCert->setMatricule($entity->getAgent());
                    $documentCert->setLibelle("Certificat de prise de service");
                    $documentCert->setEtat(2);

                    //$entity->set
                    //$em->flush();
                    ////
                    $entity->setDocumentCertif($documentCert);
                    $entity->setSigneCertificat(1);
                    //$entity->setDateCertificat($date);
                    //$entity->setNumCertificat($numeroActe);
                    $entity->setDateAutoSignCertif(new \DateTime('now'));
                    $entity->setMatSignCertif($this->returnConnecte());


                    ////////////////Création du compte utilsateur//////////////////////
                    $userNew = $this->get('ediligence.fonctiondebase')->creerUser($entity->getAgent(), 2);
                    ////////////////Fin Création du compte utilsateur///////////////
                    $em->persist($entity);
                    $em->flush($entity);




                    $this->addFlash(
                            'notice', 'La Numérisation du certificat de prise de Service s\'est effectuée avec suucès');
                } else {
                    $this->addFlash(
                            'notice', 'l\'email existe déja');
                }
                if (!$test) {
                    $trc_lib = "Numérisation du certificat de prise de Service+" . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                    return $this->redirect($this->generateUrl('affecter_list_num_certif'));
                } else {
                    $test->setEtatTraitement(1);
                    $test->setDateTraitement(new \DateTime('now'));
                    $em->persist($test);
                    $em->flush($test);

                    $trc_lib = "(Imputer) Numérisation du certificat de prise de Service+" . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                    $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);

                    return $this->redirect($this->generateUrl('imputation_affecter'));
                }
                //return $this->redirect($this->generateUrl('affecter_list_num_certif'));
            }
        } else {
            //die;
            return $this->render('AgentBundle:Affecter:numerise.html.twig', array(
                        'docu' => $document,
                        'entity' => $entity,
                        //'form_file' => '',
                        'form' => $form->createView(),
                        'deleguation' => $this->getDeleguation($route)['retour'],
            ));
        }


        return $this->redirect($this->generateUrl('affecter'));
    }

    public function printAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Cette demande n\'existe pas');
        }

        $etat = $entity->getEtatAffectation();
        switch ($etat) {
            case 1:
                # code...
                $action = 'AgentBundle:Affecter:note_affectation_pdf.html.twig';
                $filename = "note_affectation_" . $entity->getAgent()->getNom();
                break;

            case 2:
                # code...


                if ($this->getUser()->hasRole("ROLE_RESPO_SRHMG") or $entity->getImputer()->getMatricule() == $this->getUser()->getAgent()->getMatricule()) {
                    $action = 'AgentBundle:Affecter:certificat_prise_pdf.html.twig';
                    $filename = "certificat_prise_" . $entity->getAgent()->getNom();
                } elseif ($this->getUser()->hasRole("ROLE_RESPO")) {
                    $action = 'AgentBundle:Affecter:attestation_prise_pdf.html.twig';
                    $filename = "attestation_prise_" . $entity->getAgent()->getNom();
                }
                break;

            default:
                # code...
                $action = 'AgentBundle:Affecter:certificat_prise_pdf.html.twig';
                $filename = "certificat_prise_" . $entity->getNom();
                break;
        }

        ///////////////////Génération PDF/////////////////////////
        //////////////////////////////////////////////////////////
        /* $options = new Options();
          $options->set('isRemoteEnabled', TRUE);
          $dompdf = new Dompdf($options);
          $html=$this->renderview($action, array('entity'=>$entity
          ));
          $dompdf->loadHtml($html);
          $dompdf->render();
          return new Response ($dompdf->stream($filename)); */
        //$agent=$entity->getEmmeteur()->getNom();
        $filename = $filename . ".pdf";
        $snappy = $this->get('knp_snappy.pdf');

        $qr = $this->get('ediligence.fonctiondebase')->barcode('QRCODE', 'affecter-' . $id . '-' . $this->getUser()->getAgent()->getMatricule(), -2, -2, 'black', [-2, -2, -2, -2], 'white');
        $footer = $this->renderview('DemandesBundle:Demande:footer_pdf.html.twig', array('qr' => $qr));
        //echo $a=$qr;
        //echo $a;
        //dump($a);
        //die;
        $html = $this->renderview($action, array('entity' => $entity, 'qr' => $qr));


        $snappy->setOption('margin-top', 10);
        $snappy->setOption('margin-bottom', 12);

        //$snappy->setOption('footer-center',utf8_decode('Página [page] de [topage] - Impresso em '));
        // $snappy->setOption('footer-left','<div>a_fbygtyètr-fuyfyègt-èhbt_-brt-trb-trbèrtètr-rb-r_(-rbbbbbb-tr_fght_èggty<br>è</div>');


        $snappy->setOption('footer-html', $footer);

        $options = [
            'orientation' => 'portrait',
            'encoding' => 'UTF-8',
            'footer-html' => $footer,
        ];

        return new PdfResponse(
                $snappy->getOutputFromHtml($html, $options), $filename
        );
        /*
          $dompdf = $this->get('dompdf');
          $dompdf->streamHtml($html, "document.pdf");
          $dompdf->getPdf($action);
          return new Response($dompdf->output($html), 200, array('Content-Type'=>'application/pdf')); */
        /*
          $html=$this->renderView($action, array('entity'=>$entity
          ));


          $filename="Note.pdf";

          $footer=$this->renderview("DemandesBundle:Demande:footer_pdf.html.twig");
          var_dump($footer);

          $snappy=$this->get('knp_snappy.pdf');

          $snappy->setOption('margin-top', 10);
          $snappy->setOption('margin-bottom', 10);
          $snappy->setOption('footer-spacing', 0);
          $snappy->setOption('footer-left', 0);
          $snappy->setOption('footer-center',utf8_decode('Página [page] de [topage] - Impresso em '));

          //$snappy->setOption('margin-left', 0);
          //$snappy->setOption('margin-right', 0);

          $snappy->setOption('footer-html', $footer);

          return new Response(
          $snappy->getOutputFromHtml($html),
          200,
          array(
          'Content-Type'          => 'application/pdf',
          'Content-Disposition'   => 'attachment; filename='.$filename,
          'charset'=> 'UTF-8'
          )
          );
          /*
         */

        /////////////////////////////
    }

    public function printestAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Cette demande n\'existe pas');
        }
        return $this->render('AgentBundle:Affecter:note_affectation_pdf.html.twig', array('entity' => $entity
        ));
    }

    /**
     * Edits an existing Affecter entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, 3);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('affecter'));
        }

        return $this->render('AgentBundle:Affecter:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    public function updatedirAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Affecter')->find($id);
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('affecter' => $entity->getId()));
        $test = $em->getRepository('AgentBundle:Imputation')->testImputation("AgentBundle:Affecter", $id);
        // dump($test); die;
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Affecter entity.');
        }
        $editForm = $this->createEditFormDirection($entity, 2, 2);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $trc_mat = $this->returnConnecte();
            //dump($trc_mat);
            //die;
            $validateur = $trc_mat->getMatricule() . "+" . $trc_mat->concatNom();

            $trc_route = 'affecter_update_dir';
            $trc_entite = 'AgentBundle:Affecter';
            $trc_id = $id;
            $entity->setEtatAffectation(1);
            $entity->setDateMiseService(new \DateTime('now'));
            $entity->setMatMiseService($trc_mat);
            $em->persist($entity);
            $em->flush($entity);
            if ($agent->getDirection()->getCodeDc()) {
                $agent->setCodeDc($agent->getDirection()->getCodeDc());
                $agent->setCodeDg($agent->getDirection()->getDirectionGle());
            }
            //dump($entity);
            //die;

            $em->persist($agent);
            $em->flush($agent);

            if (!$test) {

                $trc_lib = "Affecter un agent " . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                $this->addFlash('notice', 'affectation effectuée avec succès');
                return $this->redirect($this->generateUrl('affecter'));
            } else {
                $test->setEtatTraitement(1);
                $test->setDateTraitement(new \DateTime('now'));
                $em->persist($test);
                $em->flush($test);
                $imputer = new Imputation();
                $imputer->setDateImputation(new \DateTime('now'));
                $imputer->setObjetImputation("AgentBundle:Affecter");
                $imputer->setObjetId($entity->getId());
                $imputer->setEtat(1);
                $imputer->setMatImputateur($test->getMatImputateur());
                $imputer->setMatImputer($trc_mat);
                $imputer->setActions("affecter_print");
                $em->persist($imputer);
                $em->flush($imputer);
                $trc_lib = "(Imputer) Affecter un agent " . $entity->getAgent()->getMatricule() . "+" . $entity->getAgent()->concatNom() . "+par+" . $validateur;
                $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
                $this->addFlash('notice', 'affectation effectuée avec succès');

                return $this->redirect($this->generateUrl('imputation_affecter'));
            }
        }

        return $this->render('AgentBundle:Affecter:choix_direction.html.twig', array(
                    'entity' => $entity,
                    'agent' => $agent,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Affecter entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Affecter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Affecter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('affecter'));
    }

    /**
     * Creates a form to delete a Affecter entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('affecter_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function ListeDirectionCentraleAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $direction = $em->getRepository('AgentBundle:Direction')->findBy(array('directionGle' => $id));

        $tab = array();
        if (!empty($direction)) {
            foreach ($direction as $dc) {
                $id = $dc->getId();
                $lib = $dc->getlibDirect();

                $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"));
                ;
            }
            //dump($tab); die;
            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
        return $response;
    }

    public function ListeSousDirectionAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $Sousdirection = $em->getRepository('AgentBundle:SousDirection')->findBy(array('code_dc' => $id));

        $tab = array();
        if (!empty($Sousdirection)) {
            foreach ($Sousdirection as $sd) {
                $id = $sd->getCodeSd();
                $lib = $sd->getDesignation();
                $dc = $sd->getCodeDc()->getEtatDirection();
                $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"), $dc);
                //$tab[$id] = mb_convert_encoding($dc, "UTF-8");
            }
            // dump($tab); die;
            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
        //var_dump($response);
        //die;
        return $response;
    }

    public function ListeServiceDirectionAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $Service = $em->getRepository('AgentBundle:ServiceDirection')->findBy(array('codeSousDir' => $id));
        $tab = array();
        if (!empty($Service)) {
            foreach ($Service as $sc) {
                $id = $sc->getCodeSc();
                $lib = $sc->getDesignation();

                $tab[$id] = array(mb_convert_encoding($lib, "UTF-8"));
                //$tab[$id] = mb_convert_encoding($dc, "UTF-8");
            }
            // dump($tab); die;
            $response->setData($tab);
        } else {
            $response->setData($tab);
        }
        //var_dump($response);
        //die;
        return $response;
    }

    public function testMailAction() {
        $mailer = $this->get('agent_mailer');
        $mailer->agentConfirm($this->getUser(), "jonoj,oiljipo");
       // var_dump($mailer);
        die;
    }

}

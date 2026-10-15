<?php

namespace Agent\AgentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Agent\AgentBundle\Entity\Agent;
use Agent\AgentBundle\Form\AgentType;
use Agent\AgentBundle\Form\AgentEditProfileType;
use Agent\AgentBundle\Form\AgentRechercheType;
use Agent\AgentBundle\Form\AgentReinitialiseType;
use Agent\AgentBundle\Entity\Echelon;
use Agent\AgentBundle\Form\DesignationType;

/**
 * Agent controller.
 *
 */
class AgentController extends Controller {

    public function revokerole() {
        die;
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UsersBundle:Users')->findAll();
        $password = "12345678";
        //dump("mm");
        //$entity->setPassword("1234567");
        foreach ($user as $users) {
            if ($users->getAgent()->getFonction()->getId()) {

                if ($users->getAgent()->getFonction()->getId() == 8) {
                    $userManager = $this->container->get('fos_user.user_manager');
                    $users->removeRole('ROLE_RESPO');


                    $userManager->updateUser($users);

                    $em->flush();
                   // dump($users->getUsername());
                }
            }
        }
    }

public function creationcompteusers() {
        die;
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AgentBundle:Agent')->creationcompteusers();

        $password = "12345678";

        foreach ($user as $entity) {
            $userManager = $this->container->get('fos_user.user_manager');
            $users = $userManager->createUser();
            $users->setUsername($entity->getMatricule());
            $users->setEmail($entity->getEmail());
            $users->setPlainPassword($password);
            $users->setEnabled(TRUE);
           
            $users->addRole("ROLE_AGENT");
 
            $users->addRole("ROLE_ERH");
            $users->addRole("ROLE_BIBLIO");
            $users->addRole("ROLE_EDILIGENCE");

            $entity->setUsers($users);
            $em->persist($entity);

            $users->setAgent($entity);
            $userManager->updateUser($users);

            //dump($users);
        }
    }

    public function soutraAction() {
        $em = $this->getDoctrine()->getManager();
die;

             $em = $this->getDoctrine()->getManager();
        $demandes= $em->getRepository('DemandesBundle:Demande')->findAll();

        foreach ($demandes as  $demande) {
           
            $p = $this->get('ediligence.fonctiondebase')->positionnementAgent($demande->getEmmeteur());

            $demande->setPositionnement($p);

            $em->persist($demande);

        }
        $em->flush();

            echo "ok";

        die;



        $i=$em->getRepository('AgentBundle:Interimaire')->interimDgEncours()[0];
        dump($i->getInterimaire()->concatNom());
        die;
        //$this->revokerole();
        
       // $this->creationcompteusers();
       // die;
        
        $user = $em->getRepository('UsersBundle:Users')->findAll();
        $password = "12345678";
        //dump($user); die;
        //$entity->setPassword("1234567");
        foreach ($user as $users) {/* z
          if ($users->getAgent()->getDirection()) {
          if ($users->getAgent()->getDirection()->getId() == 4) { */
            $userManager = $this->container->get('fos_user.user_manager');

            $users->setPlainPassword($password);
            $users->setLastLogin(null);

            $userManager->updateUser($users);


            //dump($users->getUsername());
            /*
              }
              } */
        }
        $em->flush();
        // $users1 = $em->getRepository('UsersBundle:Users')->findOneBy(['username' => '366251K']);
        //dump($users1);
        die;
        /*
          $em = $this->getDoctrine()->getManager();
          $entity=$em->getRepository('UsersBundle:Users')->findOneBy(['username'=>'319968K']);
          $this->container->get('agent_mailer')->agentConfirm($entity,"nlnjlhnljhn",1);
          return $this->redirectToRoute('agent');
          $em = $this->getDoctrine()->getManager();
          $entity=$em->getRepository('UsersBundle:Users')->findAll();
          foreach($entity as $users){
          $users->addRole("ROLE_ERH");
          $users->addRole("ROLE_EDILIGENCE");
          $users->addRole("ROLE_BIBLIO");
          $em->persist($users);
          }

          $em->flush(); */
        //////////////////
        /*
          $i=0;
          $echelon = new Echelon();
          $em = $this->getDoctrine()->getManager();
          $entity=$em->getRepository('AgentBundle:Classe')->classe_echelon();
          foreach($entity as $classe){
          // dump($classe); die;
          $echelon = new Echelon();
          $echelon->setLibEchelon("1ère Echelon");
          $echelon->setClasse($classe);
          $em->persist($echelon);
          $em->flush($echelon);
          //////////////
          $echelon = new Echelon();
          $echelon->setLibEchelon("2ème Echelon");
          $echelon->setClasse($classe);
          $em->persist($echelon);
          $em->flush($echelon);
          /////////////
          $echelon = new Echelon();
          $echelon->setLibEchelon("3ème Echelon");
          $echelon->setClasse($classe);
          $em->persist($echelon);
          $em->flush($echelon);

          if($classe->getLibClas()== "2ème Classe"){
          $echelon = new Echelon();
          $echelon->setLibEchelon("4ème Echelon");
          $echelon->setClasse($classe);
          $em->persist($echelon);
          $em->flush($echelon);
          //$i++;

          }

          }
          dump($entity);
          die; */
    }

    public function listeClasseAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $classe = $em->getRepository('AgentBundle:Classe')->findBy(array('Grade' => $id));

        $tab = array();
        if (!empty($classe)) {
            foreach ($classe as $cl) {
                $id = $cl->getId();
                $lib = $cl->getlibClas();

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

    public function listeEchelonAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $echelon = $em->getRepository('AgentBundle:Echelon')->findBy(array('Classe' => $id));

        $tab = array();
        if (!empty($echelon)) {
            foreach ($echelon as $cl) {
                $id = $cl->getId();
                $lib = $cl->getlibEchelon();

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

    public function listeIndiceAction($id) {
        $response = new JsonResponse();
        $em = $this->getDoctrine()->getManager();
        $indice = $em->getRepository('AgentBundle:Indice')->findBy(array('Echelon' => $id));

        $tab = array();
        if (!empty($indice)) {
            foreach ($indice as $cl) {
                $id = $cl->getId();
                $lib = $cl->getNumero();

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

    public function formMeAction() {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AgentBundle:Agent')->afficherAgentMe($this->getUser());
        //dump($entities); die;
        return $this->render('AgentBundle:Agent:listForMe.html.twig', array(
                    'entities' => $entities
        ));
    }

    /**
     * Lists all Agent entities.
     *
     */
    public function indexAction() {
        //dump("z");
        //return $this->redirect($this->generateUrl('agent_identification_home'));
        //dump("a");
        //die;
        $em = $this->getDoctrine()->getManager();

        $activite= $em->getRepository('AgentBundle:Agent')->findBy(['position'=>[null,0]],['datePriseServiceDge'=>'ASC','nom'=>'ASC']);
        $autres=$em->getRepository('AgentBundle:Agent')->findBy(['position'=>[1,2,3,4]],['nom'=>'ASC']);
        $form = $this->createForm(new AgentRechercheType());

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

//On vérifie que les valeurs entrées sont correctes
//dump($form->isValid());die;
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
//On récupère les données entrées dans le formulaire par l'utilisateur
                $data = $this->getRequest()->request->get('agent_agentbundle_rechercheragent');

                $activite = $em->getRepository('AgentBundle:Agent')->findAgentByParametres($data);

                return $this->render('AgentBundle:Agent:index.html.twig', array(
                            'entities' => $activite,
                            'autres'   => $autres,
                            'form' => $form->createView()
                ));
            }
        }

        return $this->render('AgentBundle:Agent:index.html.twig', array(
                    'entities' => $activite,
                    'autres'   => $autres,
                    'form' => $form->createView()
        ));
    }

    public function reinitialiseAction() {
        //dump("z");
        //return $this->redirect($this->generateUrl('agent_identification_home'));
        //dump("a");
        //die;
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('AgentBundle:Agent')->afficherAgent();
        $form = $this->createForm(new AgentReinitialiseType(), array(
            'action' => $this->generateUrl('agent_reinitialise'),
            'method' => 'POST',
        ));

        ///$form->add('submit', 'submit', array('label' => 'REINITIALISER LE COMPTE'));
        //return $form;

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bind($request);

//On vérifie que les valeurs entrées sont correctes
//dump($form->isValid());die;
            if ($form->isValid()) {

                $data = $this->getRequest()->request->get('agent_agentbundle_reinitialise_password');

                $users = $em->getRepository('UsersBundle:Users')->findOneBy(['agent' => $data['users']]);
                $password = $data['mdp'];
                    //dump($users); die;
                if ($users) {
                    $userManager = $this->container->get('fos_user.user_manager');

                    $users->setPlainPassword($password);
                    $users->setLastLogin(null);
                    $users->setEtatConnexion(null);

                    $userManager->updateUser($users);

                    $em->flush();
                    $this->addFlash(
                            'notice', 'mot de passe reinitialise'
                    );
                    //die;
                    return $this->redirect($this->generateUrl('agent_reinitialise'));
                }

                return $this->render('AgentBundle:Agent:reinitialise.html.twig', array(
                            //'entities' => $entities,
                            'form' => $form->createView()
                ));
            }
        }

        return $this->render('AgentBundle:Agent:reinitialise.html.twig', array(
                    //'entities' => $entities,
                    'form' => $form->createView()
        ));
    }

    public function rechercheAction() {
        $form = $this->createForm(new AgentRechercheType());
    }

    public function listModifAction() {
        $em = $this->getDoctrine()->getManager();

       // $entities = $em->getRepository('AgentBundle:Agent')->afficherAgent();
        $activite= $em->getRepository('AgentBundle:Agent')->findBy(['position'=>[null,0]],['nom'=>'ASC']);
        $autres=$em->getRepository('AgentBundle:Agent')->findBy(['position'=>[1,2,3,4]],['nom'=>'ASC']);

        return $this->render('AgentBundle:Agent:listModif.html.twig', array(
                    'entities' => $activite,
                    'autres'=>$autres,
        ));
    }

    public function listDocAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AgentBundle:Agent')->afficherAgent();

        return $this->render('AgentBundle:Agent:listDoc.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function passwordCreate() {
        for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != 8; $x = rand(0, $z), $s .= $a{$x}, $i++)
            ;
        return $s;
    }

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

    /**
     * Creates a new Agent entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Agent();
        $em = $this->getDoctrine()->getManager();
        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        $form = $this->createCreateForm($entity, 0);
        $form->handleRequest($request);


        $id = $form->getData()->getMatricule();
        

        if ($form->isValid()) {
            // Vérification de l'existance de l'agent dans la base


            $user_exist = $em->getRepository('AgentBundle:Agent')->find($id);
            //$affecter_id=$em->getRepository('AgentBundle:Affecter');

            if ($user_exist) {
                $em->flush();
                $this->addFlash(
                        'error', 'L\'Agent que vous tentez d\'ajouter existe déjà dans la base de données'
                );
                //die;
                return $this->redirect($this->generateUrl('agent_show', array('id' => $entity->getId())));
            }

            $email = $em->getRepository('UsersBundle:users')->findOneBy(array('email' => $entity->getEmail()));
            if ($email) {
                $this->addFlash(
                        'notice', 'L\'émail existe déjà dans la base de données'
                );
                return $this->render('AgentBundle:Agent:new.html.twig', array(
                            'entity' => $entity,
                            'emploi' => $emploi,
                            'form' => $form->createView(),
                ));
            }
            $password = "12345678";//$this->passwordCreate();
            $userManager = $this->container->get('fos_user.user_manager');
            $users = $userManager->createUser();
            $users->setUsername($entity->getMatricule());
            $users->setEmail($entity->getEmail());
            $users->setPlainPassword($password);
            $users->setEnabled(TRUE);
            switch ($entity->getFonction()->getId()) {

                case 5:
                    $users->addRole("ROLE_RESPO");
                    break;

                case 7:
                    $users->addRole("ROLE_RESPO");
                    break;

                default:
                    $users->addRole("ROLE_AGENT");
                    break;
            }

            $users->addRole("ROLE_ERH");
            $users->addRole("ROLE_BIBLIO");
            $users->addRole("ROLE_EDILIGENCE");
            // $users->addRole($entity->getRole()->getRoleBase());
            $entity->setCodeDc($entity->getDirection()->getCodeDc());
            $entity->setMatAjoutEnreg($this->returnConnecte());
            $entity->setUsers($users);
            $em->persist($entity);

            $users->setAgent($entity);
            $userManager->updateUser($users);

            //var_dump($users); die;
            //envoi E-mail
            $mailer = $this->get('agent_mailer');
            $mailer->agentConfirm($users, $password);

            $em->flush();
            $this->addFlash(
                    'notice', 'Le nouvel Agent a été éffectuée avec Succès'
            );

            return $this->redirect($this->generateUrl('agent_show', array('id' => $entity->getId())));
        } else {
            //die;
        }

        return $this->render('AgentBundle:Agent:new.html.twig', array(
                    'entity' => $entity,
                    'emploi' => $emploi,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Agent entity.
     *
     * @param Agent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Agent $entity, $todo) {
        $form = $this->createForm(new AgentType($todo), $entity, array(
            'action' => $this->generateUrl('agent_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Agent entity.
     *
     */
    public function newAction() {
        $entity = new Agent();

        $em = $this->getDoctrine()->getManager();
        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        $form = $this->createCreateForm($entity, 0);

        return $this->render('AgentBundle:Agent:new.html.twig', array(
                    'entity' => $entity,
                    'emploi' => $emploi,
                    'form' => $form->createView(),
        ));
    }

    public function pdfAction() {
        //////////////////////
        ////*
        /*
          return $this->render('::gabarit_print.html.twig', array(
          )); */

        $html = $this->renderView('::gabarit_print.html.twig', array(
        ));

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"'
                )
        );
        /*
         */

        /////////////////////////////
    }

    /**
     * Finds and displays a Agent entity.
     *
     */
    public function showAction($id, $val) {
        $em = $this->getDoctrine()->getManager();

        //$yapi=$this->get('ediligence.fonctiondebase')->addTracing(/*$libelle=null,$matricule=null,$route=null,$entite=null,$id=null,$os=null*/);
        $entity = $em->getRepository('AgentBundle:Agent')->find($id);
        $document = $em->getRepository('AgentBundle:Document')->afficherDocumentAgent($id);

        $user = $this->getUser();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }
        if ($val != 0 and $user->hasRole('ROLE_RESPO')) {
            //return $this->redirectToRoute('agent_tableau', ['id' => $user->getAgent()->getMatricule()]);
            return $this->redirectToRoute('agent_tableau', ['id' => $user->getAgent()->getId()]);
        } else {
            $deleteForm = $this->createDeleteForm($id);
            return $this->render('AgentBundle:Agent:show.html.twig', array(
                        'entity' => $entity,
                        'document' => $document,
                        'delete_form' => $deleteForm->createView(),
            ));
        }
    }

    /**
     * Displays a form to edit an existing Agent entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Agent')->find($id);
        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $editForm = $this->createEditForm($entity, 0);
        $deleteForm = $this->createDeleteForm($id);
        //dump($editForm->createView());
        // var_dump($editForm->createView()); die;
        return $this->render('AgentBundle:Agent:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'emploi' => $emploi,
        ));
    }

    public function editProfilAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Agent')->find($id);

        // $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $originalAdresse = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getAdresse() as $adr) {
            $originalAdresse->add($adr);
        }
        $editForm = $this->createEditProfilForm($entity);
        $editForm->handleRequest($request);
        //dump($entity);
        //$deleteForm = $this->createDeleteForm($id);
        // var_dump($editForm->createView()); die;

        if ($editForm->isValid()) {
            foreach ($originalAdresse as $adrs) {
                if (false === $entity->getAdresse()->contains($adrs)) {

                    $em->remove($adrs);
                }
            }

            $em->flush();
            //die;
            $this->addFlash(
                    'notice', 'Les informations de l\'Agent ont été Mis à Jour avec Succès'
            );
            return $this->redirect($this->generateUrl('agent_show', array('id' => $entity->getId())));
        }
        return $this->render('AgentBundle:Agent:edit_profil.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Agent entity.
     *
     * @param Agent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Agent $entity, $todo) {
        $form = $this->createForm(new AgentType($todo), $entity, array(
            'action' => $this->generateUrl('agent_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function createEditProfilForm(Agent $entity) {
        $form = $this->createForm(new AgentEditProfileType(), $entity, array(
            'action' => $this->generateUrl('agent_edit_profil', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Appliquer la modification', 'attr' => ['class' => 'col-md-6 col-md-push-3 btn btn-success']));

        return $form;
    }

    public function comparaison($old = null, $new = null) {
        if (strcmp($old, $new) == 0) {
            return 0; //identique
        } else {
            return 1; //different
        }
    }

    /**
     * Edits an existing Agent entity.
     *
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $emploi = $em->getRepository('AgentBundle:Emploi')->findAll();
        $matModif = $this->getUser()->getAgent();
        $entity = $em->getRepository('AgentBundle:Agent')->find($id);
        
        $oldmat = $entity->getMatricule();
        $oldemail = $entity->getEmail();
        //var_dump($entity->getAffecter()); die;

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agent entity.');
        }

        $originalAdresse = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($entity->getAdresse() as $adr) {
            $originalAdresse->add($adr);
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, 0);
        $editForm->handleRequest($request);
        //dump($editForm->getData()->getMatricule());
        //dump($entity->getMatricule());die;
        if ($editForm->isValid()) {

            $trc_mat = $this->getUser()->getAgent();
            $trc_route = 'agent_update';
            $trc_entite = 'AgentBundle:Agent';
            $trc_lib = "Modifier informations agent";
            $trc_id = $id;
            $entity->setDateAutoModifEnreg(new \DateTime('now'));
            $entity->setMatModifEnreg($matModif);
            $entity->setCodeDc($entity->getDirection()->getCodeDc());
            foreach ($originalAdresse as $adrs) {
                if (false === $entity->getAdresse()->contains($adrs)) {

                    $em->remove($adrs);
                }
            }
            $comp1 = $this->comparaison($oldmat, $editForm->getData()->getMatricule());
            $comp2 = $this->comparaison($oldemail, $editForm->getData('email'));

            $userManager = $this->container->get('fos_user.user_manager');
            $users = $userManager->findUserBy(['agent'=>$entity->getId()]);

            if ($users) {

                $users->setUsername($editForm->getData()->getMatricule());
                $users->setEmail($editForm->getData()->getEmail());

                $em->persist($users);
            }
            $em->persist($entity);

            $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
            $em->flush();
            if ($comp1 == 1) {
                //envoi de mail
            }
            $this->addFlash(
                    'notice', 'Les informations de l\'Agent ont été Mis à Jour avec Succès');
            return $this->redirect($this->generateUrl('agent_show', array('id' => $entity->getId())));
            /* $test_user = $em->getRepository('UsersBundle:Users')->findOneBy(['username' => $entity->getMatricule()]);

              $test_email = $em->getRepository('UsersBundle:Users')->findOneBy(['email' => $entity->getEmail(),]);
              dump($test_email);
              die;
              $userManager = $this->container->get('fos_user.user_manager');
              $users = $userManager->findUserByUsername($entity->getMatricule());
              $trc_mat = $this->getUser()->getAgent();
              $trc_route = 'agent_update';
              $trc_entite = 'AgentBundle:Agent';
              $trc_id = $id;
              $comp1 = $this->comparaison($oldmat, $editForm->getData()->getMatricule());
              $comp2 = $this->comparaison($oldemail, $editForm->getData()->getEmail());

              //utilisateur déja créé
              if ($users) {

              $comp1=$this->comparaison($oldmat, $editForm->getData()->getMatricule());
              $comp2=$this->comparaison($oldemail, $editForm->getData('email'));
              if ($comp1 != 0 || $comp2 != 0) {//identique
              $trc_lib = "Suppression compte compte users " . $users->getUsername() . " " . $users->getEmail();
              $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
              $trc_lib = "Modifier informations agent";
              //$users
              $em->remove($users);
              $em->flush();
              //////////////Création nouvelle utilisateur//////////

              $userNew = $this->get('ediligence.fonctiondebase')->creerUser($entity, 1);
              //var_dump($userNew);
              //die;
              //var_dump($entity->getAgent()->getMatricule());
              }
              //nouvel agent
              } else {
              $trc_lib = "Modifier informations nouvel agent : " . $entity->concatNom() . "  par : " . $this->getUser()->getAgent()->concatNom();
              } */

            /* if (!$test_user or ! $test_email) {
              //$em = $this->getDoctrine()->getManager();
              $userManager = $this->container->get('fos_user.user_manager');
              $users = $userManager->findUserByUsername($entity->getMatricule());
              $trc_mat = $this->getUser()->getAgent();
              $trc_route = 'agent_update';
              $trc_entite = 'AgentBundle:Agent';
              $trc_id = $id;
              $comp1 = $this->comparaison($oldmat, $editForm->getData()->getMatricule());
              $comp2 = $this->comparaison($oldemail, $editForm->getData()->getEmail());

              //utilisateur déja créé
              if ($users) {


              if ($comp1 != 0 || $comp2 != 0) {//identique
              $trc_lib = "Suppression compte compte users " . $users->getUsername() . " " . $users->getEmail();
              $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);
              $trc_lib = "Modifier informations agent";
              //$users
              $em->remove($users);
              $em->flush();
              //////////////Création nouvelle utilisateur//////////

              $userNew = $this->get('ediligence.fonctiondebase')->creerUser($entity, 1);
              //var_dump($userNew);
              //die;
              //var_dump($entity->getAgent()->getMatricule());
              }
              //nouvel agent
              } else {
              $trc_lib = "Modifier informations nouvel agent : " . $entity->concatNom() . "  par : " . $this->getUser()->getAgent()->concatNom();
              }
              $entity->setDateAutoModifEnreg(new \DateTime('now'));
              $entity->setMatModifEnreg($matModif);
              foreach ($originalAdresse as $adrs) {
              if (false === $entity->getAdresse()->contains($adrs)) {

              $em->remove($adrs);
              }
              }

              $em->persist($entity);
              $em->flush($entity);
              $trace = $this->get('ediligence.fonctiondebase')->addTracing($trc_lib, $trc_mat, $trc_route, $trc_entite, $trc_id, 0);

              $this->addFlash(
              'notice', 'Les informations de l\'Agent ont été Mis à Jour avec Succès');
              return $this->redirect($this->generateUrl('agent_show', array('id' => $entity->getId())));
              } else {
              $this->addFlash(
              'error', 'le matricule ou l\'email exist déjà ');
              return $this->render('AgentBundle:Agent:edit.html.twig', array(
              'emploi' => $emploi,
              'entity' => $entity,
              'form' => $editForm->createView(),
              'delete_form' => $deleteForm->createView(),
              ));
              } */
        }

        return $this->render('AgentBundle:Agent:edit.html.twig', array(
                    'emploi' => $emploi,
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Agent entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AgentBundle:Agent')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Agent entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('agent'));
    }

    /**
     * Creates a form to delete a Agent entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('agent_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    public function docAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AgentBundle:Agent')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Aucun Agent ne porte se Matricule');
        }

        $editForm = $this->createEditForm($entity, 0);


        // var_dump($editForm->createView()); die;
        return $this->render('AgentBundle:Agent:edit_doc.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
        ));
    }

    public function menuAction($id = null) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if ($id == 0) {
            $user->setEtat(0);
        } elseif ($id == 1) {
            $user->setEtat(1);
        }elseif ($id == 2) {
            $user->setEtat(2);
        }
        $em->persist($user);
        $em->flush();

        return $this->redirect(
                        $this->getRequest()
                                ->headers
                                ->get('referer')
        );
    }

    public function designerAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $tableau = $this->designationtab();

        $form = $this->Formdesignation($tableau);
        $form->handleRequest($request);

        //   dump($form->isValid());
        //   dump($form);
        //  die;
        if ($request->isMethod('post')) {
            $frm = $form->getData();

            foreach ($frm as $key => $values) {
                $recoverchief = $this->recoverchief($key, $values);
            }
//return $this->redirect($this->generateUrl('agent_reinitialise'));
            $this->addFlash(
                    'notice', 'Opération reussie avec succes'
            );
            return $this->redirectToRoute('agent_designer');
        }

        return $this->render('AgentBundle:Agent:designer.html.twig', array('tableau' => $tableau, 'form' => $form->createView()));
    }

    private function Formdesignation($tableau) {
        $form = $this->createForm(new DesignationType($tableau), null, array(
            'action' => $this->generateUrl('agent_designer'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'DESIGNER', 'attr' => ['class' => 'form-control btn-default']));
        return $form;
    }

    private function designationtab() {
        $em = $this->getDoctrine()->getManager();

        $directiongles = $em->getRepository('AgentBundle:DirectionGenerale')->findAll();
        //$tableau[]='';
        foreach ($directiongles as $directiongle) {
            $agentdirectiongles = $em->getRepository('AgentBundle:Agent')->findOneBy(array('code_dg' => $directiongle->getCodeDg(), 'Fonction' => [10]));

            $tableau[$directiongle->getCodeDg()]['Service'] = $directiongle;
            $tableau[$directiongle->getCodeDg()]['respo'] = $agentdirectiongles;

            $directions = $em->getRepository('AgentBundle:Direction')->findBy(array('directionGle' => $directiongle), ['rang1' => 'ASC']);

            foreach ($directions as $direction) {
                $agentdirection = $em->getRepository('AgentBundle:Agent')->findOneBy(array('code_dg' => $directiongle->getCodeDg(), 'code_dc' => $direction->getCodeDc(), 'Fonction' => [9, 8, 7, 5]));

                $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()]['Service'] = $direction;
                $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()]['respo'] = $agentdirection;

                $sousdirections = $em->getRepository('AgentBundle:SousDirection')->findBy(array('code_dc' => $direction));

                foreach ($sousdirections as $sousdirection) {
                    $agentsousdirection = $em->getRepository('AgentBundle:Agent')->findOneBy(array('code_dg' => $directiongle->getCodeDg(), 'code_dc' => $direction->getCodeDc(), 'code_sd' => $sousdirection->getCodeSd(), 'Fonction' => [6, 4, 3]));

                    $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()][$sousdirection->getCodeSd()]['Service'] = $sousdirection;
                    $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()][$sousdirection->getCodeSd()]['respo'] = $agentsousdirection;

                    $servicedirections = $em->getRepository('AgentBundle:ServiceDirection')->findBy(array('codeSousDir' => $sousdirection));

                    foreach ($servicedirections as $servicedirection) {
                        $agentservicedirection = $em->getRepository('AgentBundle:Agent')->findOneBy(array('code_dg' => $directiongle->getCodeDg(), 'code_dc' => $direction->getCodeDc(), 'code_sd' => $sousdirection->getCodeSd(), 'code_sc' => $servicedirection->getCodeSc(), 'Fonction' => [4, 3]));

                        $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()][$sousdirection->getCodeSd()][$servicedirection->getCodeSc()]['Service'] = $servicedirection;
                        $tableau[$directiongle->getCodeDg()][$direction->getCodeDc()][$sousdirection->getCodeSd()][$servicedirection->getCodeSc()]['respo'] = $agentservicedirection;
                    }
                }
            }
        }

        return $tableau;
    }

    private function recoverchief($key = null, $values = null) {
        $em = $this->getDoctrine()->getManager();

        if (!preg_match("#Service#", $key) && !preg_match("#label#", $key)) {
            $key = substr($key, 1);
            if ($values) {
                $explodekey = explode('_', $key);
                //trouver le responsable actuel
                $x = count($explodekey);
                $chiefactuel = $explodekey[$x - 1];
                $service = $explodekey[$x - 2];

                if ($chiefactuel != 'null') {//demettre
                    $fonctions = $em->getRepository('AgentBundle:Fonction')->find(2); //charge etude

                    $chiefactuel = $em->getRepository('AgentBundle:Agent')->find($chiefactuel);

                    $chiefactuel->setFonction($fonctions);



                    $chiefactuel->getUsers()->removeRole('ROLE_RESPO');
                    $em->persist($chiefactuel);
                }

                $sc = $sd = $dc = $dg = $fonction_id = null;
                if (preg_match("#SC#", $key)) {
                    $sc = $em->getRepository('AgentBundle:ServiceDirection')->findOneBy(array('code_sc' => $explodekey[3]));
                    $fonction_id = 4;
                }
                if (preg_match("#SD#", $key)) {
                    $sd = $em->getRepository('AgentBundle:SousDirection')->findOneBy(array('code_sd' => $explodekey[2]));
                    if ($sd && !$fonction_id) {
                        if ($sd->getCodeDc()->getEtatDirection() == 0) {
                            $fonction_id = 3; //chef section
                        } elseif ($sd->getCodeDc()->getEtatDirection() == 1) {
                            $fonction_id = 6; //sous directeur
                        } else {
                            $fonction_id = 4; //chef de service
                        }
                    }
                }
                if (preg_match("#DC#", $key)) {
                    $dc = $em->getRepository('AgentBundle:Direction')->findOneBy(array('code_dc' => $explodekey[1]));
                    if ($dc && !$fonction_id) {
                        if ($dc->getEtatDirection() == 0) {
                            $fonction_id = 5; //chef service rattache
                            if ($dc->getId() == 3) {
                                $role = 'ROLE_RESPO_SRHMG';
                            }
                        } elseif ($dc->getEtatDirection() == 1) {
                            $fonction_id = 7; //directeur
                        } elseif ($dc->getEtatDirection() == 2) {
                            $fonction_id = 9; //directeur general adjoint
                        } else {
                            $fonction_id = 4; //chef de service
                        }
                    }
                }
                if (preg_match("#DG#", $key)) {
                    $dg = $em->getRepository('AgentBundle:DirectionGenerale')->findOneBy(array('codeDg' => $explodekey[0]));
                    if ($dg && !$fonction_id) {
                        $fonction_id = 10; //directeur general
                    }
                }

                $fonction = $em->getRepository('AgentBundle:Fonction')->find($fonction_id);

                $values->setCodeSc($sc);
                $values->setCodeSd($sd);
                $dc_ = (empty($dc)) ? null : $explodekey[1];
                $values->setCodeDc($dc_);
                $values->setDirection($dc);
                $values->setCodeDg($dg);

                $values->setFonction($fonction);

                if ($values->getUsers()) {
                    $values->getUsers()->addRole('ROLE_RESPO');
                }
                if (isset($role) && $role == 'ROLE_RESPO_SRHMG' && $fonction_id == 5) {
                    if ($values->getUsers()) {
                        $values->getUsers()->addRole('ROLE_RESPO_SRHMG');
                    }
                }
                $em->persist($values);


                $em->flush();

                //return  0;
            }
        }
    }

}

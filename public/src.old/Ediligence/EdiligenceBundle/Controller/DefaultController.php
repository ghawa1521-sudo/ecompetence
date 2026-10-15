<?php

namespace Ediligence\EdiligenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ediligence\EdiligenceBundle\Entity\Notification;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DefaultController extends Controller {

    function __construct() {
        
    }

    public function indexAction(Request $request) {
     
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('AgentBundle:Direction')->findBy(array('etatDirection' => [0, 1]), array('rang' => 'ASC'));
        $suivi_expire = $this->suivi_dashboard(1);

        for ($o = 0; $o < 4; $o++) {
            if ($o > 0) {
                $ii = 0;
                do {
                    $cal[$o] = $this->get('ediligence.fonctiondebase')->calculdate(date('Y-m-d'), $o + $ii);
                    $tdate[$o]=$this->get('ediligence.fonctiondebase')->calculdate(date('Y-m-d'), $o + $ii,1);
                    $ii++;
                    $suivi[$o] = $this->suivi_dashboard($cal[$o]);
                } while ($cal[$o] <= $cal[$o - 1]);
            } else {
                $cal[$o] = $this->get('ediligence.fonctiondebase')->calculdate(date('Y-m-d'), $o);
                $tdate[$o]=$this->get('ediligence.fonctiondebase')->calculdate(date('Y-m-d'), $o,1);
                $suivi[$o] = $this->suivi_dashboard($cal[$o]);
            }
        }
        
        
    
       //dump($cal);die;
        //$services = ['' => ''];
       

        // dump(implode(',', $query_role));  die;    
        return $this->render('EdiligenceBundle:Default:index.html.twig', array('suivi' => $suivi, 'suivi_expire' => $suivi_expire,'tdate'=>$tdate));
        /*    $Troles = array('ROLE_DGE', 'ROLE_Service_Courrier', 'ROLE_Sous_Dir_Chef_Sec',
          'ROLE_Charge_etudes', 'ROLE_Conseillers', 'ROLE_Courrier_Interne',
          'ROLE_Administrateur');

          $UserRoles = $this->getUser()->getRoles();
          foreach ($UserRoles as $UserRole) {
          if (in_array($UserRole, $Troles)) {
          break ;
          }
          }



          var_dump($UserRoles);
          var_dump($Troles);
          die; */
////dump($this->getUser()->getAgent()); 
        // var_dump($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase());die;

        /*  $menu = $this->menu($matricule = $this->getUser()->getAgent()->getMatricule(), 
          $fonction = $this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase(),
          $sup = $this->getUser()->getAgent()->getFonction()->getSup()
          ); */

        //var_dump($menu);
        //die;
        //return new Response($menu);
    }

    public function menuAction() {
        $menu = $this->menu($matricule = $this->getUser()->getAgent()->getMatricule(),
                // $fonction = $this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase(), 
                $sup = $this->getUser()->getRoles()
                //$privileges = $this->getUser()->getAgent()->getRoleEdiligence()
        );
        $tab = $this->get('ediligence.fonctiondebase')->countNotif();

        return $this->render('EdiligenceBundle:Default:menu.html.twig', array('menus' => $menu, 'tab' => $tab));
    }

    public function menu($matricule = null, $sup = null) {

        $em = $this->getDoctrine()->getManager();

        $profil = $em->getRepository('EdiligenceBundle:Menu')->query_menu($sup); //$fonction, $this->getUser()->getRoles()

        return $profil;
        //return array('matricule' => $matricule, 'fonction' => $fonction, 'sup' => $sup);
    }

    public function board($role) {
        $r = explode(',', $role);
        if (in_array("ROLE_SERVICE_COURRIER", $r)) {
            $profile = null;
        } elseif (in_array("ROLE_CHARGE_ETUDES", $r)) {
            $key = array('Courrier arrivé' => 5);
            $values = array('Courrier enregistré' => 4);
            $profile = array_merge($key, $values);
        } else {
            $profile = null;
        }
        /*
          switch($role){
          case "ROLE_Charge_etudes": {
          $key=array('Courrier arrivé'=>5);
          $values=array('Courrier enregistré'=>4);
          $profile = array_merge($key, $values);

          } break;

          default :{$profile = null;}
          } */
        return $profile;
    }

    public function query_role($role) {
        $em = $this->getDoctrine()->getManager();
        $annee = date('Y');
        $result = array();
        for ($m = 1; $m <= 12; $m++) {
            if (strlen($m) == 1) {
                $m = '0' . $m;
            }
            $query = $em->getRepository('EdiligenceBundle:Menu')->tableau_bord($role, $m, $annee);
            $result[] = $query;
        }
        return $result;
    }

    public function apercu($rootDir = null) {
        $lien = "http:\\docs.google.com/viewer?url=" . $rootDir . "&embedded=true";
        $apercu_doc = "apercu";

        return '<a href="" onclick=pop_apercu("' . $lien . '")>' . $apercu_doc . '</a>';
    }

    /** Gestion des Notifications * */
    public function addNotification($em, $matuser, $description, $objet = null, $objetid = 0, $action = null) {
        //$em = $this->getDoctrine()->getManager();

        $notification = new Notification();
        $date = new \DateTime();
        //$agent=$user->getAgent();  //->getMatricule();
        $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('matricule' => $matuser));
        $notification->setObjet($objet);
        $notification->setObjetid($objetid);
        $notification->setDate($date);
        $notification->setDescription($description);
        $notification->setAction($action);
        $notification->setAgent($agent);

        $em->persist($notification);
        $em->flush();
    }

    /**
     * 
     * 
     * 
     * */
    public function disableNotification($em, $matuser = null, $objet = null, $objetid = 0) {
        if ($matuser != null) {
            $agent = $em->getRepository('AgentBundle:Agent')->findOneBy(array('matricule' => $matuser));
            $notifications = $em->getRepository('EdiligenceBundle:Notification')->findBy(['objet' => $objet, 'objetid' => $objetid, 'agent' => $matuser]);
        } else {
            $notifications = $em->getRepository('EdiligenceBundle:Notification')->findBy(['objet' => $objet, 'objetid' => $objetid]);
        }

        if ($notifications) {
            foreach ($notifications as $notification) {
                //$notification->setEtat(1);   //Disable Notification
                $em->remove($notification);
                //$em->persist($notification);
            }

            $em->flush();
        }
    }

    public function listNotification($em, $user) {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('EdiligenceBundle:Notification')->findBy(['agent' => $this->getUser()->getAgent()->getMatricule(), 'etat' => 0]);
        $tnotifications = [];
        if ($notifications) {
            foreach ($notifications as $notification) {
                //Récupération de l'objet concerné
                $objet = $em->getRepository($notification->getObjet())->find($notification->getObjetid());
                $tnotifications[] = ['objet' => $objet, 'notification' => $notification];
            }
        }

        return $tnotifications;
    }

    public function notificationAction() {
        $em = $this->getDoctrine()->getManager();
        //$tnotifications = $this->listNotification($em, $this->getUser());
        $tnotifications = $this->get('ediligence.fonctiondebase')->countNotif(1);


        return $this->render('EdiligenceBundle:Default:notification.html.twig', array('notifications' => $tnotifications));
    }

    public function suivi_dashboard($param = null) {

        $em = $this->getDoctrine()->getManager();
        $service_imput = $this->getUser()->getAgent()->retour_service();
        $matricule = $this->getUser()->getAgent()->getMatricule();
        $entity = $em->getRepository('EdiligenceBundle:Timputations')->suividiligencedge($service_imput['service'], $matricule, $this->getUser(), $param);
        $tab_dir = '';
        foreach ($entity as $entits) {
            if ($entits[0] != null) {
                $tab_dir .= $entits[0]->getId() . ',';
            }
        }
        $tab_dir = substr($tab_dir, 0, (strlen($tab_dir) - 1));

        $entity1 = $em->getRepository('EdiligenceBundle:TimputDir')->service_dest($tab_dir);

        return array('entity' => $entity, 'entity1' => $entity1);
    }

    
   public function statsAction(Request $request) { 
          //dump($this->get('ediligence.fonctiondebase')->superieur_agent()); die;
        $query_role = $this->query_role($this->getUser()->getAgent()->getFonction()->getTypeCompte()->getRoleBase());
        //  $query_role = $this->getUser()->getRoles();
        //  $query_service = $this->getUser()->getAgent()->retour_service();
        //  $query_fonction = $this->query_role($this->getUser()->getAgent()->getFonction()->getId();
        $board = $this->get('ediligence.board')->board(implode(',', $query_role));
       
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('AgentBundle:Direction')->findBy(array('etatDirection' => [0, 1]), array('rang' => 'ASC'));
        $objet = ['' => 'Tous', 'Tcourrier' => 'Courrier', 'Ttraitement' => 'Traitement', 'Timputations' => 'Imputations', 'Tarchive' => 'Archive'];
        $connecteur = ['' => ' ', 'and' => 'Ou', 'or' => 'Et'];
        $form = $this->createFormBuilder()
                ->add('motcles1', TextType::class)
                ->add('objet1', ChoiceType::class, ['choices' => $objet])
                ->add('conn1', ChoiceType::class, ['choices' => $connecteur])
                ->add('motcles2', TextType::class)
                ->add('objet2', ChoiceType::class, ['choices' => $objet])
                ->add('conn2', ChoiceType::class, ['choices' => $connecteur])
                ->add('motcles3', TextType::class)
                ->add('objet2', ChoiceType::class, ['choices' => $objet])
                ->add('objet3', ChoiceType::class, ['choices' => $objet])
                ->add('datedebut', DateType::class, array('widget' => 'single_text', 'label' => 'Date debut:', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'input-datepicker')))
                ->add('datefin', DateType::class, array('widget' => 'single_text', 'label' => 'Date fin:', 'format' => 'dd-MM-yyyy', 'attr' => array('class' => 'input-datepicker')))
                ->add('services', ChoiceType::class, ['choices' => $services, 'empty_value' => 'Tous les Services'])
                ->setAction($this->generateUrl('courrier_delete', array('id' => 1)))
                ->setMethod('GET')
                ->add('submit', 'submit', array('label' => 'Rechercher'))
                ->getForm();

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            
        }
 
        return $this->render('EdiligenceBundle:Default:stats.html.twig', array('board' => $board, 'query_role' => implode(',', $query_role),'form' => $form->createView()));

   }
    
}

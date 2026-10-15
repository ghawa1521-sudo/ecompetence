<?php
namespace Ecompetence\EcompetenceBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ecompetence\EcompetenceBundle\Form\CompetenceRechercheType;
class ProfileController extends Controller
{    use \Ecompetence\EcompetenceBundle\Entity\traitfuncion ;
    public $domaine=array();
    public function profileAction(Request $request)
    { 
        
        $agent=[];
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AgentBundle:Agent')->AfficherAgentExp();
        //dump($entities);die;
        $i=0;
        foreach ($entities as $entity)
        { $structure=null;
            //$Agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $entity->getId()]);
          if($entity && $entity->getdirection())
          {
              $structure=$entity->getDirection()->getSigle();
          }

         // ==========================
// CALCUL EXPERIENCE TOTALE
// ==========================
$experiences = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent' => $entity]);

$totalDaysHorsDge = 0;
$totalDaysDge = 0;

$datePdge = $entity->getDatePriseServiceDge();
$now = new \DateTime(); // date "aujourd'hui"

// Parcours des expériences
foreach ($experiences as $exp) {
    $start = $exp->getDateDebExp();
    $end   = $exp->getDateFinExp() ?: $now;

    if (!$start) continue;

    // Cas expérience entièrement après DGE
    if ($datePdge && $start >= $datePdge) {
        $interval = $start->diff($end);
        $totalDaysDge += $interval->days;
    }
    // Cas expérience chevauche DGE
    elseif ($datePdge && $start < $datePdge && $end > $datePdge) {
        // Partie avant DGE
        $intervalHors = $start->diff($datePdge);
        $totalDaysHorsDge += $intervalHors->days;

        // Partie après DGE
        $intervalDge = $datePdge->diff($end);
        $totalDaysDge += $intervalDge->days;
    }
    // Cas expérience entièrement hors DGE
    else {
        $interval = $start->diff($end);
        $totalDaysHorsDge += $interval->days;
    }
}

// ==========================
// EXPÉRIENCE TOTALE (CORRIGÉE)
// ==========================

// Interval DGE
$intervalDge = $datePdge ? $datePdge->diff($now) : null;

// Interval hors DGE
$intervalHors = null;
if ($totalDaysHorsDge > 0) {
    $dateDebutHors = clone $now;
    $dateDebutHors->modify('-' . (int)$totalDaysHorsDge . ' days');
    $intervalHors = $dateDebutHors->diff($now);
}

// Addition des années et mois
$totalYears  = 0;
$totalMonths = 0;

if ($intervalDge) {
    $totalYears  += $intervalDge->y;
    $totalMonths += $intervalDge->m;
}

if ($intervalHors) {
    $totalYears  += $intervalHors->y;
    $totalMonths += $intervalHors->m;
}

// Si les mois dépassent 11, convertir en années
if ($totalMonths >= 12) {
    $totalYears += floor($totalMonths / 12);
    $totalMonths = $totalMonths % 12;
}

// Formatage texte
if ($totalYears >= 1) {
    $anexp = $totalYears . ' an' . ($totalYears > 1 ? 's' : '');
    if ($totalMonths > 0) {
        $anexp .= ' et ' . $totalMonths . ' mois';
    }
} elseif ($totalMonths >= 1) {
    $anexp = $totalMonths . ' mois';
} else {
    $anexp = 'moins d’un mois';
}

// ==========================
// EXPÉRIENCE DGE
// ==========================
$anexpdge = 'Non renseigné';
if ($datePdge) {
    $interval = $datePdge->diff($now);
    $yearsDge  = $interval->y;
    $monthsDge = $interval->m;

    if ($yearsDge >= 1) {
        $anexpdge = $yearsDge . ' an' . ($yearsDge > 1 ? 's' : '');
        if ($monthsDge > 0) {
            $anexpdge .= ' et ' . $monthsDge . ' mois';
        }
    } elseif ($monthsDge >= 1) {
        $anexpdge = $monthsDge . ' mois';
    } else {
        $anexpdge = 'moins d’un mois';
    }
}

// ==========================
// EXPÉRIENCE HORS DGE
// ==========================
$anexpHorsDge = 'moins d’un mois';
if ($totalDaysHorsDge > 0) {
    $dateDebutHors = clone $now;
    $dateDebutHors->modify('-' . (int)$totalDaysHorsDge . ' days');
    $intervalHors = $dateDebutHors->diff($now);

    $yearsHorsDge  = $intervalHors->y;
    $monthsHorsDge = $intervalHors->m;

    if ($yearsHorsDge >= 1) {
        $anexpHorsDge = $yearsHorsDge . ' an' . ($yearsHorsDge > 1 ? 's' : '');
        if ($monthsHorsDge > 0) {
            $anexpHorsDge .= ' et ' . $monthsHorsDge . ' mois';
        }
    } elseif ($monthsHorsDge >= 1) {
        $anexpHorsDge = $monthsHorsDge . ' mois';
    }
}

//dump($yearsDge);die;

          // code grise par Samin
        //    $expdebut = $em->getRepository('EcompetenceBundle:Experience')->findDateMin($entity->getId());
        //    $expfin = $em->getRepository('EcompetenceBundle:Experience')->findDateMax($entity->getId());
           
            
        //    if(!$expdebut)
        //    {
        //     $anexp=null;
         
        //    }
        //    else
        //    {
        //   // $structure=$expfin[0]->getStructure()->getLibStructure(); 
        //    $datedebut=$expdebut[0]->getDateDebExp();
          
        //    $datefin=$expfin[0]->getDateFinExp();
           
        //    if($datefin==null)
        //    {
        //       $datefin=new \DateTime('now');
        //    }
        //    $interval = $datefin->diff($datedebut);
           
        //    if($interval->format('%y')=='0'||$interval->format('%y')=='1')
        //    {
        //        $anexp=$interval->format('%y an');
               
        //    }
        //    else
        //    {
        //     $anexp= $age=$interval->format('%y ans');  
        //    }
        //    }

       
        //    $anexpdge=null;
        //    $datePdge=$entity->getDatePriseServiceDge();
        //    if($datePdge){
        //    $datefindge=new \DateTime('now');
        //    $interval = $datefindge->diff($datePdge);          
        //    if($interval->format('%y')=='0'||$interval->format('%y')=='1')
        //    {
        //        $anexpdge=$interval->format('%y an');
        //    }
        //    else
        //    {
        //     $anexpdge=$interval->format('%y ans');  
        //    }
        //    }
            // fin code grise par Samin
        // dump($anexp);die;
           $age=null;
           $datenais=$entity->getDateNaiss();
           if($datenais){
           $datejour=new \DateTime('now');
           $interval = $datejour->diff($datenais);
           
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $age=$interval->format('%y an');
           }
           else
           {
            $age=$interval->format('%y ans');  
           }
           }
        //dump($anexp);die;
            $agent[$i]=array('id'=>$entity->getId(),
                            'matricule'=>$entity->getMatricule(),
                            'nom'=>$entity->getNom(),
                            'prenoms'=>$entity->getPrenoms(),
                            'situationMatri'=>$entity->getSituationMatri(),
                            'NomJeuneFille'=>$entity->getNomJeuneFille(),
                            'age'=>$age,
                            'anexp'=>$anexp,
                            'employeur'=>$structure,
                            'emploi'=>$entity->getEmploi()->getLibEmpl(),
                            'sousdirection'=>$entity->getCodeSd(),
                            'service'=>$entity->getCodeSc(),
                            'poste'=>$entity->getFonction()->getLibFonc(),
                            'anexpdge'=>$anexpdge,                            
                            'anexpHorsDge' => $anexpHorsDge                          
        );
          
                           
         $i++;

        }  
       // $entities = $em->getRepository('EcompetenceBundle:Experience')->findProfileByParametres();
        $form = $this->createForm(new CompetenceRechercheType());     
        $request = $this->getRequest();
        $this->domaine=[];
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $agent=[];$i=0;
                $domain=array();
                $results=array();
                $em = $this->getDoctrine()->getManager();
                $data = $this->getRequest()->request->get('comptence_ecompetencebundle_rechercher');
                $data1 = $request->request->get('competences');
                if($data1)
                {
                foreach($data1 as $tree){
                $domaines=$em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$tree]) ; 
                $domain[]=$domaines;
                $this->domaine[]=$domaines->getId(); 
                }
                $results = $this->tree_recherche_parent($domain);  
                foreach($results as $result)
                {
                      $competence= $em->getRepository('EcompetenceBundle:Domaine')->findOneBy(['id'=>$result]);
                      $this->domaine[]=$competence->getId(); 
                }
                }
                $entities = $em->getRepository('AgentBundle:Agent')->findProfileByParametres($data,$data1);
                if($data1)
                {
                $entit=array();
                $n=0;
                foreach ($entities as $entity)
                { 
                    $comps= $em->getRepository('EcompetenceBundle:Agentcompetence')->findBy(['agent'=>$entity->getId()]);
                    $i=0;
                    $compces=array();
                    foreach ($comps as $comp)
                    {
                       $compces[$i]=strval($comp->getCompetence()->getId());
                       $i++;
                    }   
                   $trouve=false;
                 
                   foreach ($data1 as $donnee)
                   { 
                      if(!in_array($donnee,$compces)) 
                      {
                        $trouve=true;
                      }
                   }
                   
                   if ($trouve==false) 
                   {
                    $entit[$n]= $entity; 
                    $n++;
                   }
                   }
                   $entities=$entit;
               
                   }
           foreach ($entities as $entity)
           { $structure=null;
            //$Agent= $em->getRepository('AgentBundle:Agent')->findOneBy(['id' => $entity->getId()]);
            if($entity && $entity->getdirection())
            {
              $structure=$entity->getDirection()->getSigle();
            }
            //Code grise par Samin
        //    $expdebut = $em->getRepository('EcompetenceBundle:Experience')->findDateMin($entity->getId());
        //    $expfin = $em->getRepository('EcompetenceBundle:Experience')->findDateMax($entity->getId());
         
        //    if(!$expdebut)
        //    {
        //     $anexp=null;  
        //    }
        //    else
        //    {
        //    //$structure=$expfin[0]->getStructure()->getLibStructure(); 
        //    $datedebut=$expdebut[0]->getDateDebExp();
        //    $datefin=$expfin[0]->getDateFinExp();
           
        //    if($datefin==null)
        //    {
        //       $datefin=new \DateTime('now');
        //    }
        //    $interval = $datefin->diff($datedebut);
        //    if($interval->format('%y')=='0'||$interval->format('%y')=='1')
        //    {
        //        $anexp=$interval->format('%y an');
        //    }
        //    else
        //    {
        //     $anexp= $age=$interval->format('%y ans');  
        //    }
        //    }
        //    $anexpdge=null;
        //    $datePdge=$entity->getDatePriseServiceDge();
        //    if($datePdge){
        //    $datefindge=new \DateTime('now');
        //    $interval = $datefindge->diff($datePdge);
           
        //    if($interval->format('%y')=='0'||$interval->format('%y')=='1')
        //    {
        //        $anexpdge=$interval->format('%y an');
        //    }
        //    else
        //    {
        //     $anexpdge=$interval->format('%y ans');  
        //    }
        //    }
           // Fin code grise par Samin
          
// ==========================
// CALCUL EXPERIENCE TOTALE
/*

$experiences = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent' => $entity]);
$totalDays = 0;
foreach ($experiences as $exp) {
    $start = $exp->getDateDebExp();
    $end   = $exp->getDateFinExp() ?: new \DateTime();

    if ($start) {
        $interval = $start->diff($end);
        $totalDays += $interval->days;
    }
}

// Conversion en années et mois
$totalYears = floor($totalDays / 365);
$remainingDays = $totalDays % 365;
$totalMonths = floor($remainingDays / 30);

// Formatage expérience totale
if ($totalYears >= 1) {
    $anexp = ($totalYears == 1) ? '1 an' : $totalYears.' ans';
} else {
    $anexp = ($totalMonths <= 1) ? '1 mois' : $totalMonths.' mois';
}

// ==========================
// CALCUL EXPERIENCE DGE
// ==========================
$anexpdge = '0 mois';
$datePdge = $entity->getDatePriseServiceDge();
if ($datePdge) {
    $now = new \DateTime();
    $intervalDge = $datePdge->diff($now);
    $yearsDge = $intervalDge->y;
    $monthsDge = $intervalDge->m;

    if ($yearsDge >= 1) {
        $anexpdge = ($yearsDge == 1) ? '1 an' : $yearsDge.' ans';
    } else {
        $anexpdge = ($monthsDge <= 1) ? '1 mois' : $monthsDge.' mois';
    }
}

// ==========================
// EXPERIENCE HORS DGE
// ==========================
$yearsHorsDge = max(0, $totalYears - ($yearsDge ?? 0));
$anexpHorsDge = ($yearsHorsDge <= 1) ? '1 an' : $yearsHorsDge.' ans';

*/
// ==========================
$experiences = $em->getRepository('EcompetenceBundle:Experience')->findBy(['agent' => $entity]);

$totalDaysHorsDge = 0;
$totalDaysDge = 0;

$datePdge = $entity->getDatePriseServiceDge();
$now = new \DateTime(); // date "aujourd'hui"

// Parcours des expériences
foreach ($experiences as $exp) {
    $start = $exp->getDateDebExp();
    $end   = $exp->getDateFinExp() ?: $now;

    if (!$start) continue;

    // Cas expérience entièrement après DGE
    if ($datePdge && $start >= $datePdge) {
        $interval = $start->diff($end);
        $totalDaysDge += $interval->days;
    }
    // Cas expérience chevauche DGE
    elseif ($datePdge && $start < $datePdge && $end > $datePdge) {
        // Partie avant DGE
        $intervalHors = $start->diff($datePdge);
        $totalDaysHorsDge += $intervalHors->days;

        // Partie après DGE
        $intervalDge = $datePdge->diff($end);
        $totalDaysDge += $intervalDge->days;
    }
    // Cas expérience entièrement hors DGE
    else {
        $interval = $start->diff($end);
        $totalDaysHorsDge += $interval->days;
    }
}

// ==========================
// EXPÉRIENCE TOTALE (CORRIGÉE)
// ==========================

// Interval DGE
$intervalDge = $datePdge ? $datePdge->diff($now) : null;

// Interval hors DGE
$intervalHors = null;
if ($totalDaysHorsDge > 0) {
    $dateDebutHors = clone $now;
    $dateDebutHors->modify('-' . (int)$totalDaysHorsDge . ' days');
    $intervalHors = $dateDebutHors->diff($now);
}

// Addition des années et mois
$totalYears  = 0;
$totalMonths = 0;

if ($intervalDge) {
    $totalYears  += $intervalDge->y;
    $totalMonths += $intervalDge->m;
}

if ($intervalHors) {
    $totalYears  += $intervalHors->y;
    $totalMonths += $intervalHors->m;
}

// Si les mois dépassent 11, convertir en années
if ($totalMonths >= 12) {
    $totalYears += floor($totalMonths / 12);
    $totalMonths = $totalMonths % 12;
}

// Formatage texte
if ($totalYears >= 1) {
    $anexp = $totalYears . ' an' . ($totalYears > 1 ? 's' : '');
    if ($totalMonths > 0) {
        $anexp .= ' et ' . $totalMonths . ' mois';
    }
} elseif ($totalMonths >= 1) {
    $anexp = $totalMonths . ' mois';
} else {
    $anexp = 'moins d’un mois';
}

// ==========================
// EXPÉRIENCE DGE
// ==========================
$anexpdge = 'Non renseigné';
if ($datePdge) {
    $interval = $datePdge->diff($now);
    $yearsDge  = $interval->y;
    $monthsDge = $interval->m;

    if ($yearsDge >= 1) {
        $anexpdge = $yearsDge . ' an' . ($yearsDge > 1 ? 's' : '');
        if ($monthsDge > 0) {
            $anexpdge .= ' et ' . $monthsDge . ' mois';
        }
    } elseif ($monthsDge >= 1) {
        $anexpdge = $monthsDge . ' mois';
    } else {
        $anexpdge = 'moins d’un mois';
    }
}

// ==========================
// EXPÉRIENCE HORS DGE
// ==========================
$anexpHorsDge = 'moins d’un mois';
if ($totalDaysHorsDge > 0) {
    $dateDebutHors = clone $now;
    $dateDebutHors->modify('-' . (int)$totalDaysHorsDge . ' days');
    $intervalHors = $dateDebutHors->diff($now);

    $yearsHorsDge  = $intervalHors->y;
    $monthsHorsDge = $intervalHors->m;

    if ($yearsHorsDge >= 1) {
        $anexpHorsDge = $yearsHorsDge . ' an' . ($yearsHorsDge > 1 ? 's' : '');
        if ($monthsHorsDge > 0) {
            $anexpHorsDge .= ' et ' . $monthsHorsDge . ' mois';
        }
    } elseif ($monthsHorsDge >= 1) {
        $anexpHorsDge = $monthsHorsDge . ' mois';
    }
}


           $age=null;
           $datenais=$entity->getDateNaiss();
           if($datenais){
           $datejour=new \DateTime('now');
           $interval = $datejour->diff($datenais);
           
           if($interval->format('%y')=='0'||$interval->format('%y')=='1')
           {
               $age=$interval->format('%y an');
           }
           else
           {
            $age=$interval->format('%y ans');  
           }
           }
          
              
            $agent[$i]=array('id'=>$entity->getId(),
                            'matricule'=>$entity->getMatricule(),
                            'nom'=>$entity->getNom(),
                            'prenoms'=>$entity->getPrenoms(),
                            'situationMatri'=>$entity->getSituationMatri(),
                            'NomJeuneFille'=>$entity->getNomJeuneFille(),
                            'age'=>$age,
                            'anexp'=>$anexp,
                            'employeur'=>$structure,
                            'emploi'=>$entity->getEmploi()->getLibEmpl(),
                            'sousdirection'=>$entity->getCodeSd(),
                            'service'=>$entity->getCodeSc(),
                            'poste'=>$entity->getFonction()->getLibFonc(),
                            'anexpdge'=>$anexpdge,
                            'anexpHorsDge' => $anexpHorsDge   // expérience hors DGE

                       
                            
            );
        
                           
               $i++;
            }
      
           
               $competences= $em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>null],['libDomaine'=>'asc']);
                return $this->render('EcompetenceBundle:Agent:rechercheprofil.html.twig', array(
                            'entities' => $entities,'agents'=>$agent,'competences'=>$competences,
                            'form' => $form->createView(),
                            'name' => $this->domaine,
                        ));
         }  
        }
       
        $competences= $em->getRepository('EcompetenceBundle:Domaine')->findBy(['parent'=>null],['libDomaine'=>'asc']);
        return $this->render('EcompetenceBundle:Agent:rechercheprofil.html.twig', array(
                    'entities' => $entities,'competences'=>$competences,'agents'=>$agent,
                    'form' => $form->createView(),
                    'name' =>$this->domaine,
        ));
    
}

public function competenceapiAction(Request $request)
{
    $cmp=array();
    $response = new JsonResponse();
    if( $request->request->get('champ')=="")
    {
       $cmp=[]; 
    }
    else
    { $cmp=explode(',',$request->request->get('champ'));
    }
   
    $em = $this->getDoctrine()->getManager();
    $domaines=$em->getRepository('EcompetenceBundle:Domaine')->Listedomaine();
    $tab = array();
    $i= 0;
    foreach ($domaines as $key => $domaine) {
         if($domaine->getParent())
         {
         $parent=$domaine->getParent()->getId();
                 
         }
         else
         {
         $parent=Null;    
         }
         if(in_array($domaine->getId(),$cmp))
         {
          $checked=true;   
         }
         else
         {
          $checked=false;
         }
        $tab[$key] = array('id' => $domaine->getId(),
                         'parent_id' =>$parent,
                         'label' => $domaine->getLibDomaine(),
                         'value' => $domaine->getId(),
                         'checked'=>$checked
                )
                         ;
        
    }
    //dump($tab); die;
    
  $result = $this->buildTree($tab);
  
  
  // dump(json_encode($result)); die;
  
 // $response->setData($result);
 
  
  return $response->setData(json_encode($result)); 
}
}

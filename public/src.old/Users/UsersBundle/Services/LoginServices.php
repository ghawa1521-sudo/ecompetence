<?php

namespace Users\UsersBundle\Services;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\redirectToRoute;
/**
 *  
 */
class LoginServices extends Controller {

    protected $em;
    protected $request;
    private $securityContext;

    public function __construct(EntityManager $entityManager, $request, SecurityContext $securityContext /* SecurityContext $securityContext */) {
        $this->em = $entityManager;
       
        $this->request = $request;
        $this->securityContext = $securityContext;
        #$this->securityContext = $securityContext;
        #$this->mailer = $mailer;
        #$this->templating = $templating;
    }

   public function getEm(){
        return $this->em;
    }
   
    public function getRequest(){
        return $this->request;
    }
/*public function doRedirect($url=null){
        return $this->redirectToRoute($url);
    }*/

    //For tracking USer
    public function resetTentative($userid) {
        $em = $this->em;
        $user = $em->getRepository('TrackingBundle:UserActivities')->findOneBy(array('userid' => $userid));
        $user->setTentative(0);
        $em->persist($user);
        $em->flush();
    }

    public function countTentative($username) {
        $em = $this->em;
        $userReal = $em->getRepository('UsersBundle:utilisateur')->findOneBy(array('username' => $username));
        if ($userReal) {
            $user = $em->getRepository('TrackingBundle:UserActivities')->findOneBy(array('userid' => $userReal->getId()));
            if ($user) {
                if ((strcmp($cip['ip'], "::1") != 0) && (strcmp($cip['ip'], "127.0.0.1") != 0)) {
                    $user->setTentative((int) ($user->getTentative() + 1));
                    //Nombre de tentative autorisées
                    if ($user->getTentative() >= 3) {
                        $userReal->setLocked(1);
                        $session = new Session();
                        $user->setUnlockedSession($session->getId());
                        $message = \Swift_Message::newInstance()
                                ->setSubject('Controle de Sécurité Plateforme GPP | Compte Bloqué')
                                ->setFrom('pgpadmin@perequaci.com')
                                ->setTo($userReal->getEmail())
                                ->setBody(
                                $this->templating->render(
                                        '@Tracking/Default/locked.html.twig', array('cip' => $this->checkIp(), 'user' => $userReal, 'heure' => $userReal->getLastLogin(), 'tokenmail' => $session->getId())
                                ), 'text/html'
                                )
                        ;
                        $mailer = $this->mailer;


                        $mailer->send($message);
                    }
                }
            } else {
                $this->controlLocation($this->checkIp());
            }
            $em->persist($user);
            //$em->persist($userReal);
            $em->flush();
        }
    }

    //Get IP adress and browser and Computer details
    public function controlLocation($cip) {
        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $em = $this->em;
            $user = $this->securityContext->getToken()->getUser();
            $userid = $user->getId(); //Récupération du ID de l'utilisateur connecté
            $UserAct = $em->getRepository('TrackingBundle:UserActivities')->findOneBy(array('userid' => $userid));
            if ($UserAct) {

                //Ecriture de la fonction de controle des historique des lieu de connexion
                //controle sur le Browsers
                $Tpays = explode("|", $UserAct->getPays());
                if (in_array($cip['pays'], $Tpays)) {
                    $state['pays'] = 1;
                } else {
                    $state['pays'] = 0;
                    $Tpaysno = explode("|", $UserAct->getPaysno()); //Ajout dans la liste non vérifié
                    if (!in_array($cip['pays'], $Tpaysno)) {
                        $UserAct->setPaysno($UserAct->getPaysno() . "|" . $cip['pays']);
                    }
                }
                //Controle sur la Ville
                $Tville = explode("|", $UserAct->getville());
                if (in_array($cip['ville'], $Tville)) {
                    $state['ville'] = 1;
                } else {
                    $state['ville'] = 0;
                    $Tvilleno = explode("|", $UserAct->getvilleno()); //Ajout dans la liste non vérifié
                    if (!in_array($cip['ville'], $Tvilleno)) {
                        $UserAct->setVilleno($UserAct->getVilleno() . "|" . $cip['ville']);
                    }
                }
                //Controle sur le Browsers
                $Tbrowsers = explode("|", $UserAct->getBrowsers());
                if (in_array($cip['browsers'], $Tbrowsers)) {
                    $state['browsers'] = 1;
                } else {
                    $state['browsers'] = 0;
                    $Tbrowsersno = explode("|", $UserAct->getBrowsersno()); //Ajout dans la liste non vérifié
                    if (!in_array($cip['browsers'], $Tbrowsersno)) {
                        $UserAct->setBrowsersno($UserAct->getBrowsersno() . "|" . $cip['browsers']);
                    }
                }
                //Controle sur la Platform
                $Tplatforms = explode("|", $UserAct->getPlatform());
                if (in_array($cip['platform'], $Tplatforms)) {
                    $state['platform'] = 1;
                } else {
                    $state['platform'] = 0;
                    $Tplatformsno = explode("|", $UserAct->getPlatformno()); //Ajout dans la liste non vérifié
                    if (!in_array($cip['platform'], $Tplatformsno)) {
                        $UserAct->setPlatformno($UserAct->getPlatformno() . "|" . $cip['platform']);
                    }
                }
            } else {
                $UserAct = new UserActivities();
                $UserAct->setBrowsers($cip['browsers'] . "|");
                $UserAct->setPays($cip['pays'] . "|");
                $UserAct->setVille($cip['ville'] . "|");
                $UserAct->setPlatform($cip['platform'] . "|");
                $UserAct->setUserid($userid);
                ($state['ville'] = 1);
                ($state['browsers'] = 1);
                ($state['pays'] = 1);
                ($state['platform'] = 1);
            }




            if (($state['ville'] == 0) || ($state['browsers'] == 0) || ($state['pays'] == 0) || ($state['platform'] == 0)) {

                if ((strcmp($cip['ip'], "::1") != 0) && (strcmp($cip['ip'], "127.0.0.1") != 0)) {

                    $session = new Session();
                    $Ttoken = explode("|", $UserAct->getTokenmail()); //Ajout dans la liste non vérifié
                    if (!in_array($session->getId(), $Ttoken)) {
                        $UserAct->setTokenmail($UserAct->getTokenmail() . "|" . $session->getId());
                    }
                    $message = \Swift_Message::newInstance()
                            ->setSubject('Controle de Sécurité Plateforme GPP')
                            ->setFrom('pgpadmin@perequaci.com')
                            ->setTo($user->getEmail())
                            ->setBody(
                            $this->templating->render(
                                    '@Tracking/Default/index.html.twig', array('cip' => $cip, 'user' => $user, 'heure' => $user->getLastLogin(), 'tokenmail' => $session->getId())
                            ), 'text/html'
                            )
                    ;
                    $mailer = $this->mailer;

                    $mailer->send($message);
                }
            }

            $em->persist($UserAct);

            $em->flush($UserAct);
        }
    }

    public function checkIp() {
        $em = $this->em;
        $ip = $this->request->getCurrentRequest()->getClientIp();
        /* Vérification de l'adresse IP */
        $Connected = $em->getRepository('TrackingBundle:Connected')->findOneBy(array('ip' => $ip));
        if ($Connected) {
            $Connected->setDate(new \DateTime());
        } else {
            $Connected = new Connected();
            $Connected->setIp($ip);
        }
        //Identified User Agent and update this
        $uagent = $this->parse_user_agent();
        /*
          if ($ip = "127.0.0.1") {
          $ip = "41.189.44.65";
          } */
        //GEt Ip Adress Details
        $ipData = $this->getIpDetails($ip);

        $Connected->setBrowser($uagent['browser']);
        $Connected->setPlatform($uagent['platform']);
        $Connected->setBrowserVersion($uagent['version']);
        $Connected->setPays($ipData['pays']);
        $Connected->setVille($ipData['ville']);


        //
        $em->persist($Connected);


        //Chedie;ck Ip Adress
        //$cip = $this->connected->checkIp();
        $cip['browsers'] = $uagent['browser'] . " " . $uagent['version'];
        $cip['pays'] = $ipData['pays'];
        $cip['ville'] = $ipData['ville'];
        $cip['platform'] = $uagent['platform'];
        $cip['ip'] = $ip;


        /* Services to get User */


        //die;
        $em->flush($Connected);
        return $cip;
    }

    public function countIp() {
        $CountIp = count($this->em->getRepository('TrackingBundle:Connected')->findAll());
        return (int) $CountIp;
    }

    Public function getIpDetails($ip) {
        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));

        if ($ip_data && $ip_data->geoplugin_countryName != null) {

            $result['pays'] = $ip_data->geoplugin_countryName;

            $result['ville'] = $ip_data->geoplugin_city;
        }
        return $result;
    }

    public function parse_user_agent($u_agent = null) {
        if (is_null($u_agent)) {
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $u_agent = $_SERVER['HTTP_USER_AGENT'];
            } else {
                throw new \InvalidArgumentException('parse_user_agent requires a user agent');
            }
        }

        $platform = null;
        $browser = null;
        $version = null;

        $empty = array('platform' => $platform, 'browser' => $browser, 'version' => $version);

        if (!$u_agent)
            return $empty;

        if (preg_match('/\((.*?)\)/im', $u_agent, $parent_matches)) {
            preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS)|Xbox(\ One)?)
				(?:\ [^;]*)?
				(?:;|$)/imx', $parent_matches[1], $result, PREG_PATTERN_ORDER);

            $priority = array('Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'CrOS', 'X11');

            $result['platform'] = array_unique($result['platform']);
            if (count($result['platform']) > 1) {
                if ($keys = array_intersect($priority, $result['platform'])) {
                    $platform = reset($keys);
                } else {
                    $platform = $result['platform'][0];
                }
            } elseif (isset($result['platform'][0])) {
                $platform = $result['platform'][0];
            }
        }

        if ($platform == 'linux-gnu' || $platform == 'X11') {
            $platform = 'Linux';
        } elseif ($platform == 'CrOS') {
            $platform = 'Chrome OS';
        }

        preg_match_all('%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|Safari|MSIE|Trident|AppleWebKit|TizenBrowser|Chrome|
				Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|CriOS|UCBrowser|
				Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
				Valve\ Steam\ Tenfoot|
				NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
				(?:\)?;?)
				(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix', $u_agent, $result, PREG_PATTERN_ORDER);

        // If nothing matched, return null (to avoid undefined index errors)
        if (!isset($result['browser'][0]) || !isset($result['version'][0])) {
            if (preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result)) {
                return array('platform' => $platform ? : null, 'browser' => $result['browser'], 'version' => isset($result['version']) ? $result['version'] ? : null : null);
            }

            return $empty;
        }

        if (preg_match('/rv:(?P<version>[0-9A-Z.]+)/si', $u_agent, $rv_result)) {
            $rv_result = $rv_result['version'];
        }

        $browser = $result['browser'][0];
        $version = $result['version'][0];

        $lowerBrowser = array_map('strtolower', $result['browser']);

        $find = function ( $search, &$key, &$value = null ) use ( $lowerBrowser ) {
            $search = (array) $search;

            foreach ($search as $val) {
                $xkey = array_search(strtolower($val), $lowerBrowser);
                if ($xkey !== false) {
                    $value = $val;
                    $key = $xkey;

                    return true;
                }
            }

            return false;
        };

        $key = 0;
        $val = '';
        if ($browser == 'Iceweasel') {
            $browser = 'Firefox';
        } elseif ($find('Playstation Vita', $key)) {
            $platform = 'PlayStation Vita';
            $browser = 'Browser';
        } elseif ($find(array('Kindle Fire', 'Silk'), $key, $val)) {
            $browser = $val == 'Silk' ? 'Silk' : 'Kindle';
            $platform = 'Kindle Fire';
            if (!($version = $result['version'][$key]) || !is_numeric($version[0])) {
                $version = $result['version'][array_search('Version', $result['browser'])];
            }
        } elseif ($find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS') {
            $browser = 'NintendoBrowser';
            $version = $result['version'][$key];
        } elseif ($find('Kindle', $key, $platform)) {
            $browser = $result['browser'][$key];
            $version = $result['version'][$key];
        } elseif ($find('OPR', $key)) {
            $browser = 'Opera Next';
            $version = $result['version'][$key];
        } elseif ($find('Opera', $key, $browser)) {
            $find('Version', $key);
            $version = $result['version'][$key];
        } elseif ($find(array('IEMobile', 'Edge', 'Midori', 'Vivaldi', 'Valve Steam Tenfoot', 'Chrome'), $key, $browser)) {
            $version = $result['version'][$key];
        } elseif ($browser == 'MSIE' || ($rv_result && $find('Trident', $key))) {
            $browser = 'MSIE';
            $version = $rv_result ? : $result['version'][$key];
        } elseif ($find('UCBrowser', $key)) {
            $browser = 'UC Browser';
            $version = $result['version'][$key];
        } elseif ($find('CriOS', $key)) {
            $browser = 'Chrome';
            $version = $result['version'][$key];
        } elseif ($browser == 'AppleWebKit') {
            if ($platform == 'Android' && !($key = 0)) {
                $browser = 'Android Browser';
            } elseif (strpos($platform, 'BB') === 0) {
                $browser = 'BlackBerry Browser';
                $platform = 'BlackBerry';
            } elseif ($platform == 'BlackBerry' || $platform == 'PlayBook') {
                $browser = 'BlackBerry Browser';
            } else {
                $find('Safari', $key, $browser) || $find('TizenBrowser', $key, $browser);
            }

            $find('Version', $key);
            $version = $result['version'][$key];
        } elseif ($pKey = preg_grep('/playstation \d/i', array_map('strtolower', $result['browser']))) {
            $pKey = reset($pKey);

            $platform = 'PlayStation ' . preg_replace('/[^\d]/i', '', $pKey);
            $browser = 'NetFront';
        }

        return array('platform' => $platform ? : null, 'browser' => $browser ? : null, 'version' => $version ? : null);
    }

}

<?php
namespace Agent\AgentBundle\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 *  
 */
 class Mailer extends Controller
 {
 	private $mailer;
 	private $templating;
 	private $subject;
 	private $body;
 	private $from;
 	private $to;
 	private $url;

 	public function __construct($mailer , EngineInterface $templating)
 	{

 		$this->mailer=$mailer;
 		$this->templating=$templating;
//dump($this->mailer);
//dump($this->templating);//die;
 		//$this->router=$router;
 	}
 	//var_dump($user); die;
 	public function agentConfirm($user=null, $password, $param=null)
 	{
                
 		//$url = $this->generateUrl('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
 		//dump($user->getEmail()); die;
		$this->subject=sprintf('Bienvenu(e) %s', $user->getAgent()->getNom());
		$this->from=array('personnel.dge@gmail.com'=>'DGE-SRHMG');
		$this->to=$user->getAgent()->getEmail();
		//$user->getAgent()->getEmail();
		//dump($user);
		//dump($param);
		switch ($param) {
			////////////////modification compte utilisateur////////////
			case 1:
					//dump("ici");
				$this->doTemplate('AgentBundle:Mail:agentDelete.html.twig', array(
				'user' => $user->getAgent(),
				'password' => $password,
			));
				# code...

				break;
				////////////Creation compte nouvel utilisateur//////////////
			case 2:
					//dump("ici");
				$this->doTemplate('AgentBundle:Mail:agentConfirm.html.twig', array(
				'user' => $user->getAgent(),
				'password' => $password,
			));
				# code...

				break;
			default:
				# code...
				$this->doTemplate('AgentBundle:Mail:agentConfirm.html.twig', array(
				'user' => $user->getAgent(),
				'password' => $password,
				));
				break;
		}
		

 		$send=$this->send();
 		//dump($send); 
 		//die;
		
 		//die;
 	}

 	private function doTemplate($template, array $options)
 	{
 		$this->body= $this->templating->render($template, $options);
 	}

 	public function send()
 	{
 		
 		$message= \Swift_Message::newInstance()
 			->setSubject($this->subject)
 			->setFrom($this->from)
 			->setTo($this->to)
 			->setBody($this->body, 'text/html')
 		;
 		//dump($this->mailer);
 		$this->mailer->send($message);

 	}
 } 
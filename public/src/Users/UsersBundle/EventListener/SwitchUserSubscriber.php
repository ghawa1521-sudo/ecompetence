<?php

namespace Users\UsersBundle\EventListener;

use Users\UsersBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Role\SwitchUserRole;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Core\User\UserInterface;

class SwitchUserSubscriber implements EventSubscriberInterface
/**
 * Description of SwitchUserSubscriber
 *
 * @author Curtis DOGBO
 */ {

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    protected $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManager $entityManager) {
        $this->tokenStorage = $tokenStorage;
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents() {

        return [
            SecurityEvents::SWITCH_USER => [
                ['checkSwitchAuthorisation', 0],
            ],
        ];
    }

    public function checkSwitchAuthorisation(SwitchUserEvent $switchEvent) {
        $em = $this->em;
        //Le responsable ou interime
        $responsable = $switchEvent->getTargetUser();

        //Utilisateur Connecté devant être l'interimaire
        $interimairee = $this->tokenStorage->getToken()->getUser();


        //Fonction vérifiant si l'utilisateur à le droit ou pas d'effectuer un interim
        $interimaire = $em->getRepository('AgentBundle:Interimaire')->controle_etatinterim($interimairee->getAgent()->getId(), $responsable->getAgent()->getId());
        if (!$interimaire && $switchEvent->getRequest()->query->get('_interim_user') != "_exit") {
            throw new AccessDeniedException("Accès refusé");
        }
        //die;
    }

    /**
     * Fonction vérifiant si l'utilisateur à le droit ou pas d'effectuer un interim
     *
     * @param UserInterface $user
     * @return bool
     */
    protected function isCurrentUserAllowedToSwitchTo(UserInterface $user) {
        $em = $this->em;
        $impersonator = $this->getImpersonatingUser();
        $impersonatingUser = $this->tokenStorage->getToken()->getUser();
        $impersonatedUser = $user;
        // If a user is impersonating, check if we want to switch back, in that case
        // $user will be the same as the user doing the impersonating.
        if ($impersonator && $impersonator->getId() == $user->getId()) {
            $impersonatedUser = $this->tokenStorage->getToken()->getUser();
            $impersonatingUser = $user;
        }


        //Contrôle de silué à placer sur l'interim doit retourner True or False

        return true;
        return $impersonatingUser->manages($impersonatedUser);
    }

    /**
     * Retrieves the User that is doing the impersonating by checking the roles in the current token.
     *
     * @return User
     */
    protected function getImpersonatingUser() {
        foreach ($this->tokenStorage->getToken()->getRoles() as $role) {
            if ($role instanceof SwitchUserRole) {
                return $role->getSource()->getUser();
            }
        }
        return null;
    }

    public function geToken() {
        return $this->tokenStorage->getToken()->getRoles();
    }

}

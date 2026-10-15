<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Users\UsersBundle\Controller;

use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the password change
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ChangePasswordController extends Controller {

    /**
     * Change user password
     *
     * @param Request $request
     *
     * @return Response
     */
    public function changePasswordAction(Request $request) {
        //dump("ok"); die();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        // dump($user->getPassword());
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        // var_dump($form->get('current_password')->getData());
        // var_dump($form->get('plainPassword')->getData());
        //var_dump(hash('sha512', "R0001"));
        //die;
        $plainPassword = $form["plainPassword"]->getData();
        // $currentPasswordForValidation = 'R0002';
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        //$encodedPassword = $encoder->encodePassword($currentPasswordForValidation, $user->getSalt());
        // var_dump($plainPassword);

        if ($form->isValid()) {
            //die;
            //var_dump("ok");
            /** @var $userManager UserManagerInterface */
            $verif = $encoder->isPasswordValid($user->getPassword(), $plainPassword, $user->getSalt());
            //dump($verif);
            if ($verif == false) {

                // var_dump("false");
                $userManager = $this->get('fos_user.user_manager');
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $event);
                $user->setEtatConnexion(1);
                $userManager->updateUser($user);


                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('agent_homepage');
                    $this->addFlash('notice', 'Votre mot de passe a été modifié avec Succès');
                    $response = new RedirectResponse($url);
                    $dispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, new FilterUserResponseEvent(
                            $user, $request, $response));
                    return $response;
                }
            } else {
                //dump("yes"); die;
                $this->addFlash('error', 'le mot de passe que vous tentez d\'utiliser est identifque au précédent');
            }
        }
        return $this->render('FOSUserBundle:ChangePassword:change_password.html.twig', array(
                    'form' => $form->createView()
        ));
    }

}

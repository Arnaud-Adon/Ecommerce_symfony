<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Listener;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;


/**
 * Description of RedirectionListener
 *
 * @author Arnaud
 */
class RedirectionListener {

    public function __construct(ContainerInterface $container, Session $session) {
        $this->router = $container->get('router');
        $this->session = $session;
        $this->securityContext = $container->get('security.authorization_checker');
    }

    public function onKernelRequest(GetResponseEvent $event) {
        $route = $event->getRequest()->attributes->get('route');
        

        if ($route == 'livraison' || $route == 'validation') {
            if ($this->session->has('panier')) {
                if (count($this->session->get('panier')) == 0) {
                    $event->setResponse(new RedirectResponse($this->router->generate('panier')));
                }
            }

            if ($this->securityContext->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')) {
                $this->session->getFlashBag()->add('notification', 'Vous devez vous identifier');
                $event->setResponse(new RedirectResponse($this->router->generate('fos_user_security_login')));
            }
        }
        //var_dump($route);
    }

}

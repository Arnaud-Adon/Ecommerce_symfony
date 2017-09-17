<?php

namespace Utilisateurs\UtilisateursBundle\Controller;

use Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Utilisateursadress controller.
 *
 */
class UtilisateursAdressesAdminController extends Controller
{

    /**
     * Finds and displays a utilisateursAdress entity.
     *
     */
    public function showAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('UtilisateursBundle:Utilisateurs')->find($id); 
        //var_dump($this->get('request'));
        $route = $this->get('request')->get('_route');
        if ( $route === 'adminUtilisateursAdresses_show'){
            return $this->render('UtilisateursBundle:Admin:utilisateursadresses/layout/index.html.twig', array('utilisateur' => $utilisateur));
        }
        elseif ($route === 'adminUtilisateursFactures_show') {
             return $this->render('UtilisateursBundle:Admin:utilisateursfactures/layout/index.html.twig', array('utilisateur' => $utilisateur));
        }
        else{
            throw $this->createNotFoundException('La page n\' a pas été trouvée');
        }    
    }

}

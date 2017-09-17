<?php

namespace Utilisateurs\UtilisateursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UtilisateursAdminController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $utilisateurs = $em->getRepository('UtilisateursBundle:Utilisateurs')->findAll();

        return $this->render('UtilisateursBundle:Admin:utilisateurs/layout/index.html.twig', array('utilisateurs' => $utilisateurs));
    }

    public function showAction($id) {
         $em = $this->getDoctrine()->getManager();
         $utilisateur = $em->getRepository('UtilisateursBundle:Utilisateurs')->find($id);
         
         return $this->render('UtilisateursBundle:Admin:utilisateurs/layout/show.html.twig', array('utilisateur' => $utilisateur));
    }

}

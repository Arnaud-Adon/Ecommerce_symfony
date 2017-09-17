<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Services;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of GetFacture
 *
 * @author Arnaud
 */
class GetFacture {
     public function __construct(ContainerInterface $container) {
        $this->container=$container;
        
    }
    
    public function facture($facture){
                
        $template=$this->container->get('templating')->render('UtilisateursBundle:Default:layout/pdf.html.twig',array('facture' => $facture));
        
        $html2pdf=$this->container->get('ecommerce.html2pdf');
        
        $html2pdf->create('P','A4','fr',true, 'UTF-8', array(10,15,10,15));
        
       return $html2pdf->generatePdf($template,'facture-'.$facture->getUtilisateur()->getUsername().'-'.$facture->getReference());
           
    }
}

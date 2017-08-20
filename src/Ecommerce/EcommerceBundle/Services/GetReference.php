<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Services;


use Symfony\Component\Security\Core\SecurityContextInterface;


/**
 * Description of GetReference
 * 
 * permet d'attribuer une référence à une commande 
 * en paramettre les service demander dans le service yml
 *
 * @author Arnaud
 */
class GetReference {

    public function __construct(SecurityContextInterface $securityContext,$entityManager) {
        $this->securityContext=$securityContext;
        $this->em = $entityManager;
    }
    
    public function reference(){
        $reference = $this->em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('valider' => 1) , array('id'=>'DESC'),1,1);
        
        if(!$reference){
            return 1;
        }           
        else{ return $reference->getReference()+1;}
           
    }

    

}

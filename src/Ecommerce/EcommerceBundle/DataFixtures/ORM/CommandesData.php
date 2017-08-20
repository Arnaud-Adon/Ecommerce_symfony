<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ecommerce\EcommerceBundle\Entity\Commandes;

/**
 * Description of CommandesData
 *
 * @author Arnaud
 */
class CommandesData extends AbstractFixture implements OrderedFixtureInterface {
    public function load(ObjectManager $manager){
        $commande1= new Commandes();
        $commande1->setUtilisateur($this->getReference('utilisateur1'));      
        $commande1->setReference('1');
        $commande1->setDate(new \DateTime());
        $commande1->setValider('1');
        $commande1->setProduits(array( '0' => array('1'=>'2'),
                                       '1' => array('2' => '4'),
                                       '2' => array('5' => '7')
            ));    
        $manager->persist($commande1);
        
        $commande2= new Commandes();
        $commande2->setUtilisateur($this->getReference('utilisateur3'));      
        $commande2->setReference('2');
        $commande2->setDate(new \DateTime());
        $commande2->setValider('1');
        $commande2->setProduits(array( '0' => array('10'=>'2'),
                                       '1' => array('3' => '4'),
                                       '2' => array('6' => '7')
            ));    
        $manager->persist($commande2);
        
        $manager->flush();
    }
    
    public function getOrder() {
        return 7;
    }
}

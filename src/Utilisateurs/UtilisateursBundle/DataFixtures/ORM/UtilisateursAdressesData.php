<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Utilisateurs\UtilisateursBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses;

/**
 * Description of UtilisateursAdressesData
 *
 * @author Arnaud
 */
class UtilisateursAdressesData extends AbstractFixture implements OrderedFixtureInterface {
    
    public function load(ObjectManager $manager){
        $adresses1= new UtilisateursAdresses();
        $adresses1->setUtilisateur($this->getReference('utilisateur1'));
        $adresses1->setNom('Adon');
        $adresses1->setPrenom('Arnaud');
        $adresses1->setAdresse('4 rue du chemin');
        $adresses1->setComplement('hall 12');
        $adresses1->setVille('Paris');
        $adresses1->setCp('75017');
        $adresses1->setPays('France');
        $adresses1->setTelephone('0145264589');
        $manager->persist($adresses1);
        
        $adresses2= new UtilisateursAdresses();
        $adresses2->setUtilisateur($this->getReference('utilisateur2'));
        $adresses2->setNom('Sylvain');
        $adresses2->setPrenom('Bobois');
        $adresses2->setAdresse('12 rue Rolli');
        $adresses2->setComplement('hall 6');
        $adresses2->setVille('Creteil');
        $adresses2->setCp('96000');
        $adresses2->setPays('France');
        $adresses2->setTelephone('0144986932');
        $manager->persist($adresses2);
        
        $manager->flush();
        
    }
    
    public function getOrder(){
        return 6;
    }
        
}

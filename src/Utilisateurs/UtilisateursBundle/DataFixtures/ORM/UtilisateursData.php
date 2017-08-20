<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Utilisateurs\UtilisateursBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Utilisateurs\UtilisateursBundle\Entity\Utilisateurs;

/**
 * Description of UtilisateursData
 *
 * @author Arnaud
 */
class UtilisateursData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface {
    
    private $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        
        
        $utilisateur1= new Utilisateurs();
        $utilisateur1->setUsername('arnaud');
        $utilisateur1->setEmail('assy@yahoo.fr');
        $utilisateur1->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('arnaud', $utilisateur1->getSalt()));
        $manager->persist($utilisateur1);
        
        $utilisateur2= new Utilisateurs();
        $utilisateur2->setUsername('thierry');
        $utilisateur2->setEmail('tierry@gmail.fr');
        $utilisateur2->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('thierry', $utilisateur1->getSalt()));
        $manager->persist($utilisateur2);
        
        $utilisateur3= new Utilisateurs();
        $utilisateur3->setUsername('romuald');
        $utilisateur3->setEmail('romuald@yahoo.fr');
        $utilisateur3->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('romuald', $utilisateur1->getSalt()));
        $manager->persist($utilisateur3);
        
        $utilisateur4= new Utilisateurs();
        $utilisateur4->setUsername('eugénie');
        $utilisateur4->setEmail('eugenie@yahoo.fr');
        $utilisateur4->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('eugenie', $utilisateur1->getSalt()));
        $manager->persist($utilisateur4);
        
        $utilisateur5= new Utilisateurs();
        $utilisateur5->setUsername('pauline');
        $utilisateur5->setEmail('pauline@yahoo.fr');
        $utilisateur5->setPassword($this->container->get('security.encoder_factory')->getEncoder($utilisateur1)->encodePassword('pauline', $utilisateur1->getSalt()));
        $manager->persist($utilisateur5);
        
        $manager->flush();
        
        $this->addReference('utilisateur1', $utilisateur1);
        $this->addReference('utilisateur2', $utilisateur2);
        $this->addReference('utilisateur3', $utilisateur3);    
        $this->addReference('utilisateur4', $utilisateur4);     
        $this->addReference('utilisateur5', $utilisateur5);
       
        
    }
    
    public function getOrder() {
        return 5;
    }
}

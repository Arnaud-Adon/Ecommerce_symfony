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
use Ecommerce\EcommerceBundle\Entity\Categories;

/**
 * Description of CategoriesData
 *
 * @author Arnaud
 */
class CategoriesData extends AbstractFixture implements OrderedFixtureInterface {
   public function load(ObjectManager $manager){
       $categorie1= new Categories();
       $categorie1->setNom('Légumes');
       $categorie1->setImage($this->getReference('media1'));
       $manager->persist($categorie1);
       
       $categorie2= new Categories();
       $categorie2->setNom('fruits');
       $categorie2->setImage($this->getReference('media3'));
       $manager->persist($categorie2);
       
       
       $manager->flush();
       
       $this->addReference('categorie1',$categorie1);
       $this->addReference('categorie2',$categorie2);
   }
   
    public function getOrder(){
        return 2;
    }
}

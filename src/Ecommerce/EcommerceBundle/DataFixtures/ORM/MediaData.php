<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Ecommerce\EcommerceBundle\Entity\Media;

/**
 * Description of MediaData
 *
 * @author Arnaud
 */
class MediaData extends AbstractFixture implements OrderedFixtureInterface  {
    public function load(ObjectManager $manager)
    {
        $media1 = new Media();
        $media1->setPath('https://31.media.tumblr.com/bc596e24a60ade006463361671f4edc3/tumblr_inline_n668q8178k1qzz7zz.jpg');
        $media1->setAlt('Légumes');
        $manager->persist($media1);
        
        $media2 = new Media();
        $media2->setPath('http://psycho2rue.fr/wp-content/uploads/2015/01/fruit_selection_155265101_web-300x179.jpg');
        $media2->setAlt('Fruits');       
        $manager->persist($media2);
        
        $media3 = new Media();
        $media3->setPath('http://stickeramoi.com/7055-7774-thickbox/sticker-mural-poivron-rouge.jpg');
        $media3->setAlt('Poivron rouge');       
        $manager->persist($media3);
        
        $media4 = new Media();
        $media4->setPath('http://www.santelog.com/uploaded3/images/Actus%2021/Fotolia_22413024_XS.jpg');
        $media4->setAlt('Piment');       
        $manager->persist($media4);
        
        $media5 = new Media();
        $media5->setPath('https://elefectorayleigh.files.wordpress.com/2012/07/juicy-tomato-0509-lg-75860228.jpg');
        $media5->setAlt('Tomate');       
        $manager->persist($media5);
        
        $media6 = new Media();
        $media6->setPath('http://www.unexport.es/sites/default/files/imagenes_de_producto/pimiento_verde.jpg');
        $media6->setAlt('Poivron vert');       
        $manager->persist($media6);
        
        $media7 = new Media();
        $media7->setPath('https://www.grandfrais.com/userfiles/image/produit/raisin-red-globe.png');
        $media7->setAlt('Raisin');       
        $manager->persist($media7);
        
        $media8 = new Media();
        $media8->setPath('http://4.bp.blogspot.com/-XuqTIy5dQqY/T7CXJLOkdxI/AAAAAAAAAKk/rr_ITfrEeu8/s1600/orange.jpg');
        $media8->setAlt('Orange');       
        $manager->persist($media8);
        
        
        $manager->flush();
        
        $this->addReference('media1',$media1);
        $this->addReference('media2',$media2);
        $this->addReference('media3',$media3);
        $this->addReference('media4',$media4);
        $this->addReference('media5',$media5);
        $this->addReference('media6',$media6);
        $this->addReference('media7',$media7);
        $this->addReference('media8',$media8);
        
    }
    
    public function getOrder(){
        return 1;
    }
}

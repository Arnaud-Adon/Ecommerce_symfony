<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Produits;
use Ecommerce\EcommerceBundle\Form\ProduitsType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;


/**
 * Description of TestController
 *
 * @author Arnaud
 */
class TestController extends Controller {
    
    public function testFormAction(){
        
        $form = $this->createForm(new ProduitsType());
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            //die('Je traite mon formulaire ici');
            $form->bind($request);
            echo $form['description']->getData();
            
            /*if($form->isValid()){
                $em=$this->getDoctrine()->getManager();
                $em->persist($form);
                $em->flush();
            }*/
        }
        
        return $this->render('EcommerceBundle:Default:test.html.twig', array('form' => $form->createView()));
    }    
        
    
        
        public function updateFormAction(){
            $produit= new Produits();
            $form =  $this->createFormBuilder($produit);
            
            
            $form
                    ->add('nom', TextType::class)
                    ->add('description', TextType::class)
                    ->add('date', DateType::class)
                    ->add('Sauvegarder', SubmitType::class)
                    ->getForm();
                    
            return $this->render('EcommerceBundle:Default:test.html.twig', array('form' => $form->createView()));
                    
        }
    
    
    /*public function ajouterAction()
    {
        $em = $this->getDoctrine()->getManager();
     
    
        $produit = new Produits();
        
        $produit->setCategorie('Legume');
        $produit->setDescription('La tomate ce mange');
        $produit->setDisponible('1');
        $produit->setPrix('0.99');
        $produit->setImage('http://lorempixel.com/200/200/fruit');
        $produit->setNom('Tomate');
        $produit->setTva('19.6');
        
        $em->persist($produit);
        
        $produit2 = new Produits();
        
        $produit2->setCategorie('Fruit');
        $produit2->setDescription('L\'abricot ce mange');
        $produit2->setDisponible('1');
        $produit2->setPrix('0.75');
        $produit2->setImage('http://lorempixel.com/200/200/fruit');
        $produit2->setNom('Abricot');
        $produit2->setTva('17.6');
        
        $em->persist($produit2);
        
        $em->flush();
     
         
        
        $produits  = $em->getRepository('EcommerceBundle:Produits')->findAll();
        
        //die('test de l\'enregistrement produit');
        return $this->render('EcommerceBundle:Default:produits/layout/produits.html.twig', array('produits'=>$produits));
    }*/
}

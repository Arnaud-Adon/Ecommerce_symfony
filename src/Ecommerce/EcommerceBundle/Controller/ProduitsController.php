<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Form\RechercheType;
use Symfony\Component\HttpFoundation\Session\Session;
use Ecommerce\EcommerceBundle\Entity\Categories;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of produitsController
 *
 * @author Arnaud
 */
class ProduitsController extends Controller
{
    public function categorieAction($categorie){
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('EcommerceBundle:Produits')->byCategorie($categorie);
        
        $categorie = $em->getRepository('EcommerceBundle:Categories')->find($categorie);
        if(!$categorie) throw $this->createNotFoundException('La catégorie n\'existe pas');


        return $this->render('EcommerceBundle:Default:produits/layout/index.html.twig', array('produits' => $produits));
    }
    
    public function produitsAction(Request $request, Categories $categorie = null)
    {
        $em = $this->getDoctrine()->getManager();        
        $session = new Session();
        
        if(!is_null($categorie))
            $findProducts = $em->getRepository('EcommerceBundle:Produits')->byCategorie($categorie);        
        else
            $findProducts = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible'=> 1));
        
        if($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
         //La pagination
        $paginator = $this->get('knp_paginator');
        // Arguments | recuperations des produits | prendre la page de départ dans la requete | le nombre de produits par page
        $produits  = $paginator->paginate($findProducts, $request->query->getInt('page',1), 3);
    
        return $this->render('EcommerceBundle:Default:produits/layout/index.html.twig', array('produits' =>  $produits, 'panier' => $panier));
    }
    
    public function presentationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('EcommerceBundle:Produits')->find($id);
        
        $session = new Session();
        
         if($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
        if(!$produit) throw $this->createNotFoundException('Le produits n\'existe pas');
        
        return $this->render('EcommerceBundle:Default:produits/layout/presentation.html.twig', array('produit' => $produit, 'panier' =>$panier));
    }
    
    public function rechercheAction()
    {
        $form = $this->createForm(new RechercheType());
        return $this->render('EcommerceBundle:Default:recherche/moduleUsed/recherche.html.twig', array('form'=>$form->createView() ));
    }


    public function rechercheTraitementAction(){
        $form= $this->createForm(new RechercheType());   
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            $form->bind($request);
            $chaine  = $form['recherche']->getData();
            $em = $this->getDoctrine()->getManager();
            $produit = $em->getRepository('EcommerceBundle:Produits')->recherche($chaine);
        }else{
            throw $this->createNotFoundException("La page n'existe pas");
        }
        
        return $this->render('EcommerceBundle:Default:produits/layout/index.html.twig', array('produits' =>  $produit));
    
    }
}

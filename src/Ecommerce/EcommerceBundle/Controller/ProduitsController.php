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
    
    public function produitsAction(Categories $categorie = null)
    {
        $em = $this->getDoctrine()->getManager();        
        $session = new Session();
        
        if(!is_null($categorie))
            $produits = $em->getRepository('EcommerceBundle:Produits')->byCategorie($categorie);        
        else
            $produits = $em->getRepository('EcommerceBundle:Produits')->findBy(array('disponible'=> 1));
        
        if($session->has('panier'))
            $panier = $session->get('panier');
        else
            $panier = false;
        
        
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

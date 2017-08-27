<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ecommerce\EcommerceBundle\Listener\RedirectionListener;
use Utilisateurs\UtilisateursBundle\Form\UtilisateursAdressesType;
use Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Ecommerce\EcommerceBundle\Entity\Produits;

/**
 * Description of panierController
 *
 * @author Arnaud
 */
class PanierController extends Controller
{
    //pour la gestion du panier du menu en bootstrap | gestion des article  dans le panier
    public function menuAction(){
        
        $session = new Session();
        
        if(!$session->has('panier')){
            //si il n'y a pas de session panier les article sont à 0
            $articles = 0;
        
            //et on retourne le nombre d'article sur le module pour l'affichage
            return $this->render('EcommerceBundle:Default:panier/moduleUsed/panier.html.twig',array('articles' => $articles));
        }
        else {
            $panier = $session->get('panier');
            $articles = count($session->get('panier'));
            $produits = $this->getDoctrine()->getManager()->getRepository('EcommerceBundle:Produits')->findArray(array_keys($panier));
            
            return $this->render('EcommerceBundle:Default:panier/moduleUsed/panier.html.twig',array('articles' => $articles, 'panier' => $panier, 'produits' => $produits));
        }
        
        
        
    }
    
    public function ajouterAction($id){
        $session = new Session();
        
        if(!$session->has('panier')) $panier = $session->set('panier', array());
        
        $panier = $session->get('panier');
        
        if(array_key_exists($id, $panier)){
            if($this->getRequest()->query->get('qte') != null) $panier[$id] = $this->getRequest()->query->get('qte');
            $session->getFlashBag()->add('success', 'Quantité modifié avec succès.');
        }else{
            if($this->getRequest()->query->get('qte') != null)
                $panier[$id] = $this->getRequest()->query->get('qte');
            else
                $panier[$id] = '1';
                $session->getFlashBag()->add('success', 'L\'article a été ajouté avec succès.');
            
        }
        $session->set('panier', $panier);
        
            
                   
        return $this->redirect($this->generateUrl('panier'));
    }
    
    public function supprimmerAction($id){
        $session = new Session();
        //$em = $this->getDoctrine()->getManager();
        //
        //$produit = $em->getRepository('EcommerceBundle:Produits')->find($id);
        if($session->has('panier')) $panier = $session->get('panier');
        
      if(array_key_exists($id, $panier)){
          unset($panier[$id]);
          $session->set('panier',$panier);
          $session->getFlashBag()->add('success', 'L\'article a été supprimmer avec succès.');
      }
        
        return $this->redirect($this->generateUrl('panier'));
    }

    public function panierAction()
    {
        
        $session = new Session();
        if(!$session->has('panier')) $session->set('panier',array());
        $paniers = $session->get('panier');
        $produits = $this->getDoctrine()->getManager()->getRepository('EcommerceBundle:Produits')->findArray(array_keys($paniers));
        
        
        //var_dump($paniers);
        return $this->render('EcommerceBundle:Default:panier/layout/panier.html.twig', array('produits' => $produits, 'paniers' => $paniers));
    }
    
    public function livraisonAction()
    {
        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $entity = new UtilisateursAdresses();
        $em = $this->getDoctrine()->getManager();        
        $form = $this->createForm(new UtilisateursAdressesType(),$entity);
        $request = $this->getRequest();
        
        
        
        if($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
                $entity->setUtilisateur($utilisateur);
                $em->persist($entity);
                $em->flush();
                
                return $this->redirect($this->generateUrl('livraison'));
            }
            
        }
        $session=new Session();        
              
        return $this->render('EcommerceBundle:Default:panier/layout/livraison.html.twig', array('utilisateur' => $utilisateur, 'form' => $form->createView()));
        
    }
    
    public function setLivraisonOnSession(){
        $session = new Session();
        
        if(!$session->has('adresse')) $session->set('adresse',array());
        
        
           $adresse=$session->get('adresse');
           
           if($this->getRequest()->request->get('livraison') != null && $this->getRequest()->request->get('facturation') != null){
               $adresse['livraison'] = $this->getRequest()->request->get('livraison');
               $adresse['facturation'] = $this->getRequest()->request->get('facturation');
           }else{
               return $this->redirect($this->generateUrl('validation'));
           }
           
           $session->set('adresse', $adresse);
           return $this->redirect($this->generateUrl('validation'));
        
    }
    
     public function validationAction()
    {
         
 
         if($this->getRequest()->getMethod() == 'POST') {$this->setLivraisonOnSession();}
         $session= new Session();
        $em=$this->getDoctrine()->getManager();
        $prepareCommande=$this->forward('EcommerceBundle:Commandes:prepareCommande');
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($prepareCommande->getContent());
        
    
        return $this->render('EcommerceBundle:Default:panier/layout/validation.html.twig', array('commande'=>$commande));
    }
    
  

        public function livraisonAdresseSuppressionAction($id){
        
        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
        
        $em=$this->getDoctrine()->getManager();
        $entity = $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->find($id);
        
        if($utilisateur != $entity->getUtilisateur() || !$entity)  
            return $this->redirect($this->generateUrl('livraison')); 
        
        $em->remove($entity);
        $em->flush();                        
          
        
        return $this->redirect($this->generateUrl('livraison'));
    }
       
    public function redirectionLoginAction(){
        return $this->redirect($this->generateUrl('login'));
    }
        
        
}

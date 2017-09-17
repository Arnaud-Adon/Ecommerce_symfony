<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ecommerce\EcommerceBundle\Entity\Commandes;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


class CommandesController extends Controller {
    
    public function facture(){
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $generator=$this->container->get('security.secure_random');
        $adresse=$session->get('adresse');
        $panier=$session->get('panier');
        $commande=array();
        $totalHT=0;
        $totalTVA = 0;
        
        $facturation =  $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->find($adresse['facturation']);
        $livraison =  $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->find($adresse['livraison']);
        $produits = $em->getRepository('EcommerceBundle:Produits')->findArray(array_keys($panier));
        
        foreach($produits as $produit){
            $prixHT=($produit->getPrix() * $panier[$produit->getId()]);
            $prixTTC=($produit->getPrix() * $panier[$produit->getId()]) / $produit->getTva()->getMultiplicate();
            $totalHT += $prixHT ;
            
           
            
            if(!isset($commande['tva']['%'.$produit->getTva()->getValeur()])){
                $commande['tva']['%'.$produit->getTva()->getValeur()]= round($prixTTC - $prixHT,2);
               
            }else{
                $commande['tva']['%'.$produit->getTva()->getValeur()] += round($prixTTC - $prixHT,2);
            }
            $totalTVA += round($prixTTC - $prixHT,2);
            $commande['produit'][$produit->getId()] = array('reference' =>$produit->getNom(),
                                                            'quantite'=>$panier[$produit->getId()],
                                                            'prixHT'=>round($produit->getPrix(),2),
                                                            'prixTTC'=>round($produit->getPrix() / $produit->getTva()->getMultiplicate(),2));
        } 
        
             
        
            $commande['livraison']= array('prenom'=>$livraison->getPrenom(),
                                           'nom'=>$livraison->getNom(),
                                           'adresse'=>$livraison->getAdresse(),
                                           'cp'=>$livraison->getCp(),
                                           'ville'=>$livraison->getVille(),
                                           'pays'=>$livraison->getPays(),
                                           'complement'=>$livraison->getComplement());
            
            $commande['facturation']= array('prenom'=>$facturation->getPrenom(),
                                           'nom'=>$facturation->getNom(),
                                           'adresse'=>$facturation->getAdresse(),
                                           'cp'=>$facturation->getCp(),
                                           'ville'=>$facturation->getVille(),
                                           'pays'=>$facturation->getPays(),
                                           'complement'=>$facturation->getComplement());
            
            $commande['prixHT'] = round($totalHT,2);
             $commande['prixTTC'] = round($totalHT + $totalTVA ,2);
             $commande['token'] = bin2hex($generator->nextBytes(20));
             
             
             
             return $commande;
        
    }

    public function prepareCommandeAction() {
        $session = new Session();
        $em = $this->getDoctrine()->getManager();

        if (!$session->has('commande')) {
            $commande = new Commandes();
            
        } else {
            $commande = $em->getRepository('EcommerceBundle:Commandes')->find($session->get('commande'));
        }
        
        $commande->setDate(new \DateTime());
        $commande->setUtilisateur($this->container->get('security.token_storage')->getToken()->getUser());
        $commande->setValider(0);
        
        //appel du service qui attribut une reference
        $commande->setReference($this->container->get('setNewReference')->reference());
        $commande->setCommande($this->facture());
        
        
        
        if(!$session->has('commande'))
        {
            $em->persist($commande);
            $session->set('commande',$commande);
        }
        
        $em->flush();
        
        return new Response($commande->getId());
    }
    
    /*
     * Cette methode remplace l'api banque
     * Simulation de paiment à remple par une api paypal ou autre
     */
    
    public function validationCommandeAction($id){
        //initialisation des donnée utile à la recherche
        $session= new Session();
        $em=$this->getDoctrine()->getManager();
        $commande = $em->getRepository('EcommerceBundle:Commandes')->find($id);
        
        
        //si il n'ya pas de commande ou que la commande a déjà été valider on renvoi une erreur throw createNotFound | commande non trouvé
        if(!$commande || $commande->getValider() == 1)
            throw $this->createNotFoundException ('La commande n\'existe pas.');
        
        $commande->setValider(1);       
        //Service qui attribuera une reference à la commande pour l'nregistrement 
        $commande->setReference(1);
        
        $em->flush();
        
        //Une fois la commande valider On n'a plus besoin de la session en cour
        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
        
        
        
        //On affiche le message à l'utilisateur que la commande a été validé
        $session->getFlashBag()->add('success', 'Votre commande est validé avec succès');
        
        
        //retour à la page de presentations des produits
        return $this->redirect($this->generateUrl('factures'));
        
    }

}

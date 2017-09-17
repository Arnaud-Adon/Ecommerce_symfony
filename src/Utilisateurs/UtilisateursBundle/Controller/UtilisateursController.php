<?php

namespace Utilisateurs\UtilisateursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Utilisateurs\UtilisateursBundle\Form\UtilisateursAdressesType;
use Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class UtilisateursController extends Controller
{
    public function factureAction()
    {
        $em = $this->getDoctrine()->getManager();
        $factures = $em->getRepository('EcommerceBundle:Commandes')->byFacture($this->getUser());
        
        return $this->render('UtilisateursBundle:Default:layout/facture.html.twig', array('factures' => $factures));
    }
    
    public function facturePDFAction($id){
        $em = $this->getDoctrine()->getManager();
        
        $facture = $em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur'=> $this->getUser(),
                                                                                    'valider' => 1,
                                                                                    'id' =>$id
                                                                                      ));
        
        if(!$facture){
            $this->get('session')->getFlashBag('error','Une erreur est survenue');           
            $this->render($this->generateUrl('factures'));
        }
        
   
        
        $html2pdf=$this->get('setNewFacture');
        $html2pdf->facture($facture);
        
    }
    
    public function adresseAction(){
        $em= $this->getDoctrine()->getManager();
        
        $adresses = $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->byAdresse($this->getUser());

        return $this->render('UtilisateursBundle:Default:layout/adresse.html.twig', array('adresses' => $adresses));
                
    }
    
     public function deleteAdresseAction($id){
        $session=new Session();
        $em= $this->getDoctrine()->getManager();
        
        $adresses = $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->find($id);
        
        if(!$adresses){
            $session->getFlashBag()->add('error','Une erreur est survenue');
            return $this->render('UtilisateursBundle:Default:layout/adresse.html.twig', array('adresses' => $adresses));
            
        }else{
            $em->remove($adresses);
            $em->flush();
            $session->getFlashBag()->add('success','L\'adresse a été supprimé avec succes');
            return $this->redirectToRoute('utilisateurs_adresses');
        }
    
                
    }
    
     public function updateAdresseAction($id){
            $session= new Session();
            $em=$this->getDoctrine()->getManager();
            $adresse = $em->getRepository('UtilisateursBundle:UtilisateursAdresses')->find($id);
            $form=$this->createForm(new UtilisateursAdressesType(),$adresse);
            $request= Request::createFromGlobals();
                      
            
            
            if($request->getMethod() == 'POST'){
                
                $form->handleRequest($request); 
                if($form->isValid() && $form->isSubmitted()){                    
                    $em->persist($adresse);
                    $em->flush();
                    $session->getFlashBag()->add('success','L\'adresse a été modifié avec succes');     
                    
                    return $this->redirectToRoute('utilisateurs_adresses');
                }
            }
            
         
                return  $this->render('UtilisateursBundle:Default:layout/updateAdresse.html.twig', array('form'=> $form->createView()));   
    }
    
   
    
    
    
   
}

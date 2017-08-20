<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ecommerce\EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of CategoriesController
 *
 * @author Arnaud
 */
class CategoriesController extends Controller {
    public function menuAction(){
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('EcommerceBundle:Categories')->findAll();
        
        return $this->render('EcommerceBundle:Default:categories/moduleUsed/menu.html.twig', array('categories'=>$categories));
    }    
    
}

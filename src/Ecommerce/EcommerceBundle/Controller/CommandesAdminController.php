<?php

namespace Ecommerce\EcommerceBundle\Controller;

use Ecommerce\EcommerceBundle\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Commande controller.
 *
 */
class CommandesAdminController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('EcommerceBundle:Commandes')->findAll();

        return $this->render('EcommerceBundle:Admin:commandes/layout/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new commande entity.
     *
     */
    public function newAction(Request $request)
    {
        $commande = new Commandes();
        $form = $this->createForm('Ecommerce\EcommerceBundle\Form\CommandesType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('adminCommandes_show', array('id' => $commande->getId()));
        }

        return $this->render('EcommerceBundle:Admin:commandes/layout/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     */
    public function showAction(Commandes $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('EcommerceBundle:Admin:commandes/layout/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
    public function editAction(Request $request, Commandes $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('Ecommerce\EcommerceBundle\Form\CommandesType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adminCommandes_edit', array('id' => $commande->getId()));
        }

        return $this->render('EcommerceBundle:Admin:commandes/layout/edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commande entity.
     *
     */
    public function deleteAction(Request $request, Commandes $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('adminCommandes_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commandes $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commandes $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adminCommandes_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function facturePDFAction($id){
        $em = $this->getDoctrine()->getManager();
        $session= new Session();
        
        $facture =$em->getRepository('EcommerceBundle:Commandes')->findOneBy(array('utilisateur'=>$this->getUser(),'valider'=>1,'id'=>$id));
        
        if(!$facture){
            $session->getFlashBag()->add('error','La facture n\' est pas disponible ');        
            $this->redirectToRoute('adminCommandes_index');
        }
        
        $facturePdf=$this->get('setNewFacture');
        $facturePdf->facture($facture);
       
    }
}

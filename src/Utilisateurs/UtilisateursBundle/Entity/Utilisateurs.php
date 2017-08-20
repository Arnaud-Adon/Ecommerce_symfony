<?php
// src/UtilisateursBundle/Entity/Utilisateurs.php

namespace Utilisateurs\UtilisateursBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="utilisateurs")
 */
class Utilisateurs extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->commandes = new ArrayCollection();
        $this->adresses = new ArrayCollection();
    }
    
    /**
     * @ORM\OneToMany(targetEntity="Ecommerce\EcommerceBundle\Entity\Commandes",mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;
    
     /**
     * @ORM\OneToMany(targetEntity="Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses",mappedBy="utilisateur", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;

    /**
     * Add commandes
     *
     * @param \Ecommerce\EcommerBundle\Entity\Commandes $commandes
     * @return Utilisateurs
     */
    public function addCommande(\Ecommerce\EcommerceBundle\Entity\Commandes $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes
     *
     * @param \Ecommerce\EcommerBundle\Entity\Commandes $commandes
     */
    public function removeCommande(\Ecommerce\EcommerceBundle\Entity\Commandes $commandes)
    {
        $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adresses
     *
     * @param \Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses $adresses
     * @return Utilisateurs
     */
    public function addAdress(\Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses
     *
     * @param \Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses $adresses
     */
    public function removeAdress(\Utilisateurs\UtilisateursBundle\Entity\UtilisateursAdresses $adresses)
    {
        $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}

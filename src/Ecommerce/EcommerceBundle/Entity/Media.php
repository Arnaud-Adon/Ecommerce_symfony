<?php

namespace Ecommerce\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//Pour imposé des contraintes tel que la taille d'un fichier  | l'état d'un champ de texte
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="Ecommerce\EcommerceBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @var \Datetime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $update_at;
    

    /**
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(name="alt", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $alt;
     /**
     *
     * @Assert\File()
     * variable contenant le fichier
     */
    private $file;
    
    //variable contenant le fichier temporaire
    private $tempFile;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    
    public function getPath(){
        return $this->path;
    }
    
    public function  getAlt(){
        return $this->alt;
    }
    
    public function setPath($path){
        $this->path=$path;
    }
    
    public function setAlt($alt){
        $this->alt=$alt;
    }


    public function getFile(){
       return $this->file;
    }


    public function setFile(UploadedFile $file){
        $this->file = $file;
        $this->update_at = new \DateTime();
        if($this->path !== null)
            $this->tempFile = $this->getAbsolutePath();
    }

        /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function PreUpload(){
        if($this->file === null){
            return;
        }          
        if(null !== $this->file) $this->path=sha1(uniqid(mt_rand(),true)).'.'.$this->file->guessExtension();
    }

    

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        //Si il n'y a pas de fichier
        if ($this->file === null) {
            return;
        }
          
        //On prend l'ancien fichier pourb le supprimmer dans le cas d'un update
       if($this->tempFile !== null){
           $oldFile = $this->tempFile;
           if(file_exists($oldFile)){
               unlink($oldFile);
           }
       }
       
       $this->file->move($this->getUploadRootDir(), $this->path);
    }
    
    /**
     * @ORM\PreRemove()
     */
    public function  PreRemoveUpload(){
        $this->tempFile = $this->getAbsolutePath();
    }
    
    /*public function  PreRemoveUpload(){
        $this->tempFile=$this->getUploadRootDir().$this->id.'.'.$this->extension;
    }*/
    
     /**
     * @ORM\PostRemove()
     */
    public function RemoveUpload(){
        if(file_exists($this->tempFile)){
            unlink($this->tempFile);
        }
    }

    public function getUploadDir() {
        //chemin de l'image direct pour le navigateur
        return 'img/produits/';
    }

    public function getUploadRootDir() {
        return  __DIR__ . '/../../../../web/' .$this->getUploadDir();
    }
    
    public function getAbsolutePath(){
        //chemin absolu du fichier
        return $this->getUploadRootDir().$this->getPath();
    }
    
   

}

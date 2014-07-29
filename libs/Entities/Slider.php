<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Slider")
  * @Custom\Description(value="Administrar Sliders")
  * @Custom\ABML(modificacion=true,lista=true)  
  *
*/

class Slider extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     * @Custom\Description(value="Nombre")
     * @Custom\ReadOnly
     * @Custom\MainField
     */
    protected $name;

    /** @ORM\Column(type="string") 
     * @Custom\Description(value="Título")
     * @Custom\TextField
     */
    protected $titulo;
    
    /** 
    * @ORM\ManyToOne(targetEntity="Color", cascade={"persist"}) 
    * @Custom\Description(value="Color de fondo")
    * @Custom\Select
    */  
    protected $color;
    
    /**
    * @ORM\ManyToMany(targetEntity="Imagen", cascade={"persist"})
    * @ORM\JoinTable(name="SliderImagenes",
    *      joinColumns={@ORM\JoinColumn(name="info_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Imágenes")    
    * @Custom\Gallery
    */
    protected $imgs;
    
// getters/setters

    public function __construct() 
    {
      $this->imgs= new ArrayCollection(); 
    }
    
    public function getFirstImg()
    {
      if(isset($this->imgs[0])) return $this->imgs[0]->getUri();
      return "";
    }
}



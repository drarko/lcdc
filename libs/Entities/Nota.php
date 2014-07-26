<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Nota")
  * @Custom\Description(value="Administrar Notas del Blog")
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Nota extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="text") 
     * @Custom\Description(value="Título")
     * @Custom\TextField
     * @Custom\MainField
     */
    protected $title;

    /** @ORM\Column(type="string") 
     * @Custom\Description(value="Resumen")
     * @Custom\TextAreaHtml
     */
    protected $resumen;
    
    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Contenido")
     *  @Custom\TextAreaHtml
     */
    protected $content;
    
    /** @ORM\Column(type="date") 
    * @Custom\Description(value="Fecha")
    * @Custom\Date
    */  
    protected $fecha;

    /** 
    * @ORM\ManyToOne(targetEntity="Tipo", cascade={"persist"}) 
    * @Custom\Description(value="Sección")
    * @Custom\Select
    */  
    protected $seccion;
        
    /**
    * @ORM\ManyToMany(targetEntity="Imagen", cascade={"persist"})
    * @ORM\JoinTable(name="ImagenInfo",
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



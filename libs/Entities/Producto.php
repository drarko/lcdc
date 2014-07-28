<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Producto")
  * @Custom\Description(value="Administrar Productos")
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Producto extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")
     *  @Custom\TextField
     *  @Custom\MainField
     */
    protected $name;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Autor")
     *  @Custom\TextField
     */
    protected $autor;
	
    /** @ORM\Column(type="text", name="`desc`") 
     *  @Custom\Description(value="Descripción")
     *  @Custom\TextArea
     */
    protected $desc;
 
    /** @ORM\Column(type="integer") 
     *  @Custom\Description(value="Precio")
     *  @Custom\TextField
     */
    protected $precio;

    /** 
    * @ORM\ManyToOne(targetEntity="Categoria", cascade={"persist"}) 
    * @Custom\Description(value="Categoria")
    * @Custom\SelectTree
    */  
    protected $categoria;
        
    /**
    * @ORM\ManyToMany(targetEntity="Imagen", cascade={"persist"})
    * @ORM\JoinTable(name="ProductoImagenes",
    *      joinColumns={@ORM\JoinColumn(name="lote_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Imágenes")
    * @Custom\Gallery
    */
    protected $imgs;
    
   /**
    *  @ORM\Column(type="boolean")
    *  @Custom\Description(value="Aparece en listado Principal")
    *  @Custom\Boolean
    */
    protected $destacado;    

    public function __construct() 
    {
      $this->imgs= new ArrayCollection(); 
    }
    
    public function getFirstImg()
    {
      if(isset($this->imgs[0])) return $this->imgs[0]->getUri();
      return "";
    }
        
    public function renderEntity()
    {
      return '<u>' . $this->name . '</u><br/><br/>' . $this->desc;
    }
} 


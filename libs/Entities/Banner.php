<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Banner")
  * @Custom\Description(value="Administrar Banners")
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Banner extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** 
    * @ORM\ManyToOne(targetEntity="BannerTipo", cascade={"persist"}) 
    * @Custom\Description(value="Ubicación")
    * @Custom\Select
    */  
    protected $tipo;    
    
    /** @ORM\Column(type="string") 
     * @Custom\Description(value="Título")
     * @Custom\TextField
     */
    protected $titulo;
    
    /** @ORM\Column(type="string") 
     * @Custom\Description(value="Texto")
     * @Custom\TextField
     */
    protected $texto;
    
    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Color de fondo")
     *  @Custom\Color
     */
    protected $color;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Enlace")
     *  @Custom\TextField
     */    
    protected $link;
    
    /**
    * @ORM\ManyToMany(targetEntity="Imagen", cascade={"persist"})
    * @ORM\JoinTable(name="BannerImagenes",
    *      joinColumns={@ORM\JoinColumn(name="info_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Imágenes")    
    * @Custom\Gallery(limit=1)
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



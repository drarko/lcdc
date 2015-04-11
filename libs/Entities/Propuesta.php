<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("propuesta")
  * @Custom\Description(value="Administrar Propuestas")
  * @Custom\ABML(alta=true,modificacion=true,lista=true,baja=true)  
  *
*/

class Propuesta extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** 
    *  @ORM\ManyToOne(targetEntity="Imagen", cascade={"persist","remove"}) 
    *  @Custom\Description(value="Imagen")    
    *  @Custom\Imagen
    *  @Custom\MainField
    */
    protected $imagen;

    /** @ORM\Column(type="boolean") 
     *  @Custom\Description(value="Procesado")
     *  @Custom\Boolean  
     */
    protected $is_procesed;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Series")    
     *  @Custom\TextArea
     */
    protected $series;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Personajes")    
     *  @Custom\TextArea
     */
    protected $personajes;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Parejas")    
     *  @Custom\TextArea
     */
    protected $parejas;
	
    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Descripcion")    
     *  @Custom\TextArea
     */
    protected $descripcion;
	
   public function renderEntity()
   {
		return "";
   }	
	
    public function __construct() 
    {

    }	
} 

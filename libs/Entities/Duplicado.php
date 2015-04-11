<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("duplicado")
  * @Custom\Description(value="Administrar duplicados")
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Duplicado extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** 
    *  @ORM\ManyToOne(targetEntity="Imagen", cascade={"persist"}) 
    *  @Custom\Description(value="Imagen A")    
    *  @Custom\Imagen
    *  @Custom\MainField
    */
    protected $imga;

    /** 
    *  @ORM\ManyToOne(targetEntity="Imagen", cascade={"persist"}) 
    *  @Custom\Description(value="Imagen B")    
    *  @Custom\Imagen
    */
    protected $imgb;
	
   public function renderEntity()
   {
		return $this->imga->renderEntity();
   }	
	
}
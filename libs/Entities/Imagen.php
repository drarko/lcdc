<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Imagen")
  * @Custom\Description(value="Administrar Imagenes")
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Imagen extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")    
     *  @Custom\TextField
     */
    protected $name;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Imagen")
     *  @Custom\Imagen
     *  @Custom\MainField
     */
    protected $uri;
 
} 


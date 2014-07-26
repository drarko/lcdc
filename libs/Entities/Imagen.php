<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Imagen")
  * @Custom\Description(value="Administrar Imagenes")
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
     *  @Custom\Description(value="Descripción")    
     *  @Custom\TextField
     */
    protected $name;
    
    /** @ORM\Column(type="text", name="`desc`") 
     *  @Custom\Description(value="Descripción")    
     *  @Custom\TextArea
     */
    protected $desc;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Imagen")
     *  @Custom\Imagen
     *  @Custom\MainField
     */
    protected $uri;
 
} 


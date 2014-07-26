<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Config")
  * @Custom\Description(value="Configuración General")
  * @Custom\ABML(modificacion=true,lista=true)  
  *
*/

class Config extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")    
     *  @Custom\ReadOnly
     */
    protected $name;
    
    /** @ORM\Column(type="text", name="value") 
     *  @Custom\Description(value="Valor")    
     *  @Custom\TextArea
     */
    protected $value;
 
} 


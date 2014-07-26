<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("BlogTipo")
  * @Custom\Description(value="Administrar Secciones del Blog")  
  * @Custom\ABML(alta=true,baja=true,modificacion=true,lista=true)  
  *
*/

class Tipo extends Entity  {
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
    
    public function renderEntity()
    {
      return $this->name;
    }
    // getters/setters
} 

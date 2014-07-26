<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("Categoria")
  * @Custom\Description(value="Administrar Categorias")
  *
*/

class Categoria extends Entity  {
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

    /** 
    * @ORM\ManyToOne(targetEntity="Categoria", cascade={"persist"}) 
    * @Custom\Description(value="Categoria padre")
    * @Custom\Select
    */  
    protected $padre;
	
    // getters/setters

    public function renderEntity()
    {
      return $this->name;
    }
} 

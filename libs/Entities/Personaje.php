<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("personaje")
  * @Custom\Description(value="Administrar Personajes")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Personaje extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")    
     *  @Custom\TextField
     *  @Custom\MainField     
     */
    protected $name;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Descripcion")    
     *  @Custom\TextArea
     */
    protected $description;

    /** 
    * @ORM\ManyToOne(targetEntity="Serie", cascade={"persist"}) 
    * @Custom\Description(value="Serie")
    * @Custom\Select
    */  
    protected $serie;   
	
    /**
    * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
    * @ORM\JoinTable(name="personaje_tags",
    *      joinColumns={@ORM\JoinColumn(name="personaje_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Tags")
    * @Custom\MultiSelect
    */
    protected $tags;

   public function renderEntity()
   {
		return $this->name;
   }	
   
    public function __construct() 
    {
      $this->tags= new ArrayCollection(); 

    }   
} 
/*

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);

$metadata->mapManyToMany(array(
   'fieldName' => 'pareja',
   'targetEntity' => 'Pareja',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'personaje',
  ));
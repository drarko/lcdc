<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("pareja")
  * @Custom\Description(value="Administrar Parejas")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Pareja extends Entity  {
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
    * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
    * @ORM\JoinTable(name="pareja_tags",
    *      joinColumns={@ORM\JoinColumn(name="pareja_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Tags")
    * @Custom\MultiSelect
    */
    protected $tags; 

    /**
    * @ORM\ManyToMany(targetEntity="Personaje", cascade={"persist"})
    * @ORM\JoinTable(name="pareja_personajes",
    *      joinColumns={@ORM\JoinColumn(name="pareja_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="personaje_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Personajes")
    * @Custom\MultiSelect
    */
    protected $personajes; 	

    /**
    * @ORM\ManyToMany(targetEntity="Imagen", cascade={"persist"})
    * @ORM\JoinTable(name="imagen_pareja",
    *      joinColumns={@ORM\JoinColumn(name="pareja_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Imagenes")
    * @Custom\Gallery
    */
    protected $imgs; 
	
   public function renderEntity()
   {
		return $this->name;
   }	
	
    public function __construct() 
    {
      $this->tags= new ArrayCollection(); 
	  $this->personajes= new ArrayCollection(); 
	  $this->imgs= new ArrayCollection(); 
    }	
} 
/*

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapManyToMany(array(
   'fieldName' => 'imagen',
   'targetEntity' => 'Imagen',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'pareja',
  ));
<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("serie")
  * @Custom\Description(value="Administrar Series")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Serie extends Entity  {
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
    * @ORM\JoinTable(name="serie_tags",
    *      joinColumns={@ORM\JoinColumn(name="serie_id", referencedColumnName="id")},
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
use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'serie',
  ));
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'columnName' => 'id',
   'type' => 'bigint',
   'nullable' => false,
   'unsigned' => false,
   'id' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'name',
   'columnName' => 'name',
   'type' => 'string',
   'nullable' => true,
   'length' => 255,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'description',
   'columnName' => 'description',
   'type' => 'text',
   'nullable' => true,
   'length' => 65535,
   'fixed' => false,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapManyToMany(array(
   'fieldName' => 'tag',
   'targetEntity' => 'Tag',
   'cascade' => 
   array(
   ),
   'joinTable' => 
   array(
   'name' => 'serie_tags',
   'joinColumns' => 
   array(
    0 => 
    array(
    'name' => 'serie_id',
    'referencedColumnName' => 'id',
    ),
   ),
   'inverseJoinColumns' => 
   array(
    0 => 
    array(
    'name' => 'tag_id',
    'referencedColumnName' => 'id',
    ),
   ),
   ),
  ));
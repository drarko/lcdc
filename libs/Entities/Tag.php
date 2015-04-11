<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("tag")
  * @Custom\Description(value="Administrar Tags")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Tag extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Tag")    
     *  @Custom\TextField
     *  @Custom\MainField
     */
    protected $tag;

   public function renderEntity()
   {
		return $this->tag;
   }
} 
/*
use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'tag',
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
   'fieldName' => 'tag',
   'columnName' => 'tag',
   'type' => 'text',
   'nullable' => true,
   'length' => 65535,
   'fixed' => false,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapManyToMany(array(
   'fieldName' => 'imagen',
   'targetEntity' => 'Imagen',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'tag',
  ));
$metadata->mapManyToMany(array(
   'fieldName' => 'pareja',
   'targetEntity' => 'Pareja',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'tag',
  ));
$metadata->mapManyToMany(array(
   'fieldName' => 'personaje',
   'targetEntity' => 'Personaje',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'tag',
  ));
$metadata->mapManyToMany(array(
   'fieldName' => 'serie',
   'targetEntity' => 'Serie',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'tag',
  ));
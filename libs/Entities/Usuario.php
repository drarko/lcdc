<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("usuario")
  * @Custom\Description(value="Administrar Usuario")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Usuario extends Entity  {
    /**
    * @ORM\Id
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")    
     *  @Custom\TextField
     *  @Custom\MainField     
     */
    protected $name;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Descripcion")    
     *  @Custom\TextField
     */
    protected $bio;

    /** @ORM\Column(type="boolean") 
     *  @Custom\Description(value="Seguidor")
     *  @Custom\Boolean  
     */
    protected $is_follower;
    
    /** @ORM\Column(type="boolean") 
     *  @Custom\Description(value="Amigo")
     *  @Custom\Boolean  
     */
    protected $is_friend;
 
    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Lenguaje")    
     *  @Custom\TextField
     */
    protected $lang;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="JSON")    
     *  @Custom\Hidden
     */
    protected $json;
    
    public function renderEntity()
    {
      return $this->name;
    }    
   
} 
/*

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'usuario',
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
   'fieldName' => 'bio',
   'columnName' => 'bio',
   'type' => 'string',
   'nullable' => true,
   'length' => 500,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'isFollower',
   'columnName' => 'is_follower',
   'type' => 'boolean',
   'nullable' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'isFriend',
   'columnName' => 'is_friend',
   'type' => 'boolean',
   'nullable' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'lang',
   'columnName' => 'lang',
   'type' => 'string',
   'nullable' => false,
   'length' => 10,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'json',
   'columnName' => 'json',
   'type' => 'text',
   'nullable' => true,
   'length' => 65535,
   'fixed' => false,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);*/
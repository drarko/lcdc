<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("imagen")
  * @Custom\Description(value="Administrar Imagenes")
  * @Custom\ABML(alta=true,modificacion=true,lista=true,baja=true)  
  *
*/

class Imagen extends Entity  {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="bigint")
    */
    protected $id;

    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Nombre")    
     *  @Custom\TextField
     */
    protected $name;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Descripcion")    
     *  @Custom\TextArea
     */
    protected $description;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Filename")
     *  @Custom\Imagen     
     *  @Custom\MainField     
     */
    protected $filename;
    
    /** @ORM\Column(type="boolean") 
     *  @Custom\Description(value="Procesado")
     *  @Custom\Boolean  
     */
    protected $is_procesed;
 
    /** @ORM\Column(type="string") 
     *  @Custom\Description(value="Hash")    
     *  @Custom\TextField
     */
    protected $hash; 
    
    /** 
    * @ORM\ManyToOne(targetEntity="Tweet", cascade={"persist"}) 
    * @Custom\Description(value="Tweet")
    * @Custom\ReadOnly
    */  
    protected $tweet;    
   
    /**
    * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
    * @ORM\JoinTable(name="imagen_tags",
    *      joinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Tags")
    * @Custom\MultiSelect
    */
    protected $tags; 

    /**
    * @ORM\ManyToMany(targetEntity="Pareja", cascade={"persist"})
    * @ORM\JoinTable(name="imagen_pareja",
    *      joinColumns={@ORM\JoinColumn(name="imagen_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="pareja_id", referencedColumnName="id")}
    *      )
    * @Custom\Description(value="Parejas")
    * @Custom\MultiSelect
    */
    protected $parejas;	
	
    /** 
    * @ORM\OneToMany(targetEntity="Propuesta", mappedBy="imagen", cascade={"persist","remove"}) 
    * @Custom\Description(value="Propuestas")
    * @Custom\MultiSelect
    */  	
	protected $propuestas;

    /** 
    * @ORM\OneToMany(targetEntity="Duplicado", mappedBy="imga", cascade={"persist","remove"}) 
    * @Custom\Description(value="Duplicado A")
    * @Custom\MultiSelect
    */  	
	protected $duplicadoa;
	
    /** 
    * @ORM\OneToMany(targetEntity="Duplicado", mappedBy="imgb", cascade={"persist","remove"}) 
    * @Custom\Description(value="Duplicado B")
    * @Custom\MultiSelect
    */  	
	protected $duplicadob;

    public function __construct() 
    {
      $this->tags= new ArrayCollection(); 
	  $this->parejas= new ArrayCollection(); 
    }
	
} 
/*
use Doctrine\ORM\Mapping\ClassMetadataInfo;


$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapOneToOne(array(
   'fieldName' => 'posibleDuplicate',
   'targetEntity' => 'Imagen',
   'cascade' => 
   array(
   ),
   'mappedBy' => NULL,
   'inversedBy' => NULL,
   'joinColumns' => 
   array(
   0 => 
   array(
    'name' => 'posible_duplicate_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));

*/
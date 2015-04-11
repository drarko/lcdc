<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Annotations as Custom;

use Entities\Entity;

/** @ORM\Entity
  * @ORM\Table("tweet")
  * @Custom\Description(value="Administrar Tweets")
  * @Custom\ABML(alta=true,modificacion=true,lista=true)  
  *
*/

class Tweet extends Entity  {
    /**
    * @ORM\Id
    * @ORM\Column(type="bigint")
    */
    protected $id;


    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="Text")    
     *  @Custom\TextField
     *  @Custom\MainField
     */
    protected $text;

    /** @ORM\Column(type="text") 
     *  @Custom\Description(value="JSON")    
     *  @Custom\Hidden
     */
    protected $json;
       
    /** @ORM\Column(type="boolean") 
     *  @Custom\Description(value="Procesado")
     *  @Custom\Boolean  
     */     
    protected $is_procesed;
    
    /** 
    * @ORM\ManyToOne(targetEntity="Usuario", cascade={"persist"}) 
    * @Custom\Description(value="Usuario")
    * @Custom\ReadOnly
    */  
    protected $usuario;

    /** 
    * @ORM\OneToOne(targetEntity="Tweet", cascade={"persist"})
    * @ORM\JoinColumn(name="in_reply_id", referencedColumnName="id")
    * @Custom\Description(value="In Reply to")
    * @Custom\ReadOnly
    */  
    protected $in_reply_to;
    
    /** 
    * @ORM\OneToOne(targetEntity="Tweet", cascade={"persist"}) 
    * @ORM\JoinColumn(name="is_retweet_id", referencedColumnName="id")
    * @Custom\Description(value="Is Retweet of")
    * @Custom\ReadOnly
    */  
    protected $is_retweet_of;    
    
    
    /**
    * @ORM\OneToMany(targetEntity="Imagen", mappedBy="tweet", cascade={"persist"}, orphanRemoval=true)
    * @Custom\Description(value="Imágenes")    
    * @Custom\Gallery
    */
    protected $imgs;    
    
    
    public function renderEntity()
    {
      return $this->text;
    }
    
    public function __construct() 
    {
      $this->imgs= new ArrayCollection(); 
    }
        
} 

/*use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);

$metadata->mapManyToMany(array(
   'fieldName' => 'imagen',
   'targetEntity' => 'Imagen',
   'cascade' => 
   array(
   ),
   'mappedBy' => 'tweet',
  ));
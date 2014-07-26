<?php

namespace Annotations;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Service\Entity;

class Service extends Entity
{
    public function init()
    {
      $this->em->getConfiguration()->setDefaultRepositoryClassName('Annotations\Doctrine\Repository');
    }
    
    public function getAllMetadataClass()
    {
      $meta = $this->em->getMetadataFactory()->getAllMetadata();
      return $meta;
    }
    
    public function getAllTables() {
      $entities = array();
      $meta = $this->em->getMetadataFactory()->getAllMetadata();
      foreach ($meta as $m) {
	$entities[] = $m->getName();
      }
      return $entities;
    }
    
    public function getClassMetadata($class)
    {
      $metadata = $this->em->getClassMetadata($class);
      return $metadata;
    }
    
}
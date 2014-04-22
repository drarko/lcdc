<?php

namespace Service;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Service\Entity;

class Banco extends Entity
{

    public function getBanco($id)
    {
      $ban = $this->em->getRepository('Entities\Banco\Banco')->findOneById($id);
      return $ban;
    }

    public function getAllBancos()
    {
      $ban = $this->em->getRepository('Entities\Banco\Banco')->findAll();
      return $ban;
    }    
} 

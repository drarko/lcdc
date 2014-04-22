<?php

namespace Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Entity implements ServiceLocatorAwareInterface
{

    protected $services;
    protected $sm;
    protected $em;
    
    public function __construct($sm)
    {
      $this->sm = $sm;
      $this->em = $this->sm->get('Doctrine\ORM\EntityManager');
    }
    
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->services;
    }

}  

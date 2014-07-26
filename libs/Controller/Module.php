<?php

namespace Controller;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{

    public function onBootstrap(MvcEvent $e)
    {
        $event = $e->getApplication()->getEventManager();
        $event->getSharedManager()
          ->attach('Zend\Mvc\Controller\AbstractActionController',
                    'dispatch',
                array($this, 'settingUpControllerVariables'), 100
        );
    }
 
    public function settingUpControllerVariables(MvcEvent $e)
    {
        $controller = $e->getTarget();
	$controller->init();
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../' . __NAMESPACE__,
                ),
            ),
        );
    }

   public function getConfig()
   {
        return include __DIR__ . '/config/module.config.php';
   }
   
    public function getServiceConfig()
    {    
	return array();      
    }

}

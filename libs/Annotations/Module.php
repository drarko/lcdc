<?php

namespace Annotations;


use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
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
	return array(
	    'factories' => array(
		'Annotations\Service' => function ($sm) {
		    $as = new Service($sm);
		    $as->init();
		    return $as;
		},
	    ),    
	);  
    }

}

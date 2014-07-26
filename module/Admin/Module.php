<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
    }
    
    public function init(ModuleManager $mm)
    {
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
        'dispatch', function($e) {
            $e->getTarget()->layout('admin/layout');
        });
    }    

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),         
        );
    }
    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'annotation_list' => function($sm) {
                    $helper = new View\Helper\AnnotationListHelper;
                    return $helper;
                },
                'annotation_form' => function($sm) {
                    $helper = new View\Helper\AnnotationFormHelper;
                    return $helper;
                }                
            )
        );  
    }
   
    public function getServiceConfig()
    {    
	return array(
	    'factories' => array(
		'Admin\Service' => function ($sm) {
		    $as = new Service\AdminService($sm);
		    $as->init();
		    return $as;
		},
	    ),    
	);  
    }    
}

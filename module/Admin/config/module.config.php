<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'defaults' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:table[/:act][/:id]]',
                            'constraints' => array(
                                'table' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'act'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
				'defaults' => array(
                                   'type' => 'Wildcard',
				    'options' => array(
					'defaults' => array(
					    '__NAMESPACE__' => 'Admin\Controller',
					    'controller'    => 'Index',
					    'action'        => 'index',
					),
				    ),
			    ),
			),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'admin/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),    
        'template_path_stack' => array(
            'Admin' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController'
        ),
    ),
);

<?php
namespace Entities;

return array(
    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../'
		  
		  )
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__  => __NAMESPACE__ . '_driver'
                )
            )
        )
    )   
);

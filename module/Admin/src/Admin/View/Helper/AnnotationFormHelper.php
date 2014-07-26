<?php

namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
 
class AnnotationFormHelper extends AbstractHelper
{
    public function __invoke($type, $data, $property)
    {
       $classname = "Annotations\\" . $type['type'];
       
       $class = new $classname(array());
       $class->setData($type);
       return $class->renderForm($data, $property);
      
    }
}
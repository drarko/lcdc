<?php

namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
 
class AnnotationListHelper extends AbstractHelper
{
    public function __invoke($type, $data)
    {
       $classname = "Annotations\\" . $type['type'];
       
       $class = new $classname(array());
       
       return $class->renderList($data);
      
    }
}
<?php

namespace Annotations;

/** @Annotation */
class TextAreaHtml extends TextArea 
{
     public $type = "TextAreaHtml";

     public function renderList($data) 
     {
      	$result = '<pre style="text-align:left;width:500px">'. htmlentities(substr($data,0,300)."...") . '</pre>';
	return $result;
     }    
}
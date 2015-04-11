<?php

namespace Annotations;

/** @Annotation */
class Hidden extends CustomAnnotation 
{
     public $type = "Hidden";

     public function renderList($data) 
     {
		return "";
     }
     
     public function renderForm($data, $property) 
     {
	return $data . '<input type="hidden" name="' . $property . '" value="'. $data .'"></input>';
     }     
}
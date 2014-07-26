<?php

namespace Annotations;

/** @Annotation */
class TextField extends CustomAnnotation 
{
     public $type = "TextField";

     public function renderList($data) 
     {
	return $data;
     }
     
     public function renderForm($data, $property) 
     {
	return '<input type="text" name="' . $property . '" value="'. $data .'"></input>';
     }     
}
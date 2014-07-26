<?php

namespace Annotations;

/** @Annotation */
class ReadOnly extends CustomAnnotation 
{
     public $type = "ReadOnly";

     public function renderList($data) 
     {
	return $data;
     }
     
     public function renderForm($data, $property) 
     {
	return $data . '<input type="hidden" name="' . $property . '" value="'. $data .'"></input>';
     }     
}
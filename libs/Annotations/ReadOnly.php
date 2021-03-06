<?php

namespace Annotations;

/** @Annotation */
class ReadOnly extends CustomAnnotation 
{
     public $type = "ReadOnly";

     public function renderList($data) 
     {
		if(is_object($data)) $data = $data->renderEntity();
	return $data;
     }
     
     public function renderForm($data, $property) 
     {
		if(is_object($data)) $data = $data->renderEntity();
	return $data . '<input type="hidden" name="' . $property . '" value="'. $data .'"></input>';
     }     
}
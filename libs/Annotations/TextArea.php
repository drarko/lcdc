<?php

namespace Annotations;

/** @Annotation */
class TextArea extends CustomAnnotation 
{
     public $type = "TextArea";

     public function renderList($data) 
     {
	return $data;
     }
     
     public function renderForm($data, $property) 
     {
	return '<textarea id="textos" name="' . $property . '">'. $data .'</textarea>';
     }     
}
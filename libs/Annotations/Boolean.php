<?php

namespace Annotations;

/** @Annotation */
class Boolean extends CustomAnnotation 
{
     public $type = "Boolean";
     
     public function renderList($data) 
     {
	return ($data == true ? "Sí":"No");
     }
     
     public function renderForm($data, $property) 
     {
	if($data != "") {
	     $sel = true;
	}
	return '<select name="'.$property.'"><option value="0" '.(((isset($sel))&&($data == false))?"selected":"").'>No</option><option value="1" '.(((isset($sel))&&($data != false))?"selected":"").'>Sí</option></select>';
     }       

}
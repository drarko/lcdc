<?php

namespace Annotations;

/** @Annotation */
class Select extends CustomAnnotation 
{
     public $type = "Select";

     public function renderList($data) 
     {
	if($data == null) return "";
	return $data->renderEntity();
     }
     
     public function renderForm($data, $property) 
     { 
	$select = '<select name="'. $property .'"><option value="0">-- Seleccione --</option>';
	foreach($this->data['list'] as $elm) {
	  $select = $select . '<option value="'. $elm->get('id') .'" '. ((($data != "")&&($data->getId() == $elm->get('id')))?"selected":"") .'>'. $elm->get($this->data['main']) .'</option>';
	}
	$select = $select . '</select>';
	return $select;
     }     
}
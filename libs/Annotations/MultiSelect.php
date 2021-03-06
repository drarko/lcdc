<?php

namespace Annotations;

/** @Annotation */
class MultiSelect extends CustomAnnotation 
{
     public $type = "MultiSelect";
     public $limit = 0;
     
     public function renderList($data) 
     {
	 if($data == null) return "";
	$imgs = $data->toArray();
	$result = "";
	foreach($imgs as $i) {
	  $result = $result . $i->renderEntity() . ', ';
	}
	return $result;
     }
     
     public function renderForm($data, $property) 
     {
	$imgsIds = array();
	if($data != "") {
	  $imgs = $data->toArray();
	  foreach($imgs as $i) {
	    $imgsIds[] = $i->getId(); 
	  }
	}

	if($this->data['limit'] != 0) {
	  $result = '<select name="'.$property.'[]"><option value=""></option>';
	} else {
	  $result = '<select name="'.$property.'[]" multiple="multiple"><option value=""></option>';
	}
	foreach($this->data['list'] as $elm) {
	  $result = $result . '<option value="'.$elm->getId().'" '.((($data != "")&&(in_array($elm->get('id'),$imgsIds)))?"selected":"").'>'.$elm->get($this->data['main']).'</option>';
	}
	$result = $result . '</select>';
	return $result;
     }    
   
}
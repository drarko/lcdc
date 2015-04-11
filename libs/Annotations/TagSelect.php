<?php

namespace Annotations;

/** @Annotation */
class TagSelect extends CustomAnnotation 
{
     public $type = "TagSelect";
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
	  $result = '<input type="hidden" id="'.$property.'[]" value="" name="'.$property.'[]" style="width: 400px;">';
	} else {
	  $result = '<input type="hidden" id="'.$property.'[]" value="" name="'.$property.'[]" style="width: 400px;">';
	}
	foreach($this->data['list'] as $elm) {
	  $result = $result . '<option value="'.$elm->getId().'" '.((($data != "")&&(in_array($elm->get('id'),$imgsIds)))?"selected":"").'>'.$elm->get($this->data['main']).'</option>';
	}
	$result = $result . '</select>';
	return $result;
     }    
   
}

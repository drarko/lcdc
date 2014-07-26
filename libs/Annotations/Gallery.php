<?php

namespace Annotations;

/** @Annotation */
class Gallery extends CustomAnnotation 
{
     public $type = "Gallery";

     public function renderList($data) 
     {
	$imgs = $data->toArray();
	$result = "";
	foreach($imgs as $i) {
	  $result = $result . '<a href="/' . $i->get('uri') . '" rel="prettyPhoto"><img class="img-thumbnail maxsize" width="140" height="140" src="/' . $i->get('uri') . '"></img></a>';
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
	$result = '<select name="'.$property.'[]" multiple="multiple" class="gallery image-picker show-html masonry"><option value=""></option>';
	foreach($this->data['list'] as $elm) {
	  $result = $result . '<option data-img-label="'.$elm->getName().'" data-img-src="/'.$elm->get($this->data['main']).'" value="'.$elm->getId().'" '.((($data != "")&&(in_array($elm->get('id'),$imgsIds)))?"selected":"").'>'.$elm->getName().'</option>';
	}
	$result = $result . '</select>';
	return $result;
     }     
}

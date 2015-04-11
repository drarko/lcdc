<?php

namespace Annotations;

/** @Annotation */
class Gallery extends CustomAnnotation 
{
     public $type = "Gallery";
     public $limit = 0;
     
     public function renderList($data) 
     {
	$imgs = $data->toArray();
	$result = "";
	foreach($imgs as $i) {
	  $result = $result . '<a href="' . $i->get('filename') . '" rel="prettyPhoto"><img class="img-thumbnail maxsize" width="140" height="140" src="' . $i->get('filename') . '"></img></a>';
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
	  $result = '<select name="'.$property.'[]" class="gallery image-picker show-html masonry"><option value=""></option>';
	} else {
	  $result = '<select name="'.$property.'[]" multiple="multiple" class="gallery image-picker show-html masonry"><option value=""></option>';
	}
	if($data != "") {
	foreach($imgs as $elm) {
	  $result = $result . '<option data-img-label="'.$elm->getName().'" data-img-src="'.$elm->get($this->data['main']).'" value="'.$elm->getId().'" '.((($data != "")&&(in_array($elm->get('id'),$imgsIds)))?"selected":"").'>'.$elm->getName().'</option>';
	}
	}
	$result = $result . '</select>';
	return $result;
     }     
}

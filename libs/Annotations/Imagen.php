<?php

namespace Annotations;

/** @Annotation */
class Imagen extends CustomAnnotation 
{
     public $type = "Imagen";

     public function renderList($data) 
     {
	return '<a href="/' . $data . '" rel="prettyPhoto"><img class="img-thumbnail maxsize" width="140" height="140" src="/' . $data . '"></img></a>';
     }
     
     public function renderForm($data, $property) 
     {
	$result = '<input type="file" name="'. $property .'" accept="image/jpeg, image/jpg, image/png" />';
	if($data != "") {
	  $result = '<a href="/' . $data . '" rel="prettyPhoto"><img class="img-thumbnail maxsize" width="140" height="140" src="/' . $data . '"></img></a><br/><br/>' . $result;
	}
	return '<div style="text-align:left">'.$result.'</div>';

     }     
}
<?php

namespace Annotations;

/** @Annotation */
class Date extends CustomAnnotation 
{
     public $type = "Date";

     public function renderList($data) 
     {
	$data = $data->format("d/m/Y");
	if($data == "30/11/-0001") $data = "";
	if($data == "30/11/-0001") $data = "";     
	if($data == "31/12/1969") $data = "";
	if($data == "01/01/1970") $data = "";	
	return $data;
     }
     
     public function renderForm($data, $property) 
     {
	if($data == "") return '<input class="datepicker" type="text" name="' . $property . '" value=""></input>';
	$data = $data->format("d/m/Y");
	if($data == "30/11/-0001") $data = "";     
	if($data == "31/12/1969") $data = "";
	if($data == "01/01/1970") $data = "";
	return '<input class="datepicker" type="text" name="' . $property . '" value="'. $data .'"></input>';
     }     
}
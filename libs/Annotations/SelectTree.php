<?php

namespace Annotations;

/** @Annotation */
class SelectTree extends CustomAnnotation 
{
     public $type = "SelectTree";

     public function renderList($data) 
     {
	if($data == null) return "";
	return $data->renderEntity();
     }
     
     public function renderForm($data, $property) 
     { 
	  $categorias = $this->data['list'];
	  $arbol = array();
	  foreach($categorias as $cat) {
	    if($cat->getPadre() == null) {
	      $arbol[$cat->getName()]['datos'] = $cat;
	    }
	  }
	  foreach($categorias as $cat) {
	    if($cat->getPadre() != null) {
	      $arbol[$cat->getPadre()->getName()]['subcat'][] = $cat;
	    }
	  }	  

	
	$select = '<select name="'. $property .'"><option value="0">-- Seleccione --</option>';
	foreach($arbol as $key => $value) {
		$select = $select . '<optgroup label="' . $key . '">';
		if(isset($value['subcat'])) {
			foreach($value['subcat'] as $elm) {
			  $select = $select . '<option value="'. $elm->get('id') .'" '. ((($data != "")&&($data->getId() == $elm->get('id')))?"selected":"") .'>'. $elm->get($this->data['main']) .'</option>';
			}
		}
		$select = $select . '</optgroup>';
	}
	$select = $select . '</select>';
	return $select;
     }     
}
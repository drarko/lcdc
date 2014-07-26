<?php

namespace Annotations;

/** @Annotation */
class Filter extends CustomAnnotation 
{
     public $type = "Filter";
     public $filter;
     public $field;
     public $value;

     public function getResults($repository)
     {
	switch($this->filter) {
	  case "notnull":
	    return $repository->findByNot(array($this->field => NULL));
	    break;
	  case "null":
	    return $repository->findBy(array($this->field => NULL));
	    break;
	  default:
	    return $repository->findAll();
	}
     }
}
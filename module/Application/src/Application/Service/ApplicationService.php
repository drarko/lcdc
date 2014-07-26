<?php

namespace Application\Service;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\ArrayCollection;

use Service\Entity;

class ApplicationService extends Entity
{
    public $reader;
    public $annotationService;
    public $entity;
    
    public function init()
    {
      $this->reader = new AnnotationReader();
      $this->annotationService = $this->sm->get('Annotations\Service');
    }

    public function getBlogList()
    {
	  $secciones = $this->getBlogSecciones();
	  $notas = array();
	  foreach($secciones as $secc) {
	    $notas[$secc->getName()] = $this->em->getRepository('Entities\Nota')->findBy(array("seccion" => $secc), array('fecha' => 'DESC'));
	  }
	  return $notas;
    }
    
    public function getBlogSecciones()
    {
	  return $this->em->getRepository('Entities\Tipo')->findAll();
    }
    
    public function getNota($id)
    {
          return $this->em->getRepository('Entities\Nota')->findOneById($id);
    }
    public function getContent()
    {
	  return null;
    }
    
    public function getCategorias()
    {
	  $categorias = $this->em->getRepository('Entities\Categoria')->findAll();
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

	  return $arbol;
    }
    
    public function getProductos($cat)
    {
	$cat = $this->em->getRepository('Entities\Categoria')->findOneById($cat);
	if($cat != null) {
	    return $this->em->getRepository('Entities\Producto')->findByCategoria($cat);
	}
	return $this->em->getRepository('Entities\Producto')->findBy(array("destacado" => true));
    }

    public function getProducto($id)
    {
	return $this->em->getRepository('Entities\Producto')->findOneById($id);
    }    
} 

 

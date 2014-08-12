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
	    $result1 = $this->em->getRepository('Entities\Producto')->findByCategoria($cat);
	    $cats = $this->em->getRepository('Entities\Categoria')->findOneByPadre($cat);
	    $result2 = $this->em->getRepository('Entities\Producto')->findBy(array("destacado" => true, "categoria" => array($cats)));
	    $result = $result1;
	    foreach($result2 as $res2) {
	      $insert = true;
	      foreach($result as $res) {
		if($res->getId() == $res2->getId()) {
		   $insert = false;
		}
	      }
	      if($insert) $result[] = $res2;
	    }
	    return $result;
	}
	return $this->em->getRepository('Entities\Producto')->findBy(array("destacado" => true));
    }
    public function getConfig($name)
    {
      return $this->em->getRepository('Entities\Config')->findOneByName($name);
    }
    
    public function getProducto($id)
    {
	return $this->em->getRepository('Entities\Producto')->findOneById($id);
    }    
    
    public function getSlider($name)
    {
	return $this->em->getRepository('Entities\Slider')->findOneByName($name);
    }
    
    public function getBanner($tipo)
    {
	$tipo = $this->em->getRepository('Entities\BannerTipo')->findOneByName($tipo);
	$result = $this->em->getRepository('Entities\Banner')->findByTipo($tipo);
	if(!is_array($result)) return array($result);
	return $result;
    }
    
    public function buscar($term,$order)
    {
      $term = str_replace("_"," ",$term);
      
      switch($order){
	case 1:
	  $orderBy = array("destacado" => "DESC");
	break;
	case 2:
	  $orderBy = array("precio" => "ASC");
	break;
	case 3:
	  $orderBy = array("precio" => "DESC");
	break;
      }
      
      $productos1 = $this->em->getRepository('Entities\Producto')->findLikeBy(array("name" => $term),$orderBy);
      $productos2 = $this->em->getRepository('Entities\Producto')->findLikeBy(array("autor" => $term),$orderBy);
      $productos3 = $this->em->getRepository('Entities\Producto')->findLikeBy(array("desc" => $term),$orderBy);

      $notas1 = $this->em->getRepository('Entities\Nota')->findLikeBy(array("title" => $term));
      $notas2 = $this->em->getRepository('Entities\Nota')->findLikeBy(array("resumen" => $term));
      $notas3 = $this->em->getRepository('Entities\Nota')->findLikeBy(array("content" => $term));

      $productos = array();
      $notas = array();

      for($i=1;$i<4;$i++) {
	$name = "productos".$i;
	foreach($$name as $prod) {
	  if(!in_array($prod->getId(),array_keys($productos))) {
	    $productos[$prod->getId()] = $prod;
	  }
	}
	$name = "notas".$i;
	foreach($$name as $nota) {
	  if(!in_array($nota->getId(),array_keys($notas))) {
	    $notas[$nota->getId()] = $nota;
	  }
	}      
      }
      
      return array("productos" => $productos, "notas" => $notas);
    }
} 

 

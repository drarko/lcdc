<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Controller\ControllerPublic;

class IndexController extends ControllerPublic
{
    public $slug;
    public $id;
    
    public function init() 
    {
      parent::init();
      $this->slug     = $this->params()->fromRoute('slug');    
      $this->layout()->setVariable('slug',$this->slug);
    }
    
    public function indexAction()
    {
	$this->view->setVariable('bann01',$this->service->getBanner('HOME-01'));
	$this->view->setVariable('bann02',$this->service->getBanner('HOME-02'));
	$this->view->setVariable('bann03',$this->service->getBanner('HOME-03'));
	$this->view->setVariable('slider',$this->service->getBanner('HOME-SLIDER'));
	$this->view->setVariable('categorias',$this->service->getCategorias());
	return $this->view;
    }
    
    public function infoAction()
    {
      $this->id = $this->params()->fromRoute('id');
	if(in_array($this->slug,array("blog","nota","catalogo","local","producto"))) {
	  return $this->forward()->dispatch('Application\Controller\Index', array('action' => $this->slug, 'slug' => $this->slug, 'id' => $this->id));
	} else if(in_array($this->slug,array("auth"))) {
	  return $this->forward()->dispatch('Auth\Controller\Login', array('action' => "login"));
	} else {
	  return $this->redirect()->toUrl('/')->setStatusCode('301');
	}
    }
    
    public function productoAction()
    {
      $this->view->setVariable('prod',$this->service->getProducto($this->id));
      $this->view->setTerminal(true);
      $this->view->setTemplate('application/index/producto.phtml');
      return $this->view;
    }
    public function catalogoAction()
    {
      $this->view->setVariable('catid',$this->id);
      $this->view->setVariable('categorias',$this->service->getCategorias());
      $this->view->setVariable('productos', $this->service->getProductos($this->id));
      $this->view->setTemplate('application/index/catalogo.phtml');
      return $this->view;
    }
    
    public function blogAction()
    {
      $blog = $this->service->getBlogList();
      $this->view->setVariable('banner',$this->service->getBanner('BLOG'));
      $this->view->setVariable('notas',$blog);
      $this->view->setTemplate('application/index/blog.phtml');
      return $this->view;      
    }
    
    public function notaAction()
    {
      $nota = $this->service->getNota($this->id);
      $secc= $this->service->getBlogSecciones();
      
      $this->view->setVariable('secc',$secc);      
      $this->view->setVariable('nota',$nota);
      $this->view->setTemplate('application/index/nota.phtml');
      return $this->view;      
    }

    public function localAction()
    {
      $this->view->setVariable('contacto',$this->service->getConfig('contacto'));
      $this->view->setVariable('email',$this->service->getConfig('email'));
      $this->view->setVariable('horario',$this->service->getConfig('horario'));
      $this->view->setVariable('transporte',$this->service->getConfig('transporte'));
      $this->view->setTemplate('application/index/local.phtml');
      return $this->view;      
    }

    public function buscarAction()
    {
      $this->view->setVariable('sin_resultados',false);
      $this->view->setVariable('term_vacio',false);
      $term = $this->params()->fromRoute('term');
      if($term != "") {
	$this->view->setVariable('term',$term);
	$result = $this->service->buscar($term);
	if(count($result) != 0) {
	  $this->view->setVariable('resultados',$result);
	  return $this->view;
	}
	$this->view->setVariable('resultados',array());
	$this->view->setVariable('sin_resultados',true);
      }
      $this->view->setVariable('resultados',array());
      $this->view->setVariable('term_vacio',true);
      return $this->view;
    }
}

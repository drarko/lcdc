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

    }
    
    public function infoAction()
    {
      $this->id = $this->params()->fromRoute('id');
      $item = $this->service->getContent($this->slug);
      if($item != null) {
	$this->view->setVariable('html' , $item->getContent());
	$this->view->setTemplate('application/index/info.phtml');
	return $this->view;
      } else {
	if(in_array($this->slug,array("blog","nota","catalogo","local","producto"))) {
	  return $this->forward()->dispatch('Application\Controller\Index', array('action' => $this->slug, 'slug' => $this->slug, 'id' => $this->id));
	} else {
	  return $this->redirect()->toRoute('/index')->setStatusCode('301');
	}
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

}

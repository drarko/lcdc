<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Controller\ControllerPublic;

class IndexController extends ControllerPublic
{
    public $menu;
    
    public $table;
    public $action;
    public $id;
    
    public function init()
    {
      parent::init();
      $this->layout()->setVariable('menu',$this->service->getMenu());
      
      $this->table  = $this->params()->fromRoute('table');
      $this->action = $this->params()->fromRoute('act');
      $this->id     = $this->params()->fromRoute('id');      
      
      $this->view->setVariable('table',$this->table);
    }
    
    public function indexAction()
    {
      if($this->table != '') {
	$this->service->setEntity($this->table);
	//try {
	  switch($this->action) {
	    case '':
	      $this->listAction();
	      break;
	    case "delete":
	      $this->deleteAction();
	      break;
	    case "update":
	      $this->updateAction();
	      break;
	    case "create":
	      $this->createAction();
	      break;
	    case "view":
	      $this->viewAction();
	      break;	      
	  }
	//} catch(\Exception $e) {	}
      }
      return $this->view;
    }
    
    public function listAction()
    {
      $list = $this->service->getList();
      $cols = $this->service->getColumnInfo();
      
      $this->view->setVariable('list',$list);
      $this->view->setVariable('cols',$cols);
      
      $this->view->setTemplate('admin/index/list.phtml');
      return;
    }
    
    public function deleteAction()
    {
      if($this->getRequest()->isPost()) {
	if($this->id == $this->getRequest()->getPost()->get('itemid')) {
	    $this->service->deleteItem($this->id);
	}
	return $this->redirect()->toUrl('/admin/'.$this->table)->setStatusCode('301');
      }
      
      $this->view->setVariable('itemid' , $this->id);
      
      $item = $this->service->getItem($this->id);
      $cols = $this->service->getColumnInfo();
      
      $this->view->setVariable('item', $item);
      $this->view->setVariable('cols',$cols);
      
      $this->view->setTemplate('admin/index/delete.phtml');
      return;
    }
    
    public function updateAction()
    {
      if($this->getRequest()->isPost()) {
	if($this->id == $this->getRequest()->getPost()->get('itemid')) {
	  $post = $this->getRequest()->getPost();
	  $files = $this->getRequest()->getFiles();
	  
	  $this->service->updateItem($post,$files);
	}
	return $this->redirect()->toUrl('/admin/'.$this->table)->setStatusCode('301');
      }
      
      $item = $this->service->getItem($this->id);
      $cols = $this->service->getColumnInfo();
      
      $this->view->setVariable('itemid' , $this->id);
      $this->view->setVariable('item', $item);
      $this->view->setVariable('cols',$cols);
      
      $this->view->setTemplate('admin/index/edit.phtml');
      return;
    }
    
    public function createAction()
    {
      if($this->getRequest()->isPost()) {
	$post = $this->getRequest()->getPost();
	$files = $this->getRequest()->getFiles();

	$this->service->newItem($post,$files);
	return $this->redirect()->toUrl('/admin/'.$this->table)->setStatusCode('301');
      }
      
      $cols = $this->service->getColumnInfo();
      $this->view->setVariable('cols',$cols);
      
      $this->view->setTemplate('admin/index/create.phtml');
      return;
    }
    
    public function viewAction()
    {      
      $this->view->setVariable('itemid' , $this->id);
      
      $item = $this->service->getItem($this->id);
      $cols = $this->service->getColumnInfo();
      
      $this->view->setVariable('item', $item);
      $this->view->setVariable('cols',$cols);
      
      $this->view->setTemplate('admin/index/view.phtml');
      $this->view->setTerminal(true);
      return;
    }    
}

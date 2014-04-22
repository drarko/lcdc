<?php

namespace Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\EventManager\EventManagerInterface;

class ControllerBase extends AbstractActionController
{

      public $view;
      public $identity;
      public $user;
      
      
      public function __construct()
      {

	$this->view = new ViewModel();
	return $this;
      }
      
      
      public function init()
      {
	  $this->getIdentity();
	  
	  $this->view->messages = $this->flashmessenger()->getMessages();

      }
      
      public function ajaxAction() {

	  $this->view->setTerminal(true);
	  return $this->view;
      }
      
      public function getIdentity()
      {
	if($this->getServiceLocator()->get('AuthService')->hasIdentity())
	{
	      $this->identity = $this->getServiceLocator()->get('AuthService')->getIdentity();
	      $this->view->identity = $this->identity;

	      $this->user = $this->identity;

        }else
        {
	      $this->identity = FALSE;
	      $this->view->identity = FALSE;
	      $this->user = FALSE;
	
        }
	return $this->identity;
      }      

      
    public function registerEvents(Zend\EventManager\EventManagerInterface $events)
    {
        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
	    $controller->init();
        }, 100); // execute before executing action logic
    }      
}

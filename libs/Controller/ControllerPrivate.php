<?php

namespace Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ControllerPrivate extends ControllerBase
{

    public function init()
    {
    
	parent::init();

	if($this->identity === FALSE)
	{
	  
	    $this->flashmessenger()->addMessage("Debes ingresar al sistema");
	    return $this->redirect()->toUrl("/auth");
	
	}

    }
    
}
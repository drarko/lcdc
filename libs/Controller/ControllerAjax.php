<?php

namespace Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class ControllerAjax extends ControllerBase
{

    public function init()
    {
    
	parent::init();

	$this->ajaxAction();
	
    }
    
}
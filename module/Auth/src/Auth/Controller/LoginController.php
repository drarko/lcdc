<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Auth\Form\LoginForm;

use Controller\ControllerPublic;


class LoginController extends ControllerPublic
{
    protected $form;
    protected $storage;
    protected $authservice;
    
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        
        return $this->authservice;
    }
    
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()->get('Auth\Model\MyAuthStorage');
        }
        
        return $this->storage;
    }
    
    public function getForm()
    {
        if (! $this->form) {
            $user       = new LoginForm();
            $this->form = $user;
        }
        
        return $this->form;
    }
    
    public function loginAction()
    {
    
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){

	      $route = "/auth/login/success";
              if($this->request->getHeaders()->has("referer"))
              {
		$route = $this->request->getHeaders()->get("referer")->uri()->getPath();      
              }
              $uri = $this->getRequest()->getUri()->getPath();
              if($uri == $route)
              {
		$route = "/";
	      }
	      return $this->redirect()->toUrl($route);

        }
                
        $form       = $this->getForm();
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))
                                       ->setCredential($request->getPost('password'));
                                       
                $result = $this->getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }

                if ($result->isValid()) {
                    //check if it has rememberMe :
                    if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //set storage again 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }
                    
                    $this->getAuthService()->getStorage()->write($result->getIdentity());
                    
                    $route = "/auth/login/success";
                    if($this->request->getHeaders()->has("referer"))
                    {
		      $route = $this->request->getHeaders()->get("referer")->uri()->getPath();      
                    }
              $uri = $this->getRequest()->getUri()->getPath();
              if($uri == $route)
              {
		$route = "/";
	      }		    
                    return $this->redirect()->toUrl($route);
                }
            }
        }
       
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
    
    
    public function logoutAction()
    {
        $this->getSessionStorage()->forgetMe();
        $this->getAuthService()->clearIdentity();
        
        $this->flashmessenger()->addMessage("You've been logged out");

        $route = "/auth/login/login";
        if($this->request->getHeaders()->has("referer"))
        {
	  $route = $this->request->getHeaders()->get("referer")->uri()->getPath();      
        }
              $uri = $this->getRequest()->getUri()->getPath();
              if($uri == $route)
              {
		$route = "/";
	      }        
	return $this->redirect()->toUrl($route);
    }
    
    public function successAction()
    {
        return $this->redirect()->toUrl('/');
    }
}
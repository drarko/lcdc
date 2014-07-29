<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;
use Auth\Form\LoginForm;
use Auth\Form\ChangepassForm;

use Controller\ControllerPublic;


class LoginController extends ControllerPublic
{
    protected $form;
    protected $form2;
    protected $storage;
    protected $authservice;
    
    public function init()
    {
      parent::init();
      $this->layout()->setVariable('menu',array());
    }
    
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
    
    public function getForm2()
    {
        if (! $this->form2) {
            $user       = new ChangepassForm();
            $this->form2 = $user;
        }
        
        return $this->form2;
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
		$route = "/admin";
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
                    
                    $this->getAuthService()->getStorage()->write($result->getIdentity());
                    
                    $route = "/auth/login/success";
                    if($this->request->getHeaders()->has("referer"))
                    {
		      $route = $this->request->getHeaders()->get("referer")->uri()->getPath();      
                    }
              $uri = $this->getRequest()->getUri()->getPath();
              if($uri == $route)
              {
		$route = "/admin";
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
    
    public function changepassAction()
    {
        //if already login, redirect to success page 
        if (!$this->getAuthService()->hasIdentity()){

	      $route = "/auth/login/login";
	      return $this->redirect()->toUrl($route);

        }
        $this->layout()->setVariable('menu',$this->getServiceLocator()->get('Admin\Service')->getMenu());
        
        $form       = $this->getForm2();
        
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
		if($this->identity->getClave() == sha1($request->getPost('oldpass'))) {
		  if($request->getPost('password') == $request->getPost('password2')) {
		     $entity = $this->getServiceLocator()->get('Service\Entity');
		     $user = $entity->getEntityManager()->getRepository('Entities\Usuario')->findOneByUsuario($this->identity->getUsuario());
		     $user->setClave(sha1($request->getPost('password')));
		     $entity->getEntityManager()->persist($user);
		     $entity->getEntityManager()->flush();
		     $route = "/auth/login/logout";
		     return $this->redirect()->toUrl($route);		    
		   } else {
       		    $route = "/auth/login/changepass";
 		    return $this->redirect()->toUrl($route);		    		   
		   }
		} else {
		    $route = "/auth/login/changepass";
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
        return $this->redirect()->toUrl('/admin');
    }
}
<?php

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\View\Model\ViewModel;

use Auth\Form\LoginForm;

class FacebookController extends AbstractActionController
{
    protected $form;
    protected $storage;
    protected $authservice;

    
    public function callbackAction()
    {

    //$me = $this->getServiceLocator()->get('ReverseOAuth2\Google');
    //$me = $this->getServiceLocator()->get('ReverseOAuth2\Github');
    $me = $this->getServiceLocator()->get('ReverseOAuth2\Facebook');

    if (strlen($this->params()->fromQuery('code')) > 10) {

        if($me->getToken($this->request)) {
            $token = $me->getSessionToken(); // token in session
        } else {
            $token = $me->getError(); // last returned error (array)
        }

        $info = $me->getInfo();

    } else {

        $url = $me->getUrl();

    }
    print_r(array('token' => $token, 'info' => $info, 'url' => $url));
    return $this->response;

    
    
    
    }
    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthServiceFacebook');
        }
        
        return $this->authservice;
    }
    public function getAuthServiceStd()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService');
        }
        
        return $this->authservice;
    }    
    public function getSessionStorage()
    {
        if (! $this->storage) {
            $this->storage = $this->getServiceLocator()
                                  ->get('Auth\Model\MyAuthStorage');
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
        $a = $this->getServiceLocator()->get('facebookConnect');
    var_dump($a->getUserData());die();
    /*
    $me = $this->getServiceLocator()->get('ReverseOAuth2\Facebook');

    $auth = new \Zend\Authentication\AuthenticationService(); // zend

    if (strlen($this->params()->fromQuery('code')) > 10) {

        if($me->getToken($this->request)) { // if getToken is true, the user has authenticated successfully by the provider, not yet by us.
            $token = $me->getSessionToken(); // token in session
        } else {
            $token = $me->getError(); // last returned error (array)
        }

        $adapter = $this->getServiceLocator()->get('ReverseOAuth2\Auth\Adapter'); // added in module.config.php
        $adapter->setOAuth2Client($me); // $me is the oauth2 client
        $rs = $auth->authenticate($adapter); // provides an eventManager 'oauth2.success'

        if (!$rs->isValid()) {
            foreach ($rs->getMessages() as $message) {
                echo "$message\n";
            }
            echo 'no valid';
        } else {

            $this->getAuthService()->setStorage($this->getSessionStorage());
	    //$row = $this->getAuthService()->getAdapter()->getResultRowObject(array('id_usuario'));        
            //$this->getAuthService()->getStorage()->write($row->id_usuario);   
            
            $user = $this->getServiceLocator()->get("Usuarios/Model/Usuario");
            
            $fuser = $rs->getIdentity();
            
            $registrado = $user->facebookUser($fuser['id']);
            
            if($registrado instanceof \Usuarios\Model\Usuario)
            {
	      $this->getAuthServiceStd()->getStorage()->write($registrado->id);
	      $this->flashmessenger()->addMessage("Ingresaste exitosamente.");
	      return $this->redirect()->toUrl('/');        
            }else
            {   
		if ($this->getAuthServiceStd()->hasIdentity()){

		      $user->crearUsuario($this->getAuthService()->getIdentity());
		      $user->asociarFacebook($fuser['id']);
		      $this->flashmessenger()->addMessage("Has asociado tu cuenta de Facebook al sitio.");
		      return $this->redirect()->toUrl('/'); 

		}	            
	  
               $config = $this->getServiceLocator()->get('Config');
	       $facebook = new \Facebook(array('appId' => $config['reverseoauth2']['facebook']['client_id'], 'secret' => $config['reverseoauth2']['facebook']['client_secret']));

	       $result = $facebook->api('/'.$fuser['id'],'GET',array('access_token'=> $config['reverseoauth2']['facebook']['client_token']));
	       
	       
	       $id_nuevo_usuario = $user->nuevoUsuarioFacebook($result['email'],$result['id']);
	       
	       $form = $this->getServiceLocator()->get('Usuarios/Form/RegistroForm');
	       
	       $form->setData(array('usuario' => $result['username'], 'email' => $result['email'], 'email2' => $result['email']));
	       
	       return array('form' => $form, 'messages'  => $this->flashmessenger()->getMessages(), 'id' => $id_nuevo_usuario);
               
            }
        }

    } else {
        $url = $me->getUrl();
	return $this->redirect()->toUrl($url);        
    }

    return $this->response;
*/
    }
    public function registrarAction()
    {
     
	$form = $this->getServiceLocator()->get('Usuarios/Form/RegistroForm');
	$u = $this->getServiceLocator()->get('Usuarios/Model/Usuario');
            
        $request = $this->getRequest();
        if ($request->isPost()) {
       
            $post = $request->getPost();
            $form->setData($request->getPost());

            if ($form->isValid()) {
            
                
                $data = $form->getData();
                $u->actualizarUsuario($post->usuario_id,$data['usuario'],$data['clave'], $data['email']);
                return $this->redirect()->toUrl('/auth/facebook');
            }

   
            
        
	    return array('form' => $form, 'messages'  => $this->flashmessenger()->getMessages(), 'id' => $post->usuario_id);
        }
       
        return $this->response;
  
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
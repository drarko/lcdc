<?php
namespace Auth\Form;

use Zend\Form\Form;
use Zend\Form\Decorator;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class LoginForm extends Form 
{


    public function __construct($name = null)
    {
	
        // we want to ignore the name passed
        parent::__construct('login');
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Nombre de Usuario: ',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Contraseña: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Ingresar !',
                'id' => 'submitbutton',
            ),
        ));
           

            $inputFilter = new InputFilter();
            $factory     = new InputFactory();	 
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'username',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            

	$this->setInputFilter($inputFilter);
        
    }
    
    
   
} 

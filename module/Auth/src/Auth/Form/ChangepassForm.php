<?php
namespace Auth\Form;

use Zend\Form\Form;
use Zend\Form\Decorator;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class ChangepassForm extends Form 
{


    public function __construct($name = null)
    {
	
        // we want to ignore the name passed
        parent::__construct('changepass');
        
        $this->add(array(
            'name' => 'oldpass',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Clave actual: ',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Nueva clave: ',
            ),
        ));
        
        $this->add(array(
            'name' => 'password2',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Repita nueva clave: ',
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
                'name'     => 'oldpass',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'password2',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));            

	$this->setInputFilter($inputFilter);
        
    }
    
    
   
} 

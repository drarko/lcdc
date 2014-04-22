<?php

namespace Entities;

class Entity {

    public function __get($property)
    {
        // If a method exists to get the property call it.
        if(method_exists($this, 'get' . ucfirst($property)))
        {
            // This will call $this->getCoffee() while getting $this->coffee
            return call_user_func(array($this, 'get' . ucfirst($property)));
        }
        else
        {
            return $this->$property;
        }
    }
    
    public function __set($property, $value)
    {
        // If a method exists to set the property call it.
        if(method_exists($this, 'set' . ucfirst($property)))
        {
            // This will call $this->setCoffee($value) while setting $this->coffee
            return call_user_func(array($this, 'set' . ucfirst($property)), $value);
        }
        else
        {
            $this->$property = $value;
        }
    }
}

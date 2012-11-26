<?php

abstract class My_Model_Abstract
{
  public function __construct($options = null)
  {
    $this->setOptions($options);
  }

  public function setOptions($options)
  {
    if($options === null)
      return;

    if(is_object($options) || is_array($options))
    {
      foreach($options as $key => $value)
      {
        $this->_setField($key, $value);
      }
    } else {
      throw new Exception(get_class($this).': had an issue in setOptions:'.$key);
    }
  }

  protected function _setField($key, $value = null)
  {
    if(!$value)
      return;

    if(property_exists(get_class($this), $key))
    {
      //See if there is a setter
      $method = 'set' . ucfirst($value);
      if(method_exists(get_class($this), $method))
      {
        call_user_func(array($this, $method), $value);
        return;
      } 

      $this->$key = $value;
    }
  }
}

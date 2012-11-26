<?php

class My_Service_Acl extends My_Service_User implements Zend_Acl_Resource_Interface
{
  protected $_acl;
  
  abstract public function setAcl(Zend_Acl $acl);

  public function getAcl()
  {
    if($_acl === null)
    {
      $this->setAcl(new My_Acl());
    }

    return $this->_acl;
  }

  public function checkAcl($action)
  {
    return $this->getAcl()->isAllowed($this->getCurrentUser(), $this, $action
  }
}

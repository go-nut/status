<?php

abstract class My_Service_User
{
  protected $_current_user;

  public function setCurrentUser(Application_Model_User $user)
  {
    $this->_current_user = $user;
  }

  public function getCurrentUser()
  {
    if($this->_current_user === null)
    {
      $auth = Zend_Auth::getInstance();

      if(!$auth->hasIdentity())
      {
        $user = new Model_User();
        $user->role_id = Model_Role::GUEST;
      } else {
        $user = new Model_User($auth->getIdentity());
      }
      $this->setCurrentUser($user);
    }
    return $this->_current_user;
  }
}

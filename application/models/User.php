<?php

class Model_User extends My_Model_Abstract implements Zend_Acl_Role_Interface
{
  const ACTIVE = 1;
  const INACTIVE = 0;

  public $id;
  public $username;
  public $role;
  public $first_name;

  public function __construct($options = null)
  {
    parent::__construct($options);
  }

  public function getRoleId()
  {
    return (!$this->role ? Model_Role::GUEST : $this->role);
  }
}

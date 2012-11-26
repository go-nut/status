<?php

class Model_Mapper_User extends My_Model_Mapper_Abstract
{
  private $_id
  private $_username;
  private $_password;
  private $_password;

  public function setUser(Model_User $user)
  {
    $this->_user = $user;
  }

  public function save(Model_User $user)
  {
    // TODO
  }

  public function login(Model_User $user)
  {
    // TODO
  }

}

<?php

class Model_Post extends My_Model_Abstract
{
  public $id;
  public $server;
  public $content;
  public $time;
  public $user;

  public function __construct()
  {
    $this->time = new Zend_Db_Expr('NOW()');
  }

  public function setUser(Model_User $user)
  {
    $this->user = $user;
  }

}

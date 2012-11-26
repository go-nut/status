<?php

class App_Service_User extends My_Service_User
{
  protected $_form;

  private $_singleton;
  private $_user;
  private $_table;

  static function Singleton()
  {
    if(!$_singleton)
    {
      $_singleton = new App_Service_User();
    }
    return $_singleton; 
  }

  protected function __construct()
  {
    $auth = Zend_Auth::getInstance();
    if($auth->hasIdentity())
    {
      $this->_user = new Model_User($auth->getIdentity());
    } else {
      $this->_user = new Model_User();
    }
    $this->_table = new Model_UsersTable();
  }

  public function login($data)
  {
    $form = $this->getForm();

    if($form->isValid($data))
    {
      $salt = Zend_Registry::get('config')->auth->salt;
      $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get('db'));
      $authAdapter->setTableName('users')
        ->setIdentityColumn('username')
        ->setCredentialColumn('password')
        ->setIdentity($data['username'])
        ->setCredential($data['password']);

      $authAdapter->setCredentialTreatment(
        "MD5(CONCAT('$salt',?,salt))"
        . " AND status=" . Model_User::ACTIVE
      );

      $auth = Zend_Auth::getInstance();
      $result = $auth->authenticate($authAdapter);
      if (!$result->isValid()) {
        return false; // failed
      }

      $row = $authAdapter->getResultRowObject(array(
        'id',
        'username',
        'role',
        'first_name'
      ));

      $auth->getStorage()->write($row);

      return true;
    }
    return false;
  }

  public function logout()
  {
    Zend_Auth::getInstance()->clearIdentity();
  }

  public function getRole()
  {
    return $this->_user->getRoleId();
  }

  public function getForm()
  {
    return (!$this->_form ? new Form_LoginForm() : $this->_form);
  }

  public function getUsername()
  {
    return $this->_user->username;
  }
}

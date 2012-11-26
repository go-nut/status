<?php
class Form_UserForm extends Zend_Form
{
  public function init()
  {
   
    $this->setDisableLoadDefaultDecorators(true);
    $this->addDecorator('FormElements')
      ->addDecorator('Form')
      ->removeDecorator('Label');
    $this->setAction('/admin/create')
      ->setMethod('post');
      


    $username = $this->getTextElement('username', 'Username')
      ->addDecorator(array('control-group'=>'HtmlTag'), array('tag'=> 'div', 'class'=>'control-groups', 'openOnly'=>true));


    $fname = $this->getTextElement('first_name', 'First Name');

    $lname = $this->getTextElement('last_name', 'Last Name');

    $email = $this->getTextElement('email', 'Email');

    $password = $this->createElement('password', 'password');
    $password->setRequired(TRUE)
      ->setAttrib('size', 16)
      ->addFilter('StringTrim')
      ->setAttrib('class', 'field')
      ->setAttrib('id', 'inputPassword')
      ->setAttrib('placeholder', 'Password')
      ->setDecorators(array('ViewHelper'))
      ->addDecorator('HtmlTag', array('tag'=>'div', 'class'=>'controls', 'openOnly'=>false));

    $submit = $this->createElement('submit', 'add');
    $submit->setAttrib('class', 'btn btn-primary')
      ->setDecorators(array('ViewHelper'))
      ->addDecorator('HtmlTag', array('tag'=>'div', 'class'=>'controls', 'openOnly'=>false))
      ->addDecorator(array('close'=>'HtmlTag'), array('tag'=>'div', 'closeOnly'=>true));


    $this->addElement($username)
      ->addElement($fname)
      ->addElement($lname)
      ->addElement($email)
      ->addElement($password)
      ->addElement($submit);
  }

  public function persistData()
  {
    $values = $this->getValues();
    $table_salt = $this->genSalt();
    $salt = Zend_Registry::get('config')->auth->salt;
    $hash = md5(Zend_Registry::get('config')->auth->salt.$values['password'].$table_salt);
    $values['password'] = $hash;
    $values['role'] = 1;
    $values['salt'] = $table_salt;
    $table = new Model_UsersTable();
    $table->insert($values);
  }

  private function getTextElement($id, $placeholder)
  {
    $element = $this->createElement('text', $id);
    $element->setRequired(TRUE)
      ->setAttrib('size', 16)
      ->addFilter('StringTrim')
      ->setAttrib('class', 'field')
      ->setAttrib('placeholder', $placeholder)
      ->setDecorators(array('ViewHelper'))
      ->addDecorator('HtmlTag', array('tag'=>'div', 'class'=>'controls', 'openOnly'=>false));
    return $element;
  }

  private function genSalt()
  {
    mt_srand(microtime(true)*100000 + memory_get_usage(true));
    return substr(md5(uniqid(mt_rand(), true)), 0, 16);
  }
}

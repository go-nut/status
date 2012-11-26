<?php
class Form_LoginForm extends Zend_Form
{
  public function init()
  {
   
    $this->setDisableLoadDefaultDecorators(true);
    $this->addDecorator('FormElements')
      ->addDecorator('Form')
      ->setMethod('post')
      ->removeDecorator('Label');
    $this->setAction('/login')
      ->setMethod('post');
      


    $username = $this->createElement('text', 'username');
    $username->setRequired(TRUE)
      ->setAttrib('size', 16)
      ->addFilter('StringTrim')
      ->addValidator('StringLength', false, array(3, 16))
      ->addValidator('alnum')
      ->setAttrib('class', 'span2 input-small')
      ->setAttrib('placeholder', 'Username')
      ->setDecorators(array('ViewHelper'));

    $password = $this->createElement('password', 'password');
    $password->addFilter('StringTrim')
      ->addValidator('StringLength', false, array(6, 16))
      ->setRequired(true)
      ->setAttrib('class', 'span2')
      ->setAttrib('id', 'inputPassword')
      ->setAttrib('placeholder', 'Password')
      ->setDecorators(array('ViewHelper'));

    $submit = $this->createElement('submit', 'login');
    $submit->setAttrib('class', 'btn')
      ->setDecorators(array('ViewHelper'));

    $this->addElement($username)
      ->addElement($password)
      ->addElement($submit);

    $this->setAttrib('class', 'navbar-form pull-right');
  }
}

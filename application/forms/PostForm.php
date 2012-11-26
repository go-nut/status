<?php
class Form_PostForm extends Zend_Form
{
  public function init()
  {
   
    $this->setDisableLoadDefaultDecorators(true);
    $this->addDecorator('FormElements')
      ->addDecorator('Form')
      ->setMethod('post')
      ->removeDecorator('Label');
    $this->setAction('/admin/post')
      ->setMethod('post');
      


    $content = $this->createElement('textarea', 'content');
    $content->setRequired(TRUE)
      ->addFilter('StripTags')
      ->setAttrib('rows', 3)
      ->addFilter('StringTrim')
      ->setAttrib('class', 'field span12')
      ->setAttrib('placeholder', 'Enter New Status')
      ->setDecorators(array('ViewHelper'))
      ->addDecorator('HtmlTag', array('tag'=>'div', 'class'=>'controls', 'openOnly'=>false))
      ->addDecorator(array('control-group'=>'HtmlTag'), array('tag'=> 'div', 'class'=>'control-groups', 'openOnly'=>true));

    $submit = $this->createElement('submit', 'post');
    $submit->setAttrib('class', 'btn btn-primary')
      ->setDecorators(array('ViewHelper'))
      ->addDecorator('HtmlTag', array('tag'=>'div', 'class'=>'controls', 'openOnly'=>false))
      ->addDecorator(array('close'=>'HtmlTag'), array('tag'=>'div', 'closeOnly'=>true));

    $this->addElement($content)
      ->addElement($submit);
  }

  public function persistData()
  {
    $values = $this->getValues();
    $values['resource'] = 1;
    $values['user'] = 3;
    $values['time'] = new Zend_Db_Expr('NOW()');
    $table = new Model_PostsTable();
    $table->insert($values);
  }

}

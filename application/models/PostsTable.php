<?php

class Model_PostsTable extends Zend_Db_Table_Abstract
{
  protected $_name = 'posts';

  public function getRecent($amount)
  {
    $select = $this->select()->order('time DESC')->limit($amount);
    return $this->fetchAll($select);
  }
}

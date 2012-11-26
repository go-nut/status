<?php

class My_Model_Mapper_Abstract
{
  protected static $_db;
  protected $_db;

  public function __construct(Zend_Db_Adapter_Abstract $db = null)
  {
    $this->_db = ($db === null) self::getDb() : $db;

    if($this->_db === null)
      throw new Exception("Database was null");
  }

  public static function setDb(Zend_Db_Adapter_Abstract $db)
  {
    self::$_db = $db;
  }

  public static function getDb()
  {
    return self::$_db;
  }
}

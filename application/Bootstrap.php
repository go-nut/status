<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  protected function _initConfig()
  {
    $config = new Zend_Config($this->getOptions(), true);
    Zend_Registry::set('config', $config);
    return $config;
  }

  protected function _initRoutes()
  {
    $router = Zend_Controller_Front::getInstance()->getRouter();
    $route = new Zend_Controller_Router_Route (
      '/login',
      array('controller' => 'index',
      'action' => 'login')
    );
    $router->addRoute('/login', $route);

    $pages = new Zend_Controller_Router_Route(
      '/page/:pageid',
      array(
        'pageid' => 1,
        'controller' => 'index',
        'action' => 'index'
      ),
      array('pageid' => '\d+')
    );
    $router->addRoute('/page', $pages);
    $delete = new Zend_Controller_Router_Route(
      '/admin/delete/:id',
      array(
        'id' => 0,
        'controller' => 'admin',
        'action' => 'delete'
      ),
      array('pageid' => '\d+')
    );
    $router->addRoute('/admin/delete', $delete);

  }

  protected function _initRegisterPlugins()
  {
    $this->bootstrap('Frontcontroller')
      ->getResource('Frontcontroller')
      ->registerPlugin(new My_Controller_Plugin_Acl());
  }

  protected function _initHeadData()
  {
    $this->bootstrap('view');
    $view = $this->getResource('view');
    $view->doctype('XHTML1_STRICT');
    $view->headTitle('IMH Resource Status');
  }

  protected function _initNav()
  {
    $this->bootstrap('layout');
    $view = $this->getResource('layout')->getView();
    $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');

    $view->navigation(new Zend_Navigation($config));
  }

  protected function _initAutoload()
  {
    // Add autoloader empty namespace
    $autoLoader = Zend_Loader_Autoloader::getInstance();
    $autoLoader->registerNamespace('App_');
    $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
      'basePath' => APPLICATION_PATH,
      'namespace' => '',
      'resourceTypes' => array(
        'form' => array(
          'path' => 'forms/',
          'namespace' => 'Form_',
        ),
        'model' => array(
          'path' => 'models/',
          'namespace' => 'Model_'
        )
      ),
    ));
    // Return it so that it can be stored by the bootstrap
    return $autoLoader;
  }

  protected function _initAll() {
    $this->bootstrap('db');

    Zend_Registry::set('db', $this->getResource('db'));

    // Handle any custom routing here
  }



}


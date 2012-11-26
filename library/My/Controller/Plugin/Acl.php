<?php


class My_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{

  public function preDispatch(Zend_Controller_Request_Abstract $request)
  {
    $acl = new Zend_Acl();
    $acl->addRole(new Zend_Acl_Role(Model_Role::GUEST));
    $acl->addRole(new Zend_Acl_Role(Model_Role::ADMIN), Model_Role::GUEST);
    $acl->addResource(new Zend_Acl_Resource('admin'));
    $acl->addResource(new Zend_Acl_Resource('error'));
    $acl->addResource(new Zend_Acl_Resource('index'));

    $acl->allow(Model_Role::GUEST, 'error');
    $acl->allow(Model_Role::GUEST, 'index');

    $acl->allow(Model_Role::ADMIN, 'admin');

    $resource = $request->getControllerName();
    $privilege = $request->getActionName();
    $role = App_Service_User::Singleton()->getRole();

    if(!$acl->isAllowed($role, $resource, $privilege))
    {
      $this->_request->setControllerName('index')->setActionName('index');
      $this->_response->setRedirect('/');
    }
  }
}

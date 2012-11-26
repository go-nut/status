<?php

class IndexController extends Zend_Controller_Action
{

  protected $_serviceUser;

  public function init()
  {
  }

  public function indexAction()
  {
    $page = 1;
    if($this->getRequest()->getParam('pageid'))
    {
      $page = $this->getRequest()->getParam('pageid');
    }
    $table = new Model_PostsTable();
    $select = $table->select()->order('time DESC');
    $adapter = new Zend_Paginator_Adapter_DbTableSelect($select);
    $paginator = new Zend_Paginator($adapter);
    $paginator->setItemCountPerPage('3');
    $paginator->setCurrentPageNumber($page);
    $this->view->paginator = $paginator;
  }

  public function loginAction()
  {
    $request = $this->getRequest();

    if(!$request->isPost()) {
      return $this->_helper->redirector('index');
    }
    $form = new Form_LoginForm();
    if($form->isValid($request->getPost()))
      App_Service_User::Singleton()->login($request->getPost());

    $this->_helper->redirector('index', 'index');
    $this->_helper->viewRenderer->setNoRender();
  }

  public function logoutAction()
  {
    $this->_helper->viewRenderer->setNoRender();
    App_Service_User::Singleton()->logout();
    $this->_helper->redirector('index', 'index');
  }

  public function buildercreateAction()
  {
    $login = "admin";
    $options = array(
      'location' => 'http://builder.inmotionhosting.com/ServiceFacade/4.5',
      'uri' => 'http://builder.inmotionhosting.com/ServiceFacade/4.5'
    );
    $client = new Zend_Soap_Client('/AccountWebService.asmx?WSDL', $options);
    echo $client->getClassmap();
    $header = new SoapHeader('http://swsoft.com/webservices/sb/4.5/AccountService', 'CredentialsSoapHeader',
      new SoapVar(
        array(
          'Login' => $login,
          'Password' => $password,
        ),
        SOAP_ENC_OBJECT,
        'CredentialsSoapHeader',
        'http://swsoft.com/webservices/sb/4.5/AccountService'
      )
    );
    $client->resetSoapInputHeaders();
    $client->addSoapInputHeader($header, false);
    $struct = new stdClass();
    $struct->username = 'joepiestest';
    $struct->password = 'joepiestest';
    $struct->firstName = 'joepiestest';
    $struct->LastName = 'joepiestest';
    $struct->email = 'docs@inmotionhosting.com';
    $struct->role = 'SiteOwner';
    $struct->planId = '8';
    //$result = $client->CreateAccount(new Soapvar($struct, SOAP_ENC_OBJECT));
    //var_dump($result);
  }

}


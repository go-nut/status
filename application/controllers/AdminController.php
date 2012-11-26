<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function deleteAction()
    {
      $id = $this->getRequest()->getParam('id');
      if($id)
      {
        $table = new Model_PostsTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $id);
        $table->delete($where);
      }
      $this->_helper->redirector('index', 'index');
      $this->_helper->viewRenderer->setNoRender();
    }

    public function createAction()
    {
      $request = $this->getRequest();

      $form = new Form_UserForm();
      if($request->isPost()) 
      {
        if($form->isValid($request->getPost()))
        {
          $form->persistData();
        } 
      }
      $this->view->form = $form;
    }

    public function postAction()
    {
      $request = $this->getRequest();

      $form = new Form_PostForm();
      if($request->isPost()) 
      {
        if($form->isValid($request->getPost()))
        {
          $form->persistData();
        } 
      }
      $this->view->form = $form;
      $this->_helper->redirector('index', 'index');
      $this->_helper->viewRenderer->setNoRender();

    }
}


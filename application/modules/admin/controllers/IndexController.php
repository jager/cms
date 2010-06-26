<?php
class Admin_IndexController extends Webbers_Controller_Action {
	
	public function indexAction() {
		
		if ( !Zend_Auth::getInstance()->hasIdentity() ) {
			Zend_Layout::getMvcInstance	()->setLayout('login');
			$form = new Webbers_Form_Factory( 'login' );
			$this->view->form = $form->getForm();			
		} else {
			$this->_forward( 'dashboard' );
		}
		
	}
	
	public function loginAction() {		
		
		if ( ( ( $username = $this->_getParam( 'username') ) != null ) and
			 ( ( $password = $this->_getParam( 'password') ) != null )
		   ) {
			$result = Zend_Auth::getInstance()->authenticate( new Webbers_Auth_Adapter( $username, $password ) );
			if ( Zend_Auth::getInstance()->hasIdentity() ) {
				$this->_forward( 'dashboard' );
			} else {
				$this->view->msg = implode( '<br />', $result->getMessages() );
				$this->_forward( 'index' );
			}
		} else {
			$this->_redirect( '/admin' );
		}
	}
	
	public function logoutAction() {
		if ( Zend_Auth::getInstance()->hasIdentity() ) {
			Zend_Auth::getInstance()->clearIdentity();
		}
		$this->_redirect( '/admin' );
	}
	
	public function dashboardAction() {
		$this->view->message = 'Tablica ogłoszeń!';
		//echo(date('Y-m-d H:i:s'));
	}
}
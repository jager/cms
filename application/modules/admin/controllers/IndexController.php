<?php
class Admin_IndexController extends Webbers_Controller_Action {

        public function init() {
            parent::init();
            $this->_model = new Adminuser();
        }

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

        public function editAction() {
            if ( !Zend_Auth::getInstance()->hasIdentity() ) {
                $this->_redirect( '/admin' );
            }
            $id = (int)Zend_Auth::getInstance()->getIdentity()->id;
            $this->getRequest()->setParam( 'id', $id );
            $this->edit();
            $this->view->form->addElement( 'hidden', 'id');
            $this->view->form->getElement('id')->setValue( $id );
            $this->view->form->getElement('password')->setValue('');
            $this->view->form->getElement('repassword')->setValue('');            
            $this->view->aData = array(
                array( "key" => "Last Correct Login", "value" => Zend_Auth::getInstance()->getIdentity()->lastcorrectlogin ),
                array( "key" => "Last Faulty Login", "value"  => Zend_Auth::getInstance()->getIdentity()->lastfaultylogin ),
                array( "key" => "Amount of Sign in attempts", "value" => Zend_Auth::getInstance()->getIdentity()->loginamount ),
                array( "key" => "Date of account creation", "value" => Zend_Auth::getInstance()->getIdentity()->created ),
                array( "key" => "Date of last update", "value" => Zend_Auth::getInstance()->getIdentity()->edited )
            );

        }
}
<?php
class Webbers_Auth_Adapter implements Zend_Auth_Adapter_Interface {
	
	const NOT_FOUND_MSG 		= 'Account wasn\'t found';
	const WRONG_PASSWORD_MSG 	= 'Wrong password';
	const ERROR_AUTH			= 'Some error occured during authentication';
	
	private $adminUser;
	protected $username = '';
	protected $password = '';
	 
	public function __construct( $username, $password ) {
		$this->username = $username;
		$this->password = md5( $password );
	}
	
	public function authenticate() {
		try {			
			$this->adminUser = Adminuser::authenticate( $this->username, $this->password );
			return $this->createResult( Zend_Auth_Result::SUCCESS );
		} catch ( Exception $e ) {
			if ( $e->getMessage() == Adminuser::INVALID_PASSWORD ) {
				return $this->createResult( Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array( self::WRONG_PASSWORD_MSG ) );
			}
			
			if ( $e->getMessage() == Adminuser::INVALID_CREDENTIALS ) {
				return $this->createResult( Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, array( self::NOT_FOUND_MSG ) );
			}
			return $this->createResult( Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array( self::ERROR_AUTH ) );
		}
	}
	
	private function createResult( $code, $aMessages = array() ) {
		return new Zend_Auth_Result( $code, $this->adminUser, $aMessages );
	}
	
	
}
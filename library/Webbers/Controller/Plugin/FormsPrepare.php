<?php
class Webbers_Controller_Plugin_FormsPrepare extends Zend_Controller_Plugin_Abstract {
	
	
	public function preDispatch( Zend_Controller_Request_Abstract $request ) {
		self::setupFormsForAction( $request );
		self::setupFormsGeneral();
	}
	
/**
     * Method sets general configuration for forms up
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    private static function setupFormsGeneral() {
    	Webbers_Form_Factory::setCommonConfigFile( 'common.php' );
    	Webbers_Form_Factory::setDefaultFormClass( 'Webbers_Form' );
    }
    /**
     * Method sets configuration for forms used in current action up
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    private static function setupFormsForAction( Zend_Controller_Request_Abstract $request ) {
    	$module = $request->getModuleName();
        $file   = strtolower( $request->getControllerName() ) . '.php';        
        Webbers_Form_Factory::setConfigDirectory( CONFIG_PATH . DS . $module . DS . 'forms' . DS );
        try {
            Webbers_Form_Factory::setConfigFile( $file );
        } catch( Webbers_Form_Factory_Exception $e ) {
        	//self::$registry->log->err( $e );
        }
    }
}
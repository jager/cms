<?php
class Webbers_AccessBroker {
	
	private $isAuthorized = false;
	
	public function __construct( Zend_Controller_Request_Abstract $request ) {
		$moduleName 		= $request->getModuleName();
		$controllerName 	= $request->getControllerName();
		$actionName 		= $request->getActionName();
		$access 			= 'public';
		try {
			$access = $this->checkAccess( $moduleName, $controllerName, $actionName );
		} catch ( Exception $e ) {
			$access = 'public';
		}

		$this->isAuthorized = $this->auth( $access );
	}
	
	public function isAllowed() {
		return $this->isAuthorized;
	}
	
	private function auth( $access ) {
                if ( $access == 'public' ) {
			return true;
		}
		if ( Zend_Auth::getInstance()->hasIdentity() ) {
                    return true;
		} else {
                    return false;
		}
		
	}
	
	private function checkAccess( $module, $controller, $action, $params = array() ) {
		if ( ( $config = $this->getConfig() ) !== false) {
			if ( isset( $config->$module->$controller->$action->access ) ) {
                            return $config->$module->$controller->$action->access;
			} else if ( isset( $config->$module->$controller->access ) ) {
                            return $config->$module->$controller->access;
			} else if ( isset( $config->$module->access ) ) {
                            return $config->$module->access;
                        } else {
                            return 'public';
                        }
		} else {
			throw new Zend_Controller_Exception( 'No auth configuration!');
		}
	}
	
	private function getConfig() {
		$config = new Zend_Config_Ini( CONFIG_PATH . "/access.ini", APPLICATION_ENV );
		if ( $config instanceof Zend_Config_Ini ) {
			return $config;
		}
		return false;
	}
}
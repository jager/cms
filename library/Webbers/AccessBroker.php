<?php
class Webbers_AccessBroker {
	
	private $isAuthorized = false;
        private $acl;
	
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
                $this->acl = new Webbers_Acl();
		$this->isAuthorized = $this->auth( $access );
	}
	
	public function isAllowed( $resource = null ) {
            if ( $resource === null ) {
                return $this->isAuthorized;
            } else {
                return $this->auth( $resource );
            }
	}
	
	private function auth( $access ) {
		if ( Zend_Auth::getInstance()->hasIdentity() ) {
                    $role = Zend_Auth::getInstance()->getIdentity()->role;
		} else {
                    $role = Webbers_Roles::GUEST;
		}
                         
                return $this->acl->isAllowed( $role, $access );
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
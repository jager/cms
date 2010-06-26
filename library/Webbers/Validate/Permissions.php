<?php
class Webbers_Validate_Permissions extends Zend_Validate_Abstract {
    const EMPTY_PERMISSIONS                = 'emptyPermissions';
    const GK_PERMISSIONS_NOT_ALLOWED       = 'gkPermissionsNotAllowed';
    const SELECTED_PERMISSIONS_NOT_ALLOWED = 'selectedPermissionsNotAllowed';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::EMPTY_PERMISSIONS                => "Please select at least one permission",
        self::GK_PERMISSIONS_NOT_ALLOWED       => "Gatekeeper permissions are not allowed",
        self::SELECTED_PERMISSIONS_NOT_ALLOWED => "Permissions: %restrictedPermissions% are not allowed"
    );

    protected $_messageVariables = array(
        'restrictedPermissions' => '_selectedRestrictedPermissions'
    );
    protected $_allowGatekeeperPermissions    = true;
    protected $_gkPermission                  = 'Gatekeeper::general';
    protected $_restrictedPermissions         = array();
    protected $_selectedRestrictedPermissions = null;
    protected $_arrayPrefix                   = 'mode';
    protected $_somePermissionsSelected       = false;
    protected $_gkPermissionRequested         = false;
    public function __construct( $allowGatekeeperPermissions = null, $restrictedPermissions = null ) {
    	if ( null !== $allowGatekeeperPermissions ) {
    		$this->setAllowGatekeeperPermissions( $allowGatekeeperPermissions );
    	}
    	if ( null === $restrictedPermissions ) {
    		return;
    	}
        $this->setRestrictedPremissions( $restrictedPermissions );
    }
    /**
     * Enter description here...
     *
     * @param unknown_type $allow
     * @return Webbers_Validate_Permissions
     */
    public function setAllowGatekeeperPermissions( $allow ) {
    	$this->_allowGatekeeperPermissions = $allow;
    	return $this;
    }
    public function setGkArea( $area ) {
        $this->_gkArea = $area;
        return $this;
    }
    public function setRestrictedPremissions( $restrictedPermissions ) {
    	$this->clearRestrictedPermissions();
        return $this->addRestrictedPermissions( $restrictedPermissions );
    }
    public function addRestrictedPermissions( $restrictedPermissions ) {
        if ( $restrictedPermissions instanceof Zend_Config ) {
            $restrictedPermissions = $restrictedPermissions->toArray();
        }
        if ( is_string( $restrictedPermissions ) ) {
            $restrictedPermissions = Webbers_Util::explode( $restrictedPermissions );
        }
        if ( is_array( $restrictedPermissions ) ) {
            $this->_restrictedPermissions    = $restrictedPermissions;
        }
        return $this;
    }
    public function addRestrictedPermission( $restrictedPermission ) {
        $this->_restrictedPermissions[] = $restrictedPermission;
        return $this;
    }
    public function clearRestrictedPermissions() {
    	$this->_restrictedPermissions = array();
    	return $this;
    }
    public function setArrayPrefix( $prefix ) {
    	$this->_arrayPrefix = $prefix;
    	return $this;
    }
    public function isValid( $value ) {
    	$this->_setValue( $value );
        return $this->_isValid( Webbers_Permission_Renderer_Abstract::RENDER_BY_COUNTRY ) &&
               $this->_isValid( Webbers_Permission_Renderer_Abstract::RENDER_BY_MODULE ) &&
               $this->haveSomePermissions();
    }
    protected function _isValid( $mode ) {
    	$key = $this->_arrayPrefix . $mode;
        if( !isset( $this->_value[$key] ) || !is_array( $this->_value[$key] ) || count( $this->_value[$key] ) == 0 ) {
        	$this->_error( self::EMPTY_PERMISSIONS );
            return false;
        }
        $permissions = $this->_value[$key];
        $valid       = true;
        foreach( $permissions as $level1Label => $level1data ) {
            foreach( $level1data as $level2Label => $level2data ) {
                foreach( $level2data as $level3Label => $status ) {
                    if ( $status == Webbers_Permission::DENIED || $status == Webbers_Permission::REVOKED ) {
                        continue;
                    }
                    if ( Webbers_Permission_Renderer_Abstract::RENDER_BY_COUNTRY == $mode ) {
                    	$module = $level2Label;
                    	$action = $level3Label;
                    } else {
                        $module = $level1Label;
                        $action = $level2Label;
                    }
                    $valid &= $this->validatePermission( $module, $action );
                }
            }
        }
        return $valid;
    }
    public function validatePermission( $module, $action ) {
    	$this->_somePermissionsSelected = true;
    	if ( $this->_allowGatekeeperPermissions && !$this->_restrictedPermissions ) {
    		return true;
    	}
    	// check if GK permissions have been requested
        if ( !$this->_gkPermissionRequested &&
        !$this->_allowGatekeeperPermissions &&
        $this->_gkPermission == $module . '::' . $action ) {
        	$this->_gkPermissionRequested = true;
        	$this->_error( self::GK_PERMISSIONS_NOT_ALLOWED );
        	return false;
        }
        // check if restricted permissions have been selected
        if ( !self::isPermissionAllowed( $module, $action, $this->_restrictedPermissions ) ) {
        	$this->_appendRestrictedPermissions( $module, $action );
        	$this->_error( self::SELECTED_PERMISSIONS_NOT_ALLOWED );
            return false;
        }
        return true;
    }
    protected function _appendRestrictedPermissions( $module, $action ) {
    	$area = $module .'::' . $action;
    	if ( false !== strpos( $this->_selectedRestrictedPermissions, $area ) ) {
    		return;
    	}
    	if ( !empty( $this->_selectedRestrictedPermissions ) ) {
    		$this->_selectedRestrictedPermissions .= ', ' . $area;
    	} else {
            $this->_selectedRestrictedPermissions = $area;
        }
    }

    public static function isPermissionAllowed( $module, $action, $filter ) {
    	if ( !$filter ) {
    		return true;
    	}
    	return !in_array( $module . '::' . $action, $filter ) && !in_array( $module .'::*', $filter );
    }
    public function haveSomePermissions() {
        if ( $this->_somePermissionsSelected ) {
            return true;
        }
        $this->_error( self::EMPTY_PERMISSIONS );
        return false;
    }
}
?>
<?php
class Webbers_Form_Factory {
	protected static $configDirectory       = null;
	protected static $configFile            = null;
	protected static $defaultConfigClass    = 'Zend_Config_Ini';
	protected static $defaultFormClass      = 'Zend_Form';
	protected static $commonConfigFile      = null;
	protected static $commonConfigNamespace = 'common';
	/**
	 * Default configuration that all forms will inherit
	 * @var array
	 */
	protected static $commonConfig          = array();
    protected $configData                   = null;
	/**
	 * Instance of config file
	 *
	 * @var Zend_Config
	 */
	protected $config                       = null;
	/**
	 * Instance of form class
	 *
	 * @var Zend_Form
	 */
	protected $form                         = null;
	public static function setConfigDirectory( $directory ) {
		self::$configDirectory = rtrim( $directory, DS ) . DS;
	}
	public static function getConfigDirectory() {
		if ( null === self::$configDirectory ) {
			throw new Webbers_Form_Factory_Exception( 'Configuration directory hasn`t been set yet!', 2 );
		}
		
        if ( strpos( realpath( self::$configDirectory ), APPLICATION_PATH ) !== 0 ) {
            throw new Webbers_Form_Factory_Exception( 'Configuration directory couldn`t be outside the application root!', 1 );
        }
		return self::$configDirectory;
	}
	public static function setConfigFile( $file ) {
		self::$configFile = $file;
	}
	public static function getConfigFile() {
		if ( null === self::$configFile ) {
			throw new Webbers_Form_Factory_Exception( 'Config file hasn`t been set yet', 3 );
		} else {
            self::validateConfigFileName( self::$configFile );
        }
		return self::$configFile;
	}
	public static function setDefaultConfigClass( $class ) {
		self::validateClass( $class );
		self::$defaultConfigClass = $class;
	}
	public static function getDefaultConfigClass() {
		return self::$defaultConfigClass;
	}
	public static function setDefaultFormClass( $class ) {
		self::validateClass( $class );
		self::$defaultFormClass = $class;
	}
	public static function getDefaultFormClass() {
		return self::$defaultFormClass;
	}
	public static function setCommonConfigFile( $file ) {
		self::$commonConfigFile = $file;
	}
	public static function getCommonConfigFile() {
		if ( null !== self::$commonConfigFile ) {
            self::validateConfigFileName( self::$commonConfigFile );
		}
		return self::$commonConfigFile;
	}
	public static function setCommonConfigNamespace( $ns ) {
		self::$commonConfigNamespace = $ns;
	}
	public static function getCommonConfigNamespace() {
		return self::$commonConfigNamespace;
	}
    protected static function validateConfigFileName( $file ) {
    	$path     = self::getConfigDirectory() . $file ;
    	$realpath = realpath( $path );
        if ( false === $realpath ) {
            throw new Webbers_Form_Factory_Exception( 'Given file does not exist under given directory', 4 );
        }
        if ( $path != $realpath ) {
            throw new Webbers_Form_Factory_Exception( 'Given file name is incorrect', 5 );
        }
    }
    protected static function validateClass( $class ) {
        if ( !class_exists( $class, true ) ) {
            throw new Webbers_Form_Factory_Exception( "Class with given name '{$type}' was not found", 6 );
        }
    }
    /**
     *
     * @return Zend_Config
     */
    public static function getCommonConfig() {
    	if ( !array_key_exists( self::$configDirectory, self::$commonConfig ) ) {
    		try {
                $config = self::loadConfig( self::getCommonConfigNamespace(),
    		                                self::getDefaultConfigClass(),
    		                                self::getCommonConfigFile() );
    		} catch( Webbers_Form_Factory_Exception $e ) {
    			$config = false;
    		}
    		self::$commonConfig[self::$configDirectory] = $config;
    	}
    	return self::$commonConfig[self::$configDirectory];
    }
	protected static function loadConfig( $namespace, $class, $file ) {
		if ( null === $file ) {
			$file = self::getConfigFile();
		} else {
			self::validateConfigFileName( $file );
		}
		if ( null === $class ) {
			$class = self::getDefaultConfigClass();
		}
		$path = self::getConfigDirectory() . $file;
		return new $class( $path, $namespace, true );
	}
	public function __construct( $configNamespace, $configClass = null, $configFile = null ) {
		$this->configData            = new stdClass();
		$this->configData->namespace = $configNamespace;
		$this->configData->class     = $configClass;
		$this->configData->file      = $configFile;
	}
	public function getConfig() {
		if ( null === $this->config ) {
            $config = self::loadConfig( $this->configData->namespace,
                                        $this->configData->class,
                                        $this->configData->file );
	        $common = self::getCommonConfig();
	        if ( $common instanceof Zend_Config ) {
	            $common       = clone $common;
	            $this->config = $common->merge( $config );
	        } else {
	            $this->config = $config;
	        }
		}
		return $this->config;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $formClass
	 * @return Zend_Form
	 */
	public function getForm( $formClass = null ) {
		if ( null === $formClass ) {
			$formClass = self::getDefaultFormClass();
		}
		
		if ( null === $this->form ) {
			$this->form = new $formClass( $this->getConfig() );
		}
		return $this->form;
	}

	public function addToStack( $element, $value ) {
		$aTemp = $this->getForm()->getElement( $element )->getMultiOptions();
		array_unshift( $aTemp, $value );
		$this->getForm()->getElement( $element )->setMultiOptions( $aTemp );
	}
    public function addToStackNum( $element, $value ) {
        $aTemp = $this->getForm()->getElement( $element )->getMultiOptions();
        if ( is_array( $value ) ) {
        	$tmp = $value;
        } else {
            $tmp = array( "" => $value );
        }
        foreach( $aTemp as $key => $val ) {
        	$tmp[$key] = $val;
        }
        $this->getForm()->getElement( $element )->setMultiOptions( $tmp );
    }

	public function removeFromStack( $element, $key ) {
		$aTemp = $this->getForm()->getElement( $element )->getMultiOptions();
		if ( isset( $aTemp[$key] ) ) {
		  unset( $aTemp[$key] );
        }
        $this->getForm()->getElement( $element )->setMultiOptions( $aTemp );
        return sizeof( $aTemp );
	}

	public function filterStackByKey( $element, $array = array() ) {
		$aTemp = $this->getForm()->getElement( $element )->getMultiOptions();
		$aTemp = array_intersect_key( $aTemp, $array );
		$this->getForm()->getElement( $element )->setMultiOptions( $aTemp );
		return sizeof( $aTemp );
	}
}
?>
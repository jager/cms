<?php
/**
 * Copyrighted by HYPERmedia sp. z o.o.
 *
 * The code contained in this file is property or copyrighted by
 * HYPERmedia sp. z o.o. If you are not employee of this company or one of our
 * clients, please delete this file and inform us as soon as possible by
 * email: kontakt@hypermedia.pl. This file may not be disclosed, used or copied
 * by anyone other than authorized people mentioned before. If you wish
 * clarification of any matter, please request it by email.
 *
 * @author Michał Bachowski <m.bachowski@hypermedia.pl>
 * @copyright Copyright  2009, HYPERmedia
 * @filesource UniqueInDb.php
 */
/**
 * Class that checks if given data is in database
 *
 * @author Michał Bachowski (michal@bachowski.pl)
 * @package HPM library
 * @subpackage validators
 * @version 0.1
 * @copyright hypermedia (c) 2008
 * @uses Webbers_Validate_InDb, Zend_Db_Table_Abstract, Zend_Db_Abstract, Zend_Db_Select
 */
class Webbers_Validate_InDb extends Zend_Validate_Abstract {
    /**
     * Error code for duplicated entry
     */
    const NOT_IN_DATABASE = 'notInDatabase';
    /**
     * List of messages for given codes
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_IN_DATABASE => "'%value%' is not present in database table"
    );
    /**
     * Name of table where to find data
     *
     * @var string
     */
    protected $table    = null;
    /**
     * Name of column that should be matched
     *
     * @var string
     */
    protected $column   = null;
    /**
     * Additional query conditions
     *
     * @var string
     */
    protected $conditions   = null;
    /**
     * Instance of Zend_Db_Adapter_Abstract
     *
     * @var Zend_Db_Adapter
     */
    protected $adapter  = null;
    public function __construct( $table, $column, $adapter = null, $conditions = null ) {
        $this->setTable( $table )
             ->setColumn( $column )
             ->setConditions( $conditions )
             ->setAdapter( $adapter );
    }
    // setters
    public function setTable( $table ) {
        $this->table    = $table;
        return $this;
    }
    public function setColumn( $column ) {
        $this->column   = $column;
        return $this;
    }
    public function setAdapter( $adapter ) {
    	$this->adapter = $adapter;
    	return $this;
    }
    public function setConditions( $conditions ) {
        $this->conditions = $conditions;
        return $this;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getAdapter() {
        if ( is_string( $this->adapter ) ) {
            if ( Zend_Registry::isRegistered( $this->adapter ) ) {
                $this->adapter = Zend_Registry::get( $this->adapter );
            } else {
                $this->adapter = null;
            }
        }
    	if ( null === $this->adapter ) {
    		$this->adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
    	}
    	return $this->adapter;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Db_Select
     */
    protected function getSelect( $value ) {
    	$select = $this->getAdapter()->select()
    	                             ->from( $this->table, 'COUNT(*) as number' )
    	                             ->where( $this->column . '=?', $value );
        if ( $this->conditions ) {
        	$select->where( $this->conditions );
        }
        return $select;
    }
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is unique in DB
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid( $value ) {
    	$this->_setValue( $value );
        $result = $this->getAdapter()->fetchOne( $this->getSelect( $value ) );
        if ( $result > 0 ) {
            return true;
        }
        $this->_error();
        return false;
    }
}
?>
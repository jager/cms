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
 * Class that checks if given data is unique in database
 *
 * @author Michał Bachowski (michal@bachowski.pl)
 * @package HPM library
 * @subpackage validators
 * @version 0.1
 * @copyright hypermedia (c) 2008
 * @uses Webbers_Validate_InDb, Zend_Db_Table_Abstract, Zend_Db_Abstract, Zend_Db_Select
 */
class Webbers_Validate_UniqueInDb extends Webbers_Validate_InDb {
	/**
	 * Error code for duplicated entry
	 */
    const DUPLICATED = 'isDuplicated';
    /**
     * List of messages for given codes
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::DUPLICATED => "'%value%' is not unique within database table"
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
     * Name of primary key kolumn
     *
     * @var string
     */
    protected $pkColumn = null;
    /**
     * Value of primary key kolumn
     *
     * @var string|integer
     */
    protected $pkValue  = null;

    public function __construct( $table, $column, $pkColumn=null, $pkValue=null, $adapter=null ) {
    	$this->setPkColumn( $pkColumn )
             ->setPkValue( $pkValue );
        parent::__construct( $table, $column, $adapter );
    }
    // setters
    public function setPkColumn( $pkColumn ) {
        $this->pkColumn = $pkColumn;
        return $this;
    }
    public function setPkValue( $pkValue ) {
        $this->pkValue  = $pkValue;
        return $this;
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
    	$select  = $this->getSelect( $value );
    	if ( $this->pkColumn && $this->pkValue ) {
    		$select->Where( $this->pkColumn . '<>?', $this->pkValue );
    	}
    	$result = $this->getAdapter()->fetchOne( $select );
    	if ( $result==0 ) {
    		return true;
    	}
    	$this->_error( self::DUPLICATED );
    	return false;
    }
}
?>
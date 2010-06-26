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
 * Class that checks if given password has not been used yet
 *
 * @author Michał Bachowski (michal@bachowski.pl)
 * @package HPM library
 * @subpackage validators
 * @version 0.1
 * @copyright hypermedia (c) 2008
 * @uses Webbers_Validate_InDb, Zend_Db_Table_Abstract, Zend_Db_Abstract, Zend_Db_Select
 */
class Webbers_Validate_Password_Unused extends Webbers_Validate_InDb {
    /**
     * Error code for duplicated entry
     */
    const USED = 'used';
    /**
     * Instance of Zend_Db_Adapter_Abstract
     *
     * @var Zend_Db_Adapter
     */
    protected $_adapter  = null;
    /**
     * Name of schema which should be used
     *
     * @var string
     */
    protected $_schema   = null;
    /**
     * Identifier of current user
     *
     * @var integer
     */
    protected $_accountId       = null;
    /**
     * List of messages for given codes
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::USED => "Password has been used already"
    );
    public function __construct( $accountId, $schema = null, $adapter = null ) {
    	$this->setAdapter( $adapter )
    	     ->setSchema( $schema )
             ->setAccountId( $accountId );
    }
    public function setAccountId( $accountId ) {
        $this->_accountId = (int) $accountId;
        return $this;
    }
    public function setAdapter( $adapter ) {
        $this->adapter = $adapter;
        return $this;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getAdapter() {
        if ( null === $this->adapter ) {
            $this->adapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        }
        return $this->adapter;
    }
    public function setSchema( $schema ) {
        $this->schema  = $schema;
        return $this;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Db_Adapter_Abstract
     */
    public function getSchema() {
        if ( null === $this->schema ) {
            $this->schema = Webbers_Model_Abstract::getDefaultSchema();
        }
        return $this->schema;
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
    	if ( !$this->_accountId ) {
    		return true;
    	}
        $adapter = $this->getAdapter();
        $query   = 'SELECT isUniquePassword( \'' . $this->getSchema() . '.\', ' . $this->_accountId . ', \'' . $value . '\' )';
        $result  = $adapter->fetchOne( $query );
        if ( $result ) {
            return true;
        }
        $this->_error();
        return false;
    }
}
?>
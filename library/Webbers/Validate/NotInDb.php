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
 * Class that checks if given data is not in database
 *
 * @author Michał Bachowski (michal@bachowski.pl)
 * @package HPM library
 * @subpackage validators
 * @version 0.1
 * @copyright hypermedia (c) 2008
 * @uses Webbers_Validate_InDb, Zend_Db_Table_Abstract, Zend_Db_Abstract, Zend_Db_Select
 */
class Webbers_Validate_NotInDb extends Webbers_Validate_InDb {
    /**
     * Error code for duplicated entry
     */
    const IN_DATABASE = 'inDatabase';
    /**
     * List of messages for given codes
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::IN_DATABASE => "'%value%' is present in database table"
    );
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is unique in DB
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid( $value ) {
        $result = !parent::isValid( $value );
        $this->_errors   = array();
        $this->_messages = array();
        if ( $result ) {
            return true;
        }
        $this->_error();
        return false;
    }
}
?>
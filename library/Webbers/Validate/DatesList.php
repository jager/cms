<?php
class Webbers_Validate_DatesList extends Webbers_Validate_Date {
    const INCORRECT_DATE_IN_LIST = 'incorrectDateInList';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_YYYY_MM_DD             => "'%value%' is not of the format YYYY-MM-DD",
        self::INVALID                    => "'%value%' does not appear to be a valid date",
        self::FALSEFORMAT                => "'%value%' does not fit given date format",
        self::INCORRECT_DATE             => "'%value%' is not valid date in format YYYY-mm-dd",
        self::DATE_TOO_OLD               => "Date '%value%' must not be older than %minDate%",
        self::DATE_TOO_FAR_IN_THE_FUTURE => "Date '%value%' must not be later than %maxDate%",
        self::INCORRECT_DATE_IN_LIST     => "'%value%' contains at least one incorrect date"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct( $minDate = null, $maxDate = null, $allowEmpty = null, $emptyValue = null, $format = null, $locale = null ) {
        parent::__construct( $minDate, $maxDate, $allowEmpty, $emptyValue, $format, $locale );
        $dummy = new parent();
        $this->setMessages( $dummy->_messageTemplates );
    }
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value matches against the pattern option
     *
     * @param  string $value
     * @throws Zend_Validate_Exception if there is a fatal error in pattern matching
     * @return boolean
     */
    public function isValid($value) {
    	$dates = Webbers_Util::explode( $value );
    	$valid = true;
        $messages = array();
    	$errors = array();
    	foreach( $dates as $date ) {
    		$currentValid = parent::isValid( $date );
            $valid &= $currentValid;
    		if ( $currentValid ) {
    			continue;
    		}
            $messages += $this->getMessages();
            $errors += $this->getErrors();
    	}
    	if ( $valid ) {
    		return true;
    	}
    	$this->_setValue( $value );
    	$this->_error( self::INCORRECT_DATE_IN_LIST );
    	$this->_errors   += $errors;
        $this->_messages += $messages;
    	return false;
    }
}
?>
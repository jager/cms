<?php
class Webbers_Validate_Date extends Zend_Validate_Date {
    const INCORRECT_DATE             = 'incorrectDate';
    const DATE_TOO_OLD               = 'dateTooOld';
    const DATE_TOO_FAR_IN_THE_FUTURE = 'dateTooFarInTheFuture';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NOT_YYYY_MM_DD             => "'%value%' is not of the format YYYY-MM-DD",
        self::INVALID                    => "'%value%' does not appear to be a valid date",
        self::FALSEFORMAT                => "'%value%' does not fit given date format",
        self::INCORRECT_DATE             => "'%value%' is not valid date in format YYYY-mm-dd",
        self::DATE_TOO_OLD               => "Date '%value%' must not be older than %minDate%",
        self::DATE_TOO_FAR_IN_THE_FUTURE => "Date '%value%' must not be later than %maxDate%"
    );

    /**
     * @var array
     */
    protected $_messageVariables = array(
        'minDate' => '_minDate',
        'maxDate' => '_maxDate'
    );

    protected $_allowEmpty    = true;
    protected $_emptyValue    = '0000-00-00';
    protected $_minDate       = null;
    protected $_minDateParsed = null;
    protected $_maxDate       = null;
    protected $_maxDateParsed = null;
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct( $minDate = null, $maxDate = null, $allowEmpty = null, $emptyValue = null, $format = null, $locale = null ) {
    	parent::__construct( $format, $locale );
    	$dummy = new parent();
    	$this->setMessages( $dummy->_messageTemplates );
        $this->setMinDate( $minDate );
        $this->setMaxDate( $maxDate );
        if ( null !== $allowEmpty ) {
            $this->setAllowEmpty( $allowEmpty );
        }
        if ( null !== $emptyValue ) {
            $this->setEmptyValue( $emptyValue );
        }
    }
    public function setMinDate( $minDate ) {
        $this->_minDate       = $minDate;
        $this->_minDateParsed = null;
        return $this;
    }
    public function getMinDate() {
        return $this->_minDate;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Date
     */
    public function getMinDateParsed() {
    	if ( null === $this->_minDateParsed && null !== $this->_minDate ) {
    		$this->_minDateParsed = $this->parseDate( $this->_minDate );
    	}
        return $this->_minDateParsed;
    }
    public function setMaxDate( $maxDate ) {
        $this->_maxDate       = $maxDate;
        $this->_maxDateParsed = null;
        return $this;
    }
    public function getMaxDate() {
        return $this->_maxDate;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Date
     */
    public function getMaxDateParsed() {
        if ( null === $this->_maxDateParsed && null !== $this->_maxDate ) {
            $this->_maxDateParsed = $this->parseDate( $this->_maxDate );
        }
        return $this->_maxDateParsed;
    }
    /**
     * Enter description here...
     *
     * @return Zend_Date
     */
    protected function parseDate( $date ) {
        $epoch = strtotime( $date );
        if ( false === $epoch ) {
            $date = new Zend_Date( $date, $this->_format );
        } else {
            $date = new Zend_Date();
            $date->setTimestamp( $epoch );
        }
        return $date;
    }
    public function setAllowEmpty( $allowEmpty ) {
    	$this->_allowEmpty = $allowEmpty;
    	return $this;
    }
    public function getAllowEmpty() {
        return $this->_allowEmpty;
    }
    public function setEmptyValue( $emptyValue ) {
    	$this->_emptyValue = $emptyValue;
    	return $this;
    }
    public function getEmptyValue() {
        return $this->_emptyValue;
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
    	// set value
    	$this->_setValue( $value );
    	// check if given value is considered empty
        if ( $this->_allowEmpty && $this->_emptyValue == $value ) {
            return true;
        }
    	// check date format
    	if ( !parent::isValid( $value ) ) {
    		return false;
    	}
    	// check if input is valid date
    	/*
    	list( $year, $month, $day ) = explode( '-', $value );
    	if ( !checkdate( $month, $day, $year ) ) {
    		$this->_error( self::INCORRECT_DATE );
    		return false;
    	}*/
    	// prepare date to validate
    	$curDate = $this->parseDate( $value );
    	// check if date is not too old
    	if ( null !== ($minDate = $this->getMinDateParsed() ) && $curDate->isEarlier( $minDate ) ) {
            $this->_error( self::DATE_TOO_OLD );
            return false;
    	}
        // check if date is not too far in the future
        if ( null !== ($maxDate = $this->getMaxDateParsed() ) && $curDate->isLater( $maxDate ) ) {
            $this->_error( self::DATE_TOO_FAR_IN_THE_FUTURE );
            return false;
        }
    	return true;
    }
}
?>
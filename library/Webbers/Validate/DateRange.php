<?php
class Webbers_Validate_DateRange extends Webbers_Validate_DatesList {
    const TOO_MANY_PARTS          = 'tooManyParts';
    const TOO_LITTLE_PARTS        = 'tooLittleParts';

    /**
     * @var array
     */
    protected $_messageVariables = array(
        'minDate' => '_minDate',
        'maxDate' => '_maxDate',
        'parts'   => '_parts'
    );

    protected $_parts = 0;
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
        self::INCORRECT_DATE_IN_LIST     => "'%value%' contains at least one incorrect date",
        self::TOO_MANY_PARTS             => "'%value%' must contain exactly 2 parts, %parts% found",
        self::TOO_LITTLE_PARTS           => "'%value%' must contain exactly 2 parts, %parts% found"
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
    public function isValid( $value ) {
    	$this->_setValue( $value );
        $dates = Webbers_Util::explode( $value, ':' );
        $this->_parts = count( $dates );
        if ( $this->_parts < 2 ) {
            $this->_error( self::TOO_LITTLE_PARTS );
            return false;
        }
        if ( $this->_parts > 2 ) {
            $this->_error( self::TOO_MANY_PARTS );
            return false;
        }
        return parent::isValid( $dates[0] . ',' . $dates[1] );
    }
}
?>
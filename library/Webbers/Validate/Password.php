<?php

class Webbers_Validate_Password extends Zend_Validate {
    protected static $messageTooShort          = 2404;
    protected static $messageNoDigit           = 2405;
    protected static $messageNoUppercaseLetter = 2406;
    protected static $messageNoLowercaseLetter = 2407;
    protected static $messageTooWeak           = 2408;
    protected static $messageNotUnique         = 2409;
    protected static $messageNoSpecial         = 2410;
    protected $_stringLengthMin                = 8;
    protected $_requiredPoints                 = 22;
    /**
     * Enter description here...
     *
     * @var Webbers_Validate_Password_Unused
     */
    protected $uniqueValidator                 = null;
    /**
     * Class constructor. Initializes default validators
     *
     * @param integer $accountId
     */
    public function __construct( $accountId = null ) {
        $stringLength   = new Zend_Validate_StringLength( $this->_stringLengthMin );
        $stringLength->setMessage( self::$messageTooShort, Zend_Validate_StringLength::TOO_SHORT );

        $patternSpecial  = new Webbers_Validate_SpecialChar();
        $patternSpecial->setMessage( self::$messageNoSpecial, Webbers_Validate_SpecialChar::NO_SPECIAL_CHAR );

        $patternDigits  = new Webbers_Validate_HasDigit();
        $patternDigits->setMessage( self::$messageNoDigit, Webbers_Validate_HasDigit::NO_DIGIT );

        $patternUppercaseLetter  = new Webbers_Validate_HasUppercaseLetter();
        $patternUppercaseLetter->setMessage( self::$messageNoUppercaseLetter, Webbers_Validate_HasUppercaseLetter::NO_UPPERCASE_LETTER );

        $patternLowercaseLetter  = new Webbers_Validate_HasLowercaseLetter();
        $patternLowercaseLetter->setMessage( self::$messageNoLowercaseLetter, Webbers_Validate_HasLowercaseLetter::NO_LOWERCASE_LETTER );

        $this->isAccountId( $accountId );

        $strength = new Webbers_Validate_Password_Strength();
        $strength->setRequiredPoints( $this->_requiredPoints )
                 ->setMinLength( $this->_stringLengthMin )
                 ->setMessage( self::$messageTooWeak, Webbers_Validate_Password_Strength::TOO_WEAK );

        $this->addValidator( $stringLength )
              ->addValidator( $patternSpecial )
              ->addValidator( $patternDigits )
              ->addValidator( $patternUppercaseLetter )
              ->addValidator( $patternLowercaseLetter )
              ->addValidator( $this->uniqueValidator, true )
              ->addValidator( $strength );
    }
    public function setRequiredPoints( $points ) {
    	$this->_requiredPoints = (int) $points;
    	return $this;
    }
    public function setStringMinLength( $length ) {
        $this->_stringLengthMin = (int) $length;
        return $this;
    }
    /**
     * Enter description here...
     *
     * @param integer $accountId
     * @return Webbers_Validate_Password
     */
    public function isAccountId( $accountId ) {
    	if ( null === $this->uniqueValidator ) {
    		$this->uniqueValidator   = new Webbers_Validate_Password_Unused( $accountId );
    	} else {
    		$this->uniqueValidator->setAccountId( $accountId );
    	}
    	return $this;
    }
}
?>
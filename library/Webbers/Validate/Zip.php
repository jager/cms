<?php
class Webbers_Validate_Zip extends Zend_Validate_Abstract {
	protected $_countries        = array();
	protected $_useDefaultRegexp = true;
    protected $_defaultRegexp    = '/^[a-z0-9-_]{3,10}$/i';
    const INCORRECT_ZIP          = 'incorrectZip';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INCORRECT_ZIP => "'%value%' is not valid zip code"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct() {
    }
    public function setUseDefaultRegexp( $useDefaultRegexp ) {
        $this->_useDefaultRegexp = $useDefaultRegexp;
        return $this;
    }
    public function useDefaultRegexp() {
    	return $this->_useDefaultRegexp;
    }
    public function setDefaultRegexp( $defaultRegexp ) {
        $this->_defaultRegexp = $defaultRegexp;
        return $this;
    }
    public function getDefaultRegexp() {
        return $this->_defaultRegexp;
    }
    public function setCountries( array $countries ) {
        $this->clearCountries();
        $this->addCountries( $countries );
        return $this;
    }
    public function addCountry( $country ) {
        $this->_countries[] = strtolower( $country );
        return $this;
    }
    public function addCountries( array $countries ) {
        foreach( $countries as $country ) {
        	$this->addCountry( $country );
        }
        return $this;
    }
    public function clearCountries() {
        $this->_countries = array();
        return $this;
    }
    public function fetchZipCode( $country ) {
        switch( $country ) {
            /**
             * 6 digits:
             * - Kazakhstan
             * - Uzbekistan
             * - Kyrgyzstan
             * - Turkmenistan
             * - Tajikistan
             * - Armenia
             * - Belarus
             * - Russia
             * - Romania
             * - Serbia
             */
            case 'kz':
            case 'uz':
            case 'kg':
            case 'tm':
            case 'tj':
            case 'tj':
            case 'am':
            case 'by':
            case 'ru':
            case 'ro':
            case 'rs':
                return '/^[0-9]{6}$/';
            break;
            /**
             * 5 digits:
             * - Saudi Arabia
             * - United Arab Emirates
             * - Kuwait
             * - Egypt
             * - Iraq
             * - Jordan
             * - Lithuana
             * - Pakistan
             * - Estonia
             * - Mongolia
             * - Turkey
             * - Montenegro
             * - Sudan
             * - Bosnia & Herzegovina
             * - Ukraine
             * - Israel
             */
            case 'sa':
            case 'ae':
            case 'kw':
            case 'eq':
            case 'iq':
            case 'jo':
            case 'lt':
            case 'pk':
            case 'ee':
            case 'mn':
            case 'tr':
            case 'me':
            case 'sd':
            case 'ba':
            case 'ua':
            case 'il':
            case 'al':
            case 'tn':
            case 'tn':
            case 'bg':
                return '/^[0-9]{5}$/';
            break;
            /**
             * 4 digits
             * - Qatar
             * - Yemen
             * - Hungary
             * - Georgia
             * - South Africa
             */
            case 'qa':
            case 'ye':
            case 'hu':
            case 'ge':
            case 'za':
                return '/^[0-9]{4}$/';
            break;
            /**
             * "4 digits" or "[4 digits] [4 digits]":
             * - Lebanon
             */
            case 'lb':
                return '/^([0-9]{4}|[0-9]{4}\s[0-9]{4})$/';
            break;
            /**
             * 3 to 4 digits
             * - Bahrain
             */
            case 'bh':
                return '/^[0-9]{3,4}$/';
            break;
            /**
             * 3 digits
             * - Oman
             * - Incl. Iceland
             */
            case 'om':
            case 'is':
                return '/^[0-9]{3}$/';
            break;
            /**
             * "[3 digits] [2 digits]":
             * - Slovakia
             * - Czech Republic
             */
            case 'sk':
            case 'cz':
                return '/^[0-9]{3} [0-9]{2}$/';
            break;
            /**
             * "[2 digits]-[3 digits]":
             * - Poland
             */
            case 'pl':
                return '/^[0-9]{2}-[0-9]{3}$/';
            break;
            /**
             * country code followed by a dash and 4 digits
             * - Latvia
             * - Azerbaijan
             * - Moldova
             * - Slovenia
             * - Croatia
             * - Malta
             */
            case 'lv':
            case 'az':
            case 'md':
            case 'sl':
            case 'hr':
                return "/^{$country}-[0-9]{4}$/i";
            break;
            /**
             * MLH  followed by a dash and 4 digits
             * - Malta
             */
            case 'mt':
                return '/^MLH-[0-9]{4}$/i';
            break;
            /**
             * "[3 digits][2 letters][3 digits]"
             * - Mauritius
             */
            case 'mu':
                return '/^[0-9]{3}[a-z]{2}[0-9]{3}$/i';
            break;
            default:
                return null;
            break;
        }
    }
    protected function _testZip( $value, $country ) {
        $regex = $this->fetchZipCode( $country );
        if ( null === $regex ) {
        	return;
        }
        return preg_match( $regex, $value );
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
        $this->_setValue($value);
        $valid = null;
        for( $i = 0, $max = count( $this->_countries ); $i < $max; $i++ ) {
        	$valid = $this->_testZip( $value, $this->_countries[ $i ] );
        	if ( 1 === $valid ) {
                return true;
        	}
        }
        if ( null === $valid && $this->useDefaultRegexp() ) {
        	$valid = preg_match( $this->getDefaultRegexp(), $value );
        }
        if ( !$valid ) {
            $this->_error( self::INCORRECT_ZIP );
            return false;
        }
        return true;
    }
}
?>
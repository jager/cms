<?php
class Webbers_Validate_Password_Strength extends Zend_Validate_Abstract {
    const TOO_WEAK             = 'tooWeak';
    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::TOO_WEAK => "Given password is too weak"
    );
    protected $_minLength      = 8;
    protected $_requiredPoints = 22;
    protected $_conditions = array(
        '/[a-z]/'                                    => 1,
        '/[A-Z]/'                                    => 5,
        '/\d+/'                                      => 5,
        '/(.*[0-9].*[0-9].*[0-9])/'                  => 7,
        '/.[!@#$%^&*?,_~\/]/'                        => 5,
        '/(.*[\!@#$%^&*?,_~\/].*[\!@#$%^&*?,_~\/])/' => 7,
        '!([a-z].*[A-Z])|([A-Z].*[a-z])!'            => 2,
        '/([a-zA-Z](.*?)[0-9]|[0-9](.*?)[a-zA-Z])/'  => 3,
        '/([a-zA-Z0-9].*[\!@#$%^&*?_,~\/])|([\!@#$%^&*?_,~\/].*[a-zA-Z0-9])/' => 3);
    public function setRequiredPoints( $points ) {
    	$this->_requiredPoints = $points;
    	return $this;
    }
    public function setMinLength( $length ) {
        $this->_minLength = $length;
        return $this;
    }
    public function isValid( $password ) {
    	$sum     = 0;
    	$passLen = strlen( $password );
    	if ( $passLen < $this->_minLength ) {
    		$this->_error();
    		return false;
    	}
        if ( $passLen <= $this->_minLength + 2 ) {
            $sum += 6;
        } elseif ( $passLen <= $this->_minLength + 4 ) {
            $sum += 12;
        } elseif ( $passLen >= $this->_minLength + 5 ) {
            $sum += 18;
        }
        foreach( $this->_conditions as $regexp => $points ) {
        	if ( preg_match( $regexp, $password ) ) {
        		$sum += $points;
        	}
        }
        if ( $sum > $this->_requiredPoints ) {
        	return true;
        }
        $this->_error();
        return false;
    }
}
?>
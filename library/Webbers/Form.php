<?php
class Webbers_Form extends Zend_Form {
	protected $postack = null;
    /**
     * Retrieve all form element values
     *
     * @param  bool $suppressArrayNotation
     * @param array $omit list of fields to ommit (usually submit, and token)
     * @return array
     */
    public function getValues($suppressArrayNotation = false, $omit = array( 'submit', 'hash' ) ) {
    	$return = parent::getValues( $suppressArrayNotation );
    	if ( is_array( $omit ) ) {
            foreach( $omit as $key ) {
                if ( !array_key_exists( $key, $return ) ) {
                    continue;
                }
                unset( $return[$key] );
            }
    	}
    	return $return;
    }
    public function setIsPostback( $postback = true ) {
    	$this->postack = $postback;
    	return $this;
    }
    public function isPostback() {
    	if ( null === $this->postack ) {
    		$belongTo = $this->getElementsBelongTo();
            if ( $_POST && null !== $belongTo && array_key_exists( $belongTo, $_POST ) ) {
                $this->postack = true;
            } else {
            	$this->postack = false;
            }
    	}
    	return $this->postack;
    }
    public function isValid( $post ) {
    	$hasErrors = $this->isErrors();
    	$valid     = parent::isValid( $post );
    	return !$hasErrors && $valid;
    }

}
?>
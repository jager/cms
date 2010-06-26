<?php
class Webbers_Form_Element_Hash extends Zend_Form_Element_Hash {
	protected $_validationMessages = null;
    /**
     * Add validator to validation chain
     *
     * Note: will overwrite existing validators if they are of the same class.
     *
     * @param  string|Zend_Validate_Interface $validator
     * @param  bool $breakChainOnFailure
     * @param  array $options
     * @return Zend_Form_Element
     * @throws Zend_Form_Exception if invalid validator type
     */
	public function addValidator( $validator, $breakChainOnFailure = false, $options = array() ) {
		if ( 'Identical' === $validator && $this->_validationMessages ) {
			$options['messages'] = $this->_validationMessages;
		}
		return parent::addValidator( $validator, $breakChainOnFailure, $options );
	}
	public function setValidationMessages( array $messages ) {
		$this->_validationMessages = $messages;
		return $this;
	}
}
?>
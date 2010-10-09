<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RePassword
 *
 * @author mjagusia
 */
class Webbers_Validate_RePassword extends Zend_Validate_Abstract {
    
    const NOT_RETYPED = 'notReTyped';
    const FIELD_NOT_EXISTS = 'fieldDoesNotExists';
    const FIELD_EMPTY = 'emptyField';
    
    protected $_messageTemplates = array(
        self::NOT_RETYPED           => "Password is not equal re-typed value!",
        self::FIELD_NOT_EXISTS      => "Given field name doesn't exists in form!",
        self::FIELD_EMPTY           => "Field name is not set!"
    );

    protected $_fieldName = null;


    public function  __construct( $options ) {
        if ( is_array( $options ) and isset( $options['fieldName'] ) ) {
            $this->setFieldName( $options['fieldName'] );
        }
    }

    public function getFieldName() {
        return $this->_fieldName;
    }

    public function setFieldName( $fieldName ) {
        $this->_fieldName = $fieldName;
        return $this;
    }

    public function isValid( $value, $context = null ) {

        $field = $this->getFieldName();
        $this->_setValue( $value );

        if ( $field == '' ) {
            $this->_error( self::FIELD_EMPTY );
            return false;
        }

        if ( !is_array( $context ) or !isset( $context[$field] ) ) {
            $this->_error( self::FIELD_NOT_EXISTS );
            return false;
        }
        
        if ( $value != $context[$field] ) {
            $this->_error( self::NOT_RETYPED );
            return false;
        }
        return true;
    }
}
?>

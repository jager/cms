<?php
class Webbers_Form_Element_Link extends Zend_Form_Element {
    /**
     * Default view helper to use
     *
     * @var string
     */
    public $helper = 'formLink';
    public function setLabel( $label ) {
    	$this->setAttrib( 'label', $label );
    	return parent::setLabel( $label );
    }
    public function render( Zend_View_Interface $view = null ) {
    	$this->removeDecorator( 'Label' );
        return parent::render();;
    }
}
?>
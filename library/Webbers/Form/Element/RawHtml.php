<?php
class Webbers_Form_Element_RawHtml extends Zend_Form_Element {
	public function render( Zend_View_Interface $view = null ) {
		return $this->getValue();
	}
}
?>
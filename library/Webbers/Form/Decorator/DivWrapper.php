<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DivWrapper
 *
 * @author mjagusia
 */
class Webbers_Form_Decorator_DivWrapper extends Zend_Form_Decorator_Abstract {
    public function render( $content ) {
        $class = $this->getOption( 'class' );
        $class = $class != '' ? $class : 'field';
        return "<div class='{$class}'>{$content}</div>";
    }
}
?>

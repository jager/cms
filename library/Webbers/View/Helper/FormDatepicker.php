<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormDatepicker
 *
 * @author mjagusia
 */
class Webbers_View_Helper_FormDatepicker extends Zend_View_Helper_FormText {
    
    public function formDatepicker($name, $value = null, $attribs = null) {

        if ( isset( $attribs['class'] ) ) {
            $attribs['class'] .= ' date hasDatepicker';
        } else {
            $attribs['class'] = 'date hasDatepicker';
        }


        $element = parent::formText( $name, $value, $attribs );

        return $element . '<img class="ui-datepicker-trigger" src="/images/ui/calendar.png" alt="" />';
    }
}
?>

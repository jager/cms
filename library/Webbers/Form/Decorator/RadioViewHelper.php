<?php
/**
 * Description of RadioViewHelper
 *
 * @author mjagusia
 */
class Webbers_Form_Decorator_RadioViewHelper extends Zend_Form_Decorator_ViewHelper {
    public function render($content)
    {        
        $elementContent = parent::render($content);
        return "<div class='radios'>{$elementContent}</div>";
    }
}
?>

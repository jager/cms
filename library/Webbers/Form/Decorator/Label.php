<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Label
 *
 * @author mjagusia
 */
class Webbers_Form_Decorator_Label extends Zend_Form_Decorator_Label {
    public function render( $content ) {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $label     = $this->getLabel();
        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $tag       = $this->getTag();
        $id        = $this->getId();
        $class     = $this->getClass();
        $options   = $this->getOptions();


        if (empty($label) && empty($tag)) {
            return $content;
        }

        if (!empty($label)) {
            $options['class'] = $class;
            $label = $view->formLabel($element->getFullyQualifiedName(), trim($label), $options);
        } else {
            $label = '&nbsp;';
        }

        if (null !== $tag) {
            require_once 'Zend/Form/Decorator/HtmlTag.php';
            $decorator = new Zend_Form_Decorator_HtmlTag();
            if ( isset( $options['class'] ) and ( $options['class'] != '' ) ) {
                $decorator->setOptions(array('tag' => $tag,
                                             'id'  => $this->getElement()->getName() . '-label',
                                             'class' => $options['class'] ) ) ;
            } else {
                $decorator->setOptions(array('tag' => $tag,
                                             'id'  => $this->getElement()->getName() . '-label',
                                             'class' => 'label' ) ) ;
            }

            $label = $decorator->render($label);
        }

        switch ($placement) {
            case self::APPEND:
                return $content . $separator . $label;
            case self::PREPEND:
                return $label . $separator . $content;
        }
    }
}
?>

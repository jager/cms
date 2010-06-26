<?php
class Webbers_Form_Element_DbMultiSelect extends Webbers_Form_Element_DbSelect {
    /**
     * 'multiple' attribute
     * @var string
     */
    public $multiple = 'multiple';

    /**
     * Use formSelect view helper by default
     * @var string
     */
    public $helper = 'formSelect';

    /**
     * Multiselect is an array of values by default
     * @var bool
     */
    protected $_isArray = true;
}
?>
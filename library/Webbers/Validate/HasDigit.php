<?php
class Webbers_Validate_HasDigit extends Zend_Validate_Regex {
    const NO_DIGIT = 'noDigit';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NO_DIGIT => "'%value%' does not contain any digit"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct() {
        $this->setPattern('![0-9]!');
    }
}
?>
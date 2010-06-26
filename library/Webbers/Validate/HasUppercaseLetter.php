<?php
class Webbers_Validate_HasUppercaseLetter extends Zend_Validate_Regex {

    const NO_UPPERCASE_LETTER = 'noUppercaseLetter';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NO_UPPERCASE_LETTER => "'%value%' does not contain any uppercase letter"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct() {
        $this->setPattern( '![A-Z]!' );
    }
}
?>
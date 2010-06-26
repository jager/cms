<?php
class Webbers_Validate_HasLowercaseLetter extends Zend_Validate_Regex {

    const NO_LOWERCASE_LETTER = 'noLowercaseLetter';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NO_LOWERCASE_LETTER => "'%value%' does not contain any lowercase letter"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct() {
        $this->setPattern( '![a-z]!' );
    }
}
?>
<?php
class Webbers_Validate_SpecialChar extends Zend_Validate_Regex {
    const NO_SPECIAL_CHAR = 'noSpecialChar';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::NO_SPECIAL_CHAR => "'%value%' does not contain any special character (one of: !@#$%^&*?_~,.)"
    );
    /**
     * Sets validator options
     *
     * @return void
     */
    public function __construct() {
        $this->setPattern( '/[!@#$%^&*?_~,.]/' );
    }
}
?>
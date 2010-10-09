<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Acl
 *
 * @author mjagusia
 */
class Webbers_Acl extends Zend_Acl {

    public function  __construct() {
        $this->add( new Zend_Acl_Resource( Webbers_Resources::ADMIN ) );
        $this->add( new Zend_Acl_Resource( Webbers_Resources::MODERATOR ) );
        //$this->add( new Zend_Acl_Resource( Webbers_Resources::REGISTREDPAGE ) );
        $this->add( new Zend_Acl_Resource( Webbers_Resources::PUBLICPAGE ) );

        $this->addRole( new Zend_Acl_Role( Webbers_Roles::GUEST ) );
        //$this->addRole( new Zend_Acl_Role( Webbers_Roles::REGISTERED ), Webbers_Roles::GUEST );
        $this->addRole( new Zend_Acl_Role( Webbers_Roles::MODERATOR ), Webbers_Roles::GUEST );
        $this->addRole( new Zend_Acl_Role( Webbers_Roles::ADMIN ), Webbers_Roles::MODERATOR );

        $this->allow( Webbers_Roles::GUEST, Webbers_Resources::PUBLICPAGE );
        //$this->allow( Webbers_Roles::REGISTERED, Webbers_Resources::REGISTREDPAGE );
        $this->allow( Webbers_Roles::MODERATOR, Webbers_Resources::MODERATOR );
        $this->allow( Webbers_Roles::ADMIN, Webbers_Resources::ADMIN );
    }
}
?>

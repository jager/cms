<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PHPClass
 *
 * @author mjagusia
 */
class Webbers_Controller_Action_Helper_FileUploader extends Zend_Controller_Action_Helper_Abstract {


    private $_path = '/tmp';

    public function __construct() {
             
    }

    public function setPath( $path ) {
         if ( $path !== null ) {
            $this->_path = $path;
        }
        return $this;
    }

    public function getPath() {
        return $this->_path;
    }
    
    public function transferFile() {
        if ( !is_dir( $this->_path ) ) {
                mkdir( $this->_path, 0777, true );
        }
        $adapter = new Zend_File_Transfer_Adapter_Http();
        $adapter->setDestination( $this->_path );
        if ( !$adapter->receive() ) {
            $messages = $adapter->getMessages();
            throw new Exception( implode("<br />", $messages) );
        }
        return $adapter->getFileInfo();
    }

    public function direct() {
        return $this->transferFile();
    }


}
?>

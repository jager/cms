<?php
class Webbers_View_Helper_FlashMessage {

    
    public $view;

    public function flashMessage() {
        $message = Zend_Controller_Action_HelperBroker::getStaticHelper( 'flashMessenger' )
                        ->getMessages();
        return $this->setMessage( $message, false );
    }

    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }

    private function setMessage( $message ) {
        $responseCode = Zend_Controller_Front::getInstance()->getResponse()->getHttpResponseCode();
        if ( $responseCode == 200 ) {
            return $this->view->partial( 'elements/success.inc', array( 'errorMessage' => $message ) );
        } else {
            return $this->view->partial( 'elements/error.inc', array( 'errorMessage' => $message ) );
        }
    }
}
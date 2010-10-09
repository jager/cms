<?php

class Admin_ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');

        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request   = $errors->request;
        $this->view->backlink = $this->getBacklink();
    }

    private function getBacklink() {
        $backlink = $this->getRequest()->getServer( 'HTTP_REFERER' );
        $baseUrl = $this->getRequest()->getServer( 'HTTP_HOST' );
        $backlink = str_replace( 'http://','', str_replace( $baseUrl, '', $backlink ) );
        return $backlink;
    }


}


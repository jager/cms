<?php
class Webbers_Controller_Plugin_LayoutAjax extends Zend_Controller_Plugin_Abstract {
	/**
	 * Callback method called before dispatch loop start
	 *
	 * @param Zend_Controller_Request_Abstract $request
	 * @return void
	 */
    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request ) {
        $session = new Zend_Session_Namespace( 'ajax' );
    	// check if current request is XmlHttp (AJAX)
    	if ( ( !$request instanceof Zend_Controller_Request_Http || !$request->isXmlHttpRequest() ) &&
    	( null === $session->action ) ) {
    		// if not - do nothing and return from function
    		return;
    	}        
        // check if Zend_Layout has been instantinated
        if ( null !== ( $layout = Zend_Layout::getMvcInstance() ) ) {
            // if so - set "ajax" layout
            $layout->setLayout( 'ajax' );
        }
    	// and disable layout (one can enable layout when needed)
    	self::disableLayout();
    }
    
    /**
     * Method disables layout rendering
     * (disables Zend_Layout instance and turns off view renderer)
     * @return void
     */
    public static function disableLayout() {
    	// check if Zend_Layout has been instantinated
        if ( null !== ( $layout = Zend_Layout::getMvcInstance() ) ) {
        	// if so - disable it
            $layout->disableLayout();
        }
        // also disable view renderer
        Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' )->setNoRender( true );
    }
    
    /**
     * Method enables layout rendering
     * (enables Zend_Layout instance and turns on view renderer)
     * @return void
     */
    public static function enableLayout() {
        // check if Zend_Layout has been instantinated
        if (null !== ( $layout = Zend_Layout::getMvcInstance() ) ) {
            // if so - enable it
            $layout->enableLayout();
        }
        // also enable view renderer
        Zend_Controller_Action_HelperBroker::getStaticHelper( 'viewRenderer' )->setNoRender( false );
    }
}
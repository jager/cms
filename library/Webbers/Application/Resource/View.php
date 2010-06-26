<?php
class Webbers_Application_Resource_View extends Zend_Application_Resource_ResourceAbstract {
	
	
	protected $_view;
	
	public function init() {
		
		return $this->getView();
	}
	
	public function getView() {
            if (null === $this->_view) {
            $options = $this->getOptions();
            $title   = '';
            $doctype = '';
            $contentType = 'text/html; charset=iso-8859-1';
			
            if (array_key_exists('title', $options)) {
                $title = $options['title'];
                unset($options['title']);
            }            
            
        	if ( isset( $options['doctype'] ) ) {
            	$doctype = $options['doctype'];
            	unset( $options['doctype'] );
            }
           
            if ( isset( $options['content-type'] ) ) {
            	$contentType = $options['content-type'];
            	unset( $options['content-type'] );
            }
            

            $view = new Zend_View($options);
            $view->doctype( $doctype );
            $view->headTitle( $title );      
            $view->headMeta()->setHttpEquiv( 'content-type', $contentType );      
	    $view->setHelperPath( LIBRARY_PATH . DS . 'Webbers/View/Helper', 'Webbers_View_Helper' );
            
			$viewRenderer =
                Zend_Controller_Action_HelperBroker::getStaticHelper(
                    'ViewRenderer'
                );
            $viewRenderer->setViewSuffix('inc');
            $viewRenderer->setView($view);
            

            $this->_view = $view;
        }
        return $this->_view;
    }

    private function getModule() {
        if ( !$this->getBootstrap()->hasPluginResource( 'FrontController') ) {
            $this->getBootstrap()->registerPluginResource( 'FrontController' );
        }
        //Zend_Debug::dump( $this->getBootstrap()->hasPluginResource( 'FrontController') ); die();
        return $this->getBootstrap()
                    ->getPluginResource( 'FrontController')
                    ->getFrontController();
                    //->getRequest();
    }
}
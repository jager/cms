<?php
class Webbers_Controller_Plugin_LayoutSwitcher extends Zend_Controller_Plugin_Abstract {
	
	
	public function preDispatch( Zend_Controller_Request_Abstract $request ) {
		$layoutDir = 'default';
		
		
		if ( $request->getModuleName() == 'admin' ) {
			$layoutDir = 'admin';
		}
		$layout = Zend_Layout::getMvcInstance();
		$layout->setLayoutPath( APPLICATION_PATH . DS . "layouts" . DS . $layoutDir )
			   ->setInflectorTarget(':script.:suffix')
			   ->setViewSuffix( 'inc' );
		
		$this->prepareNavigation( $request->getModuleName() );
	}
	
		
	private function prepareNavigation( $moduleName = 'default' ) {               
               if ( $moduleName != 'default') {
                    $navigation = new Zend_Config_Xml( APPLICATION_PATH . DS . 'configs' . DS . $moduleName . DS . 'navigation.xml', 'nav');
                    $navigationContainer = new Zend_Navigation( $navigation );
                    $layout = Zend_Layout::getMvcInstance();
                    $layout->getView()
                            ->navigation( $navigationContainer );
                } else {
                    $menu = Menu::getStructure();                    
                    $navigation = new Zend_Config_Xml( $menu, 'nav' );
                    $navigationContainer = new Zend_Navigation( $navigation );
                    $layout = Zend_Layout::getMvcInstance();
                    $layout->getView()->navigation( $navigationContainer );
                }
	}
}
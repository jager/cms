<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewSwitcher
 *
 * @author mjagusia
 */


class Webbers_Controller_Plugin_ViewSwitcher extends Zend_Controller_Plugin_Abstract {

    private $_view;

    public function preDispatch( Zend_Controller_Request_Abstract $request ) {
            $module = 'default';


            if ( $request->getModuleName() == 'admin' ) {
                    $module = 'admin';
            }

            $aConfig = $this->getModuleConfig( $module );

            //Zend_Debug::dump( $aConfig );die();
            if ( !is_array( $aConfig ) or ( sizeof( $aConfig ) == 0 ) ) {
                return;
            }

            $this->_view = Zend_Layout::getMvcInstance()->getView();

            if ( !$this->_view instanceof Zend_View ) {
                return;
            }

            if ( isset( $aConfig['stylesheet'] ) ) {
                $this->setStylesheets($aConfig['stylesheet'] );
            }

            if ( isset( $aConfig['javascript'] ) ) {
                $this->setScripts( $aConfig['javascript'] );
            }


    }

    private function getModuleConfig( $moduleName ) {
        $aConfig = array();
        try {
            $config = new Zend_Config_Ini( APPLICATION_PATH . DS . 'configs' . DS . $moduleName . DS . 'view.ini', APPLICATION_ENV );
            $aConfig = $config->toArray();
        } catch ( Zend_Config_Exception $e ) {
            Zend_Debug::dump( $e->getMessage() );
        }

        return $aConfig;

    }

    private function setStylesheets( $aStyleSheet ) {
        if ( is_array( $aStyleSheet ) ) {
            foreach ( $aStyleSheet as $style ) {
                    $this->_view->headLink()->appendStylesheet(
                            $style['file'],
                            empty( $style['media'] ) ? "screen" : $style['media'],
                            empty( $style['ie'] ) ? null : $style['ie'] );
            }
        } else if ( $aStyleSheet != '' ) {
            $this->_view->headLink()->appendStylesheet( $stylesheet );
        }
    }

    private function setScripts( $aScripts ) {
        if ( is_array( $aScripts ) ) {
            foreach ( $aScripts as $ind => $jsFile ) {
                    $this->_view->headScript()->appendFile( $jsFile );
            }
        } else {
            $this->_view->headScript()->appendFile( $aScripts );
        }
    }
}
?>

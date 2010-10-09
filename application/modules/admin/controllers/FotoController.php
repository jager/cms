<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FotoController
 *
 * @author mjagusia
 */
class Admin_FotoController extends Webbers_Controller_Action {
    public function init() {
        parent::init();
        $this->_model = new Foto();
    }

    public function uploadAction() {
        self::disableLayout();
        $aParams = $this->_getAllParams();
        if ( !$this->_request->isPost() or !$_POST ) {
        //    $this->_redirect( '/admin/foto');
        }
            try {
                $aData['GALERY'] = ( isset( $aParams['galeryId'] ) ) ? $aParams['galeryId'] : -1;
                $this->_model->upload( $aData );
            } catch ( Exception $e ) {
                $this->view->message = $e->getMessage();
            }
    }
}
?>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GaleryController
 *
 * @author mjagusia
 */
class GaleryController extends Webbers_Controller_Action {
    public function indexAction() {
        $this->view->aGaleries = Galery::findList()
                ->orderby( 'id desc')
                ->execute();
    }
    public function viewAction() {
        $id = (int)$this->_getParam('id');
        if ( !$id ) {
            $this->_redirect( '/galerie' );
        }
        
        $this->view->galery = Galery::getById( $id );
        $this->view->aFotos = $this->view->galery->Fotos;
    }
}
?>

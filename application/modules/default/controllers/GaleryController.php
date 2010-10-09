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

    public function init() {
        parent::init();
    }
    public function indexAction() {
        $this->view->aGaleries = Galery::findList()
                ->where( "publishtype = 'g'" )
                ->orderby( 'id desc')
                ->execute();
    }
    
    public function viewAction() {
        $id = (int)$this->_getParam('id');
        if ( !$id ) {
            $this->_redirect( '/galerie' );
        }
        $this->_model = new Galery();
        $this->view->galery = $this->_model->getById( $id );
        $this->view->aFotos = $this->view->galery->Fotos;
    }
}
?>

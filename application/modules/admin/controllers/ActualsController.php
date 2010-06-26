<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_ActualsController extends Webbers_Controller_Action {

    public function init() {
        parent::init();
        $this->_model = new Aktual();
    }
    
    public function indexAction() {
        $this->view->list = $this->getList();
    }

    public function addAction() {
        $this->create();
    }

    public function editAction() {
        $this->view->labels = Label::getLabelsArr();
        $this->view->actual = $this->view();
        $this->edit();
    }

    public function viewAction() {
        $this->view->actual = $this->view();
    }

//    public function deleteAction() {
//        $actualId = (int)$this->_getParam( 'id' );
//        $this->view->actual = Aktual::getById( $actualId );
//
//        if ( !$actualId or !$this->view->actual ) {
//            $this->_flash( '/admin/actuals', 'Brak wpisu w bazie danych!!' );
//        }
//
//        $this->view->form = $this->prepareForm( 'delete' );
//
//        $this->view->form->setAction( '/admin/actuals/delete/' . $actualId );
//        $this->view->form->setDefaults( (array)$this->view->actual->_data );
//
//         if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST )) {
//            return;
//        }
//
//        $error = false;
//        try {
//            $this->view->actual->AktualsLabels->delete();
//            $this->view->actual->AktualsTags->delete();
//            $this->view->actual->delete();
//        } catch ( Exception $e ) {
//            $error = true;
//            $message = $e->getMessage();
//        }
//
//        if ( $error ) {
//            $this->_flash( '/admin/actuals', $message );
//        } else {
//            $this->_flash( '/admin/actuals', 'Artykuł został usunięty z bazy danych!' );
//        }
//    }

    public function clearlabelAction() {
        $idTag = (int)$this->_getParam( 'idT' );
        $idAct = (int)$this->_getParam( 'idA' );
        if ( !$idTag or !$idAct ) {
            return;
        }
        
        $this->view->response = '1';

        try {
            $label = new AktualsLabel();
            $label->getTable()->findOneByAktuals_idAndLabels_id( $idAct, $idTag )->delete();
        } catch( Exception $e ) {
            $this->view->response = $e->getMessage();
        }
        
    }
}
?>

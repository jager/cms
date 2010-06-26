<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_FotoController extends Webbers_Controller_Action {

    private $_path = '/tmp';
    
    public function indexAction() {
        $this->view->formAdd = $this->formFoto( 'add' );
        $this->view->tours = Tournament::getToArray();
        $this->view->list = $this->listGaleries();
        $this->getGaleries();
    }

    private function getGaleries() {
        $this->view->aGaleries = array( -1 => '-- wybierz galerię --');
        $oGalery = Galery::findList()->execute();
        if ( sizeof( $oGalery ) > 0 ) {
            foreach ( $oGalery as $galery ) {
                $this->view->aGaleries[ $galery->id ] = $galery->gname;
            }
        }
    }

    private function formFoto( $section ) {
        $fotoForm = new Webbers_Form_Factory( $section );
        $form = $fotoForm->getForm();
        $form->removeElement('hash');
        return $form;
    }

    private function listGaleries() {
        $page = (int)$this->_getParam( 'page' );
        $paginator = Webbers_Search::factory( Galery::findList() );
        $paginator->setCurrentPageNumber( $page );
        return $paginator;
    }

    public function addAction() {
        if ( !$this->getRequest()->isPost() or !$_POST ) {
            $this->_redirect( '/admin/foto' );
        }
        $form = $this->formFoto( 'add' );

        if ( !$form->isValid( $_POST ) ) {
            $this->_redirect( '/admin/foto' );
        }

        $error = false;
        try {
            $aData = $_POST;
            $aData['tournament_id'] = $_POST['Tournaments_id'];
            unset($aData['Tournaments_id']);
            $galery = new Galery();
            $galeryId = $galery->updateGalery( $aData );
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId, 'Poprawnie zapisano galerię zdjęć!' );
        }
    }

    public function geditAction() {
        $aGalery = $this->validateRequest();
        $this->view->form = $this->formFoto( 'gedit' );
        $this->view->form->setDefaults( (array)$aGalery->_data );
        $this->view->form->setAction( "/admin/foto/gedit/{$aGalery->id}");
        $this->view->tours = Tournament::getToArray();
        $this->view->selectedTour = $aGalery->Tournament->id;

        if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST ) ) {
            return;
        }

        $error = false;
        try {
            $aData = $_POST;
            $aData['tournament_id'] = $_POST['Tournaments_id'];
            unset($aData['Tournaments_id']);
            $galeryId = $aGalery->updateGalery( $aData );
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );            
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId, 'Poprawnie zapisano galerię zdjęć!' );
        }
        
    }

    public function gdeleteAction() {
        $this->view->aGalery = $this->validateRequest();
        //$this->view->aGalery = Galery::getById( $aGalery->id );
        $this->view->form = $this->formFoto( 'gdelete' );
        $this->view->form->setDefaults( (array)$this->view->aGalery->_data );
        $this->view->form->setAction( "/admin/foto/gdelete/{$this->view->aGalery->id}");

        if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST ) ) {
            return;
        }

        $error = false;
        try {
            $this->view->aGalery->delete();
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto', 'Poprawnie usunięto galerię zdjęć!' );
        }
    }

    public function gviewAction() {
        $galeryId = (int)$this->_getParam( 'galID' );
        if ( !$galeryId ) {
            $this->_redirect( '/admin/foto' );
        }
        $this->view->aGalery = Galery::getById( $galeryId );
    }

    private function validateRequest() {
        $galeryId = (int)$this->_getParam( 'galID' );
        if ( !$galeryId ) {
            $this->_redirect( '/admin/foto' );
            return;
        }

        $aGalery = Galery::getById( $galeryId );

        if ( $aGalery == null ) {
            $this->_redirect( '/admin/foto' );
            return;
        }
        return $aGalery;
    }

    public function uploadAction() {
        $aParams = $this->_getAllParams();
        if ( !$this->_request->isPost() or !$_POST ) {
        //    $this->_redirect( '/admin/foto');
        }
            try {                
                $aData['GALERY'] = ( isset( $aParams['galeryId'] ) ) ? $aParams['galeryId'] : -1;
                $foto = new Foto();
                $foto->upload( $aData );
            } catch ( Exception $e ) {
                $this->view->message = $e->getMessage();
            }
    }

    public function editfotoAction() {
        $fotoID = (int)$this->_getParam( 'fotoID' );
        if ( !$fotoID ) {
            $this->_redirect( '/admin/foto' );
            return;
        }

        $this->view->form = $this->formFoto( 'editfoto' );
        $foto = Foto::getById( $fotoID );

        foreach( $foto as $f ) {
            $this->view->form->setDefaults( (array)$f->_data );
            $fotoObj = $f;
        }
        $this->view->form->setAction( '/admin/foto/editfoto/' . $fotoID );
        $this->view->foto = $fotoObj;
        if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST ) ) {
            return;
        }

        $error = false;
        try {
            $galeryId = $fotoObj->updateFoto( $_POST );
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId , 'Poprawnie zapisano dane zdjęcia!' );
        }
    }

    public function fdeleteAction() {
        $fotoID = (int)$this->_getParam( 'fotoID' );
        if ( !$fotoID ) {
            $this->_redirect( '/admin/foto' );
            return;
        }

        $this->view->form = $this->formFoto( 'fdelete' );
        $foto = Foto::getById( $fotoID );

        foreach( $foto as $f ) {
            $this->view->form->setDefaults( (array)$f->_data );
            $fotoObj = $f;
        }
        $this->view->form->setAction( '/admin/foto/fdelete/' . $fotoID );

        if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST ) ) {
            return;
        }

        try {
            $galeryId = $fotoObj->Galeries_id;
            $fotoHandler = new Webbers_File_HandlerFoto();
            $fotoHandler->setSource( $fotoHandler->setDestination( $galeryId ) . $fotoObj->sourcename )
                        ->deleteFoto();
            $fotoHandler->setSource( $fotoHandler->setDestination( $galeryId ) . 'min/' . $fotoObj->sourcename )
                        ->deleteFoto();
            $fotoObj->delete();
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId , 'Zdjęcie zostało usunięte!' );
        }
    }

    public function fmoveAction() {
        $fotoID = (int)$this->_getParam( 'fotoID' );
        if ( !$fotoID ) {
            $this->_redirect( '/admin/foto' );
            return;
        }

        $this->view->form = $this->formFoto( 'fmove' );
        $this->getGaleries();
        $foto = Foto::getById( $fotoID );

        foreach( $foto as $f ) {            
            $fotoObj = $f;
        }
        $this->view->form->setAction( '/admin/foto/fmove/' . $fotoID );

        if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST ) ) {
            return;
        }

        $aData[ 'id' ] = $f->id;
        $aData[ 'Galeries_id'] = $_POST['galery_id'];
        $aData['Tournaments_id'] = $f->Tournaments_id;
        
        try {
            $galeryId = $fotoObj->Galeries_id;
            $fotoObj->moveFoto( $aData, false );
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId , 'Zdjęcie zostało przeniesione!' );
        }
    }

    public function fcopyAction() {
        $fotoID = (int)$this->_getParam( 'fotoID' );
        if ( !$fotoID ) {
            $this->_redirect( '/admin/foto' );
            return;
        }

        $this->view->form = $this->formFoto( 'fmove' );
        $this->getGaleries();
        $foto = Foto::getById( $fotoID );


        foreach( $foto as $f ) {
            $fotoObj = $f;
        }

        if ( isset( $this->view->aGaleries ) and isset( $this->view->aGaleries[ $fotoObj->Galeries_id] ) ) {
            unset( $this->view->aGaleries[ $fotoObj->Galeries_id] );
        }
        $this->view->form->setAction( '/admin/foto/fcopy/' . $fotoID );

        if ( !$this->getRequest()->isPost() or !$_POST ) {
            return;
        }

        $aData[ 'id' ] = $f->id;
        $aData[ 'Galeries_id'] = $_POST['galery_id'];
        $aData['Tournaments_id'] = $f->Tournaments_id;

        try {
            $galeryId = $fotoObj->Galeries_id;
            $fotoObj->moveFoto( $aData, true );
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/foto', $message );
        } else {
            $this->_flash( '/admin/foto/gview/' . $galeryId , 'Zdjęcie zostało skopiowane!' );
        }
    }
    


}
?>

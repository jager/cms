<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileController
 *
 * @author mjagusia
 */
class Admin_FileController extends Webbers_Controller_Action {

    public function init() {
        parent::init();
        $this->_model = new File();
    }

    public function addAction() {
        $this->setFilePath( File::getPath() );
        $this->create();
    }

    public function indexAction() {
        $this->view->list = $this->getList();
    }

    public function editAction() {
        $this->edit();
        $this->view->infoFileBasename = $this->getEntity()->filebasename;
        $this->view->fileID = $this->getEntity()->id;
    }

    public function publishAction() {
        $id = (int)$this->getRequest()->getParam( 'id' );
        $active = (int)$this->getRequest()->getParam( 'active' );
        $file = $this->_model->getById( $id );
        $error = false;
        if ( $file instanceof File ) {
            try {
                $file->active = $active;
                $file->save();
            } catch( Exception $e ) {
                $error = true;
                $messae = $e->getMessage();
            }
        } else {
            $error = true;
            $message = $this->getMessage('noentity');
        }
        if ( $error ) {
            $this->_flash( $this->getLink(), $message );
        } else {
            $this->_flash( $this->getLink(), $this->getMessage( 'add' ) );
        }
    }

    public function changefileAction() {
        $Id = (int)$this->getRequest()->getParam( 'id' );
        $this->setEntity( $this->_model->getById( $Id ) );
        if ( !$Id or !$this->getEntity() ) {
            $this->_flash( $this->getLink(), $this->getMessage( 'noentity' ) );
        }

        $this->view->form = $this->prepareForm( 'changefile' );
        $this->view->form->setAction( $this->getLink() . '/changefile/id/' . $Id );
        $this->view->form->setDefaults( (array)$this->getEntity()->_data );

         if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST )) {
            return;
        }

        $fileBaseName = $this->insertFile();

        $error = false;
        try {
           $this->getEntity()->filebasename = $fileBaseName;
           $this->getEntity()->save();
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( $this->getLink(), $message );
        } else {
            $this->_flash( $this->getLink(), $this->getMessage( 'edit' ) );
        }

    }
}
?>

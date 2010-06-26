<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AktualsController
 *
 * @author mjagusia
 */
class AktualsController extends Webbers_Controller_Action {


    public function indexAction() {
        $this->view->labels = Label::getLabelsArr();
        $this->view->showAllLink = false;
    }

    public function viewAction() {
        $link = $this->_getParam( 'link' );
        $this->view->actuals = Aktual::getByLink( $link );
        if ( !isset( $link ) or ( $link == '' ) ) {
            $this->view->labels = Label::getLabelsArr();
            $this->view->showAllLink = false;
            $this->render( 'index' );
            return;
        }        
    }

    public function labelslistAction() {
        $id = (int)$this->_getParam( 'id' );
        if ( !$id ) {
            $this->_redirect('/aktualnosci');
        }
        $this->view->selectedLabel = $id;
        $this->view->actuals = Aktual::getByLabel( $id );
        $this->view->labels = Label::getLabelsArr();
        $this->view->showAllLink = true;
        $this->render( 'index' );
    }
}
?>

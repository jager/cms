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
        $page = (int)$this->_getParam( 'page' );
        $paginator = Webbers_Search::factory( Aktual::findForFrontPage() );
        $paginator->setItemCountPerPage( 5 );
        $paginator->setCurrentPageNumber( $page );
        $this->view->articles = $paginator;
    }

    public function viewAction() {
        $link = $this->_getParam( 'link' );
        if ( is_numeric( $link ) ) {
            $this->_forward("index", "aktuals", "default", array( "page" => (int)$link) );
        } else {
            $this->view->actuals = Aktual::getByLink( $link );
            $this->view->sidebarArticles = Aktual::findForFrontPage()->limit(5)->execute();
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

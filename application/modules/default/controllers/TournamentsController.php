<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TournamentsController
 *
 * @author mjagusia
 */
class TournamentsController extends Webbers_Controller_Action {
    protected $_mapsApiKey;
    

    public function init() {
        parent::init();
        $aConfig = $this->_bootstrap->getOption( 'google' );
        $this->_mapsApiKey = $aConfig['mapsapikey'];
    }
    public function indexAction() {
        $this->view->active = Tournament::findActive()->execute();
        $this->view->archive = Tournament::findArchive()->execute();
    }
    
    public function viewAction() {
        $id = (int)$this->_getParam( 'id' );
        if ( !$id ) {
            $this->_redirect( '/turnieje' );
        }
        $this->view->mapsApiKey = $this->_mapsApiKey;
        $this->view->tournament = Tournament::getById( $id );
        //Zend_Debug::dump( $this->_log );die();
        //$this->_log->debug( 'Oglądam sobie turniej ' .$this->view->tournament->tname );
    }

    public function showrankAction() {
        $rank = new Rank();
        $this->view->rank = $rank->getRankingTo();
    }
}
?>

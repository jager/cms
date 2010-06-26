<?php

class IndexController extends Webbers_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_forward( 'view' );
    }

    public function viewAction() {
        $page = $this->_getParam( 'page' );
        //Zend_Debug::dump( $page );die();
        $this->view->pageContent = Page::getByLink( $page );

        if ( isset( $this->view->pageContent) and is_object( $this->view->pageContent ) ) {
            if ( $this->view->pageContent->Menus->getFirst()->parent_id == 0 ) {
                $this->view->aktual = Aktual::findForMainPage( 5 );
                $rank = new Rank();
                $this->view->rank = $rank->getRankingTo( 5 );
                $this->view->tournaments = Tournament::findActiveToMainpage( 5 );
                $this->render( 'mainpage' );
            }
        } else {
            echo '404 error';
        }
    }
}


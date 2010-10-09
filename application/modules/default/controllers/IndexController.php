<?php

class IndexController extends Webbers_Controller_Action
{

    public function init() {
        parent::init();
    }

    public function indexAction()
    {
        $this->_forward( 'view' );
    }

    public function viewAction() {
        
        $page = '';
        if ( $this->_hasParam('page') ) {
            $page = $this->_getParam( 'page' );
        }
        $this->view->pageContent = Page::getByLink( $page );
        $this->view->headTitle($this->view->pageContent->hd_title );
        $this->view->headMeta( $this->view->pageContent->hd_keywords, 'keywords' );
        if ( isset( $this->view->pageContent) and is_object( $this->view->pageContent ) ) {
            if ( $this->view->pageContent->Menus->getFirst()->type == 'main' ) {
                $this->view->articles = Aktual::findForMainPage( $this->_bootstrap->getOption( 'mainpage_articles' ) );
                $this->render( 'mainpage' );
            } else {
                if ( isset( $this->view->pageContent->template ) ) {
                    $this->render( $this->view->pageContent->template );
                }
            }
        } else {
            echo '404 error';
        }
    }

    private function getArticles( $num = 0 ) {
        $article = new Actual();
    }
}


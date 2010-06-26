<?php
class Admin_PagesController extends Webbers_Controller_Action {
    public function indexAction() {
        $this->view->list = $this->listPages();
        //$this->view->form = $this->formPages( 'add' );
        //$this->view->menuaddform = $this->formPages( 'menuadd' );
        ///
        ///$this->view->menuItemsWithoutPages = $this->getMenuItems( array( 'Pages_id' => '0' ) );
        //$this->view->menuStructure = Menu::getStructure( 'full', 'object' );
        //$this->view->menuStructure = Menu::getStructure();
        //Zend_Debug::dump($this->view->menuStructure);die();
    }
    public function addAction() {

        $this->view->form = $this->prepareForm( 'add' );
        $this->view->menuItems = $this->getMenuItems();
        $this->view->menuItemsWithoutPages = $this->getMenuItems();
        
        if ( !$_POST or !$this->getRequest()->isPost() ) {
            return;
        }

        $form = $this->formPages( 'add' );

        if ( !$this->view->form->isValid( array_merge( $_POST['page'], $_POST['menu'] ) ) ) {
            return;
        }

        $error = false;
        try {
            $page = new Page();
            $pageID = $page->updatePage( $_POST['page'], $_POST['menu'] );
        } catch( Exception $e ) {
            $message = $e->getMessage();
            $error = true;
        }

        if ( $error ) {
            $this->_flash( '/admin/pages', $message );           
        }
        $this->_flash( '/admin/pages/view/' . $pageID, 'Poprawnie dodana strona statyczna' );
    }

    public function viewAction() {}
    public function editAction() {
        $pageID = (int)$this->_getParam( 'id' );
        if ( !$pageID ) {
            $this->_redirect( '/admin/pages' );
        }
        $this->view->page = Page::getById( $pageID );

        if ( !$this->view->page ) {
            $this->_redirect( '/admin/pages' );
        }

        $this->view->form = $this->formPages( 'edit' );
        $this->view->form->setAction( '/admin/pages/edit/' . $pageID );
        $this->view->form->setDefaults( (array)$this->view->page->_data );
        $this->view->menuItems = $this->getMenuItems();
        $this->view->menuItemsWithoutPages = $this->getMenuItems();

        if ( !$_POST or !$this->getRequest()->isPost() ) {
            return;
        }

        if ( !$this->view->form->isValid( array_merge( $_POST['page'], $_POST['menu'] ) ) ) {
            return;
        }

        $error = false;
        try {
            $pageID = $this->view->page->updatePage( $_POST['page'], $_POST['menu'] );
        } catch( Exception $e ) {
            $message = $e->getMessage();
            $error = true;
        }

        if ( $error ) {
            $this->_flash( '/admin/pages', $message );           
        }
        $this->_flash( '/admin/pages/view/' . $pageID, 'Poprawnie dodane zmiany na stronie' );
    }
    public function deleteAction() {
         $pageId = (int)$this->_getParam( 'id' );
        $this->view->page = Page::getById( $pageId );

        if ( !$pageId or !$this->view->page ) {
            $this->_flash( '/admin/pages', 'Brak wpisu w bazie danych!!' );
        }

        $this->view->form = $this->formPages( 'delete' );

        $this->view->form->setAction( '/admin/pages/delete/' . $pageId );
        $this->view->form->setDefaults( (array)$this->view->page->_data );

         if ( !$this->getRequest()->isPost() or !$_POST or !$this->view->form->isValid( $_POST )) {
            return;
        }

        $error = false;
        try {
            $this->view->page->Menus->delete();
            $this->view->page->delete();
        } catch ( Exception $e ) {
            $error = true;
            $message = $e->getMessage();
        }

        if ( $error ) {
            $this->_flash( '/admin/pages', $message );
        } else {
            $this->_flash( '/admin/pages', 'Strona została usunięta z bazy danych!' );
        }
    }

    private function formPages( $section ) {
        $fotoForm = new Webbers_Form_Factory( $section );
        $form = $fotoForm->getForm();
        $form->removeElement('hash');
        return $form;
    }

    private function listPages() {
        $page = (int)$this->_getParam( 'page' );
        $paginator = Webbers_Search::factory( Page::findList() );
        $paginator->setCurrentPageNumber( $page );
        return $paginator;
    }

    private function getMenuItems( $filter = null ) {
        return Menu::getMenusInArray( $filter );
    }

    public function menuaddAction() {
        $form = $this->formPages( 'menuadd' );
        $error = false;

        if ( !$this->getRequest()->isPost() ) {
            $this->_flash('/admin/pages', 'Błędne odowołanie siŧ do strony!');
            return;
        }

        if ( !$_POST or !$form->isValid( $_POST ) ) {
            $this->view->message = $form->getMessages();
            $error = true;
        } else {
            $menu = new Menu();
            try {
                $menu->updateMenu( $_POST );
            } catch( Exception $e ) {
                $error = true;
                $this->view->message = $e->getMessage();
            }
        }
        if ( $error ) {
            $this->_flash( '/admin/pages', $this->view->message );
            return;
        }
        $this->_flash('/admin/pages', 'Poprawnie dodano element menu!');
    }

    public function menueditAction() {
        $menuID = (int)$this->_getParam( 'id' );
        $mname = $this->_getParam( 'mname' );

        if ( !$menuID or ( $mname == '' ) ) {
            return;
        }

        try {
            $menu = Menu::getMenu( $menuID );
            $menu->mname = $mname;
            $menu->save();
        } catch( Exception $e ) {
            $this->view->message = 0;
        }
        $this->view->message = 1;
    }
}
?>

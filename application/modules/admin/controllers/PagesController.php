<?php
class Admin_PagesController extends Webbers_Controller_Action {

    public function init() {
        parent::init();
        $this->_model = new Page();
    }

    public function indexAction() {
        $this->view->list = $this->getList();
        //$this->view->form = $this->formPages( 'add' );
        //$this->view->menuaddform = $this->formPages( 'menuadd' );
        ///
        ///$this->view->menuItemsWithoutPages = $this->getMenuItems( array( 'Pages_id' => '0' ) );
        //$this->view->menuStructure = Menu::getStructure( 'full', 'object' );
        //$this->view->menuStructure = Menu::getStructure();
        //Zend_Debug::dump($this->view->menuStructure);die();
    }
    public function addAction() {
        $this->view->menuItems = $this->getMenuItems();
        $this->view->menuItemsWithoutPages = $this->getMenuItems();
        $this->create();
    }

    public function viewAction() {
        $this->view->page = $this->view();
    }
    public function editAction() {
        $this->view->menuItems = $this->getMenuItems();
        $this->view->menuItemsWithoutPages = $this->getMenuItems();
        $this->edit();
        $this->view->page = $this->getEntity();
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

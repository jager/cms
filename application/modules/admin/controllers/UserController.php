<?php
class Admin_UserController extends Webbers_Controller_Action {
    public function init() {
        parent::init();
        $this->_model = new Adminuser();
    }

    public function indexAction() {
        $this->view->list = $this->getList();
    }

    public function addAction() {
        $this->create();
    }

    public function editAction() {
        $this->edit();
    }
}
?>

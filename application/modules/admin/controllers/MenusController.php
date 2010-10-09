<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenusController
 *
 * @author mjagusia
 */
class Admin_MenusController extends Webbers_Controller_Action {
    public function init() {
        parent::init();
        $this->_model = new Menu();
    }

    public function indexAction() {
        $this->view->list = $this->getList();
    }
}
?>

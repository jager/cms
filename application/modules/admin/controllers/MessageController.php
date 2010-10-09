<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageController
 *
 * @author mjagusia
 */
class MessageController extends Webbers_Controller_Action {


    public function init() {
        $this->_model = new Message();
    }

    public function addAction() {
        $this->create();
    }

    public function editAction() {
        $this->edit();
    }

    public function indexAction() {
        $this->getList();
    }

    public function viewAction() {
        $this->view();
    }
}
?>

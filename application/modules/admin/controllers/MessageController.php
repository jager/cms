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
class Admin_MessageController extends Webbers_Controller_Action {


    public function init() {        
        parent::init();
        $this->_model = new Message();
    }

    public function addAction() {
        $this->create();
    }

    public function editAction() {
        $this->edit();
    }

    public function indexAction() {
        $this->view->list = $this->getList();
    }

    public function viewAction() {
        $this->view->message = $this->view();
        $this->view->message->opened = '1';
        $this->view->message->save();

        $this->view->aAnswers = $this->view->message->readThread();
    }

    public function answerAction() {
        $this->setEntity( $this->view( $this->getRequest()->getParam( 'id', null ) ) );
        $this->create();
        $this->view->form->removeElement('title');
        $this->view->form->removeElement('reciver');
        $reciver = new Zend_Form_Element_Hidden( 'reciver' );
        $reciver->setName( 'reciver' )
                ->setValue( $this->getEntity()->author );
        $title = new Zend_Form_Element_Hidden( 'title' );
        $title->setName( 'title' )
                ->setValue( 'Re: ' . $this->getEntity()->title );
        $parent_id = new Zend_Form_Element_Hidden( 'parent_id');
        $parent_id->setName( 'parent_id' )
                ->setValue( $this->getEntity()->id );

        $this->view->form
                    ->addElement( $reciver )
                    ->addElement( $title )
                    ->addElement( $parent_id );
    }
}
?>

<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author mjagusia
 */
class Message extends  BaseMessage {

    public function getById( $id ) {
        return $this->getTable()->find( $id );
    }

    public function create( $data ) {
       if ( isset( $data['id'] ) ) {
           $this->id = (int)$data['id'];
       } else {
           $this->sentdate = new Doctrine_Expression( "now()" );
       }
       $this->title =       $data['title'];
       $this->body =        $data['body'];
       $this->author =      (int)Zend_Auth::getInstance()->getIdentity()->id;
       $this->reciver =     (int)$data['reciver'];
       $this->save();
       return $this->getLastModified();
    }

    public function markOpened() {
        $this->opened = '1';
        $this->save();
    }

    public function findList() {
        $query = $this->setFindListQuery()
                 ->where( 'reciver = ' . Zend_Auth::getInstance()->getIdentity()->id );
        return $query;
    }

    private function setFindListQuery() {
        $query = Doctrine_Core::create()
                    ->select( 'm.*' )
                    ->addSelect( "(select concat(sname, ' ', fname) from Adminusers a where Adminuser.id = f.reciver limit 1) as reciver_name" )
                    ->addSelect( "(select concat(sname, ' ', fname) from Adminusers a where Adminuser.id = f.author limit 1) as author_name" )
                    ->from( 'Message m' )
                    ->orderby( 'sentdate desc' );
        return $query;
    }
}
?>

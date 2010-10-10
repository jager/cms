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
       $this->parent_id =   isset( $data['parent_id'] ) ? (int)$data['parent_id'] : 0;
       $this->save();
       return $this->getLastModified();
    }

    public function markOpened() {
        $this->opened = '1';
        $this->save();
    }

    public function findList() {
        $query = $this->setFindListQuery()
                 ->where( 'parent_id = 0 and reciver = ' . Zend_Auth::getInstance()->getIdentity()->id );
       // Zend_Debug::dump( $query->getSqlQuery()); die();
        return $query;
    }

    private function setFindListQuery() {
        $query = Doctrine_Query::create()
                    ->select( 'm.*' )
                    ->addSelect( "(select concat(sname, ' ', fname) from Adminusers a where Adminuser.id = m.reciver limit 1) as reciver_name" )
                    ->addSelect( "(select concat(sname, ' ', fname) from Adminusers a where Adminuser.id = m.author limit 1) as author_name" )
                    ->from( 'Message m' )
                    ->orderby( 'sentdate desc' );
        return $query;
    }

    static public function getCountNotOpened( $id ) {
        return Doctrine_Query::create()->select( "count(1)")
                                       ->from( "Message" )
                                       ->where( "author = ?", (int)$id )
                                       ->where( "opened = '0'")
                                       ->execute( null, Doctrine_Core::HYDRATE_SINGLE_SCALAR );

    }

    public function countAnswers() {
        return Doctrine_Query::create()->select( "count(1)" )
                                       ->from( "Message" )
                                       ->where( "parent_id > 0 and parent_id = ?", $this->id )
                                       ->execute( null, Doctrine_Core::HYDRATE_SINGLE_SCALAR );
    }

    public function readThread() {
        $this->opened = '1';
        $this->save();
        $aAnswers = $this->getTable()->findByParent_id( $this->id );
        
        if ( $aAnswers->count() > 0 ) {
            foreach( $aAnswers as $answer ) {
                $answer->opened = '1';
                $answer->save();
            }
        }
        return $aAnswers;
    }
}
?>

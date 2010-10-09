<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of File
 *
 * @author mjagusia
 */
class File extends BaseFile {

    const FILEPATH = 'repository';

    public function getById( $id ) {
        return $this->getTable()->find( $id );
    }

    static public function getPath() {
        return APPLICATION_PATH . DS . '..' . DS . self::FILEPATH;
    }

    public function create( $aData ) {
        if ( isset( $aData['id'] ) ) {
            $this->id = $aData['id'];
        }
        $this->filename = $aData['filename'];
        $this->fileinfo = $aData['fileinfo'];
        if ( isset( $aData['filebasename'] ) ) {
            $this->filebasename = $aData['filebasename'];
        }
        $this->mime = $aData['mime'];
        $this->active = $aData['active'];
        $this->owner = Zend_Auth::getInstance()->getIdentity()->id;
        $this->sharetype = isset( $aData['sharetype'] ) ? $aData['sharetype'] : 'PRIVATE';
        $this->save();
        return $this->getIncremented();
    }

    public function findList() {
        $q = Doctrine_Query::create()
                ->select('f.*')
                ->addSelect( "(select concat(sname, ' ', fname) from Adminusers a where Adminuser.id = f.owner limit 1) as username" )
                ->from( 'File f' )
                ->orderBy( 'f.added desc');
        
        if ( Zend_Auth::getInstance()->getIdentity()->role != Webbers_Roles::ADMIN ) {
            $q->where( 'f.owner = ?', Zend_Auth::getInstance()->getIdentity()->id );
        }
        return $q;
    }
}
?>

<?php

/**
 * Galery
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Galery extends BaseGalery
{
    public function updateGalery( $aData ) {
        if ( isset( $aData['id'] ) ) {
            $this->id = $aData[ 'id' ];
        }
        $this->gname            = $aData[ 'gname' ];
        $this->gdescription     = $aData['gdescription'];
        $this->tournament_id    = $aData['tournament_id'];
        $this->owner            = ( isset( $aData['owner'] ) and ( $aData['owner'] != '' ) ) ? $aData['owner'] : 0;
        $this->save();
        return $this->getIncremented();
    }

    public static function getById( $id ) {
        return Doctrine_Core::getTable('Galery')->find( $id );
    }

    public static function findList() {
        return Doctrine_Query::create()
                ->select( 'id, gname, gdescription, tournament_id, owner')
                ->from( 'Galery' );
    }
}
<?php

/**
 * Adminuser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
class Adminuser extends BaseAdminuser {
    const INVALID_PASSWORD 		= 1;
    const INVALID_CREDENTIALS 	= 2;
    /**
     *
     * @param string $username
     * @param string $password
     * @return Adminuser
     */
    public static function authenticate( $username, $password ) {
            $adminuser = Doctrine_Core::getTable( 'Adminuser')
                                    ->findOneByUsernameAndActive( $username, '1' );
            if ( $adminuser ) {
                    if ( $adminuser->password == $password ) {
                            self::incrementCorrect( $adminuser );
                            return $adminuser;
                    }
                    self::incrementInCorrect( $adminuser );
                    throw new Exception( self::INVALID_PASSWORD );
            }
            throw new Exception( self::INVALID_CREDENTIALS );
    }

    protected function incrementInCorrect( $adminuser ) {
            $adminuser->lastfaultylogin = date('Y-m-d H:i:s');
            $adminuser->save();
    }

    protected function incrementCorrect( $adminuser ) {
            $adminuser->lastcorrectlogin = date('Y-m-d H:i:s');
            $adminuser->loginamount = $adminuser->loginamount + 1;
            $adminuser->save();
    }
}
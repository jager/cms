<?php

/**
 * BaseAdminuser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $mailadr
 * @property string $fname
 * @property string $sname
 * @property timestamp $created
 * @property timestamp $edited
 * @property timestamp $lastcorrectlogin
 * @property timestamp $lastfaultylogin
 * @property integer $loginamount
 * @property string $active
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAdminuser extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Adminusers');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('username', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '40',
             ));
        $this->hasColumn('password', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '40',
             ));
        $this->hasColumn('mailadr', 'string', 150, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '150',
             ));
        $this->hasColumn('fname', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '50',
             ));
        $this->hasColumn('sname', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '100',
             ));
        $this->hasColumn('created', 'timestamp', null, array(
             'type' => 'timestamp',
             'notnull' => true,
             'default' => 'current_timestamp',
             ));
        $this->hasColumn('edited', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('lastcorrectlogin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('lastfaultylogin', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('loginamount', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => '4',
             ));
        $this->hasColumn('active', 'string', 1, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '0',
             'fixed' => 1,
             'length' => '1',
             ));
        $this->hasColumn('role', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '20',
             ));
        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('File as Files', array(
                         'local' => 'id',
                         'foreign' => 'owner'));
    }
}
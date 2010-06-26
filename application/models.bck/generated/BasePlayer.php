<?php

/**
 * BasePlayer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $fname
 * @property string $sname
 * @property string $mailadr
 * @property string $gender
 * @property string $accept
 * @property timestamp $registered
 * @property integer $registered_by
 * @property Doctrine_Collection $Ranks
 * @property Doctrine_Collection $FotosPlayers
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BasePlayer extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Players');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('fname', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));
        $this->hasColumn('sname', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('mailadr', 'string', 150, array(
             'type' => 'string',
             'length' => '150',
             ));
        $this->hasColumn('gender', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '1',
             ));
        $this->hasColumn('accept', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '1',
             ));
        $this->hasColumn('registered', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('registered_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));


        $this->index('ind_player_mailadr', array(
             'fields' => 
             array(
              0 => 'mailadr',
             ),
             ));
        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Rank as Ranks', array(
             'local' => 'id',
             'foreign' => 'Players_id'));

        $this->hasMany('FotosPlayer as FotosPlayers', array(
             'local' => 'id',
             'foreign' => 'Players_id'));
    }
}
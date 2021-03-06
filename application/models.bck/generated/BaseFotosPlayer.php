<?php

/**
 * BaseFotosPlayer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $Fotos_id
 * @property integer $Players_id
 * @property Foto $Foto
 * @property Player $Player
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFotosPlayer extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('FotosPlayers');
        $this->hasColumn('Fotos_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'unsigned' => true,
             'length' => '4',
             ));
        $this->hasColumn('Players_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));

        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Foto', array(
             'local' => 'Fotos_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $this->hasOne('Player', array(
             'local' => 'Players_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}
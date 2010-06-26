<?php

/**
 * BaseAktualsLabel
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $Aktuals_id
 * @property integer $Labels_id
 * @property Aktual $Aktual
 * @property Label $Label
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAktualsLabel extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('AktualsLabels');
        $this->hasColumn('Aktuals_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('Labels_id', 'integer', 4, array(
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
        $this->hasOne('Aktual', array(
             'local' => 'Aktuals_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $this->hasOne('Label', array(
             'local' => 'Labels_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}
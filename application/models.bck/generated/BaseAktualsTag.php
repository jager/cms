<?php

/**
 * BaseAktualsTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $Aktuals_id
 * @property integer $Tags_id
 * @property Aktual $Aktual
 * @property Tag $Tag
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseAktualsTag extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('AktualsTags');
        $this->hasColumn('Aktuals_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('Tags_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'unsigned' => true,
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

        $this->hasOne('Tag', array(
             'local' => 'Tags_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}
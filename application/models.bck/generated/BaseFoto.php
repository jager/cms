<?php

/**
 * BaseFoto
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $sourcename
 * @property string $description
 * @property clob $tags
 * @property integer $owner
 * @property string $author
 * @property timestamp $added
 * @property integer $Galeries_id
 * @property Galery $Galery
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseFoto extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Fotos');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'unsigned' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('sourcename', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '50',
             ));
        $this->hasColumn('description', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('tags', 'clob', 65535, array(
             'type' => 'clob',
             'length' => '65535',
             ));
        $this->hasColumn('owner', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('author', 'string', 100, array(
             'type' => 'string',
             'length' => '100',
             ));
        $this->hasColumn('added', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('Galeries_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '4',
             ));

        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Galery', array(
             'local' => 'Galeries_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}
<?php

/**
 * BaseTagsRelation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $Tags_id
 * @property integer $rel_id
 * @property string $relname
 * @property Tag $Tag
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class BaseTagsRelation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('TagsRelations');
        $this->hasColumn('Tags_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'unsigned' => true,
             'length' => '4',
             ));
        $this->hasColumn('rel_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('relname', 'string', 45, array(
             'type' => 'string',
             'primary' => true,
             'length' => '45',
             ));

        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Tag', array(
             'local' => 'Tags_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));
    }
}
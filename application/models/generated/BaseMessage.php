<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseMessage
 *
 * @author mjagusia
 */
abstract class BaseMessage extends Doctrine_Record {
    public function setTableDefinition()
    {
        $this->setTableName('Messages');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('body', 'clob', 65535, array(
             'type' => 'clob',
             'length' => '65535',
             ));
        $this->hasColumn('sentdate', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('author', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('reciver', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('opened', 'string', 1, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '1',
             ));
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->option('collate', 'utf8_polish_ci');
        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp() {
        parent::setUp();
    }
}
?>

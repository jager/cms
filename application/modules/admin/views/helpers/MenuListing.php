<?php
class Webbers_View_Helper_MenuListing extends Zend_View_Helper_Abstract {

    protected $_class;
    protected $_id;

    public function MenuListing( $structure, $attribs = array(), $links = true ) {
        $returnString = '';
        $this->setAttribs( $attribs );
        foreach( $structure as $id => $item ) {
            $returnString .= "<li id='item_{$item->id}'><span>{$item->name}</span>";
            if ( $links ) {
                $returnString .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/admin/pages/menuedit/{$item->id}' class='edit menuEditorTrg' id='edit_{$item->id}' >Zmień nazwę</a>";
                $returnString .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/admin/pages/menuactivate/{$item->id}' class='menuActiveTrg' id='active_{$item->id}' >" . ( ($item->active == '1') ? "Dezaktywuj" : "Aktywuj" ) . "</a>";
                $returnString .= "&nbsp;&nbsp;&nbsp;&nbsp;<a href='/admin/pages/menudelete/{$item->id}' class='delete menuDeleteTrg' id='delete_{$item->id}' >Usuń</a>";
            }
            if ( sizeof( $item->pages ) > 0 ) {
                $returnString .= $this->MenuListing( $item->pages, array(), $links );
            }
            $returnString .= "</li>";
        }
        $returnString = "<ul {$this->_id} {$this->_class}>{$returnString}</ul>";
        return $returnString;
    }

    protected function setAttribs( $attribs ) {
        if ( !is_array( $attribs ) ) {
            return;
        }

        if ( isset( $attribs['class' ] ) ) {
            $this->_class = "class='{$attribs['class']}'";
        }

        if ( isset( $attribs['id' ] ) ) {
            $this->_id = "id='{$attribs['id' ]}'";
        }
    }
}
?>

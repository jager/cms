<?php
    $this->placeholder('title')->set( 'Strony statyczne' );
    $this->placeholder('links')->set( $this->partial( 'elements/pages/buttons.inc' ) );
?>
<div class="table">
    <?php echo $this->partial( 'elements/pages/pageslist.inc', array( 'list' => $this->list ) ); ?>
</div>

        <?php //echo $this->partial( 'elements/menu/menulist.inc', array( 'menuStructure' => $this->menuStructure ) ); ?>
        <?php            
            /*$this->menuaddform->getElement( 'parent_id' )->setValue(
                            $this->partial( 'elements/menu/selectmenuitems.inc',
                                    array( 'menuItems' => $this->menuItems,
                                           'menuItemName' => 'parent_id',
                                           'selectLabel' => 'Element nadrzędny',
                                           'idElement'  => 'menuItemParentId') )
                        );
            echo $this->menuaddform;*/
         ?>
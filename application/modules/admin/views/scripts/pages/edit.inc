<?php
    $this->headScript()->appendFile("/js/tiny_mce/tiny_mce.js");
    $this->headScript()->appendFile("/js/editPage.js");
    $title = "Edytujesz stronę: {$this->page->pname}";
    $id = "editPage{$this->page->id}"
?>
<div class="mainBox">
    <ul>
        <li><a href="#<?php echo $id; ?>"><?php echo $title; ?></a></li>
    </ul>
    <div id="<?php echo $id; ?>">
<?php

                        $this->form->getElement( 'menuitem' )->setValue(
                            $this->partial( 'elements/menu/selectmenuitems.inc',
                                    array( 'menuItems' => $this->menuItemsWithoutPages,
                                           'menuItemName' => 'page[menuitem]',
                                           'selectLabel' => 'Element menu',
                                           'selectedItem' => ( isset( $this->page->Menus->getFirst()->id ) ? $this->page->Menus->getFirst()->id : null ),
                                           'idElement' => 'menuItem') )
                        );

                        $this->form->getElement( 'parent_id' )->setValue(
                            $this->partial( 'elements/menu/selectmenuitems.inc',
                                    array( 'menuItems' => $this->menuItems,
                                           'menuItemName' => 'menu[parent_id]',
                                           'selectLabel' => 'Element nadrzędny',
                                           'idElement'  => 'menuItemParentId') )
                        );

                        echo $this->form;
?>
    </div>
</div>
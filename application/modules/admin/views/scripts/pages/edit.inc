<?php
    $this->placeholder('title')->set( 'Strony statyczne' );
    $this->placeholder('links')->set( $this->partial( 'elements/pages/buttons.inc' ) );
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
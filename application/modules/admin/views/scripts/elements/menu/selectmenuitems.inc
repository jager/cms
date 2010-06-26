<div class="select">
    <label for="menuItemParentId"><?php echo $this->selectLabel; ?></label>
<?php
    $menuItems = array( "0" => "--proszę wybrać element--" );
    if ( sizeof( $this->menuItems ) > 0 ):
        foreach( $this->menuItems as $index => $value ):
            $menuItems[ $index ] = $value;
        endforeach;
    endif;
    $selected = isset( $this->selectedItem ) ? $this->selectedItem : null;
    echo $this->formSelect( $this->menuItemName, $selected, array( 'id' => $this->idElement ), $menuItems );
?>
</div>
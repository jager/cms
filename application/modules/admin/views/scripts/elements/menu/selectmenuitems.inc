<div class="field">
    <div class="label">
        <label for="<?php echo $this->idElement ?>"><?php echo $this->selectLabel; ?></label>
    </div>
    <div class="select">
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
</div>
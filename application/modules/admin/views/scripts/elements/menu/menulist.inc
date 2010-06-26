<?php
    if ( sizeof( $this->menuStructure ) > 0 ):
        echo $this->menuListing( $this->menuStructure, array( 'class' => 'menu', 'id' => 'menuToList' ) );
    endif;


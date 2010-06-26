<?php
    $this->form->getElement( 'galery_id')->setValue(
            $this->partial( 'elements/foto/galeryselect.inc', array( 'aGaleries' => $this->aGaleries ) )
            );
    echo $this->form;

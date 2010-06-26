<?php
    $this->placeholder('title')->set( 'Aktualności' );
    $this->placeholder('links')->set( $this->partial( 'elements/actuals/buttons.inc', array( 'id' => $this->actual->id, 'view' => true ) ) );
    $aChecked = array();
    foreach( $this->actual->AktualsLabels as $al ) {
        $aChecked[] = $al->Labels_id;
    }

    $this->form->getElement( 'labels' )
            ->setValue(
            $this->partial( 'elements/label/labelschecklist.inc',
            array( 'labels' => $this->labels, 'aChecked' => $aChecked ) )
    );
    echo $this->form;
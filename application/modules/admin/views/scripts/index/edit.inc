<?php
    $this->placeholder('title')->set( 'Twoje dane do konta' );
    $this->placeholder('links')->set( '' );
    //$this->placeholder('additionalclass')->set('box-left');
    $this->form->getElement('info')->setValue( $this->partialLoop( 'elements/index/info.inc', $this->aData ) );
    echo $this->form;
<?php
    $this->headScript()->appendFile( '/scripts/custom/jquery.metadata.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/jquery.validate.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/jquery.validate.aux.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/bootstrap.js' ) ;
    $this->placeholder('title')->set( 'Aktualności' );
    $this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/actuals">Wróć do listy artykułów</a></li>
                                   </ul>' );
?>

<?php
    $this->form->getElement( 'labels' )
            ->setValue(
            $this->partial( 'elements/label/labelschecklist.inc',
            array( 'labels' => $this->labels, 'aChecked' => array() ) )
    );
    echo $this->form;
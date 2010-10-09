<?php
    $this->headScript()->appendFile( '/scripts/custom/jquery.metadata.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/jquery.validate.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/jquery.validate.aux.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/bootstrap.js' ) ;
    $this->placeholder('title')->set( 'Galerie zdjęć' );
    $this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/galery">Wróć do listy galerii</a></li>
                                   </ul>' );
    echo $this->form;
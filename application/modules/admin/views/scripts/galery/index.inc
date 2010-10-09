<?php
$this->placeholder('title')->set( 'Galerie zdjęć' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/galery/add">Dodaj nową galerię zdjęć</a></li>
                                   </ul>' );
?>
<div class="table">
    <?php echo $this->partial( 'elements/galery/galerylist.inc', array( 'list' => $this->list ) ); ?>
</div>
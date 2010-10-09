<?php
$this->placeholder('title')->set( 'Dodane do systemu pliki' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/file/add">Dodaj nowy plik</a></li>
                                   </ul>' );
?>
<div class="table">
    <?php echo $this->partial( 'elements/file/filelist.inc', array( 'list' => $this->list ) ); ?>
</div>
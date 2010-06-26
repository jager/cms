<?php
$this->placeholder('title')->set( 'Aktualności' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/actuals/add">Dodaj artykuł</a></li>
                                   </ul>' );
?>
<div class="table">
    <?php echo $this->partial( 'elements/actuals/actualslist.inc', array( 'list' => $this->list ) ); ?>
</div>



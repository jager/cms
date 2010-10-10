<?php
$this->placeholder('title')->set( 'Twoje Wiadomości' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/message/add">Wyślij wiadomość</a></li>
                                   </ul>' );
?>
<div class="table">
    <?php echo $this->partial( 'elements/message/messagelist.inc', array( 'list' => $this->list ) ); ?>
</div>
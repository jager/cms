<?php
$this->placeholder('title')->set( 'Użytkownicy' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/user">Listuj użytkowników</a></li>
                                        <li><a href="/admin/user/add">Dodaj użytkownika</a></li>
                                   </ul>' );
?>
<div class="table">
    <?php echo $this->partial( 'elements/user/userlist.inc', array( 'list' => $this->list ) ); ?>
</div>
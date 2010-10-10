<?php
$this->placeholder('title')->set( 'Twoje Wiadomości::Dodaj nową wiadomość' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/message">Listuj wiadomości</a></li>
                                        <li><a href="/admin/message/add">Wyślij wiadomość</a></li>
                                   </ul>' );
?>
<?php
    echo $this->form;

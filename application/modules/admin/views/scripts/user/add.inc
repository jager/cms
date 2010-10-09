<?php
$this->placeholder('title')->set( 'Użytkownicy::Dodaj użytkownika' );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/user">Listuj użytkowników</a></li>
                                        <li><a href="/admin/user/add">Dodaj użytkownika</a></li>
                                   </ul>' );
    echo $this->form;
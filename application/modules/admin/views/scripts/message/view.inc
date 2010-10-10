<?php
$this->placeholder('title')->set( 'Twoje Wiadomości::' . $this->message->title );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/message">Listuj wiadomości</a></li>
                                        <li><a href="/admin/message/add">Wyślij wiadomość</a></li>
                                   </ul>' );
?>
<h3><?php echo $this->message->title; ?></h3>
<p>
    <strong>Data wysłania: </strong><?php echo $this->message->sentdate;?>
    <span style="float: right; padding-right: 40px">
        <a class="delete listMenu asBox" href="/admin/message/answer/id/<?php echo $this->message->id ?>" >Odpowiedz</a>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a class="delete listMenu asBox" href="/admin/message/delete/id/<?php echo $this->message->id ?>" >Usuń</a>
    </span>
    <span style="clear: both"></span>
</p>
<p>
    <?php echo $this->message->body;?>
</p>
<div style="padding-left: 30px">
<?php
    if ( isset( $this->aAnswers )):
        foreach( $this->aAnswers as $answer ):
            echo $this->partial( 'elements/message/messageviewer.inc',
                    array(
                        'parentID' => $this->message->id,
                        'answer'   => $answer
                    )
                 );
        endforeach;
    endif;
?>
</div>
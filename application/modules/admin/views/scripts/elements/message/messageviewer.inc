<h5><?php echo $this->answer->title; ?></h5>
<p>
    <strong>Data wysłania: </strong><?php echo $this->answer->sentdate;?>
    <span style="float: right; padding-right: 40px">
        <a class="delete listMenu asBox" href="/admin/message/answer/id/<?php echo $this->parentID ?>" >Odpowiedz</a>
    </span>
    <span style="clear: both"></span>
</p>
<p>
    <?php echo $this->answer->body;?>
</p>
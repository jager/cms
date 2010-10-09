<?php
    foreach( $this->articles as $article):
?>
    <h3><?php echo $article->title; ?></h3>
    <p><?php echo $article->shortcontent; ?></p>
    <p class="read-more"><a title="<?php echo $article->title; ?>" href="/aktualnosci/<?php echo $article->link;?>">CZYTAJ DALEJ</a></p>

<?php
    endforeach;
?>

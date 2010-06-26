<dl id="mainPageActualsq">
<?php foreach( $this->aktual as $aktual ): ?>
    <dt><?php echo $aktual->title?></dt>
    <dd>
        <?php echo $aktual->shortcontent ?>
        <a class="more" href="/aktualnosci/<?php echo $aktual->link; ?>"> czytaj więcej </a>
    </dd>
<?php endforeach; ?>
</dl>
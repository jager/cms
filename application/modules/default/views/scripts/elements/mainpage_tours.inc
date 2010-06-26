<dl id="mainPageTours">
<?php
    $aKind = array(
        'female'    => '<span class="female">Turniej Kobiecy</span>',
        'male'      => '<span class="male">Turniej Męski</span>',
        'mixed'     => '<span class="mixed">Turniej Mieszany</span>'
    );
    foreach( $this->tours as $tour ):
?>
<dt><?php echo $tour->tname;?></dt>
<dd>
    <p><strong>Data:</strong> <?php echo $tour->start_date; ?> <strong>Godzina:</strong> <?php echo $tour->start_time; ?></p>
    <p class="kind"><?php echo $aKind[ $tour->kind ]; ?></p>
    <p><strong>Miejsce:</strong> <?php echo $tour->address; ?></p>
    <p class="lastLine"><a class="more" href="/turnieje/opis/<?php echo $tour->id;?>">zobacz więcej</a></p>
</dd>
<?php endforeach; ?>
</dl>
<ol>
    <?php
        $i = 0;
        foreach( $this->rank as $rank ):
    ?>
    <li><?php echo $rank->name; ?>&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $rank->points; ?> pkt.</strong></li>
    <?php endforeach; ?>
</ol>
<?php if( $this->more ): ?>
<p class="rankMore"><a href="/turnieje/ranking">zobacz więcej</a></p>
<?php endif; ?>
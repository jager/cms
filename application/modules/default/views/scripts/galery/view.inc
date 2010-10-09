<div id="full-width-content">
<h3><?php echo $this->galery->gname; ?></h3>
<p><?php echo $this->galery->gdescription; ?></p>

<?php
    if ( sizeof( $this->aFotos ) > 0 ):
        $i = 0;
        foreach( $this->aFotos as $foto ):
            $i++;
            $path = '/var/gallery' . DS . $this->galery->id . DS . 'min';
            $pathFull = '/var/gallery' . DS . $this->galery->id;
?>
    <div class="portfolio-box">
        <a rel="gallery" class="lightbox thumb" href="<?php echo $pathFull . DS . $foto->sourcename ?>">
                <img alt="" src="<?php echo $path . DS . $foto->sourcename ?>" style="opacity: 1;">
        </a>
        <p><?php echo $foto->description; ?></p>
    </div>
<?php
            if ( ($i % 3) ==  0 ):
                echo "<div class='clear'></div>";
            endif;
        endforeach;
    else:
?>
    <p>Brak zdjęć w galerii!</p>
<?php endif; ?>
</div>
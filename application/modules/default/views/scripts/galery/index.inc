<div id="full-width-content">
<?php
    if ( sizeof( $this->aGaleries ) > 0 ):
        $i = 0;
        foreach( $this->aGaleries as $galery ):
            $i++;
            $fotos = $galery->Fotos;
            $fCount = $fotos->count();
            $foto = $fotos->getFirst();
            $pathMax = '/var/gallery/' . DS . $galery->id;
            $pathMin = $pathMax . DS . 'min';
            if ( $fCount > 0 ):
?>
    <div class="portfolio-box">
        <a rel="gallery" class="lightbox thumb" title="<?php echo $galery->gname; ?>" href="<?php echo $pathMax . DS . $foto->sourcename ?>">
                <img alt="Galeria zdjęć: <?php echo $galery->gname; ?>. Ilość zdjęć: <?php echo $fCount; ?>" src="<?php echo $pathMin . DS . $foto->sourcename ?>" style="opacity: 1;">
        </a>
        <h3><a title="" href="/galerie/<?php echo $galery->id; ?>"><?php echo $galery->gname; ?></a></h3>
        <p><?php echo $galery->gdescription; ?></p>
        <p><a title="Obejrzyj galerię zdjęć" href="/galerie/<?php echo $galery->id; ?>">Pokaż zdjęcia</a></p>
    </div>
<?php
            if ( ($i % 3) ==  0 ) {
                echo "<div class='clear'></div>";
            }
            endif;
        endforeach;
    else:
?>
    <p>Brak galerii w systemie!</p>
<?php endif; ?>
</div>
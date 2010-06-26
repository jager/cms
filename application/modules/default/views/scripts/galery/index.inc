<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/galerie', 'text' => 'Galerie zdjęć' )
            ), '/'
            );
?>
</div>
<div id="portfolio-content">
<?php
    if ( sizeof( $this->aGaleries ) > 0 ):
        foreach( $this->aGaleries as $galery ):
            $fotos = $galery->Fotos;
            $fCount = $fotos->count();
            $foto = $fotos->getFirst();
            $path = '/var/gallery' . DS . $galery->id . DS . 'min';
?>
    <div class="portfolio-item">
        <a class="portfolio-item-image"  href="/galerie/<?php echo $galery->id; ?>" title="Galeria zdjęć: <?php echo $galery->gname; ?>. Ilość zdjęć: <?php echo $fCount; ?>">
            <img src="<?php echo $path . DS . $foto->sourcename ?>" alt="Galeria zdjęć: <?php echo $galery->gname; ?>. Ilość zdjęć: <?php echo $fCount; ?>" />
        </a>
        <h3><a href="/galerie/<?php echo $galery->id; ?>"><?php echo $galery->gname; ?></a></h3>
        <p><?php echo $galery->gdescription; ?></p>
    </div><!-- end portfolio-item -->
<?php
        endforeach;
    else:
?>
    <p>Brak galerii w systemie!</p>
<?php endif; ?>
</div>
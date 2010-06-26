<?php
    $this->headScript()->appendFile( '/js/jquery.prettyPhoto.js');
    $this->headLink()->appendStylesheet( '/css/prettyPhoto.css' );
    $this->headScript()->appendFile( '/js/viewGalery.js');
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/galerie', 'text' => 'Galerie zdjęć' ),
                array( 'href' => '/galerie/' . $this->galery->id, 'text' => $this->galery->gname )
            ), '/'
            );
?>
</div>
<h3><?php echo $this->galery->gname; ?></h3>
<p><?php echo $this->galery->gdescription; ?></p>
<div id="portfolio-content">
<?php
    if ( sizeof( $this->aFotos ) > 0 ):
        foreach( $this->aFotos as $foto ):
            $path = '/var/gallery' . DS . $this->galery->id . DS . 'min';
            $pathFull = '/var/gallery' . DS . $this->galery->id;
?>
    <div class="portfolio-item">
        <a class="portfolio-item-image"  rel="prettyPhoto[gallery1]" href="<?php echo $pathFull . DS . $foto->sourcename ?>" >
            <img src="<?php echo $path . DS . $foto->sourcename ?>" alt="" />
        </a>       
        <p><?php echo $foto->description; ?></p>
    </div><!-- end portfolio-item -->
<?php
        endforeach;
    else:
?>
    <p>Brak zdjęć w galerii!</p>
<?php endif; ?>
</div>
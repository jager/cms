<?php
    $this->headScript()->appendFile( '/js/fotoview.js' ) ;
?>
<div class="mainBox">
    <h3><a href="#galeryViewDetails"><?php echo 'Galeria: ' . $this->aGalery->gname; ?></a></h3>
    <div id="galeryViewDetails">
        <?php
           echo $this->partial( 'elements/foto/galeryview.inc', array( 'aGalery' => $this->aGalery ) );
        ?>
    </div>
    <h3><a href="#galeryFotoListViewer">Zdjęcia:</a></h3>
    <div id="galeryFotoListViewer">
        <?php echo $this->partial( 'elements/foto/fotolist.inc',
                        array( 'fotos' => $this->aGalery->Fotos, 'galeryID' => $this->aGalery->id ) ); ?>
    </div>
    
</div>

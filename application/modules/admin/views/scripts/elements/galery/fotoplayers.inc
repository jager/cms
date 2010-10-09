<div class="textarea">
    <label for="playersToFoto">
        Zawodnicy na zdjęciu: <br />
        <img src="<?php echo '/var/gallery' . DS . $this->foto->Galeries_id . DS . 'min/' . $this->foto->sourcename ?>" alt="" />
    </label>
    <div id="donePlayers"></div>
    <?php echo $this->formText( 'pl', null, array( 'id' => 'playersToFoto', 'class' => 'autocomplete' ) ); ?>
</div>

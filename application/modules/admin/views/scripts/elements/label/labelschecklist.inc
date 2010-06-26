<div class="field">
    <div class="label">
        <label for="newlabelID">Etykiety</label>
    </div>
    <div class="checkboxes">
<?php
    if ( sizeof( $this->labels ) > 0 ):
        echo $this->formMultiCheckbox( 'labels', $this->aChecked, array( 'class' => 'labelsList' ), $this->labels, '');
    endif;
?>
    </div>
    <div class="input text">
        <?php echo $this->formText( 'newlabel', null, array( 'class' => 'newLabelText', 'id' => 'newLabelID' ) ); ?>
    </div>
</div>

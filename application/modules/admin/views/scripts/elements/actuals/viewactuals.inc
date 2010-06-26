<?php
    $aElements = array(
        'title' => 'Tytuł',
        'shortcontent' => 'Wstęp',
        'fullcontent' => 'Treść',
        'tags'  => 'Tagi',
        'created' => 'Data utworzenia',
        'modified'  => 'Data modyfikacji',
        'link' => 'Odnośnik',
        'labels' => 'Etykiety'
    );
?>
<dl class="viewAktuals">
<?php
    foreach( $aElements as $key => $elem ):
        if ( $key != 'labels' ):
            $value = ( $this->actual->$key ) ? $this->actual->$key : '----------------';
?>
            <dt><?php echo $elem; ?>:</dt>
            <dd><?php echo $value; ?></dd>
<?php
        else:
?>
            <dt>Należy do:</dt>
            <dd>
<?php
            foreach( $this->actual->AktualsLabels as $label ):
?>
                <div class="tagContainer ui-state-default ui-corner-all" actual_id="<?php echo $this->actual->id; ?>" id="tagContainer_<?php echo $label->Label->id; ?>">
                    <?php echo $label->Label->Gname ?>
                    <span class="ui-icon ui-icon-close closeBtn" id="tagCloseBtn_<?php echo $label->Label->id; ?>"></span>
                </div><div class="clearing" ></div>
<?php
            endforeach;
?>
            </dd>
<?php
        endif;
    endforeach;
?>
</dl>
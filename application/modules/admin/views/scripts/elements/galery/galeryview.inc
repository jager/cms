<?php
    
    if ( $this->aGalery !== false ):
?>
        <dl class="detailViewer">
<?php
        $playersData = array(
            "gname"             => "Nazwa:",
            "gdescription"      => "Opis:",
            "tournament_id"     => "Połączona z turniejem:",
            "owner"             => "Właściciel:"
        );
        foreach( $playersData as $index => $value ):
            if ( isset( $this->aGalery->$index ) ):
                    $galeryValue = $this->aGalery->$index;
                    if ( $index == "tournament_id"):
                        $galeryValue = ( isset( $this->aGalery->Tournament->tname ) and ( $this->aGalery->Tournament->tname != '' ) ) ? $this->aGalery->Tournament->tname : '-----------------------';
                    endif;
                    if ( $index == 'owner' ):
                        $galeryValue = $this->aGalery->$index > 0 ? $this->aGalery->$index : 'adminstrator';
                    endif;
?>
            <dt><?php echo $value; ?></dt>
            <dd><?php echo $galeryValue ?></dd>
<?php
            endif;
        endforeach;
?>
        </dl>
<?php
    endif;

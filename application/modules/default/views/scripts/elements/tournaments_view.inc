<dl class="even">
<?php
    $tourData = array(
        "tname"             => "Nazwa turnieju",
        "kind"              => "Rodzaj turnieju",
        "start_date"        => "Data roczpoczęcia",
        "start_time"        => "Godzina pierwszego meczu",
        "city"              => "Miejsce",
        "rank"              => "Ilość punktów rankingowych",
        "max_team_no"       => "Maksym. liczba zespołów",
        "start_enroll"      => "Rozpoczęcie zapisów",
        "end_enroll"        => "Zakończenie zapisów"
    );
    foreach( $tourData as $key => $value ):
        if ( isset( $this->tournament->$key ) ):
                $tourValue = $this->tournament->$key;
                if ( $key == "city" ):
                    $tourValue = "{$this->tournament->zip} {$this->tournament->city}, {$this->tournament->street}";
                endif;
                if ( $key == 'kind' ):
                    switch ( $tourValue ):
                        case 'female': $tourValue = 'Turniej Żeński'; break;
                        case 'male': $tourValue = 'Turniej Męski'; break;
                        default: $tourVaue = 'Turniej Mieszany'; break;
                    endswitch;
                endif;
?>
            <dt><?php echo $value ?></dt>
            <dd><?php echo $tourValue ?></dd>
<?php
        endif;
    endforeach;
?>
</dl>

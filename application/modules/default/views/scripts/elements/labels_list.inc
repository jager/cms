<?php
    if ( sizeof( $this->labels ) > 0 ):
        echo "<li><h3>Kategorie</h3><ul>";
        foreach( $this->labels as $labelId => $labelName ):
             if ( $labelId == $this->selectedLabel ):
?>
                <li><span class="selectedLabel"><?php echo $labelName; ?></span></li>
<?php
             else:
?>
                <li><a href="/kategorie/<?php echo $labelId; ?>"><?php echo $labelName; ?></a></li>
<?php
             endif;
        endforeach;
        if ( $this->all ):
            echo "<li><a href='/aktualnosci'>Pokaż wszystkie</a></li>";
        endif;
        echo "</ul></li>";
    endif;
?>

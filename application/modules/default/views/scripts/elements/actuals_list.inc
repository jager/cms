<?php foreach( $this->actuals as $actual ): ?>
    <h2><a href="/aktualnosci/<?php echo $actual->link; ?>"><?php echo $actual->title; ?></a></h2>
    <h5>Kategorie:
    <?php
        $labels = $actual->getLabels();
        if ( sizeof( $labels ) > 0 ):
            $lab = '';
            foreach( $labels as $l ):
                if ( $this->selectedLabel == $l->id ):
                    $lab .= " <span class='selectedLabel'>{$l->Gname}</span>,";
                else:
                    $lab .= " <a href='/kategorie/{$l->id}'>{$l->Gname}</a>,";
                endif;
            endforeach;            
        else:
            $lab = 'brak,';
        endif;
        echo $lab;
    ?>
        <br />
        <span class="date">Data modyfikacji: <strong><?php echo $actual->edited; ?></strong></span>
    </h5>
    <!--
    <p><img src="img/blog/blog-img-1.jpg" alt=""/></p>
    -->
    <p>
        <?php echo $actual->shortcontent; ?>
         <br/>
         <a href="/aktualnosci/<?php echo $actual->link; ?>">Czytaj więcej...</a>
    </p>
<?php endforeach; ?>
<?php
    $this->headScript()->appendFile( '/js/coin-slider/coin-slider.min.js' );
    $this->headScript()->appendFile( '/js/viewActuals.js');
    $this->headLink()->appendStylesheet( '/css/coin-slider-styles.css' );
    echo $this->partial( 'elements/subheader.inc', array( 'title' => $this->actuals->title ) );
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/aktualnosci', 'text' => 'Aktualności' ),
                array( 'href' => '/aktualnosci/' . $this->actuals->link, 'text' => $this->actuals->title ),
            ), '/'
            );
?>
</div>
<h2><a href="/aktualnosci/<?php echo $this->actuals->link; ?>"><?php echo $this->actuals->title; ?></a></h2>
<h5>Kategorie:
    <?php
        $labels = $this->actuals->getLabels();
        if ( sizeof( $labels ) > 0 ):
            $lab = '';
            foreach( $labels as $l ):
                $lab .= " <a href='/kategorie/{$l->id}'>{$l->Gname}</a>,";
            endforeach;
        else:
            $lab = 'brak,';
        endif;
        echo $lab;
    ?>
        <br />
        <span class="date">Data modyfikacji: <strong><?php echo $this->actuals->edited; ?></strong></span>
    </h5>
<!--
<p><img src="img/blog/blog-img-1.jpg" alt=""/></p>
-->
<p class="shortContent"><?php echo $this->actuals->shortcontent; ?></p>
<p class="fullContent"><?php echo $this->actuals->fullcontent; ?></p>

<?php
$this->headScript()->appendFile( '/js/coin-slider/coin-slider.min.js' );
$this->headScript()->appendFile( '/js/viewActuals.js');
$this->headLink()->appendStylesheet( '/css/coin-slider-styles.css' );
echo $this->partial( 'elements/subheader.inc', array( 'title' => 'Zapraszamy na turnieje' ) );
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/turnieje', 'text' => 'Turnieje' )
            ), '/'
            );
?>
</div>
<?php
echo $this->partial( 'elements/tournaments_list.inc', array( 'tournaments' => $this->active, 'title' => 'Turnieje aktywne' ) );
echo $this->partial( 'elements/tournaments_list.inc', array( 'tournaments' => $this->archive, 'title' => 'Turnieje archiwalne' ) );
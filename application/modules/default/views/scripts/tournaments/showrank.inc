<?php
$this->headScript()->appendFile( '/js/coin-slider/coin-slider.min.js' );
$this->headScript()->appendFile( '/js/viewActuals.js');
$this->headLink()->appendStylesheet( '/css/coin-slider-styles.css' );
echo $this->partial( 'elements/subheader.inc', array( 'title' => 'Rankingi kobiet i mężczyzn' ) );
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/turnieje/ranking', 'text' => 'Ranking' )
            ), '/'
            );
?>
</div>
<div class="single-half-width-column">
     <h3>Ranking mężczyzn</h3>
        <?php echo $this->partial( 'elements/mainpage_rank.inc', array( 'rank' => $this->rank['male'], 'more' => false ) ); ?>

</div>
<div class="single-half-width-last-column">
    <h3>Ranking kobiet</h3>
        <?php echo $this->partial( 'elements/mainpage_rank.inc', array( 'rank' => $this->rank['female'], 'more' => false ) ); ?>
</div>
<?php 
    $this->headScript()->appendFile( '/js/mainpage.js');
    echo $this->partial( 'elements/slider.inc');
?>

<!-- end slider -->


<div class="single-third-width-column">
    <h3>Aktualności</h3>
    <?php echo $this->partial( 'elements/mainpage_actuals.inc', array( 'aktual' => $this->aktual ) ); ?>
</div>

<div class="single-third-width-column">
    <h3>Terminarz turniejowy</h3>
    <?php echo $this->partial( 'elements/mainpage_tours.inc', array( 'tours' => $this->tournaments ) ); ?>
</div>

<div class="single-third-width-last-column">
    <h3>Ranking mężczyzn</h3>
        <?php echo $this->partial( 'elements/mainpage_rank.inc', array( 'rank' => isset( $this->rank['male'] ) ? $this->rank['male'] : array(), 'more' => true ) ); ?>
    <h3>Ranking kobiet</h3>
        <?php echo $this->partial( 'elements/mainpage_rank.inc', array( 'rank' => isset( $this->rank['female'] ) ? $this->rank['female'] : array(), 'more' => true ) ); ?>
</div>
<?php
    $this->headScript()->appendFile( '/js/coin-slider/coin-slider.min.js' );
    $this->headScript()->appendFile( '/js/viewActuals.js');
    $this->headLink()->appendStylesheet( '/css/coin-slider-styles.css' );
    $this->headScript()->appendFile( 'http://maps.google.com/maps?file=api&v=2&key=' . $this->mapsApiKey . '&sensor=false' );
    echo $this->partial( 'elements/subheader.inc', array( 'title' => $this->tournament->tname ) );
    $enrolledTeamsNo = $this->tournament->Teams->count();
    $freeEnrollment = ( ( $this->tournament->max_team_no - $enrolledTeamsNo ) > 0 ) ? true : false;
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/turnieje', 'text' => 'Turnieje' ),
                array( 'href' => '/turnieje/opis/' . $this->tournament->id, 'text' => $this->tournament->tname )
            ), '/'
            );
?>
</div>
<h3><?php echo $this->tournament->tname; ?></h3>
<div class="single-half-width-column">
    <?php echo $this->partial( 'elements/tournaments_view.inc', array( 'tournament' => $this->tournament ) ); ?>
</div>
<div class="single-half-width-last-column">
    <div id="links_box">
        <?php if ( ( $this->tournament->start_date > date('Y-m-d') ) and
                   isset( $this->tournament->start_enroll ) and
                   ( $this->tournament->start_enroll > date('Y-m-d') ) and
                    $freeEnrollment ): ?>
        <a href="/pages/zgloszenia.html">Zgłoś się do turnieju</a>&nbsp;&nbsp;|&nbsp;&nbsp;
        <?php endif; ?>
        <?php if ( date('Y-m-d') > $this->tournament->start_date ): ?>
        <a href="/turnieje/ranking">Pokaż ranking</a>
        <?php endif; ?>
    </div>
    <div id="maps_canvas" style="width: 400px; height: 230px; border: 1px solid #333"></div>
</div>
<?php echo $this->map( array( 'address' => $this->tournament->zip . ' ' . $this->tournament->city . ', ' . $this->tournament->street ) ); ?>

<div id="content">
    <div id="home-description">
<?php 
    $countArt = sizeof( $this->articles );
    if ( $countArt > 0 ) {
        echo $this->partial( 'elements/mainpage_first_article.inc', array( 'article' => $this->articles[0] ) );
        unset( $this->articles[0] );
    }
?>
    </div>
    <div id="home-widget-area">
<?php
    echo isset( $this->pageContent->content ) ? $this->pageContent->content : null;
    //Zend_Debug::dump($this->articles);
?>
    </div>
</div>
<div id="sidebar">
    <div class="widget">
        <h2>Aktualności ze szkoły</h2>
    <?php
        if ( $countArt > 0 ) {
        echo $this->partial( 'elements/sidebar_articles.inc', array( 'articles' => $this->articles ) );
    }
    ?>
    </div>
</div>
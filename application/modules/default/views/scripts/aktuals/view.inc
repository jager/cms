<!--<div id="breadcrumbPanel">-->
<?php
//    echo $this->breadcrumbLinks(
//            array(
//                array( 'href' => '/', 'text' => 'Home' ),
//                array( 'href' => '/aktualnosci', 'text' => 'Aktualności' ),
//                array( 'href' => '/aktualnosci/' . $this->actuals->link, 'text' => $this->actuals->title ),
//            ), '/'
//            );
?>
<!--</div>-->
<div id="content">
    <div id="pad">
        <h2 class="page-title"><?php echo $this->actuals->title; ?></h2>
        <span class="author-box">Dodany <?php echo $this->actuals->edited; ?>,
            <?php
                $labels = $this->actuals->getLabels();
                $lab = '';
                if ( sizeof( $labels ) > 0 ):
                    foreach( $labels as $l ):
                        $lab .= " <a href='/kategorie/{$l->id}'>{$l->Gname}</a>,";
                    endforeach;
                endif;
                echo $lab;
            ?>
        </span>
        <p class="shortContent"><?php echo $this->actuals->shortcontent; ?></p>
        <p class="fullContent"><?php echo $this->actuals->fullcontent; ?></p>
    </div>
</div>
<div id="sidebar">
    <?php echo $this->partial( 'elements/articles_scroller_widget.inc', array( 'articles' => $this->sidebarArticles ) ); ?>
</div>
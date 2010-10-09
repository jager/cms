<div id="content">
    <div class="pad">
<?php
    $i = 0;
    foreach( $this->articles as $article ):
            if ( $i == 0 ):
?>
                <div class="featured-news">
                    <?php echo $this->partial( 'elements/actuals_single_article.inc', array( 'article' => $article ) ); ?>
                </div>
<?php
            else:
?>
                <div class="news-article">
                    <?php echo $this->partial( 'elements/actuals_single_article.inc', array( 'article' => $article ) ); ?>
                </div>
<?php
            if ( ( $i % 2 ) == 0 ):
                echo "<div class='clear'></div>";
            endif;
        endif;
        $i++;
    endforeach;
?>
<div class="clear"></div>

<!-- PAGINATION -->
<div class="wp-pagenavi">
    <span class="pages"><?php echo "Strona " . $this->articles->getCurrentPageNumber() . " z " . $this->articles->count(); ?> </span>
    <?php echo $this->articles; ?>
    <!--<span class="current">1</span>
    <a title="2" class="page" href="">2</a>
    <a title="3" class="page" href="">3</a>
    <a href="">»</a>-->
</div><!-- .wp-pagenavi (end) -->



    </div>
</div>


	                	

				

<?php
    /*echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/aktualnosci', 'text' => 'Aktualności' )
            ), '/'
            );*/
?>

    <?php //echo $this->partial( 'elements/labels_list.inc', array( 'labels' => $this->labels, 'all' => $this->showAllLink, 'selectedLabel' => $this->selectedLabel ) ); ?>
            <?php //echo $this->partial( 'elements/actuals_list.inc', array( 'actuals' => $this->actuals, 'selectedLabel' => $this->selectedLabel ) ); ?>
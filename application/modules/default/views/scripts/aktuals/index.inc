<?php
    $this->headScript()->appendFile( '/js/coin-slider/coin-slider.min.js' );
    $this->headScript()->appendFile( '/js/viewActuals.js');
    $this->headLink()->appendStylesheet( '/css/coin-slider-styles.css' );
    echo $this->partial( 'elements/subheader.inc', array( 'title' => 'Aktualności' ) );
?>
<div id="breadcrumbPanel">
<?php
    echo $this->breadcrumbLinks(
            array(
                array( 'href' => '/', 'text' => 'Home' ),
                array( 'href' => '/aktualnosci', 'text' => 'Aktualności' )
            ), '/'
            );
?>
</div>
<ul id="sidebar">
<!--
		<li><h3>Search</h3>
			<form action="blog.html" method="post">
				<p>
					<input class="text" id="search-input" type="text" onblur="if (this.value == '') {this.value = 'Type your search and hit enter'}" onfocus="if (this.value == 'Type your search and hit enter') {this.value = '';}" value="Type your search and hit enter"/>
				</p>
			</form>
		</li>

		<li><h3>Archives</h3>
			<ul>
				<li><a href="#">March 2010</a></li>
				<li><a href="#">February 2010</a></li>
				<li><a href="#">January 2010</a></li>
				<li><a href="#">December 2009</a></li>
				<li><a href="#">November 2009</a></li>
			</ul>
		</li>
-->
    <?php echo $this->partial( 'elements/labels_list.inc', array( 'labels' => $this->labels, 'all' => $this->showAllLink, 'selectedLabel' => $this->selectedLabel ) ); ?>
</ul><!-- end sidebar -->

	<div id="blog-entries">
            <?php echo $this->partial( 'elements/actuals_list.inc', array( 'actuals' => $this->actuals, 'selectedLabel' => $this->selectedLabel ) ); ?>
        </div>
<?php echo $this->doctype(); ?>
<html>
<head>
<?php echo $this->headTitle()->setSeparator(" ::: ") ?>
<?php echo $this->headMeta() ?>
<?php echo $this->headLink() ?>
<?php echo $this->headScript() ?>
<!--[if IE 6]>
    <script type='text/javascript' src='layout/js/dd_belated_png.js'></script>
    <script>DD_belatedPNG.fix('.ie6');</script>
<![endif]-->
</head>
<body>
<div id="wrapper">
    <?php echo $this->partial( 'elements/header.inc' ); ?>
    <?php echo $this->partial( 'elements/menu.inc' ); ?>
    <div id="main">
        <?php
            echo $this->partial( 'elements/slider.inc' ); ?>
        <div id="primary" class="ie6">
            <?php echo $this->layout()->content; ?>
            <div class="clear"></div>
	</div><!-- #primary (end) -->
        <?php echo $this->partial( 'elements/footer.inc', array( 'galeryListing' => $this->galeryListing ) ); ?>
    </div><!-- #main (end) -->
    <div id="copyright" class="ie6">
        <div class="pad">
                &copy;2010 SMS PZPS Łódź
        </div><!-- .pad (end) -->
    </div><!-- #footer (end) -->
</div><!-- #wrapper (end) -->
</body>
</html>


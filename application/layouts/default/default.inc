<?php echo $this->doctype(); ?>
<html>
<head>
<?php echo $this->headTitle() ?>
<?php echo $this->headMeta() ?>
<?php echo $this->headLink() ?>
<?php echo $this->headScript() ?>
</head>
<body>

<div id="wrapper">

	<?php echo $this->partial( 'elements/header.inc' ); ?>
    <div id="single-content">
	<?php echo $this->layout()->content; ?>
    </div>
	<?php echo $this->partial( 'elements/footer.inc' ); ?>

</div><!-- end wrapper -->

<script src="/js/cufonize.js" type="text/javascript"></script>

</body>
</html>	
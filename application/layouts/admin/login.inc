<?php echo $this->doctype(); ?>
	<head>
		<?php echo $this->headTitle() ?>
		<?php echo $this->headMeta() ?>
		<!-- stylesheets -->
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<link id="color" rel="stylesheet" type="text/css" href="css/colors/blue.css" />
		<!-- scripts (jquery) -->
		<script src="scripts/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="scripts/jquery-ui-1.8.custom.min.js" type="text/javascript"></script>
		<script src="scripts/smooth.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				style_path = "css/colors";

				$("input.focus").focus(function () {
					if (this.value == this.defaultValue) {
						this.value = "";
					}
					else {
						this.select();
					}
				});

				$("input.focus").blur(function () {
					if ($.trim(this.value) == "") {
						this.value = (this.defaultValue ? this.defaultValue : "");
					}
				});

				$("input:submit, input:reset").button();
			});
		</script>
	</head>
	<body>
            <?php echo $this->layout()->content; ?>
	</body>
</html>
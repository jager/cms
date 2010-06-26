<?php
if ( isset( $this->errorMessage ) and !empty( $this->errorMessage ) ):
	$errorMessage = "";
?>
<div class="ui-widget">
<?php 
	if ( is_array( $this->errorMessage ) ):
	//Zend_Debug::dump($this->errorMessage);die();
	//$errorMessage = implode( '<br />', $this->errorMessage );
	foreach( $this->errorMessage as $error ):
		if( is_array( $error ) ):
			$errorMessage .= implode( '<br />', $error );
		else:
			$errorMessage .= $error . "<br /";
		endif;
	endforeach;
?>
	<div style="padding: 0.7em;" class="ui-state-error ui-corner-all"> 
		<p style="margin: 0"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> 
		<?php echo $errorMessage?>
		</p>
	</div>
<?php 
	else:
?>
	<div style="padding: 0.7em;" class="ui-state-error ui-corner-all"> 
		<p style="margin: 0"><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span> 
			<?php echo $this->errorMessage; ?>
		</p>
	</div>
<?php 
	endif;
?>	
</div>
<?php endif; ?>
<?php
if ( isset( $this->errorMessage ) and !empty( $this->errorMessage ) ):
	$errorMessage = "";
?>
<div class="message message-success" id="message-success">
    <div class="image">
        <img height="32" alt="Success" src="/images/icons/success.png">
    </div>
    <div class="text">
        <h6>Wykonanie poprawne</h6>
<?php 
	if ( is_array( $this->errorMessage ) ):
		foreach( $this->errorMessage as $error ):
			if( is_array( $error ) ):
				$errorMessage .= implode( '<br />', $error );
			else:
				$errorMessage .= $error . "<br /";
			endif;
		endforeach;
	else:
		$errorMessage = $this->errorMessage;
	endif;
?>
	
        <span><?php echo $errorMessage?></span>
    </div>
    <div class="dismiss">
            <a href="#message-success"></a>
    </div>
</div>

<?php endif; ?>
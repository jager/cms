<?php
$this->placeholder('title')->set( $this->message );
$this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="' . $this->backlink .'">Wróć do poprzedniej strony</a></li>
                                   </ul>' );
?>
<h3>Error information:</h3>
<p>
  <b>Message:</b> <?php echo $this->exception->getMessage() ?>
</p>
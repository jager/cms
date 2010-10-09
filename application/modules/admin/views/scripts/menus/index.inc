<?php
    $this->placeholder('title')->set( 'Strony statyczne' );
    $this->placeholder('links')->set( $this->partial( 'elements/pages/buttons.inc' ) );
    //Zend_Debug::dump($this->list);
?>
<div class="table">
    <?php echo $this->partial( 'elements/menu/menulist.inc', array( 'list' => $this->list ) ); ?>
</div>

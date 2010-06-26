<?php
    $this->placeholder('title')->set( 'Aktualności' );
    $this->placeholder('links')->set( $this->partial( 'elements/actuals/buttons.inc', array( 'id' => $this->actual->id, 'edit' => true ) ) );
?>
<h2>Podgląd: <?php echo $this->actual->title; ?></h2>
<?php echo $this->partial( 'elements/actuals/viewactuals.inc', array ( 'actual' => $this->actual ) ); ?>
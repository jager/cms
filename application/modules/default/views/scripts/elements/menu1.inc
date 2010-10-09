<ul id="quick" >
<?php
    $accessBroker = Zend_Registry::get( 'AccessBroker' );
    foreach( $this->container as $page ):
        if ( $accessBroker->isAllowed( $page->getPrivilege() ) ):
            if ( !$page->hasChildren() ):
?>
	<li><a href="<?php echo $page->getHref(); ?>"><span class="normal"><?php echo $page->getLabel(); ?></span></a></li>
<?php   else: ?>
        <li><a href="<?php echo $page->getHref(); ?>"><span class="normal"><?php echo $page->getLabel(); ?></span></a>
            <ul>
<?php
        foreach( $page->getChildren as $child ):
            if ( $accessBroker->isAllowed( $child->getPrivilege() ) ):
?>
                <li><a href="<?php echo $child->getHref(); ?>"><?php echo $child->getLabel(); ?></a></li>
<?php
            endif;
        endforeach;
?>
            </ul>
        </li>
<?php
            endif;
        endif;
?>
<?php endforeach; ?>
</ul>
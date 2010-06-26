<ul id="quick" >
<?php 
    foreach( $this->container as $page ):
        if ( !$page->hasChildren() ):
?>
	<li><a href="<?php echo $page->getHref(); ?>"><span class="normal"><?php echo $page->getLabel(); ?></span></a></li>
<?php   else: ?>
        <li><a href="<?php echo $page->getHref(); ?>"><span class="normal"><?php echo $page->getLabel(); ?></span></a>
            <ul>
<?php foreach( $page->getChildren as $child ): ?>
                <li><a href="<?php echo $child->getHref(); ?>"><?php echo $child->getLabel(); ?></a></li>
<?php endforeach; ?>
            </ul>
        </li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
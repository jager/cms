<?php if (isset($this->previous)): ?>
&nbsp; <a href="<?php echo $this->url(array('page' => $this->previous)); ?>">&laquo;</a>
<?php endif; ?>
<?php foreach ($this->pagesInRange as $page): ?>
    <?php if ($page != $this->current): ?>
        <a href="<?php echo $this->url(array('page' => $page)) . "/" . $page; ?>" class="page">
            <?php echo $page; ?>
        </a>
    <?php else: ?>
        <span class="current"><?php echo $page; ?></span>
    <?php endif; ?>
<?php endforeach; ?>
<?php if (isset($this->next)): ?>
        &nbsp; <a href="<?php echo $this->url(array('page' => $this->next)); ?>">&raquo;</a>
<?php endif; ?>
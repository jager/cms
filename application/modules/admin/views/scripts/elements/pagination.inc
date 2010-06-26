 <!--
See http://developer.yahoo.com/ypatterns/pattern.php?pattern=searchpagination
-->
<?php if ($this->pageCount): ?>
    <ul class="pager">
    <!-- Previous page link -->
        <?php if (isset($this->previous)): ?>
            <li>
                <a href="<?php echo $this->url(array('page' => $this->previous)); ?>" >
                &laquo; Previous
                </a>
            </li>
        <?php else: ?>
        <li class="disabled">&laquo; Previous</li>
        <?php endif; ?>

        <?php foreach ($this->pagesInRange as $page): ?>
        <?php if ($page != $this->current): ?>
            <li>
                <a href="<?php echo $this->url(array('page' => $page)); ?>">
                    <?php echo $page; ?>
                </a>
            </li>
        <?php else: ?>
            <li class="current"><?php echo $page; ?></li>
        <?php endif; ?>
        <?php endforeach; ?>

        <!-- next page link -->
        <?php if (isset($this->next)): ?>
            <li>
                <a href="<?php echo $this->url(array('page' => $this->next)); ?>">
                Next &raquo;
                </a>
            </li>
        <?php else: ?>
            <li class="disabled">Next &raquo;</li>
        <?php endif; ?>
    </ul>
<?php endif; ?>

<div class="widget">
    <h2>Inne artykuły</h2>
    <div class="news-scroller-wrapper">
        <div class="news-scroller">
            <?php foreach( $this->articles as $article ): ?>
                <div>
                    <p><a href="/aktualnosci/<?php echo $article->link ?>"><strong><?php echo $article->title ?></strong></a><br />
                    <p><?php echo $article->shortcontent ?></p>
                    <p class="date">Dodany <?php echo $article->edited ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <ul class="news-scroller-nav">
            <li><a href="javascript:void(0)" class="news-previous rounded-5">&laquo;</a></li>
            <li><a href="javascript:void(0)" class="news-next rounded-5">&raquo;</a></li>
        </ul>
    </div>
</div>
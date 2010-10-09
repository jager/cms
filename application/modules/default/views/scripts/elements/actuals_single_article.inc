<?php if ( $this->article != null ): ?>
<h2><a title="" href=""><?php echo $this->article->title; ?></a></h2>
<span class="small">Dodany <?php echo $this->article->created; ?></span>
<p><?php echo $this->article->shortcontent; ?></p>
<p><a title="<?php echo $this->article->title; ?>" href="/aktualnosci/<?php echo $this->article->link; ?>">Czytaj więcej</a></p>
<?php endif; ?>
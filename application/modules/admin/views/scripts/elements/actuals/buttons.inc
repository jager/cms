<ul class="links">
    <li><a href="/admin/actuals">Wróć do listy artykułów</a></li>
    <?php if ( $this->edit ) : ?><li><a href="/admin/actuals/edit/<?php echo $this->id; ?>">Edytuj</a></li><?php endif; ?>
    <?php if ( $this->view ) : ?><li><a href="/admin/actuals/view/<?php echo $this->id; ?>">Podgląd</a></li><?php endif; ?>
    <li><a href="/admin/actuals/delete/<?php echo $this->id; ?>">Usuń</a></li>
</ul>

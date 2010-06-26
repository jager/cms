<div class="pagination pagination-left">
    <div class="results">
      <span>
        Znaleziono: <?php echo $this->list->getTotalItemCount() ?> rekordy.
        Strona: <?php echo $this->list->getCurrentPageNumber() ?> z <?php echo $this->list->count() ?>
      </span>
    </div>
    <?php echo $this->list ?>
</div>
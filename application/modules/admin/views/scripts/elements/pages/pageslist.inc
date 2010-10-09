<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>


<table id="tournamentsList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Nazwa strony</th>
                <th>Data dodania</th>
                <th>Data modyfikacji</th>
                <th>Opublikowana</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php

if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
	foreach ( $this->list as $page ):
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
                        <td class="title"><a href="/admin/pages/edit/<?php echo $page->id ?>" class="noBox"><?php echo $page->pname ?></a></td>
                        <td><?php echo $page->created ?></td>
                        <td><?php echo $page->edited ? $page->edited : 'N/A' ?></td>
                        <td class="selected"><?php echo $page->active == '1' ? "<input type='checkbox' name='publish' id='publish_{$page->id}' class='publish' />" : "<input type='checkbox' name='unpublish' id='unpublish_{$page->id}' class='unpublish' />" ?></td>
                        <td class="last">
                            <a class="edit listMenu" href="/admin/pages/edit/<?php echo $page->id ?>" >Edytuj</a>
                            <a class="delete listMenu asBox" href="/admin/pages/delete/<?php echo $page->id ?>" >Usuń</a>
			</td>

		</tr>
<?php
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak jeszcze stron statycznych!' ) ); ?>
            </td>
	</tr>
<?php
endif;
?>
	</tbody>
</table>
<?php echo $this->partial( 'elements/paginator_view.inc', array( 'list' => $this->list ) ); ?>
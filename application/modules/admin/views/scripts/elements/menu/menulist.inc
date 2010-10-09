<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>


<table id="tournamentsList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th>Menu</th>
                <th>Typ</th>
                <th>Odnośnik</th>
                <th>Opublikowany</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php

if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
	foreach ( $this->list as $menuitem ):
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td class="selected"><?php echo ++$lp; ?></td>
                        <td class="title"><a href="/admin/pages/edit/<?php echo $menuitem->id ?>" class="noBox"><?php echo $menuitem->mname ?></a></td>
                        <td><?php echo $menuitem->type ?></td>
                        <td><?php echo $menuitem->link ?></td>
                        <td class="selected"><?php echo $menuitem->active == '1' ? "<input type='checkbox' name='publish' id='publish_{$menuitem->id}' class='publish' />" : "<input type='checkbox' name='unpublish' id='unpublish_{$menuitem->id}' class='unpublish' />" ?></td>
                        <td class="last">
                            <a class="edit listMenu" href="/admin/pages/edit/<?php echo $menuitem->Pages_id ?>" >Edytuj</a>
                            <a class="delete listMenu asBox" href="/admin/pages/delete/<?php echo $menuitem->Pages_id ?>" >Usuń</a>
			</td>

		</tr>
<?php
        echo $this->getSubmenu( $menuitem, &$lp );
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


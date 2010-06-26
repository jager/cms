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
        $aActive = array(
            '0'      => 'Nie publikowana',
            '1'      => 'Opublikowana'
        );
        
	foreach ( $this->list as $page ):
                $view = array( 'controller' => 'actuals', 'action' => 'view', 'id' => $page->id );
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td><a href="/admin/pages/view/<?php echo $page->id ?>" class="noBox"><?php echo $page->pname ?></a></td>
			<td><?php echo $page->created ?></td>
                        <td><?php echo $page->edited ? $page->edited : 'N/A' ?></td>
			<td><?php echo isset( $aActive[$page->active] ) ? $aActive[$page->active] : '' ?></td>
			<td>
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

<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>

<table id="actualsList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Tytuł aktualności</th>
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
        
	foreach ( $this->list as $actual ):
                $view = array( 'controller' => 'actuals', 'action' => 'view', 'id' => $actual->id );
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td class="title"><a href="/admin/actuals/view/<?php echo $actual->id ?>" class="noBox"><?php echo $actual->title ?></a></td>
			<td><?php echo $actual->created ?></td>
                        <td><?php echo $actual->edited ? $actual->edited : 'N/A' ?></td>
			<td><?php echo isset( $aActive[$actual->active] ) ? $aActive[$actual->active] : '' ?></td>
			<td>
                            <a class="edit listMenu" href="/admin/actuals/edit/<?php echo $actual->id ?>" >Edytuj</a>
                            <a class="delete listMenu asBox" href="/admin/actuals/delete/<?php echo $actual->id ?>" >Usuń</a>                            
			</td>

		</tr>
<?php
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak aktualności do wyświetlenia!' ) ); ?>
            </td>
	</tr>
<?php
endif;
?>
    </tbody>
</table>


<?php echo $this->partial( 'elements/paginator_view.inc', array( 'list' => $this->list ) ); ?>
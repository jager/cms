<table id="galeriesList" class="listing">
	<thead>
                <tr>
                    <td colspan="10" style="text-align: right; font-weight: bold">
                        <span>Znaleziono: <?php echo $this->list->getTotalItemCount() ?> rekordy. </span>
                        <span>Strona: <?php echo $this->list->getCurrentPageNumber() ?> z <?php echo $this->list->count() ?></span>
                    </td>
                </tr>
		<tr>
			<th>Lp.</th>
			<th>Nazwa galeri</th>
			<th>Opis</th>
			<th>Turniej</th>
			<th>Właściciel</th>
                        <th></th>
		</tr>
	</thead>
	<tfoot>
            <tr>
                <td colspan="10" style="text-align: right"><?php echo $this->list; ?></td>
            </tr>
        </tfoot>
	<tbody>
<?php
if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
	foreach ( $this->list as $foto ):
                $view = array( 'controller' => 'foto', 'action' => 'view', 'galID' => $foto->id );
                //$team_no = $tournament->Teams->count();
                if ( $foto->tournament_id > 0 ) {
                    $tournamentName = $foto->Tournament->tname;
                } else {
                    $tournamentName = '------------------';
                }
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td><a href="<?php echo $this->url( $view, 'viewgalery');?>" class="noBox"><?php echo $foto->gname ?></a></td>
			<td><?php echo $foto->gdescription ?></td>
			<td><?php echo $tournamentName ?></td>
			<td><?php echo $foto->owner == 0 ? 'administrator' : $foto->owner ?></td>
			<td>
				<a class="edit listMenu asBox" href="/admin/foto/gedit/<?php echo $foto->id ?>" >Edytuj</a>
                                <a class="delete listMenu asBox" href="/admin/foto/gdelete/<?php echo $foto->id ?>" >Usuń</a>
                                <a class="other listMenu" href="/admin/foto/gview/<?php echo $foto->id ?>" >Podgląd</a>
			</td>
		</tr>
<?php 
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak galerii do wyświetlenia!' ) ); ?>
            </td>
	</tr>
<?php 
endif;
?>
	</tbody>
</table>

<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>

<table id="fileList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Nazwa pliku</th>
                <th>Opis zawartości</th>
                <th>Data dodania</th>
                <th>Właściciel</th>
                <th>Współdzielenie</th>
                <th>Opublikowany</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php
if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
	foreach ( $this->list as $file ):
                $view = array( 'controller' => 'file', 'action' => 'edit', 'id' => $file->id );
                $aActive = array(
                    '0'      => "<a href='/admin/file/publish/id/{$file->id}/active/1' class='publish' id='publish_" . $file->id ."' >Nieopublikowany</a>",
                    '1'      => "<a href='/admin/file/publish/id/{$file->id}/active/0' class='publish' id='unpublish_" . $file->id ."' >Opublikowany</a>"
                );
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td class="left"><a href="/admin/file/edit/<?php echo $file->id ?>" class="noBox"><?php echo $file->filename ?></a></td>
			<td><?php echo $file->fileinfo ?></td>
                        <td><?php echo $file->added ?></td>
                        <td><?php echo $file->username ?></td>
                        <td><?php echo $file->sharetype == 'PRIVATE' ? 'prywatny' : 'publiczny' ?></td>
			<td><?php echo isset( $aActive[$file->active] ) ? $aActive[$file->active] : '' ?></td>
			<td>
                            <a class="edit listMenu" href="/admin/file/edit/id/<?php echo $file->id ?>" >Edytuj</a>
                            <a class="delete listMenu asBox" href="/admin/file/delete/id/<?php echo $file->id ?>" >Usuń</a>
			</td>

		</tr>
<?php
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak plików do wyświetlenia!' ) ); ?>
            </td>
	</tr>
<?php
endif;
?>
    </tbody>
</table>


<?php echo $this->partial( 'elements/paginator_view.inc', array( 'list' => $this->list ) ); ?>
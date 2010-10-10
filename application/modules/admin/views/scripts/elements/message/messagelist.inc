
<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>

<table id="messageList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Tytuł wiadomości</th>
                <th>Data wysłania</th>
                <th>Nadawca</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php
if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
	foreach ( $this->list as $message ):
                $view = array( 'controller' => 'message', 'action' => 'edit', 'id' => $message->id );
                $aActive = array(
                    '0'      => "<a href='/admin/message/publish/id/{$message->id}/active/1' class='publish' id='publish_" . $message->id ."' >Nieopublikowany</a>",
                    '1'      => "<a href='/admin/message/publish/id/{$message->id}/active/0' class='publish' id='unpublish_" . $message->id ."' >Opublikowany</a>"
                );
                $answersCount = 0;
                $answersCount = $message->countAnswers();
                $title = $message->title;
                if ( $answersCount > 0 ) {
                    $title .= ' (' . $answersCount . ')';
                }
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td class="title"><a href="/admin/message/view/<?php echo $message->id ?>" class="noBox"><?php echo $message->opened == '0' ? "<strong>{$title}</strong>" : $title ?></a></td>
			<td><?php echo $message->sentdate ?></td>
                        <td><?php echo $message->author_name ?></td>
			<td>
                            <a class="delete listMenu asBox" href="/admin/message/delete/id/<?php echo $message->id ?>" >Usuń</a>
			</td>

		</tr>
<?php
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak wiadomości w skrzynce!' ) ); ?>
            </td>
	</tr>
<?php
endif;
?>
    </tbody>
</table>


<?php echo $this->partial( 'elements/paginator_view.inc', array( 'list' => $this->list ) ); ?>

<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>

<table id="actualsList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Nazwisko, Imię</th>
                <th>Login</th>
                <th>E-mail</th>
                <th>Data poprawnego logowania</th>
                <th>Ilość poprawnych logowań</th>
                <th>Status</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php
if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
        $aActive = array(
            '0'      => 'Nie aktywny',
            '1'      => 'Aktywny'
        );

	foreach ( $this->list as $user ):
                $view = array( 'controller' => 'user', 'action' => 'view', 'id' => $user->id );
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td class="left"><a href="/admin/user/edit/<?php echo $user->id ?>" class="noBox"><?php echo $user->sname . ", " . $user->fname ?></a></td>
			<td><?php echo $user->username ?></td>
                        <td><?php echo $user->mailadr ?></td>
                        <td><?php echo $user->lastcorrectlogin ? $user->lastcorrectlogin : 'N/A' ?></td>
                        <td><?php echo $user->loginamount ? $user->loginamount : 'N/A' ?></td>
			<td><?php echo isset( $aActive[$user->active] ) ? $aActive[$user->active] : '' ?></td>
			<td>
                            <a class="edit listMenu" href="/admin/user/edit/<?php echo $user->id ?>" >Edytuj</a>
                            <a class="delete listMenu asBox" href="/admin/user/delete/<?php echo $user->id ?>" >Usuń</a>
			</td>

		</tr>
<?php
	endforeach;
else:
?>
	<tr>
            <td colspan="10" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak użytkowników do wyświetlenia!' ) ); ?>
            </td>
	</tr>
<?php
endif;
?>
    </tbody>
</table>


<?php echo $this->partial( 'elements/paginator_view.inc', array( 'list' => $this->list ) ); ?>
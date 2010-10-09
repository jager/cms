
<div class="pagination pagination-left">
    <?php echo $this->list; ?>
</div>

<table id="galeriesList" class="listing">
    <thead>
        <tr>
                <th>Lp.</th>
                <th class="left">Nazwa galerii</th>
                <th>Miejsce publikacji</th>
                <th></th>
        </tr>
    </thead>
    <tbody>
<?php
if ( $this->list->count() > 0 ):
	$lp = $this->list->getItemCountPerPage() * ( $this->list->getCurrentPageNumber() - 1 );
        $aPublishType = array(
            'g'      => 'Galerie zdjęć',
            's'      => 'Strony statyczne',
            'a'      => 'Aktualności'
        );

	foreach ( $this->list as $galery ):
                $view = array( 'controller' => 'actuals', 'action' => 'view', 'id' => $galery->id );
?>
		<tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
			<td><?php echo ++$lp; ?></td>
			<td class="title"><a href="/admin/galery/edit/<?php echo $galery->id ?>" class="noBox"><?php echo $galery->gname ?></a></td>
                        <td><?php echo isset( $aPublishType[$galery->publishtype] ) ? $aPublishType[$galery->publishtype] : "Galerie zdjęć" ?></td>
			<td>
                            <a class="edit listMenu" href="/admin/galery/edit/<?php echo $galery->id ?>" >Edytuj</a>
                            <a class="edit listMenu" href="/admin/galery/manage/<?php echo $galery->id ?>" >Zarządzaj zdjęciami</a>
                            <a class="delete listMenu asBox" href="/admin/galery/delete/<?php echo $galery->id ?>" >Usuń</a>
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
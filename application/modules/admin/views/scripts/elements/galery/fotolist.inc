<table id="fotoList" class="listing">
    <thead>
        <tr>
            <th>Zdjęcie</th>
            <th>Opis</th>
            <th>Autor</th>
            <th>Data dodania</th>
            <th>Tagi</th>
            <th>Turniej</th>
            <th></th>
        </tr>
    </thead>
    <tfoot></tfoot>
    <tbody>
<?php 
    if ( sizeof( $this->fotos ) > 0 ):
        $path = '/var/gallery' . DS . $this->galeryID . DS . 'min';
        foreach ( $this->fotos as $foto ):
?>
        <tr <?php echo $this->cycle( array( "class='light'", "class='dark'") )->next(); ?> >
            <td><img src="<?php echo $path . DS . $foto->sourcename ?>" alt="" /></td>
            <td><?php echo $foto->description ?></td>
            <td><?php echo $foto->author ?></td>
            <td><?php echo $foto->added ?></td>
            <td><?php echo $foto->tags ?></td>
            <td><?php echo isset( $foto->Tournament->tname ) ? $foto->Tournament->tname : 'N/A'; ?></td>
            <td>
                <span class="buttonSelect"><strong>Edytuj zdjęcie</strong>
                    <ul>
                        <li><a href="/admin/foto/editfoto/<?php echo $foto->id; ?>" id="editfoto_<?php echo $foto->id; ?>" class="asBox">Edytuj opisy</a></li>
                        <li><a href="/admin/foto/fdelete/<?php echo $foto->id; ?>" id="deletefoto_<?php echo $foto->id; ?>" class="asBox">Usuń zdjęcie</a></li>
                        <li><a href="/admin/foto/fcopy/<?php echo $foto->id; ?>" id="copyfoto_<?php echo $foto->id; ?>" class="asBox">Skopiuj ...</a></li>
                        <li><a href="/admin/foto/fmove/<?php echo $foto->id; ?>" id="movefoto_<?php echo $foto->id; ?>" class="asBox">Przenieś ...</a></li>
                    </ul>
                </span>


            </td>
        </tr>
<?php
        endforeach;
?>
<?php else: ?>
        <tr>
            <td colspan="8" style="padding: 10px">
                <?php echo $this->partial('elements/error.inc', array( 'errorMessage' => 'Brak zdjęć do wyświetlenia!' ) ); ?>
            </td>
        </tr>
<?php endif; ?>
    </tbody>
</table>
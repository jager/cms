<?php
    $aKind = array(
        'male'      => 'Męski',
        'female'    => 'Żeński',
        'mixed'     => 'Mieszany'
    );
?>
<h3><?php echo $this->title; ?></h3>
<table>
    <thead>
        <tr>
            <th>Nazwa turnieju</th>
            <th>Rodzaj</th>
            <th>Data rozpoczęcia</th>
            <th>Godzina rozpoczęcia</th>
            <th>Miejsce turnieju</th>
            <th>Ilość miejsc</th>
            <th></th>
        </tr>
    </thead>
    <tfoot></tfoot>
    <tbody>
<?php
    if ( $this->tournaments->count() > 0 ):
        $teamsEnrolled = 0;
        foreach( $this->tournaments as $tournament ):
            $teamsEnrolled = $tournament->Teams->count();
?>
        <tr>
            <td><?php echo $tournament->tname; ?></td>
            <td><?php echo isset( $aKind[ $tournament->kind ] ) ? $aKind[ $tournament->kind ] : ''; ?></td>
            <td><?php echo $tournament->start_date; ?></td>
            <td><?php echo $tournament->start_time; ?></td>
            <td><?php echo $tournament->address; ?></td>
            <td><?php echo ($tournament->max_team_no ? ($tournament->max_team_no - $teamsEnrolled) : 'b/o'); ?></td>
            <td><a href="/turnieje/opis/<?php echo $tournament->id; ?>">Pokaż szczegóły</a></td>
        </tr>
        
<?php 
        endforeach;
    else: 
?>        
        <tr>
            <td colspan="6">Brak turniejów do wyświetlenia!</td>
        </tr>
<?php
    endif;
?>
    </tbody>
</table>

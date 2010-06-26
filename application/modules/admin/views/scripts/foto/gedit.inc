<?php
    $this->form->getElement( 'tournament_id' )
                          ->setValue(
                                  $this->partial( 'elements/tournaments/tournament_select.inc',
                                                    array( 'tours' => $this->tours, 'selectedTour' => $this->selectedTour )
                                                )
                                    );
    echo $this->form;
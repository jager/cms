<?php
    $this->form->getElement( 'info_filebasename')
               ->setValue(
                       $this->partial( 'elements/file/info.inc',
                                        array( 'info' => $this->infoFileBasename,
                                               'fileID' => $this->fileID )
                                     )
                         );
    echo $this->form;

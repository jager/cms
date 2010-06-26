<?php
abstract class Webbers_File_HandlerAbstract {

    protected $_aFiles = array();

    const FILE_DOESNOT_EXIST = 'Plik źródłowy nie istnieje!';
    const DIR_DOESNOT_EXIST = 'Katalog docelowy nie istnieje lub nie masz uprawnień do tego katalogu';
    const ERROR_DURING_DELETE = 'Wysąpił bład podczas usuwania pliku';
    const ERROR_MOVING_FOTO = 'Błąd podczas przenoszenia zdjęcia!';

    public function getFiles() {
        return $this->_aFiles;
    }

    protected function move( $source, $destination, $tmpFileName, $toLeave = false ) {
        if ( !is_dir( $destination ) ) {
            mkdir( $destination, 0777, true );
        }

        if ( copy( $source, $destination . $tmpFileName ) ) {
            if ( !$toLeave ) {
                unlink( $source );
            }
            return true;
        }
        if ( !$toLeave ) {
            unlink( $source );
        }
        return false;
    }
    
    public function setDestination( $suffix ) {
        if ( $suffix > 0 ) {
            return GALLERY_PATH . DS . $suffix . DS;
        } else {
            return GENERAL_PATH . DS ;
        }
    }

}
?>

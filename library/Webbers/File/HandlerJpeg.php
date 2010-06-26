<?php
require_once( LIBRARY_PATH . DS . 'phpThumb/phpthumb.class.php' );
class Webbers_File_HandlerJpeg extends Webbers_File_HandlerAbstract {


    private     $_fileName;
    private     $_suffix = -1;
    private     $_files;
    protected   $_ext = 'jpg';

    public function  __construct( $files, $suffix = -1 ) {
        if ( $files ) {
            $this->setFiles( $files )
                 ->setSuffix( $suffix )
                 ->invoke();
        }
    }

    private function moveToDestination( $destination ) {
        $fileName = md5( $this->_fileName . time() ) . ".{$this->_ext}";
        if ( $this->move( $this->_fileName, $destination, $fileName ) and
                          $this->generateThumbnail( $destination, $fileName, 'min' ) ) {
            $this->_aFiles[] = $fileName;
        } else {
            throw new Exception( 'Błąd podczas przenoszenia pliku!' );
        }
    }

    public function setFiles( $files ) {
        $this->_files = $files;
        return $this;
    }

    public function setSuffix( $suffix ) {
        if ( !empty( $suffix ) ) {
            $this->_suffix = $suffix;
        }
        return $this;
    }

    public function invoke() {
        $destination = $this->setDestination( $this->_suffix );
        if ( is_array( $this->_files ) and ( sizeof( $this->_files ) > 0 ) ) {
            foreach ( $this->_files as $f ) {
                $this->_fileName = $f;
                $this->moveToDestination( $destination );
            }
        } else if ( $this->_files ) {
            $this->_fileName = $this->_files;
            $this->moveToDestination( $destination );
        }
    }

    private function generateThumbnail( $destination, $filename, $size ) {
        $thumbDestination = $destination . $size . DS;
        if ( !is_dir( $thumbDestination ) ) {
            mkdir( $thumbDestination, 0777, true );
        }

        $imageSettings = $this->getConfig();

        if ( sizeof( $imageSettings ) == 0 ) {
            return false;
        }

        $thumb = new phpThumb();
        foreach ( $imageSettings[ $size ] as $key => $value ) {
            $thumb->setParameter( $key, $value );
        }
        $thumb->setSourceData(file_get_contents( $destination . $filename ) );
        if ( $thumb->GenerateThumbnail() ) { // this line is VERY important, do not remove it!
            if ( $thumb->RenderToFile( $thumbDestination . $filename ) ) {
                return true;
            } else {
                throw new Exception( "Nie udało mi się wygenerować miniaturki o rozmiarze - {$size} Ponieważ:\n {$thumb->debugmessages}" );
            }
        } else {
            throw new Exception( "Błąd generatora\n {$thumb->debugmessages}");
        }
        return false;
    }

    private function getConfig() {
        $config = new Zend_Config_Ini( CONFIG_PATH . DS . 'application.ini', APPLICATION_ENV );
        return $config->image->toArray();
    }


}
?>

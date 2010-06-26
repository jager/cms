<?php
class Webbers_File_HandlerFoto extends Webbers_File_HandlerAbstract {

    private $_sourceFile;
    private $_destinationDirectory;
    private $_destinationFileName;

    public function  __construct( $sourceFile = '' ) {
        if ( $sourceFile != '' ) {
            $this->setSource( $sourceFile );
        }

    }

    public function setSource( $sourceFile ) {
        if ( !is_file( $sourceFile ) ) {
            throw new Exception( parent::FILE_DOESNOT_EXIST );
        }

        $this->_sourceFile = $sourceFile;
        return $this;
    }

    public function setDestinationDirectory( $dir ) {
        if ( !is_dir( $dir ) ) {
            throw new Exception( parent::DIR_DOESNOT_EXIST );
        }
        $this->_destinationDirectory = $dir;
        return $this;
    }

    public function setDestinationName( $fileName ) {
        $this->_destinationFileName = $fileName;
        return $this;
    }

    public function moveFoto( $toLeave = false ) {
        return $this->move( $this->_sourceFile, $this->_destinationDirectory, $this->_destinationFileName, $toLeave );
    }

    public function deleteFoto() {
        if ( $this->_sourceFile != '' ) {
            unlink( $this->_sourceFile );
            return true;
        }
        throw new Exception( parent::ERROR_DURING_DELETE );
    }
}
?>

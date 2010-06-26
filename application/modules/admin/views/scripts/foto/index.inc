<?php
    $this->headScript()->appendFile( '/js/jquery.metadata.js' ) ;
    $this->headScript()->appendFile( '/js/jquery.validate.js' ) ;
    $this->headScript()->appendFile( '/js/jquery.validate.aux.js' ) ;
    
    $this->headScript()->appendFile( '/js/plupload/js/gears_init.js' ) ;
    $this->headScript()->appendFile( 'http://bp.yahooapis.com/2.4.21/browserplus-min.js' ) ;
    $this->headScript()->appendFile( '/js/plupload/js/plupload.full.min.js' ) ;
    $this->headScript()->appendFile( '/js/plupload/js/jquery.plupload.queue.min.js' ) ;

    $this->headScript()->appendFile( '/js/galleryList.js' ) ;

?>
<div id="fotoTabs" class="contentTabs">
    <ul>
        <li><a href="#listGallery">Galerie zdjęć</a></li>
        <li><a href="#addGallery">Utwórz nową galerię</a></li>
        <?php if ( sizeof( $this->aGaleries ) > 1 ): ?>
            <li><a href="#addFoto">Dodaj zdjęcia</a></li>
        <?php endif; ?>
    </ul>
    <div id="listGallery">
        <?php echo $this->partial( 'elements/foto/galerylist.inc', array( 'list' => $this->list ) ); ?>
    </div>
    <div id="addGallery">
        <?php
            
            $this->formAdd->getElement( 'tournament_id' )
                          ->setValue(
                                  $this->partial( 'elements/tournaments/tournament_select.inc',
                                                    array( 'tours' => $this->tours )
                                                )
                                    );
            echo $this->formAdd;
         ?>
    </div>
<?php if ( sizeof( $this->aGaleries ) > 1 ): ?>
    <div id="addFoto">
        <div class="select">
            <label for="galeryID"> Galeria docelowa: </label>
            <?php echo $this->formSelect( 'galery_id', null, array( 'id' => 'galeryID' ), $this->aGaleries ); ?>
        </div>        
        <div id="uploader" >
            <table id="filelist">
                <thead>
                    <tr>
                        <th>Nazwa pliku</th>
                        <th>Wielkość pliku</th>
                        <th>Postęp załadowania</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan ="3">
                            <a id="pickFiles" href="#">Wybierz pliki</a>
                            <a id="uploadFiles" href="#">Wyślij na serwer</a>
                        </td>
                    </tr>
                </tfoot>
                <tbody></tbody>
            </table>
            <br />
            
        </div>
    </div>
</div>

<?php $this->inlineScript()->captureStart(); ?>
var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'pickFiles',
		container : 'uploader',
		max_file_size : '4mb',
		url : '/admin/foto/upload',
		flash_swf_url : '/js/plupload/js/plupload.flash.swf',
		silverlight_xap_url : '/js/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "Pliki JPEG", extensions : "jpg"},
			{title : "Pliki archiwów", extensions : "zip"}
		],
		resize : {width : 800, height : 600 , quality : 90},
                multipart: true,
                multipart_params : {}
	});
        
	uploader.bind('Init', function(up, params) {
		//$('#filelist1').html("<div>Current runtime: " + params.runtime + "</div>");
	});

	uploader.bind('FilesAdded', function(up, files) {
		$.each(files, function(i, file) {
			$('table#filelist tbody').append(
				'<tr id="' + file.id + '">' +
				'<td>' + file.name + '</td><td>' + plupload.formatSize(file.size) + '</td><td></td>' +
				'</tr>'
			);
		});
	});



	uploader.bind('UploadProgress', function(up, file) {
		$('tr#' + file.id + " td:eq(2)").html(file.percent + "%");
	});

        uploader.bind('FileUploaded', function(up, file) {
            $("tr#" + file.id).css('background','#11f477').fadeMessage();
        });
        
	$('#uploadFiles').click(function(e) {
                uploader.start();
		e.preventDefault();
	});

	uploader.init();
        $("table#filelist").hide()
<?php
        $this->inlineScript()->captureEnd();
    endif;
?>

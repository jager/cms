<?php
    $this->headScript()->appendFile( '/scripts/custom/plupload/js/gears_init.js' ) ;
    $this->headScript()->appendFile( 'http://bp.yahooapis.com/2.4.21/browserplus-min.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/plupload/js/plupload.full.min.js' ) ;
    $this->headScript()->appendFile( '/scripts/custom/plupload/js/jquery.plupload.queue.min.js' ) ;
    $this->placeholder('title')->set( 'Galerie zdjęć::zarządzasz galerią - ' . $this->galery->gname );
    $this->placeholder('links')->set( '<ul class="links">
                                        <li><a href="/admin/galery">Wróć do listy galerii</a></li>
                                   </ul>' );
?>
<div id="uploader" >
    <table id="filelist" class="listing">
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
    <div id="errorMessages"></div>

</div>
<?php $this->inlineScript()->captureStart(); ?>

var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'pickFiles',
		container : 'uploader',
		max_file_size : '4mb',
		url : '/admin/foto/upload',
		flash_swf_url : '/scripts/custom/plupload/js/plupload.flash.swf',
		silverlight_xap_url : '/scripts/custom/plupload/js/plupload.silverlight.xap',
		filters : [
			{title : "Pliki JPEG", extensions : "jpg"},
			{title : "Pliki archiwów", extensions : "zip"}
		],
		resize : {width : 800, height : 600 , quality : 90},
                multipart: true,
                multipart_params : { galeryId : <?php echo $this->galery->id ?> }
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
		$("tr#" + file.id + " td:eq(2)").html(file.percent + "%");
	});


        uploader.bind('Error', function(up, err) {
		$('#errorMessages').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});

	$('#uploadFiles').click(function(e) {
                uploader.start();
		e.preventDefault();
	});
$(document).ready( function() {
	uploader.init();
});
<?php $this->inlineScript()->captureEnd(); ?>
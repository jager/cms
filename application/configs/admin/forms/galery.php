[common ]

[add : common]

action = "/admin/galery/add"
attribs.id = "addGalleryForm"
attribs.enctype = "multipart/form-data"


elements.gname.type = text
elements.gname.options.label = "Nazwa galerii"
elements.gname.options.validators.maxlen.validator = "StringLength"
elements.gname.options.validators.maxlen.options.min = "3"
elements.gname.options.validators.maxlen.options.max = "100"
elements.gname.options.attribs.class = "{ required: true, maxlength: 100 }"
elements.gname.options.attribs.maxlength = "100"
elements.gname.options.required = true

elements.gdescription.type = textarea
elements.gdescription.options.label = "Opis galerii"
elements.gdescription.options.attribs.cols = 30
elements.gdescription.options.attribs.rows = 5
elements.gdescription.options.attribs.class = "{ required: true }"
elements.gdescription.options.required = true


elements.publishtype.type = select
elements.publishtype.options.label = "Miejsce publikacji"
elements.publishtype.options.required = true
elements.publishtype.options.class = "{ required: true }"
elements.publishtype.options.multiOptions.g.key = "g"
elements.publishtype.options.multiOptions.g.value = "Galeria zdjęć"
elements.publishtype.options.multiOptions.s.key = "s"
elements.publishtype.options.multiOptions.s.value = "Strona statyczna"
elements.publishtype.options.multiOptions.a.key = "a"
elements.publishtype.options.multiOptions.a.value = "Aktualności"

elements.submit.type = submit
elements.submit.options.label = "Dodaj galerię"
elements.submit.options.attribs.id = "addTournamentBtn"

[edit : add]

action = /admin/galery/edit
elements.id.type = hidden

elements.submit.type = submit
elements.submit.options.label = "Zapisz"


[delete : common]

action = /admin/foto/gdelete
attribs.id = "deleteForm"
decorators.fieldset.options.legend = "Usuń wybraną galerię: "

elements.id.type = hidden
elements.id.options.label = "Czy na pewno chcesz usunąć wybraną galerię?"

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Usuń"

[uploadfoto : common]

action = "/admin/uploadfoto"
attribs.enctype = "multipart/form-data"
elements.galery_id.type = "hidden"

;elements.DOCFILE.type = "file"
;elements.DOCFILE.options.label = "Choose file to upload"
;elements.DOCFILE.options.attribs.class = "{ required: true }"
;elements.DOCFILE.options.required = true;
;elements.DOCFILE.options.maxFileSize                      	= "2097152" ; "8192000"   ; 8MB
;elements.DOCFILE.options.validators.count.validator       	= "Count"
;elements.DOCFILE.options.validators.count.options.min     	= "1"
;elements.DOCFILE.options.validators.count.options.max     	= "20"
;elements.DOCFILE.options.validators.size.validator 			= "Size"
;elements.DOCFILE.options.validators.size.options.max 		= "4MB"
;elements.DOCFILE.options.validators.ext.validator 			= "Extension"
;elements.DOCFILE.options.validators.ext.options 			= "csv,zip,xls,xlsx,doc,docx,pdf,txt,csv,dat,dbf,ppt,pptx"

[editfoto : common]
action = "/admin/editfoto"
decorators.fieldset.options.legend = "Wypełnij dane dotyczące zdjęcia:"

elements.id.type = "hidden"

elements.description.type = "textarea"
elements.description.options.label = "Opis zdjęcia"
elements.description.options.attribs.cols = 40
elements.description.options.attribs.rows = 2
elements.description.options.attribs.class = "{ maxlength: 200 }"

elements.tags.type = "textarea"
elements.tags.options.label = "Słowa kluczowe"
elements.tags.options.attribs.cols = 40
elements.tags.options.attribs.rows = 2

elements.author.type = "text"
elements.author.options.label = "Autor zdjęcia"
elements.author.options.attribs.maxlength = 100
elements.author.options.validators.maxlen.validator = "StringLength"
elements.author.options.validators.maxlen.options.min = "3"
elements.author.options.validators.maxlen.options.max = "100"
elements.author.options.attribs.class = "{ maxlength: 100 }"

elements.players.type = rawHtml;

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Zapisz"

[fdelete : common]

action = /admin/foto/fdelete
attribs.id = "deleteForm"
decorators.fieldset.options.legend = "Usuń wybrane zdjęcie: "

elements.id.type = hidden
elements.id.options.label = "Czy na pewno chcesz usunąć wybrane zdjęcie?"

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Usuń"

[fmove : common]

action = /admin/foto/fcopy
attribs.id = "fotoMoveForm"
decorators.fieldset.options.legend = "Skopiuj wybrane zdjęcie: "

elements.id.type = hidden
elements.id.options.label = "Wybierz galerię docelową dla zdjęcia"

elements.galery_id.type = rawHtml

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Zapisz"

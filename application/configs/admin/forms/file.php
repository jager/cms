;<?php die();?>

[common]

[changefile]
elements.filebasename.type = "file"
elements.filebasename.options.label = "Wybierz plik"
elements.filebasename.options.attribs.class = "{ required: true }"
elements.filebasename.options.required = true;
elements.filebasename.options.maxFileSize                      	= "2097152" ; "8192000"   ; 8MB
;elements.filebasename.options.validators.upload.validator       	= "Upload"
elements.filebasename.options.validators.count.validator       	= "Count"
elements.filebasename.options.validators.count.options.min     	= "1"
elements.filebasename.options.validators.count.options.max     	= "1"
elements.filebasename.options.validators.size.validator 			= "Size"
elements.filebasename.options.validators.size.options.max 		= "8MB"
elements.filebasename.options.validators.ext.validator 			= "Extension"
elements.filebasename.options.validators.ext.options 			= "csv,zip,xls,xlsx,doc,docx,pdf,txt,csv,dat,dbf,ppt,pptx"

elements.filebasename.options.decorators.file.decorator = "File"
elements.filebasename.options.decorators.errors = "Errors"
elements.filebasename.options.decorators.htmlTag.decorator = "HtmlTag"
elements.filebasename.options.decorators.htmlTag.options.tag = "div"
elements.filebasename.options.decorators.htmlTag.options.class = "input"
elements.filebasename.options.decorators.label.decorator = "Label"
elements.filebasename.options.decorators.label.options.tag = "div"
elements.filebasename.options.decorators.label.options.class = "label"
elements.filebasename.options.decorators.fieldDiv.decorator = "DivWrapper"
elements.filebasename.options.order = 30

[ add : changefile ]

elements.filename.type = "text"
elements.filename.options.label = "Nazwa pliku"
elements.filename.options.required = true;
elements.filename.options.attribs.maxlength = 100;
elements.filename.options.attribs.class = "{ required: true }";
elements.filename.options.order = 10

elements.fileinfo.type = "textarea"
elements.fileinfo.options.label = "Krótki opis"
elements.fileinfo.options.attribs.class = "medium { maxlength: 255 }"
elements.fileinfo.options.validators.maxlen.validator = "StringLength"
elements.fileinfo.options.validators.maxlen.options.min = "0"
elements.fileinfo.options.validators.maxlen.options.max = "255"
elements.fileinfo.options.order = 20

elements.active.type = "radio"
elements.active.options.label = "Opublikowany"
elements.active.options.decorators.viewHelper.decorator = "RadioViewHelper";
elements.active.options.decorators.viewHelper.options.helper = "FormRadioWithDiv";
elements.active.options.decorators.label.decorator = "Label"
elements.active.options.decorators.label.options.tag = "div"
elements.active.options.decorators.label.options.class = "label"
elements.active.options.decorators.fieldDiv.decorator = "DivWrapper"

elements.active.options.separator = ""
elements.active.options.required = true
elements.active.options.class = "{ required: true }"
elements.active.options.multiOptions.m.key = "1"
elements.active.options.multiOptions.m.value = "Opbulikowany"
elements.active.options.multiOptions.f.key = "0"
elements.active.options.multiOptions.f.value = "Ukryty"
elements.active.options.order = 40

elements.sharetype.type = "radio"
elements.sharetype.options.decorators.viewHelper.decorator = "RadioViewHelper";
elements.sharetype.options.decorators.viewHelper.options.helper = "FormRadioWithDiv";
elements.sharetype.options.decorators.label.decorator = "Label"
elements.sharetype.options.decorators.label.options.tag = "div"
elements.sharetype.options.decorators.label.options.class = "label"
elements.sharetype.options.decorators.fieldDiv.decorator = "DivWrapper"

elements.sharetype.options.label = "Współdzielenie"
elements.sharetype.options.separator = ""

elements.sharetype.options.class = "{ required: true }"
elements.sharetype.options.multiOptions.m.key = "PRIVATE"
elements.sharetype.options.multiOptions.m.value = "Dostęp prywatny"
elements.sharetype.options.multiOptions.f.key = "PUBLIC"
elements.sharetype.options.multiOptions.f.value = "Dostęp publiczny"
elements.sharetype.options.order = 50

elements.submit.type = "submit"
elements.submit.options.label = "Dodaj"


[ edit ]

elements.filename.type = "text"
elements.filename.options.label = "Nazwa pliku"
elements.filename.options.required = true;
elements.filename.options.attribs.maxlength = 100;
elements.filename.options.attribs.class = "{ required: true }";
elements.filename.options.order = 10

elements.fileinfo.type = "textarea"
elements.fileinfo.options.label = "Krótki opis"
elements.fileinfo.options.attribs.class = "medium { maxlength: 255 }"
elements.fileinfo.options.validators.maxlen.validator = "StringLength"
elements.fileinfo.options.validators.maxlen.options.min = "0"
elements.fileinfo.options.validators.maxlen.options.max = "255"
elements.fileinfo.options.order = 20



elements.info_filebasename.type = "rawHtml"
elements.info_filebasename.options.order = 25


elements.active.type = "radio"
elements.active.options.label = "Opublikowany"
elements.active.options.decorators.viewHelper.decorator = "RadioViewHelper";
elements.active.options.decorators.viewHelper.options.helper = "FormRadioWithDiv";
elements.active.options.decorators.label.decorator = "Label"
elements.active.options.decorators.label.options.tag = "div"
elements.active.options.decorators.label.options.class = "label"
elements.active.options.decorators.fieldDiv.decorator = "DivWrapper"

elements.active.options.separator = ""
elements.active.options.required = true
elements.active.options.class = "{ required: true }"
elements.active.options.multiOptions.m.key = "1"
elements.active.options.multiOptions.m.value = "Opbulikowany"
elements.active.options.multiOptions.f.key = "0"
elements.active.options.multiOptions.f.value = "Ukryty"
elements.active.options.order = 40

elements.sharetype.type = "radio"
elements.sharetype.options.decorators.viewHelper.decorator = "RadioViewHelper";
elements.sharetype.options.decorators.viewHelper.options.helper = "FormRadioWithDiv";
elements.sharetype.options.decorators.label.decorator = "Label"
elements.sharetype.options.decorators.label.options.tag = "div"
elements.sharetype.options.decorators.label.options.class = "label"
elements.sharetype.options.decorators.fieldDiv.decorator = "DivWrapper"

elements.sharetype.options.label = "Współdzielenie"
elements.sharetype.options.separator = ""

elements.sharetype.options.class = "{ required: true }"
elements.sharetype.options.multiOptions.m.key = "PRIVATE"
elements.sharetype.options.multiOptions.m.value = "Dostęp prywatny"
elements.sharetype.options.multiOptions.f.key = "PUBLIC"
elements.sharetype.options.multiOptions.f.value = "Dostęp publiczny"
elements.sharetype.options.order = 50

elements.submit.type = "submit"
elements.submit.options.label = "Zmień"

[delete]

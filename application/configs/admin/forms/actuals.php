[common]

[add : common]

action = "/admin/actuals/add"
;decorators.fieldset.options.legend = "Dodaj nowy artykuł: "
attribs.id = "addActualForm"

elements.title.type = text
elements.title.options.label = "Tytuł"
elements.title.options.validators.maxlen.validator = "StringLength"
elements.title.options.validators.maxlen.options.min = "3"
elements.title.options.validators.maxlen.options.max = "150"
elements.title.options.attribs.class = "large { required: true, maxlength: 150 }"
elements.title.options.attribs.maxlength = "150"
elements.title.options.required = true


elements.shortcontent.type = textarea
elements.shortcontent.options.label = "Wstęp"
elements.shortcontent.options.validators.maxlen.validator = "StringLength"
elements.shortcontent.options.validators.maxlen.options.min = "3"
elements.shortcontent.options.validators.maxlen.options.max = "200"
elements.shortcontent.options.attribs.class = "{ required: true, maxlength: 200 }"
elements.shortcontent.options.attribs.cols = 70
elements.shortcontent.options.attribs.rows = 3
elements.shortcontent.options.required = true

elements.fullcontent.type = textarea
elements.fullcontent.options.label = "Pełna treść"
elements.fullcontent.options.attribs.class = "{ required: true }"
elements.fullcontent.options.attribs.id = "editor"
elements.fullcontent.options.attribs.class = "editor"
elements.fullcontent.options.attribs.cols = 70
elements.fullcontent.options.attribs.rows = 25
elements.fullcontent.options.required = true

elements.published.type = datepicker
elements.published.options.label = "Data publikacji"

elements.tags.type = text
elements.tags.options.label = "Tagi"
elements.tags.options.attribs.class = "medium { maxlength: 255 }"
elements.tags.options.validators.maxlen.validator = "StringLength"
elements.tags.options.validators.maxlen.options.min = "0"
elements.tags.options.validators.maxlen.options.max = "255"
elements.tags.options.attribs.maxlength = "255"

elements.active.type = radio
elements.active.options.decorators.viewHelper.decorator = "RadioViewHelper";
elements.active.options.decorators.viewHelper.options.helper = "FormRadioWithDiv";
elements.active.options.decorators.label.decorator = "Label"
elements.active.options.decorators.label.options.tag = "div"
elements.active.options.decorators.label.options.class = "label"
elements.active.options.decorators.fieldDiv.decorator = "DivWrapper"

elements.active.options.label = "Status"
elements.active.options.separator = ""
elements.active.options.required = true
elements.active.options.class = "{ required: true }"
elements.active.options.multiOptions.m.key = "1"
elements.active.options.multiOptions.m.value = "Opublikowana"
elements.active.options.multiOptions.f.key = "0"
elements.active.options.multiOptions.f.value = "Szkic"

elements.labels.type = rawHtml;

elements.submit.type = submit
elements.submit.options.label = "Zapisz"
elements.submit.options.attribs.class = "ui-button ui-widget ui-state-default ui-corner-all"
elements.submit.options.attribs.id = "addActualsBtn"

[edit : add]

action = /admin/actuals/edit
elements.id.type = hidden

;elements.reject.type = submit
;elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Zapisz"
elements.submit.options.attribs.id = "editActualsBtn"


[delete : common]

action = /admin/actuals/delete
attribs.id = "deleteForm"
decorators.fieldset.options.legend = "Usuń wybrany artykuł: "

elements.id.type = hidden
elements.id.options.label = "Czy na pewno chcesz usunąć wybrany artykuł?"

elements.player.type = rawHtml

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Usuń"




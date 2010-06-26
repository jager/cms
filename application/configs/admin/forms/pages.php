[common]

[add : common]

action = "/admin/pages/add"
isArray = true;

attribs.id = "addPageForm"
;displayGroupDecorators.fieldset.decorator.options.legend = "Utwórz nowy element menu"
displayGroups.page.name = "page"
displayGroups.menu.name = "menu"
displayGroups.menu.options.legend = "Utwórz nowy element menu"
;displayGroupDecorators.menu.fieldset.options.legend = "Part"
displayGroups.common.name = "common"

displayGroups.page.elements.pname = pname
displayGroups.page.elements.hd_title = hd_title
displayGroups.page.elements.hd_keywords = hd_keywords
displayGroups.page.elements.content = content
displayGroups.page.elements.active = active
displayGroups.page.elements.menuitem = menuitem

displayGroups.menu.elements.mname = mname
displayGroups.menu.elements.parent_id = parent_id
displayGroups.menu.elements.type = type

displayGroups.common.elements.submit = submit

elements.pname.type = text
elements.pname.options.label = "Nazwa strony"
elements.pname.options.validators.maxlen.validator = "StringLength"
elements.pname.options.validators.maxlen.options.min = "3"
elements.pname.options.validators.maxlen.options.max = "100"
elements.pname.options.attribs.class = "medium { required: true, maxlength: 100 }"
elements.pname.options.attribs.maxlength = "100"
elements.pname.options.required = true
elements.pname.options.belongsTo = page

elements.hd_title.type = text
elements.hd_title.options.label = "Tytuł strony"
elements.hd_title.options.validators.maxlen.validator = "StringLength"
elements.hd_title.options.validators.maxlen.options.min = "3"
elements.hd_title.options.validators.maxlen.options.max = "200"
elements.hd_title.options.attribs.class = "medium { required: true, maxlength: 200 }"
elements.hd_title.options.attribs.maxlength = "200"
elements.hd_title.options.required = true
elements.hd_title.options.belongsTo = page

elements.hd_keywords.type = text
elements.hd_keywords.options.label = "Słowa kluczowe"
elements.hd_keywords.options.attribs.class = "large"
elements.hd_keywords.options.belongsTo = page

elements.content.type = textarea
elements.content.options.label = "Treść strony"
elements.content.options.attribs.class = "editor"
elements.content.options.attribs.cols = 70
elements.content.options.attribs.rows = 25
elements.content.options.required = true
elements.content.options.belongsTo = page

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
elements.active.options.multiOptions.m.value = "Aktywna"
elements.active.options.multiOptions.f.key = "0"
elements.active.options.multiOptions.f.value = "Nie aktywna"
elements.active.options.belongsTo = page

elements.menuitem.type = rawHtml
elements.menuitem.options.belongsTo = page

elements.mname.type = text
elements.mname.options.label = "Nowy element menu"
elements.mname.options.belongsTo = menu
elements.mname.options.validators.maxlen.validator = "StringLength"
elements.mname.options.validators.maxlen.options.min = "3"
elements.mname.options.validators.maxlen.options.max = "20"
elements.mname.options.attribs.class = "{ required: 'select#menuItemParentId [value=0]', maxlength: 20 }"
elements.mname.options.attribs.maxlength = "20"
;elements.mname.options.required = true

elements.type.type = hidden
elements.type.options.value = "static"
elements.type.options.belongsTo = menu

elements.parent_id.type = rawHtml
elements.parent_id.options.belongsTo = menu


elements.submit.type = submit
elements.submit.options.label = "Zapisz"
elements.submit.options.attribs.class = "submit"
elements.submit.options.attribs.id = "addPageBtn"
elements.submit.options.belongsTo = common

[edit : add]

action = /admin/page/edit
elements.id.type = hidden

elements.submit.options.attribs.id = "editPageBtn"


[delete : common]

action = /admin/page/delete
attribs.id = "deletePageForm"

elements.id.type = hidden
elements.id.options.label = "Czy na pewno chcesz usunąć wybraną stronę?"

elements.reject.type = submit
elements.reject.options.label = "Anuluj"

elements.submit.type = submit
elements.submit.options.label = "Usuń"


[ menuadd : common ]
action = /admin/pages/menuadd
attribs.id = "addMenuItem"

elements.mname.type = text
elements.mname.options.label = "Nazwa menu"
elements.mname.options.validators.maxlen.validator = "StringLength"
elements.mname.options.validators.maxlen.options.min = "3"
elements.mname.options.validators.maxlen.options.max = "20"
elements.mname.options.attribs.class = "{ maxlength: 20 }"
elements.mname.options.attribs.maxlength = "20"
elements.mname.options.required = true
elements.mname.options.class = "{ required: true }"

elements.type.type = select
elements.type.options.label = "Typ elementu"
elements.type.options.required = true
elements.type.options.class = "{ required: true }"
elements.type.options.multiOptions.s.key = "static"
elements.type.options.multiOptions.s.value = "Strona statyczna"
elements.type.options.multiOptions.g.key = "gallery"
elements.type.options.multiOptions.g.value = "Galeria zdjęć"
elements.type.options.multiOptions.t.key = "tournaments"
elements.type.options.multiOptions.t.value = "Turnieje"
elements.type.options.multiOptions.r.key = "ranks"
elements.type.options.multiOptions.r.value = "Rankingi"
elements.type.options.multiOptions.a.key = "actuals"
elements.type.options.multiOptions.a.value = "Aktualności"

elements.parent_id.type = rawHtml

elements.active.type = radio
elements.active.options.label = "Status"
elements.active.options.separator = ""
elements.active.options.required = true
elements.active.options.class = "{ required: true }"
elements.active.options.multiOptions.m.key = "1"
elements.active.options.multiOptions.m.value = "Aktywna"
elements.active.options.multiOptions.f.key = "0"
elements.active.options.multiOptions.f.value = "Nie aktywna"

elements.submit.type = submit
elements.submit.options.label = "Zapisz"
elements.submit.options.attribs.class = "submit"
elements.submit.options.attribs.id = "addPageBtn"

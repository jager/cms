;<?php die();?>


[ add ]

elements.title.type = "text"
elements.title.options.label = "Tytuł wiadomości"

elements.body.type = "textarea"
elements.body.options.label= "Treść"

elements.reciver.type = "dbSelect"
elements.reciver.options.label = "Odbiorca"
elements.reciver.options.attribs.class = "{ required: true' }"
elements.reciver.options.required = true
elements.reciver.options.valueColumn = "id"
elements.reciver.options.labelColumn = "concat(sname, ' ', fname)"
elements.reciver.options.table = "Adminuser"


elements.submit.type = "submit"
elements.submit.options.label = "Wyślij"

[ answer ]




;<?php die(); ?>
[common]

[add]
action = ""

elements.username.type = "text"
elements.username.options.label = "Username"
elements.username.options.class = "field { required: true }"
elements.username.options.required = true
elements.username.options.validators.maxlen.validator = "StringLength"
elements.username.options.validators.maxlen.options.min = "0"
elements.username.options.validators.maxlen.options.max = "40"

elements.password.type = "password"
elements.password.options.label = "Password"
elements.password.options.class = "field"
elements.password.options.validators.maxlen.validator = "StringLength"
elements.password.options.validators.maxlen.options.min = "0"
elements.password.options.validators.maxlen.options.max = "20"
elements.password.options.validators.pass.validator = "Password"
elements.password.options.validators.repass.validator = "RePassword"
elements.password.options.validators.repass.options.fieldName = "repassword";
elements.password.options.required = true

elements.repassword.type = "password"
elements.repassword.options.label = "Confirm Password"
elements.repassword.options.class = "field"
elements.repassword.options.validators.maxlen.validator = "StringLength"
elements.repassword.options.validators.maxlen.options.min = "0"
elements.repassword.options.validators.maxlen.options.max = "20"

elements.mailadr.type = "text"
elements.mailadr.options.label = "E-mail"
elements.mailadr.options.class = "field { required: true, email: true }"
elements.mailadr.options.required = true
elements.mailadr.options.validators.email.validator = "EmailAddress"
elements.mailadr.options.validators.maxlen.validator = "StringLength"
elements.mailadr.options.validators.maxlen.options.min = "0"
elements.mailadr.options.validators.maxlen.options.max = "150"

elements.fname.type = "text"
elements.fname.options.label = "First Name"
elements.fname.options.class = "field"
elements.fname.options.validators.maxlen.validator = "StringLength"
elements.fname.options.validators.maxlen.options.min = "0"
elements.fname.options.validators.maxlen.options.max = "50"

elements.sname.type = "text"
elements.sname.options.label = "Last Name"
elements.sname.options.class = "field"
elements.sname.options.validators.maxlen.validator = "StringLength"
elements.sname.options.validators.maxlen.options.min = "0"
elements.sname.options.validators.maxlen.options.max = "100"

[edit : add]
elements.id.type = "hidden"

elements.password.options.required = false
elements.info.type = "rawHtml"
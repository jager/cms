;<?php die(); ?>
[common]

[login]

action = "/admin/index/login"
;decorators.fieldset.options.legend = "Proszę się zalogować"


elements.username.type = "text"
elements.username.options.label = "Username"
elements.username.options.class = "field { required: true }"

elements.password.type = "password"
elements.password.options.label = "Password"
elements.password.options.class = "field { required: true }"

elements.submit.type = "submit"
elements.submit.options.label = "Login"

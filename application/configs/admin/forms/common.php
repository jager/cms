; <?php die(); ?>
[common]
method = "post"

prefixPath.element.prefix = "Webbers_Form_Element"
prefixPath.element.path = "Webbers"DS"Form"DS"Element"DS
prefixPath.decorator.prefix = "Webbers_Form_Decorator"
prefixPath.decorator.path = "Webbers"DS"Form"DS"Decorator"DS

elementPrefixPath.validate.prefix = "Webbers_Validate"
elementPrefixPath.validate.path = "Webbers"DS"Validate"DS
elementPrefixPath.decorator.prefix = "Webbers_Form_Decorator"
elementPrefixPath.decorator.path = "Webbers"DS"Form"DS"Decorator"DS

decorators.elements.decorator = "FormElements"
decorators.divWrapper.decorator = "DivWrapper"
decorators.divWrapper.options.class = "fields"
decorators.htmltag.decorator = "HtmlTag"
decorators.htmltag.options.tag = "div"
decorators.htmltag.options.class = "form"
decorators.form.decorator = "Form"
;decorators.errors = "Errors"

elementDecorators.viewHelper = "ViewHelper"
elementDecorators.errors = "Errors"
;elementDecorators.description = "Description"
elementDecorators.htmlTag.decorator = "HtmlTag"
elementDecorators.htmlTag.options.tag = "div"
elementDecorators.htmlTag.options.class = "input"

elementDecorators.label.decorator = "Label"
elementDecorators.label.options.tag = "div"
elementDecorators.label.options.class = "label"

elementDecorators.fieldDiv.decorator = "DivWrapper"

displayGroupDecorators.formElements = "FormElements"
displayGroupDecorators.fieldset.decorator = "Fieldset"


; security hash
elements.hash.type = "Hash"
elements.hash.options.decorators.viewHelper = "ViewHelper"
elements.hash.options.salt = "form"
elements.hash.options.order = "1"
elements.hash.options.validationMessages.notSame = "For security reason please submit form once again"
elements.hash.options.validationMessages.missingToken = "For security reason please submit form once again"

elements.submit.type = "submit"
elements.submit.options.decorators.viewHelper = "ViewHelper"
elements.submit.options.decorators.htmlTag.decorator = "HtmlTag"
elements.submit.options.decorators.htmlTag.options.tag = "div"
elements.submit.options.decorators.htmlTag.options.class = "buttons"
elements.submit.options.order = "1000000000"
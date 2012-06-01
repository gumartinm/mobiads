<?php

class WidgetFormSchemaFormatterCustom extends sfWidgetFormSchemaFormatterTable
{
     protected
    // this says to surround our element with a div of class "form-row".
    // then print out the error, label, form field, help text, and finally the hidden fields
    // new lines () are included for readable html

    /*$rowFormat           = "<div class=\"form-row\">
                            %error%
                            %label%%field%
                            %help%
                            %hidden_fields%
                            </div>",
    // this defines the exact format of the above %help%. This says to wrap it in a div of class form_helper.
    // The %help% in this case defines that actual help text (if any) that's given
    $helpFormat      = '<div class="form_helper">%help%</div>',
    // Certain errors do not pertain to any specific widget. In these cases, the errors are printed on their own row
    // This defines the format of how to set up that row
    $errorRowFormat  = "<div>%errors%</div>",
    // this is the wrapper always uses around errors.
    $errorListFormatInARow     = "  <ul class=\"error_list\">%errors%  </ul>",
    // This defines how to print the actual error in normal situations
    $errorRowFormatInARow      = "    <li>%error%</li>",
    // This defines how to print the actual error in situations where the error does not belong to a specific widget - is printed at the top of the form
    $namedErrorRowFormatInARow = "    <li>%name%: %error%</li>",
    // We didn't cover it, but you can embed forms inside other forms.
    // When you do, the following is used to "wrap" your form. In the table example, this is a <table> </table> value.
    $decoratorFormat = "<div>%content%</div>";*/
    protected
        $rowFormat       = "<tr>\n  <th>%label%</th>\n  <td>%error%%field%%help%%hidden_fields%</td>\n</tr>\n",
        $errorRowFormat  = "<tr><td colspan=\"2\">\n%errors%</td></tr>\n",
        $helpFormat      = '<br />%help%',
        $decoratorFormat = "<table>\n  %content%</table>";
}

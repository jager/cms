$(document).ready(function() {
    if ( jQuery.fn.validate ) {
        console.log("mam validator");
        $( "form" )
            .not( ".has-validation" )
            .addClass( "has-validation" )
            .each( function() {
                $( this ).validate();
        });
    }
});


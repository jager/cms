jQuery.validator.addMethod("dateIsOlderThan", function(value, element, params) {
	var newer = $(params).val().replace(/[^0-9-]+/g, '').split('-');
	var older = value.replace(/[^0-9-]+/g, '').split('-');
	if ( 3 != newer.length || 3 != older.length ) return this.optional(element) || false;
	newer = new Date(newer[0], newer[1], newer[2]).valueOf();
	older = new Date(older[0], older[1], older[2]).valueOf();
	return this.optional(element) || isNaN(newer) || isNaN(older) ? false : newer < older; 
}, $.format("Second date should be older."));

jQuery.validator.addMethod("localized", function(value, element, params) {
	return this.optional(element) || (2 == $(params).filter('input[value]').length);
}, $.format("Address not localized."));

jQuery.validator.addMethod("betweenRequired", function(value, element, params) {
	var l = element.id.substr(-1);
	var id = ( 1 == l) ? element.id.substr(0, element.id.length-1) : element.id;

	var v1 = $('#' + id).val() == '';
	var v2 = $('#' + id + '1').val() == '';
	var op = $('#' + id + '_operator').val();

	return !( 'bet' == op && ((!v1 && v2) || (v1 && !v2)));
}, $.format("Both values are required."));

jQuery.validator.addMethod("betweenRequiredBis", function(value, element, params) {
	var l = element.id.substr(-4);
	var id = ( '_bis' == l) ? element.id.substr(0, element.id.length-4) : element.id;

	var v1 = $('#' + id).val() == '';
	var v2 = $('#' + id + '_bis').val() == '';
	var op = $('#' + id + '_operator').val();

	return !( 'bet' == op && ((!v1 && v2) || (v1 && !v2)));
}, $.format("Both values are required."));  

jQuery.validator.addMethod("lo", function(value, element, params) { 
    return this.optional(element) || value < params; 
}, $.format("Please enter a value less than {0}.")); 

jQuery.validator.addMethod("le", function(value, element, params) { 
    return this.optional(element) || value <= params; 
}, $.format("Please enter a value less than or equal to {0}.")); 

jQuery.validator.addMethod("gr", function(value, element, params) { 
    return this.optional(element) || value > params; 
}, $.format("Please enter a value greater than {0}.")); 

jQuery.validator.addMethod("income", function(value, element, params) { 
    return this.optional(element) || value > params; 
}, $.format("Please enter a value between 0 and 99999999999."));

jQuery.validator.addMethod("ge", function(value, element, params) { 
    return this.optional(element) || value >= params; 
}, $.format("Please enter a value greater than or equal to {0}.")); 

jQuery.validator.addMethod("numberPrecision", function(value, element, params) {
	var regexp = new RegExp('^[-]?[\\d]+([.,][\\d]{1,' + params + '})?$');
    return this.optional(element) || regexp.test(value); 
}, $.format("Precision to {0} decimal place."));

jQuery.validator.addMethod("maxWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length < params; 
}, $.format("Please enter {0} words or less.")); 

jQuery.validator.addMethod("minWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length >= params; 
}, $.format("Please enter at least {0} words.")); 
 
jQuery.validator.addMethod("rangeWords", function(value, element, params) { 
    return this.optional(element) || value.match(/\b\w+\b/g).length >= params[0] && value.match(/bw+b/g).length < params[1]; 
}, $.format("Please enter between {0} and {1} words."));

jQuery.validator.addMethod("letterswithbasicpunc", function(value, element) {
    return this.optional(element) || /^[a-z-.,()'\"\s]+$/i.test(value);
}, "Letters or punctuation only please");  

jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^\w+$/i.test(value);
}, "Letters, numbers, spaces or underscores only please");  

jQuery.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Letters only please"); 

jQuery.validator.addMethod("nowhitespace", function(value, element) {
    return this.optional(element) || /^\S+$/i.test(value);
}, "No white space please"); 

jQuery.validator.addMethod("ziprange", function(value, element) {
    return this.optional(element) || /^90[2-5]\d\{2}-\d{4}$/.test(value);
}, "Your ZIP-code must be in the range 902xx-xxxx to 905-xx-xxxx");

/**
* Return true, if the value is a valid vehicle identification number (VIN).
*
* Works with all kind of text inputs.
*
* @example <input type="text" size="20" name="VehicleID" class="{required:true,vinUS:true}" />
* @desc Declares a required input element whose value must be a valid vehicle identification number.
*
* @name jQuery.validator.methods.vinUS
* @type Boolean
* @cat Plugins/Validate/Methods
*/ 
jQuery.validator.addMethod(
    "vinUS",
    function(v){
        if (v.length != 17)
            return false;
        var i, n, d, f, cd, cdv;
        var LL    = ["A","B","C","D","E","F","G","H","J","K","L","M","N","P","R","S","T","U","V","W","X","Y","Z"];
        var VL    = [1,2,3,4,5,6,7,8,1,2,3,4,5,7,9,2,3,4,5,6,7,8,9];
        var FL    = [8,7,6,5,4,3,2,10,0,9,8,7,6,5,4,3,2];
        var rs    = 0;
        for(i = 0; i < 17; i++){
            f = FL[i];
            d = v.slice(i,i+1);
            if(i == 8){
                cdv = d;
            }
            if(!isNaN(d)){
                d *= f;
            }
            else{
                for(n = 0; n < LL.length; n++){
                    if(d.toUpperCase() === LL[n]){
                        d = VL[n];
                        d *= f;
                        if(isNaN(cdv) && n == 8){
                            cdv = LL[n];
                        }
                        break;
                    }
                }
            }
            rs += d;
        }
        cd = rs % 11;
        if(cd == 10){cd = "X";}
        if(cd == cdv){return true;}
        return false; 
    },
    "The specified vehicle identification number (VIN) is invalid."
);

/**
  * Return true, if the value is a valid date, also making this formal check dd/mm/yyyy.
  *
  * @example jQuery.validator.methods.date("01/01/1900")
  * @result true
  *
  * @example jQuery.validator.methods.date("01/13/1990")
  * @result false
  *
  * @example jQuery.validator.methods.date("01.01.1900")
  * @result false
  *
  * @example <input name="pippo" class="{dateITA:true}" />
  * @desc Declares an optional input element whose value must be a valid date.
  *
  * @name jQuery.validator.methods.dateITA
  * @type Boolean
  * @cat Plugins/Validate/Methods
  */
jQuery.validator.addMethod(
    "dateITA",
    function(value, element) {
        var check = false;
        var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/
        if( re.test(value)){
            var adata = value.split('/');
            var gg = parseInt(adata[0],10);
            var mm = parseInt(adata[1],10);
            var aaaa = parseInt(adata[2],10);
            var xdata = new Date(aaaa,mm-1,gg);
            if ( ( xdata.getFullYear() == aaaa ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == gg ) )
                check = true;
            else
                check = false;
        } else
            check = false;
        return this.optional(element) || check;
    }, 
    "Please enter a correct date"
);

/**
 * matches US phone number format 
 * 
 * where the area code may not start with 1 and the prefix may not start with 1 
 * allows '-' or ' ' as a separator and allows parens around area code 
 * some people may want to put a '1' in front of their number 
 * 
 * 1(212)-999-2345
 * or
 * 212 999 2344
 * or
 * 212-999-0983
 * 
 * but not
 * 111-123-5434
 * and not
 * 212 123 4567
 */
jQuery.validator.addMethod("phone", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
    return this.optional(element) || phone_number.length > 9 &&
        phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");

// TODO check if value starts with <, otherwise don't try stripping anything
jQuery.validator.addMethod("strippedminlength", function(value, element, param) {
    return jQuery(value).text().length >= param;
}, jQuery.format("Please enter at least {0} characters"));

// same as email, but TLD is optional
jQuery.validator.addMethod("email2", function(value, element, param) {
    return this.optional(element) || /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(value); 
}, jQuery.validator.messages.email);

// same as url, but TLD is optional
jQuery.validator.addMethod("url2", function(value, element, param) {
    return this.optional(element) || /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)*(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(value); 
}, jQuery.validator.messages.url);

// same as url, but TLD is optional
jQuery.validator.addMethod("regexp", function(value, element, param) {
    return param.test( value );
}, $.format("Email should match pattern {0}.") );

// different zip codes
jQuery.validator.addMethod( "zipbycountry", function(value, element, param) {
    if ( this.optional(element) ) {
        return true;
    }
    if ( value.length == 0 ) {
        return true;
    }
    var country = null;
    if ( param.length == 2 ) {
        country = param;
    } else {
        country = $( param ).val();
    }
    if ( null == country ) {
        country = "";
    }
    if ( "object" != typeof( country ) ) {
        country = [country]
    }
    for ( i in country ) {
	    var regexp = null;
	    switch( country[i].toLowerCase() ) {
	        /**
	         * 6 digits:
	         * - Kazakhstan
	         * - Uzbekistan
	         * - Kyrgyzstan
	         * - Turkmenistan
	         * - Tajikistan
	         * - Armenia
	         * - Belarus
	         * - Russia
	         * - Romania
	         * - Serbia
	         */
	        case 'kz':
	        case 'uz':
	        case 'kg':
	        case 'tm':
	        case 'tj':
	        case 'tj':
	        case 'am':
	        case 'by':
	        case 'ru':
	        case 'ro':
	        case 'rs':
	            regexp = /^[0-9]{6}$/;
	        break;
	        /**
	         * 5 digits:
	         * - Saudi Arabia
	         * - United Arab Emirates
	         * - Kuwait
	         * - Egypt
	         * - Iraq
	         * - Jordan
	         * - Lithuana
	         * - Pakistan
	         * - Estonia
	         * - Mongolia
	         * - Turkey
	         * - Montenegro
	         * - Sudan
	         * - Bosnia & Herzegovina
	         * - Ukraine
	         * - Israel
	         */
	        case 'sa':
	        case 'ae':
	        case 'kw':
	        case 'eq':
	        case 'iq':
	        case 'jo':
	        case 'lt':
	        case 'pk':
	        case 'ee':
	        case 'mn':
	        case 'tr':
	        case 'me':
	        case 'sd':
	        case 'ba':
	        case 'ua':
	        case 'il':
	        case 'al':
	        case 'tn':
	        case 'tn':
	        case 'bg':
	            regexp = /^[0-9]{5}$/;
	        break;
	        /**
	         * 4 digits
	         * - Qatar
	         * - Yemen
	         * - Hungary
	         * - Georgia
	         * - South Africa
	         */
	        case 'qa':
	        case 'ye':
	        case 'hu':
	        case 'ge':
	        case 'za':
	            regexp = /^[0-9]{4}$/;
	        break;
	        /**
	         * "4 digits" or "[4 digits] [4 digits]":
	         * - Lebanon
	         */
	        case 'lb':
	            regexp = /^([0-9]{4}|[0-9]{4}\s[0-9]{4})$/;
	        break;
	        /**
	         * 3 to 4 digits
	         * - Bahrain
	         */
	        case 'bh':
	            regexp = /^[0-9]{3,4}$/;
	        break;
	        /**
	         * 3 digits
	         * - Oman
	         * - Incl. Iceland
	         */
	        case 'om':
	        case 'is':
	            regexp = /^[0-9]{3}$/;
	        break;
	        /**
	         * "[3 digits] [2 digits]":
	         * - Slovakia
	         * - Czech Republic
	         */
	        case 'sk':
	        case 'cz':
	            regexp = /^[0-9]{3} [0-9]{2}$/;
	        break;
	        /**
	         * "[2 digits]-[3 digits]":
	         * - Poland
	         */
	        case 'pl':
	            regexp = /^[0-9]{2}-[0-9]{3}$/;
	        break;
	        /**
	         * country code followed by a dash and 4 digits
	         * - Latvia
	         * - Azerbaijan
	         * - Moldova
	         * - Slovenia
	         * - Croatia  
	         * - Malta
	         */
	        case 'lv':
	        case 'az':
	        case 'md':
	        case 'sl':
	        case 'hr':
	            regexp = new RegExp( "^" + country + "-[0-9]{4}$", "i" );
	        break;
	        /**
	         * MLH  followed by a dash and 4 digits
	         * - Malta
	         */
	        case 'mt':
	            regexp = /^MLH-[0-9]{4}$/i;
	        break;
	        /**
	         * "[3 digits][2 letters][3 digits]"
	         * - Mauritius
	         */
	        case 'mu':
	            regexp = /^[0-9]{3}[a-z]{2}[0-9]{3}$/i;
	        break;
	        default:
	            regexp = /^[a-z0-9-_]{3,10}$/i;
	    }
	    if ( regexp.test( value ) ) {
	       return true;
	    }
    }
    return false;
}, "Please enter valid postal code" );
// ensure that date is in the past
jQuery.validator.addMethod( "childdob",
                            function( value, element, params ) {
                                if ( this.optional(element) ) {
                                    return true;
                                }
                                if ( '0000-00-00' == value ) {
                                    return true;
                                }
                                var parts   = value.split("-");
                                var cur     = new Date();
                                var future  = cur.setMonth( cur.getMonth() + 9 );
                                var entered = new Date();
                                parts[0]    = parseInt( parts[0], 10 );
                                parts[1]    = parseInt( parts[1], 10 );
                                parts[2]    = parseInt( parts[2], 10 );
                                if ( parts[0] == 0 || parts[0] < 1900 ||
                                     parts[1] == 0 || parts[1] > 12 ||
                                     parts[2] == 0 || parts[2] > 31 ) {
                                     return false;
                                }
                                entered.setFullYear( parts[0], parts[1] - 1, parts[2] );
                                entered.setHours(0,0,0,0)
                                return entered <= future; 
                            },
                            "Please enter valid date (between 1900-01-01 and 9 months from now)."
);

// ensure that date is in the past
jQuery.validator.addMethod( "dateInPast",
                            function( value, element, params ) {
                                if ( '0000-00-00' == value ) {
                                    return true;
                                }
                                var parts   = value.split("-");
                                var cur     = new Date();
                                var entered = new Date();
                                parts[0]    = parseInt( parts[0], 10 );
                                parts[1]    = parseInt( parts[1], 10 );
                                parts[2]    = parseInt( parts[2], 10 );
                                if ( parts[0] == 0 || parts[0] < 1900 ||
                                     parts[1] == 0 || parts[1] > 12 ||
                                     parts[2] == 0 || parts[2] > 31 ) {
                                     return false;
                                }
                                entered.setFullYear( parts[0], parts[1] - 1, parts[2] );
                                entered.setHours(0,0,0,0)
                                return entered <= cur; 
                            },
                            "Please enter valid date in the past (grater or equal than 1900-01-01)."
);
// ensure that date is in the future
jQuery.validator.addMethod( "dateInFuture",
                            function( value, element, params ) {
                                if ( this.optional(element) ) {
                                    return true;
                                }
                                if ( '0000-00-00' == value ) {
                                    return true;
                                }
                                var parts   = value.split("-");
                                var cur     = new Date();
                                var entered = new Date();
                                parts[0]    = parseInt( parts[0], 10 );
                                parts[1]    = parseInt( parts[1], 10 );
                                parts[2]    = parseInt( parts[2], 10 );
                                if ( parts[0] == 0 || parts[0] < cur.getFullYear() ||
                                     parts[1] == 0 || parts[1] > 12 ||
                                     parts[2] == 0 || parts[2] > 31 ) {
                                     return false;
                                }
                                entered.setFullYear( parts[0], parts[1] - 1, parts[2] );
                                entered.setHours(0,0,0,0)
                                return entered > cur; 
                            },
                            "Please enter valid date (format: 'YYYY-MM-DD') in the future."
);
// ensure that field value is unique
jQuery.validator.addMethod( "unique",
                            function( value, element, params ) {
                                if ( this.optional(element) ) {
                                    return true;
                                }
                                var $wrapper       = null;
                                var fieldsSelector = null;
                                if ( "object" == typeof( params ) ) {
                                    $wrapper       = $( element ).closest( params.closest ); 
                                    fieldsSelector = params.selector;
                                } else {
                                    fieldsSelector = params;
                                }
                                var isUnique = true;
                                $( fieldsSelector, $wrapper ).not( element )
                                    .each( function() {
                                        if ( !isUnique ) {
                                            return;
                                        }
                                        switch( this.type ) {
                                            case "submit":
                                            case "hidden":
                                            case "select-one":
                                            case "text":
                                            case "radio":
                                            case "checkbox":
                                                isUnique = isUnique & ( this.value != value );
                                                return;
                                            case "select-multiple":
                                                throw( "Implement!" );
                                                return;
                                            default:
                                                isUnique = isUnique & ( $.trim( this.innerHTML ) != value );
                                                return;
                                        }
                                    } );
                                return isUnique;
                            },
                            "Value must be unique"
);
jQuery.validator.addMethod( "dateList",
                            function( value, element, params ) {
                                if ( this.optional(element) ) {
                                    return true;
                                }
								var invalid_counter;
								invalid_counter = 0;
								var dates = value.split(",");
								if (dates.length > 0) {
									for (var i in dates) {
										var parts = dates[i].split("-");
										if (parts.length == 3) {
											var cur = new Date();
											var entered = new Date();
											parts[0] = parseInt(parts[0], 10);
											parts[1] = parseInt(parts[1], 10);
											parts[2] = parseInt(parts[2], 10);
											if (parts[0] == 0 || parts[0] < cur.getFullYear() ||
											parts[1] == 0 ||
											parts[1] > 12 ||
											parts[2] == 0 ||
											parts[2] > 31) {
												invalid_counter++;
											}
											entered.setFullYear(parts[0], parts[1] - 1, parts[2]);
											entered.setHours(0, 0, 0, 0)
											if ( (entered > cur)==false){
												invalid_counter++;
											}
										}else{
											invalid_counter++;
										}
									}			
																	
									if ( invalid_counter == 0 ){
										//var dates2 = dates;
										//for (var i in dates) {
										//	for (var j in dates2){
										//		if ( (i != j) && (trim(dates[i]) == trim(dates2[j]))){
										//			return false;
										//		}
										//	}
										//}
										
										return true;
									}else{
										return false;
									}
									
								}else{
									return false;
								}
								 
                            },
							//"Wrong format of date list it should be 'YYYY-MM-DD, YYYY-MM-DD, etc.', all dates should be in future, date can't repeat"
                            "Wrong format of date list it should be 'YYYY-MM-DD, YYYY-MM-DD, etc.', all dates should be in future"
);

jQuery.validator.addMethod( "dateRange",
        function( value, element, params ) {
            if ( this.optional(element) ) {
                return true;
            }
			var invalid_counter;
			invalid_counter = 0;
			var dates = value.split(" : ");
			if (dates.length > 0) {
				for (var i in dates) {
					var parts = dates[i].split("-");
					if (parts.length == 3) {
						var cur = new Date();
						
						parts[0] = parseInt(parts[0], 10);
						parts[1] = parseInt(parts[1], 10);
						parts[2] = parseInt(parts[2], 10);
						if (parts[0] == 0 || parts[0] < cur.getFullYear() ||
						parts[1] == 0 ||
						parts[1] > 12 ||
						parts[2] == 0 ||
						parts[2] > 31) {
							invalid_counter++;
						}
						var entered = new Date(parts[0], parts[1] - 1, parts[2] );
						//entered.setFullYear(parts[0], parts[1] - 1, parts[2]);
						cur.setHours(0, 0, 0, 0);
						if ( entered.valueOf() < cur.valueOf() ){
							invalid_counter++;
						}
					} else {
						invalid_counter++;
					}
				}			
				if ( invalid_counter == 0 ){
					//var dates2 = dates;
					//for (var i in dates) {
					//	for (var j in dates2){
					//		if ( (i != j) && (trim(dates[i]) == trim(dates2[j]))){
					//			return false;
					//		}
					//	}
					//}
					
					return true;
				}else{
					return false;
				}
				
			}else{
				return false;
			}
			 
        },
		//"Wrong format of date list it should be 'YYYY-MM-DD, YYYY-MM-DD, etc.', all dates should be in future, date can't repeat"
        "Wrong format of dates range it should be 'YYYY-MM-DD:YYYY-MM-DD', all dates should be in future"
);
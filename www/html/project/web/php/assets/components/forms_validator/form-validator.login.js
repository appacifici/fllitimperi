formValidatorLogin = null;
$( function() {
    formValidatorLogin = new FormValidatorLogin();
});

/**
 * Classe per delle notyfy
 */ 
var FormValidatorLogin = function() {	
    this.initValidate( 'formLogin' );
    
}


FormValidatorLogin.prototype.initValidate = function( idFormLogin, reload, callback ) {
    var reload = typeof reload != 'undefined' ? reload : true;
    
	// initialize tooltipster on text input elements
    $( '#'+idFormLogin+' input' ).tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: 'bottom',
        fixedWidth: '290'
    });

    // initialize validate plugin on the form
    $( '#'+idFormLogin ).validate({
        errorPlacement: function (error, element) {
//            $(element).tooltipster('update', $(error).text());
//            $(element).tooltipster('show');
            $(element).addClass('has-error');
        },
        success: function (label, element) {
            //$(element).tooltipster('hide');
            $(element).removeClass('has-error');
        },
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            password: {
                required: "Inserisci la tua password",
                minlength: "Inserisci la tua password"
            },
            email: "Inserisci un email valita"
        },

        submitHandler: function () {
            var request = $.ajax({
                url: ajaxCallPath + "call.php?" + $( "#"+idFormLogin ).serialize(),
                type: "GET",
                async: false,
                dataType: "xml"
            });

            request.done( function( xml ) {
                var totalError = false; 
                var mex = false;

                $( xml ).find('root').each( function() {
                    totalError = $( this ).find('errors').attr('total');
                    mex = $( this ).find('message').text();
                });

                if( !totalError && reload ) {
                    setTimeout(function(){ location.reload(); }, 2000 );
                } else if( !totalError && !reload ) {
                    var html = '<div class="row row-icons popupLogin"><div class="col-md-2 col-sm-1"><a href=""><i class="fa fa-check-square-o"></i></a></div>'+
                            '<h4 style="padding: 33px;">LOGIN EFFETTUATO CON SUCCESSO</h4></div>';
                    $( "#"+idFormLogin ).closest( '.innerAll' ).html( html );

                    if( typeof callback != 'undefined' ) {
                        if( typeof callback.params != 'undefined' )
                            callback.call( callback.params[0] );
                        else
                            callback.call();
                    }
                    bootbox.hideAll();
                    return true;
                }

                var parameters = new Array();   
                parameters['type'] = !totalError ? 'success' : 'error';
                parameters['layout'] = 'top';
                parameters['mex'] =  mex;
                classNotyfy.openNotyfy( parameters );     

            });
            return false;    
        }
	});
};

$.validator.addMethod("loginRegex", function(value, element) {
    return true;
    //return this.optional(element) || /^[a-zA-Z0-9\_-\s]+$/.test(value);
});
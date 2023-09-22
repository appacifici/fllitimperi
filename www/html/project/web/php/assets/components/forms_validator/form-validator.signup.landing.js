formValidatorSignupLanding = null;
$( function() {
    formValidatorSignupLanding = new FormValidatorSignupLanding();
});

/**
 * Classe per delle notyfy
 */ 
var FormValidatorSignupLanding = function() {	
    this.initValidate( 'formSignUp' ); 
}

/**
 * Metodo che valida il form della registrazione
 * @param {type} idFormLogin
 * @returns {undefined}
 */
FormValidatorSignupLanding.prototype.initValidate = function( idFormLogin ) {
    var that = this;
    
    var ww = $( window ).width();
    if( ww < 480 )
        var pos = 'bottom';
    else
        var pos = 'left';
        
    // initialize tooltipster on text input elements
    $('#'+idFormLogin+' input, #'+idFormLogin+' select').tooltipster({
        trigger: 'custom',
        onlyOne: false,
        position: pos,
        fixedWidth: '290'
    });

    // initialize validate plugin on the form
    $( '#'+idFormLogin ).validate({
        errorPlacement: function (error, element) {
            $( element ).removeClass( 'error' ); 
            $( element ).tooltipster( 'update', $( error ).text() );
            $( element ).tooltipster( 'show' );
            $( element ).addClass( 'has-error' );            
            
            if( $( error ).text() != '' ) {
                utility.trackGAClickEvent( 'Registrazione', 'Errore Compilazione Form', element.context.name );
            }
        },
        success: function ( label, element ) {
            $( element ).tooltipster( 'hide' );
            $( element ).removeClass( 'has-error' );
        },
        rules: {
            username: {
                required: true,
                minlength: 3,
                loginRegex: true
            },
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo: $('#'+idFormLogin ).find( '#password' )
            },
            email: {
                required: true,
                email: true
            },
            fkCategory: { required: true },
            privacy: "required"
        },
        messages: {
            firstname: "Please enter your firstname",
            lastname: "Please enter your lastname",
            username: {
                required: "Inserisci la tua username",
                minlength: "L'username deve essere di almeno 3 ",
                loginRegex: "L'username può contenere solo lettere e numeri"
            },
            password: {
                required: "Inserisci una password",
                minlength: "Inserisci una password di almeno 5 caratteri"
            },
            confirm_password: {
                required: "Inserisci una password",
                minlength: "Inserisci una password di almeno 5 caratteri",
                equalTo: "Inserisci la stessa password inserita sopra"
            },
            email: "Inserisci un email valita",
            fkCategory: "Seleziona la categoria",
            privacy: "Campo obbligatorio"
        },
        submitHandler: function () {
            var request = $.ajax({
                url: ajaxCallPath + "call.php?" + $('#formSignUp').serialize(),
                type: "GET",
                async: false,
                dataType: "xml"
            });
//
            request.done( function ( xml ) {
                var totalError = false;
                var mex = false;

                $(xml).find('root').each(function () {
                    totalError = $(this).find('errors').attr('total');
                    mex = $(this).find('message').text();
                    field = $(this).find('field').text();
                });
                
                if( totalError ) {
                    if( field != 'username' && field != 'email' ) {
                        var parameters = new Array();
                        parameters['type'] = !totalError ? 'success' : 'error';
                        parameters['layout'] = 'top';
                        parameters['mex'] = mex;
                        classNotyfy.openNotyfy(parameters); 
                    } else {
                        utility.trackGAClickEvent( 'Registrazione', 'Submit Handler', 'Errore' );
                    }

                    if( typeof field != 'unefined' && field != '' ) {
                        utility.trackGAClickEvent( 'Registrazione', 'Submit Handler', field + ' gia esistente' );
                        $('#'+idFormLogin).find( '#' + field ).tooltipster( 'update', mex );
                        $('#'+idFormLogin).find( '#' + field ).tooltipster( 'show' );
                        $('#'+idFormLogin).find( '#' + field ).addClass( 'has-error' );
                    }
                    
                } else {
                    utility.trackGAClickEvent( 'Registrazione', 'Submit Handler', 'Successo' );
                    that.getSnippedConfirmSignup( idFormLogin );
                }
                
                if (!totalError)
                    formControl.resetForm( "#formSignUp" );
            });
            return false;
        }
    });
};

/**
 * Metodo che recupera lo snipped della conferma registrazione avvenuta
 * @param {type} idFormLogin
 * @returns {undefined}
 */
FormValidatorSignupLanding.prototype.getSnippedConfirmSignup = function( idFormLogin ) {    
    utility.getConfirmEmailUserSocial( $('#'+idFormLogin).find( '#email' ).val() );
    return true;
    
    var request = $.ajax({
        url: ajaxCallPath + "call.php?action=getConfirmSignup&email="+$('#'+idFormLogin).find( '#email' ).val(),
        type: "GET",
        async: false,
        dataType: "html"
    });
    request.done(function ( html ) {
        var params = { 
            type: 'custom', 
            title: '',
            callbackModals: html
        };
        classModals.openModals( params );         
    });
};

$.validator.addMethod("loginRegex", function(value, element) {
    return true;
    //return this.optional(element) || /^[a-zA-Z0-9\_-\s]+$/.test(value);
});
var formModifyAccount = null;
$( function() {    
    formModifyAccount = new FormModifyAccount();
});

/**
 * Classe per della modifica dell'account
 */ 
var FormModifyAccount = function() {	
    this.init();    
}

/**
 * Inizializzatore classe
 * @returns {undefined}
 */
FormModifyAccount.prototype.init = function() {
    var that = this;
    this.idFormModify = 'formModifyAccount';
    $( "#" + this.idFormModify ).find( '#fkCategory' ).click( function() {
        that.enabledFieldAge( this );
    });
    
    this.isActivity = $( '#isActivity' ).val();
    this.enabledAge = this.isActivity == 1 ? false : true;
    this.enabledCatInterest = this.isActivity == 1 ? false : true;
    this.enabledAreasInterest = this.isActivity == 1 ? false : true;
    this.initValidate();
    
    
    $( "#" + this.idFormModify ).find( '#fkRegion' ).change( function() {
         $( "#" + that.idFormModify ).find( '#fkProvince' ).select2("val", "");
         $( "#" + that.idFormModify ).find( '#fkCity' ).select2("val", "");
    });
    
     $( "#" + this.idFormModify ).find( '#fkProvince' ).change( function() {
         $( "#" + that.idFormModify ).find( '#fkCity' ).select2("val", "");
    });    
    
};

/**
 * Metodo che effettua la validazione del form di modifuca profilo utente
 * @returns {undefined}
 */
FormModifyAccount.prototype.initValidate = function() {
    var that = this;
    
	// validate signup form on keyup and submit
	$( "#" + this.idFormModify ).validate({
		rules: {
            username: { 
                required: true,
                remote: {
                    url: ajaxCallPath + "call.php?action=checkExistsUsername",
                    type: "get"
                }
            },
            email: { 
                required: true,                
                email: true,
                remote: {
                    url: ajaxCallPath + "call.php?action=checkExistsEmail",
                    type: "get"
                }
            },
            fkCategory: { required: true },
            fkRegion: { required: true },
            fkProvince: { required: true },
            fkCity: { required: true },
            ageMan: { required: that.enabledAge },
            ageWoman: { required: that.enabledAge },
            "catInterest[]": { required: that.enabledCatInterest },
            "areasInterest[]": { required: that.enabledAreasInterest },
            tel: { number: true },
            address: { number: false },
			description: {
				maxlength: 1000
			}            
		},
		messages: {
            username: {
                required: "Inserisci una username",
                remote: "L'username è gia in uno"
            },
            email: {
                required: "Inserisci la tua email",
                email: "Inserisci un email valida",
                remote: "L'email è gia in uso"
            },
            fkCategory : "Seleziona la categoria",
            fkRegion : "Seleziona la regione",
            fkProvince : "Seleziona la provincia",
            fkCity : "Seleziona la città",
            ageMan : "Seleziona l'eta",
            ageWoman : "Seleziona l'eta",
            tel: "Inserisci un numero di telefono valido",
            address: "Inserisci un indirizzo di telefono valido",
            "catInterest[]" : "Seleziona le categorie di interesse",
            "areasInterest[]" : "Seleziona le zone di interesse",
			description: "Inserire massimo 500 caratteri"
		},
        
        submitHandler: function() { 
            if( !users.isLogged() ) {
                var callback = { 'call': that.modify.bind( that ) };
                users.getLoginBox( 'formLoginPopup', false, callback );
                return false;
            }            
            that.modify(); 
            return false;
        },

        showErrors: function(map, list) {
            this.currentElements.parents('label:first, div:first').find('.has-error').remove();
            this.currentElements.parents('.form-group:first').removeClass('has-error');

            $.each(list, function(index, error) 
            {
                var ee = $(error.element);
                var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');

                ee.parents('.form-group:first').addClass('has-error');
                eep.find('.has-error').remove();
                eep.append('<p class="has-error help-block pull-right" style="color:#a94442;margin-top:3px:margin-rigth:15px;">' + error.message + '</p>');

            });
            //refreshScrollers();
        }

	});
};

/**
 * Metodo che abilita il field dell'eta in base alla categoria
 * @param {type} sender
 * @returns {undefined}
 */
FormModifyAccount.prototype.enabledFieldAge = function( sender ) {   
    switch( $( sender ).val() ) {
        case '1':
        case '2':
        case '3':
        case '9':
        case '10':            
            $( "#" + this.idFormModify ).find( '#ageMan' ).removeAttr('disabled');
            $( "#" + this.idFormModify ).find( '#ageWoman' ).removeAttr('disabled');
        break;
        case '4':
        case '5':
            $( "#" + this.idFormModify ).find( '#ageMan' ).removeAttr('disabled');
            $( "#" + this.idFormModify ).find( '#ageWoman' ).attr('disabled','disabled');
            $( '#s2id_ageWoman' ).closest('.col-md-9').find( '.help-block' ).remove();
            $( '#s2id_ageWoman' ).closest('.has-error').removeClass( 'has-error' );
        break;
        case '6':
        case '7':
        case '11':
            $( "#" + this.idFormModify ).find( '#ageMan' ).attr('disabled','disabled');
            $( "#" + this.idFormModify ).find( '#ageWoman' ).removeAttr('disabled');
            $( '#s2id_ageMan' ).closest('.col-md-9').find( '.help-block' ).remove();
            $( '#s2id_ageMan' ).closest('.has-error').removeClass( 'has-error' );
        break;
        default:
            $( "#" + this.idFormModify ).find( '#ageMan' ).removeAttr('disabled');
            $( "#" + this.idFormModify ).find( '#ageWoman' ).removeAttr('disabled');
        break;
    }
};

/**
 * MEtodo che effettua la modifica del prodilo dell'utente
 * @returns {undefined}
 */
FormModifyAccount.prototype.modify = function() {
    var that = this;
    
    utility.trackGAClickEvent( 'Modifica Account', 'Invio Form', '' );
    var request = $.ajax({
        url: ajaxCallPath + "call.php?" + $( "#" + this.idFormModify  ).serialize(),
        type: "GET",
        async: false,
        dataType: "xml"
    });

    request.done( function( xml ) {
        var totalError = false;
        var mex = false;

        $( xml ).find( 'root' ).each( function() {
            totalError = $( this ).find( 'errors' ).attr( 'total' );
            mex = $( this ).find( 'message' ).text();
        });

        var parameters = new Array();   
        parameters['type'] = !totalError ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = mex;
        classNotyfy.openNotyfy( parameters );   
        
        if( !totalError ) {
            utility.trackGAClickEvent( 'Modifica Account', 'Successo Modifica', '' );
            //that.getAccountDetails();
            
            switch( $( '#data-typeRegister' ).val() ) {                
                case 'userSocialNotEmailRegister':
                    var email = $( "#" + that.idFormModify  ).find( '#email' ).val();
                    utility.getConfirmEmailUserSocial( email );
                    $( '.buttonModify' ).remove();
                break;
                case 'userFormRegister':
                case 'userSocialEmailRegister':
                    if( $( '#imageProfile' ).val() == '' )
                        utility.getInsertImageProfile();
                    else
                        utility.getViewNumberRequiredHigh();                    
                    $( '.buttonModify' ).remove();
                break;
            }            
            utility.trackGAClickEvent( 'Modifica Account', 'Successo Modifica', $( '#data-typeRegister' ).val() );
        } else {
            utility.trackGAClickEvent( 'Modifica Account', 'Errore Modifica', '' );
        }

    });
};

/**
 * Metodo che recupera i dettagli aggiornati dell'utente
 * @returns {undefined}
 */
FormModifyAccount.prototype.getAccountDetails = function() {
    var request = $.ajax({
        url: ajaxCallPath + "call.php?action=getAccountDetails",
        type: "GET",
        async: false,
        dataType: "html"
    }).done( function( html ) {
        $( '#account-details' ).html( html );
    });
};

/*
 * Metodo che apre il popup guida dopo la modifica dell'account in fase di registrazione
 */
FormModifyAccount.prototype.openGuidePostModify = function() {
    var email = $( "#" + this.idFormModify  ).find( '#email' ).val();
    utility.getConfirmEmailUserSocial( email );
    $( '.buttonModify' ).remove();
}
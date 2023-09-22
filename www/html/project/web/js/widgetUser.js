
/**
 * Classe per la gestione dei commenti
 */
var WidgetUser = function () {
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetUser.prototype.initListeners = function () {
    var that = this;       
    
    
    $('body').on( 'click', '[data-logout]', function(e) {
        if (that.isLogged() == 1) {
           that.userLogout();
        }
    });
    
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-forgotPwd="1"]', function ( e ) {
        bootbox.hideAll();
        that.openPopupForgotPwd();
    });
   
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-resetPwd="1"]', function ( e ) {
        var pwd = $('#resetPwd').val();
        var confirmPwd = $('#confirmPwd').val();
        if ( pwd != confirmPwd) {
            e.stopPropagation();
            e.preventDefault(); 
            var params = { 
              type: 'custom', 
              title: 'Offerteprezzi.it' ,
              callbackModals: '\
              <div class="containerMsg">\
                  <div class="containerMsg">\
                      <div>\
                          <label>Le due password devono coincidere</label>\
                      </div>\
                  </div>\
              </div>'
              };
          classModals.openModals( params );
        }
    });
    
    // al click mando la mail per il reset della password
    $( 'body' ).on( 'click', '[data-sendMail="1"]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
        bootbox.hideAll();
        that.forgotPwd( this );
    });
    
    // al click parte il flusso per la registrazione
    $( 'body' ).on( 'click', '[data-defaultRegister]', function ( e ) {
        that.sendRegistration( this );       
    });
    
    // al click parte il flusso per il login
    $( 'body' ).on( 'click', '[data-defaultLogin]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();    
        that.sendLogin( this );
    }); 
    
    
};


/**
 * Metodo che controlla se l'utente è loggato
 */
WidgetUser.prototype.isLogged = function ( sender ) {
    var isLogged = 0;
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Logged",
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         isLogged = resp;
     });
     
     return isLogged;
};

/**
 * Metodo che gestisce il login
 */
WidgetUser.prototype.sendLogin = function ( sender ) {

    var that = this; 
    var login = 0;
    var data = $( sender ).closest( '[data-formLogin]' ).serialize();
    
    var loginEmail = $( sender ).closest( '[data-formLogin]' ).find( '#email' );
    var loginPassword = $( sender ).closest( '[data-formLogin]' ).find( '#password' );
    
    if ( loginPassword.val() == "" || loginEmail.val() == "") {
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( 'error' );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( 'Inserisci email e password');
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( 'error' );
        }, 5000 );
        
        return false;
    }
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Login?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {
        login = resp;
        
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        
        
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( parameters['type'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( parameters['mex'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( parameters['type'] );
            if( resp != 0 ) {
                $ ('[data-widgetLogin], [data-boxLogin]').toggle();  
                window.location.href = '/';
            }
        }, 3000 );                         
        
    });
    
    return login;
};

/**
 * Metodo che gestisce la registrazione dell'utente
 */
WidgetUser.prototype.sendRegistration = function ( sender ) {
    var that = this;
    var error = 0;
    var data = $( sender ).closest( '[data-formRegistration]' ).serialize();
    
    var loginEmail = $( sender ).closest( '[data-formRegistration]' ).find( '#email2' );
    var loginPassword = $( sender ).closest( '[data-formRegistration]' ).find( '#password2' );
    var privacy = $( sender ).closest( '[data-formRegistration]' ).find( '#privacy' );
    
    if ( loginPassword.val() == "" || loginEmail.val() == "" || !privacy.is(':checked') ) {
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( 'error' );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( 'Inserisci email password, e consenso informativa privacy');
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( 'error' );
        }, 5000 );
        
        return false;
    }
    
    var request = $.ajax ({
        url: "/ajax/sendRegistration/externalUser?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( response ) {
        var type = 'error';
        
        if ( response == 1 ) {
            var msg = 'Registrazione avvenuta con successo';
            var type = 'success';                        
        }  
        
        if ( response == 0 ) {            
            var msg = 'Errore durante la Registrazione. Riprova!';            
        }
        
        if ( response == 2 ) {
            var msg = 'Errore durante la Registrazione. Indirizzo Mail già presente!'       
        }
        
        if ( response == 3 ) {
            var msg = 'Inserisci un indirizzo email valido!'       
        }
        
        var parameters = new Array();   
        parameters['type'] = type;
        parameters['layout'] = 'top';
        parameters['mex'] =  msg;
        
        $( '[data-boxLogin] [data-boxRespUser]' ).addClass( parameters['type'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).html( parameters['mex'] );
        $( '[data-boxLogin] [data-boxRespUser]' ).show();
        setTimeout(function() {
            $( '[data-boxLogin] [data-boxRespUser]' ).hide();
            $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( parameters['type'] );
            if( resp == 1 ) {
                window.location.href = '/';
            }
        }, 3000 );           
//        if ( response == 1 ) {
//            setTimeout(function() {
//                bootbox.hideAll();    
//                window.location.href = '/';
//            }, 1500);
//        }
        
    });
};

/**
 * Metodo che apre il popUp per il login
 */
WidgetUser.prototype.openPopupLogin = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'ACCEDI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formLogin" class="login-form" data-formLogin>\
                    <div class="form__row">\
                        <div>\
                            <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">\
                        </div>\
                        <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">\
                            </div>\
                            <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>\
                        </div>\
                    </div>\
                </form>\
                <div>\
                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">\
                </div>\
            </div>'
            };
    classModals.openModals( params );
    //
    //<div>\
    //    <input class="googleLogin button button--fill button--big" data-GoogleLogin type="submit" value="Accedi con Google">\
    //</div>\
};

/**
 * Metodo che apre il popUp per il reset della Pwd
 */
WidgetUser.prototype.openPopupForgotPwd = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'RESETTA PASSWORD' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formForgotPwd" class="reset-form" data-formForgotPwd>\
                    <div class="form__row">\
                        <div>\
                            <input id="resetEmail" class="form__input-text form__input-text--m-top" type="email" name="resetEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-reset" class="button button--fill button--big" type="submit" data-sendMail="1" value="Invia Mail">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
};

/**
 * Metodo che apre il popUp per la registrazione
 */
WidgetUser.prototype.openPopupRegistration = function ( teams ) {
    var option = '';
    var optionAge = '';
    
    if ( teams != null ) {
        $( teams ).each( function() {
            option+= '<option value="'+ this.id +'">'+this.name+'</option>';
        });
    }
    
    for( var x = 6; x < 100; x++ ) {
        optionAge+= '<option value="'+ x +'">'+x+'</option>';
    };
    
    var params = { 
            type: 'custom', 
            title: 'REGISTRATI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formRegistration" onSubmit="return false" class="registration-form" data-formRegistration>\
                    <div class="form__row">\
                        <div>\
                            <input id="registrationName" type="text" name="registrationName" placeholder="Nome" required>\
                        </div>\
                        <div>\
                            <input id="registrationSurname" type="text" name="registrationSurname" placeholder="Cognome" value="">\
                        </div>\
                        <div>\
                            <input id="registrationEmail" type="email" name="registrationEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="registrationPassword" type="password" name="registrationPassword" placeholder="Password" value="">\
                        </div>\
                        <div>\
                            <select id="registrationAge" class="selectIsTeam"  name="registrationAge">\
                            '+ optionAge +'\
                            </select>\
                        </div>\
                        <div>\
                            <input id="registrationCity" type="hidden" name="registrationCity" placeholder="Città" value="">\
                        </div>\
                        <div>\
                            <input id="registrationTeam" class="selectIsTeam" name="registrationTeam" value="0" type="hidden">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input type="submit" id="button-registration" data-addUser="1" class="button button--fill button--big" value="Registrati">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
    $('.containerForm').closest('.modal-content').css('height', '600px');
};

/**
 * Metodo che riprende tutti i team per la scelta della sqadra per la registrazione
 */
WidgetUser.prototype.retrieveTeam = function () {
    var that = this;
    var request = $.ajax ({
            url: "/ajax/retrieve/team",
            type: "GET",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null )
                that.openPopupRegistration(resp);             
        });
        return false;
};

/**
 * Metodo che permette il reset della pwd
 */
WidgetUser.prototype.forgotPwd = function ( sender ) {
    var that = this;
    var data = $( sender ).closest( '[data-formForgotPwd]' ).serialize();
    
    var request = $.ajax ({
            url: "/ajax/forgot/password?"+data,
            type: "POST",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null ) {
                  var params = { 
                        type: 'custom', 
                        title: 'Calciomercato.it' ,
                        callbackModals: '\
                        <div class="containerMsg">\
                            <div class="containerMsg">\
                                <div>\
                                    <label>Ti abbiamo inviato una mail al tuo indirizzo</label>\
                                </div>\
                            </div>\
                        </div>'
                        };
                    classModals.openModals( params );        
            }
        });
        return false;
};

WidgetUser.prototype.userLogout = function ( sender ) {    
    
    var request = $.ajax ({
        url: "/logoutExternalUser",
        type: "POST",
        async: true,
        dataType: "html"        
        });
        request.done( function( resp ) {
            if (resp != false ) {
                window.location.href = '/';
            } else {
                return false;
            }

        });
        
    };

var widgetUser   = null;
widgetUser       = new WidgetUser();
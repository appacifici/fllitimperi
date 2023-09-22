

/**
 * Classe per la gestione degli utenti
 */ 
var Facebook = function() {
    var that = this;
    this.authResponse = null;
    this.facebookLogin = $( '[data-FbLogin]' );
    
    window.fbAsyncInit = function() {
        FB.init({
          appId      : facebookAppId,
          cookie     : true,  // enable cookies to allow the server to access 
                              // the session
          xfbml      : true,  // parse social plugins on this page
          version    : 'v3.2' // use version 2.2
        });
//        FB.getLoginStatus(function(response) {
//          that.statusChangeCallback(response);
//        });
    };
    this.initListeners();
};

/**
 * Metodo che avvia gli scoltatori
 */
Facebook.prototype.initListeners = function() {
    var that = this;
    $( 'body' ).on( 'click', '[data-FbLogin]', function() {       
//        users.logout( false );
//        utility.trackGAClickEvent( 'Login', 'Facebook', 'Landing' );
        that.login();
    });
};

/**
 * @returns {undefined}
 * https://developers.facebook.com/docs/facebook-login/permissions/v1.0#reference-extended
 */
Facebook.prototype.login = function() {
    var that = this;    
    FB.login(function(){
            FB.getLoginStatus(function(response) {
                that.checkUserLoginStatus( response );
            });
        }, { scope: facebookScope }
    );       
};

/**
 * This is called with the results from from FB.getLoginStatus()
 * @param {type} response
 * @returns {undefined}
 */
Facebook.prototype.checkUserLoginStatus = function ( response ) {
    var that = this;
    this.authResponse = response.authResponse;
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
//      utility.trackGAClickEvent( 'Login', 'Facebook', 'Connesso a Facebook' );
      var images = this.getImageProfileUser();
      var email = this.getUserInfo();
      setTimeout( function(){that.connectUserFromFacebook()}, 500 );
    }     
};

/**
 * Metodo che recupera l'immagine del profilo dell'utente
 * @returns {undefined}
 */
Facebook.prototype.getImageProfileUser = function (  ) {
    var that = this;
    FB.api(
        "/me/picture", {
            "redirect": false, 
            "height": 500,
            "width": 500,
            "type": "normal"
        },
        function ( response ) {
          if ( response && !response.error ) {
            that.imageProfile = response;
          }
        }
    );
};
/**
 * Metodo che recupera il profilo dell'utente
 * @returns {undefined}
 */
Facebook.prototype.getUserInfo = function (  ) {
    var that = this;    
    FB.api('/me', {fields: 'email, age_range'}, function(response) {
        that.email = response.email;
        that.age   = response.age_range.min;
    });
};

/**
 * Metodo che connette l'utente a calciomercato.it tramite facebook.com
 * @returns {undefined}
 */
Facebook.prototype.connectUserFromFacebook = function () {
    var that = this;
    
    FB.api( '/me', function( response ) {
        response.picture = that.imageProfile['data']['url'];
        response.email   = that.email;
        response.age     = that.age;
        var request = $.ajax({
            url: "/ajax/sendRegistration/externalUserSocial",
            type: "GET",
            async: false,
            dataType: "html",
            data: {
                action : 'Facebook',
                authResponse : JSON.stringify( that.authResponse ),
                userFb : JSON.stringify( response )
            }
        });
        request.done( function( resp ) {                          
            var parameters = new Array();   
            
            if (resp == 1 ) {
                parameters['type'] = 'success';
                parameters['mex'] =  'Login effettato con successo';    
                  
            } else if (resp == 0 ) {
                parameters['type'] = 'error';
                parameters['mex'] =  'Errore durante il login';
            } else if (resp == 2 ) {
                parameters['type'] = 'error';
                parameters['mex'] =  'Email già presente';
            } else if (resp == 5 ) {
                parameters['type'] = 'error';
                parameters['mex'] =  'Non è stato possibile effettuare la registrazione, in quanto il tuo account non ha accesso pubblico alla tua email';
            }
            
            parameters['layout'] = 'top';
//            classNotyfy.openNotyfy( parameters ); 
            $( '[data-boxLogin] [data-boxRespUser]' ).addClass( parameters['type'] );
            $( '[data-boxLogin] [data-boxRespUser]' ).html( parameters['mex'] );
            $( '[data-boxLogin] [data-boxRespUser]' ).show();
            setTimeout(function() {
                $( '[data-boxLogin] [data-boxRespUser]' ).hide();
                $( '[data-boxLogin] [data-boxRespUser]' ).removeClass( parameters['type'] );
                $ ('[data-widgetLogin], [data-boxLogin]').toggle();  
                window.location.href = '/'; 
            }, 3000 );
        });        
    });
};

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      facebook.statusChangeCallback(response);
    });
}

//        window.onload = function() {
//
//        //if( window.location.pathname == "/amp/getFormLogin" ) {
//            // Load the SDK asynchronously
//            function loadLibraryFb(d, s, id) {
//              var js, fjs = d.getElementsByTagName(s)[0];
//              if (d.getElementById(id)) return;
//              js = d.createElement(s); js.id = id;
//              js.src = "//connect.facebook.net/it_IT/sdk.js";
//              fjs.parentNode.insertBefore(js, fjs);
//            };
//
//            loadLibraryFb(document, 'script', 'facebook-jssdk');
//        };

var facebook = null;
facebook = new Facebook();
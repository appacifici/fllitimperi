var clientId = googleClientId;
var apiKey = googleApiKey;
var scopes = googleScopes;


function handleAuthResult( authResult ) { googleClass.handleAuthResult( authResult ); }
function makeApiCall() { googleClass.makeApiCall(); }

/**
 * Classe per la gestione delle comunicazioni con google
 */ 
var Google = function( clientId, apiKey, scopes ) {
    var that = this;
    
    this.clientId = clientId;
    this.apiKey   = apiKey;
    this.scopes   = scopes;   
    this.authResponse = null;
    
    this.googleLogin = $( '[data-GoogleLogin]' );
    this.init();
};

/**
 * Metodo che avvia gli scoltatori
 */
Google.prototype.init = function() {
    var that = this;
    $( 'body' ).on( 'click', '[data-GoogleLogin]', function() {   
//        users.logout( false );
//        utility.trackGAClickEvent( 'Login', 'Google', 'Landing' );
        
        gapi.client.setApiKey( that.apiKey );
//        window.setTimeout( that.checkAuth, 1 );
        gapi.auth.authorize({
            client_id: that.clientId, 
            scope: that.scopes, 
            immediate: false
        }, that.handleAuthResult );
            
    });
};

/**
 * Metodo che effettua il login tramite google plus
 * @returns {undefined}
 */
Google.prototype.login = function() {
    // Step 2: Reference the API key
    var that = this;
    gapi.client.setApiKey( that.apiKey );
    window.setTimeout( that.checkAuth, 1 );    
};

/**
 * Metodo che effettua la richiesta oAuth per il login di google plus
 * @returns {undefined}
 */
Google.prototype.checkAuth = function() {
    var that = this;
    gapi.auth.authorize({
        client_id: that.clientId, 
        scope: that.scopes, 
        immediate: false
    }, that.handleAuthResult );
};

/**
 * Metodo che analizza la risposta della richiesta oAuth
 * @param {type} authResult
 * @returns {undefined}
 */
Google.prototype.handleAuthResult = function( authResult ) {
    var authorizeButton = $('#authorize-button');
    if (authResult && !authResult.error) {
      $( authorizeButton ).css( 'visibility ', 'hidden');
      gapi.auth.setToken( authResult ); 
      this.makeApiCall();
      
       if (authResult && !authResult.error) {
        $.get("https://www.google.com/m8/feeds/contacts/default/full?alt=json&access_token=" + authResult.access_token + "&max-results=700&v=3.0",
          function(response){
             ;
          });
        }
      
    } else {
      authorizeButton.style.visibility = '';
      authorizeButton.onclick = this.handleAuthClick;
    }
};

/**
 * Metodo che effettua la richiesta oAuth per il login di google plus
 * @returns {undefined}
 */
Google.prototype.handleAuthClick = function() {  
    var that = this;
    gapi.auth.authorize({
        client_id: clientId, 
        scope: scopes, 
        immediate: false
    }, that.handleAuthResult );
};

/**
 * Metodo che sfrutta le api gapi per recuperare i dati dell'utente loggato con google  plus
 * @returns {undefined}
 */
Google.prototype.makeApiCall = function() {
    var that = this;   
//    utility.trackGAClickEvent( 'Login', 'Google', 'Connesso a google' );
    gapi.client.load('oauth2', 'v2', function() {
        var request = gapi.client.oauth2.userinfo.get();
        request.execute( that.connectUserFromGoogle );
    });    
};

Google.prototype.connectUserFromGoogle = function ( response ) {
    var that = this; 
    var request = $.ajax({
        url: "/ajax/sendRegistration/externalUserSocial",
        type: "GET",
        async: false,
        dataType: "html",
        data: {
            action : 'Google',
            access_token : gapi.auth.getToken().access_token,
            userGoogle : JSON.stringify( response )
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
};

/**
 * Metodo che avvia il recupero dei contatti di un utente
 * @param {type} callback
 * @returns {undefined}
 */
Google.prototype.getUserFriendsContacts = function( callback ) {
	gapi.client.setApiKey( apiKey );	// app api-wide client api key
	//this.getGoogleContactEmails( callback );
        
    var that = this;
    gapi.auth.authorize({
        client_id: clientId, 
        scope: 'https://www.google.com/m8/feeds', 
        immediate: false
    }, function( authResult ) {
       if ( authResult && !authResult.error ) {
            that.getGoogleContactEmails( callback );
        } else {
            that.getUserFriendsContacts( callback );
        } 
    }); 
};

/**
 * Metodo che recupera i contatti di un utente tramite le gapi di google
 * @param {type} callback
 * @returns {undefined}
 */
Google.prototype.getGoogleContactEmails = function( callback ) {
  var oauth_clientKey = clientId; // replace with your oauth client api key
	var firstTry = true;
    
	function connect(immediate, callback){
	    var config = {
	        'client_id': oauth_clientKey,
	        'scope': 'https://www.google.com/m8/feeds',
	        'immediate': immediate
	    };        
	    gapi.auth.authorize( config, function () {
			var authParams = gapi.auth.getToken();            
	        $.ajax({
	            url: 'https://www.google.com/m8/feeds/contacts/default/full?max-results=10000',
	            dataType: 'jsonp',
	            type: "GET",
	            data: authParams,
	            success: function( data ) {                    
	                var parser = new DOMParser();
	 				xmlDoc = parser.parseFromString( data, "text/xml" );
	 				var entries = xmlDoc.getElementsByTagName( 'feed' )[0].getElementsByTagName( 'entry' );
	 				var contacts = [];
	 				for ( var i = 0; i < entries.length; i++ ){
                        var name = entries[i].getElementsByTagName( 'title' )[0].innerHTML;                        
                        if( typeof entries[i].getElementsByTagName( 'gd:email' )[0] != 'undefined' ) {
                            var email = $( entries[i].getElementsByTagName( 'gd:email' )[0] ).attr( 'address' );
                            contacts.push( { name: name, email: email } );
                        } else {
                            var emails = entries[i].getElementsByTagName( 'email' );
                            for ( var j = 0; j < emails.length; j++ ) {
                              var email = emails[j].attributes.getNamedItem( 'address' ).value;
                              contacts.push( { name: name, email: email } );
                            }
                        }                                                    
	 				}
	 				callback( contacts );
	            }
	        });
	    });
	}
	connect( true, callback );
}

var googleClass = null;
googleClass = new Google( clientId, apiKey, scopes );
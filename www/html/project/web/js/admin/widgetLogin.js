WidgetLogin = null;
$(function () {
    widgetLogin = new WidgetLogin();
});

/**
 * Classe per la gestione del widget
 */
var WidgetLogin = function () {
    this.formLogin = $( '#formLogin' );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetLogin.prototype.initListeners = function () {
    var that = this;
    $( this.formLogin ).find( 'button' ).click( function (e) {
        that.sendLogin( this );
    }); 
    
};

WidgetLogin.prototype.isLogged = function ( sender ) {
    var isLogged = 0;
    
    var request = $.ajax ({
        url: "/admin/userLogged",
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         isLogged = resp;
     });
     return isLogged;
};

WidgetLogin.prototype.sendLogin = function ( sender ) {
     var data = $( sender ).closest( '#formLogin' ).serialize();

    var request = $.ajax ({
        url: "/admin/login?"+data,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) {
         
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        classNotyfy.openNotyfy( parameters ); 
        if( resp != 0 ) {
            setTimeout( function() {
                window.location.href = '/admin/listArticles';
            }, 1500 ); 
        } 
     });
};

WidgetLogin.prototype.openLoginPopup = function ( sender, callback ) {
    var data = $( sender ).serialize();
    
    var request = $.ajax ({
        url: "/admin/login?"+data,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) {
         
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        classNotyfy.openNotyfy( parameters ); 
              
        if (resp == 1 ) {
            
            bootbox.hideAll();
            console.dir(  callback );
            
            
            
            if( typeof callback != 'undefined' ) {
            if( typeof callback.params != 'undefined' ) {    
                if( callback.params[0] == 'submit' )
                    callback.call.submit();
                else
                    callback.call( callback.params[0] );
            } else {
                callback.call();
            }
        }
//            if( $( sender ).attr( 'data-type' ) == 'sendForm' )
//                $( sender ).closest( 'form' )[0].submit();
//            else return true;
        }
            
     });
};

/**
 * Metodo che recupera il box del login
 * @param {type} idFormLogin
 * @param {type} reload
 * @param {type} callback
 * @returns {undefined}
 */
WidgetLogin.prototype.getLoginBox = function( callback ) {
    var that = this;
    
    console.dir(callback);
    var params = { 
        type: 'custom', 
        title: 'LOGIN',
        callbackModals: '\
        <div class="innerAll" style="overflow: hidden;">\
            <div class="innerLR">\
                <form class="form-horizontal" id="loginPopup" method="get" autocomplete="off" onsubmit="return false;">\
                    <input type="hidden">\
                    <div class="form-group">\
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>\
                        <div class="col-sm-10">\
                            <input type="text" id="email" name="username" class="form-control" id="inputEmail3" placeholder="Email">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>\
                        <div class="col-sm-10">\
                            <input type="password" type="text" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="col-sm-offset-2 col-sm-10">\
                            <button type="button" class="btn btn-primary pull-right btnPopup">Login</button>\
                        </div>\
                    </div>\
                </form>\
            </div>\
        </div>'
    };
    classModals.openModals( params );
    
    $( '.btnPopup').unbind();
    
    $( '.btnPopup').click( function( e ) {
        
        e.stopPropagation();
        e.preventDefault();    
        that.openLoginPopup( $('#loginPopup'), callback  );
    });
};
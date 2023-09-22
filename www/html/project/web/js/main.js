main = null;
/**
 * Classe per la gestione della homepage
 */
var Main = function() {
    this.isOpenLogin = false;
    this.charLoader = false;
    this.initListeners(); 
};

/**
 * Metodo che avvia gli ascoltatori
 */
Main.prototype.initListeners = function() {
    var that = this;
    $('body').on('click', '[data-widgetOpenLogin], [data-widgetCloseLogin]', function() {
        that.manageBoxLogin ();
    });
    
    $( '#openSearch').click( function() {
        $( this ).closest( '.header' ).toggleClass( 'open' );
        $( this ).closest( '.header' ).find('.btnSearch').toggle();
    });   
   
    $( '#micro-section-header span').click( function() {
        $( this ).toggleClass( 'auto' );        
    });   
    
    $('body').on('click', '[data-boxPaymentsOpen]', function() {
        that.boxPaymentsOpen( this );
    });    
    $('body').on('click', '[data-closeoverlay]', function() {
        $( '#boxOverlay' ).hide();
    });    
    $('body').on('click', '[data-pOff]', function() {
        that.offProduct( this );
    });    
    
    $('body').on('click', '[data-CreateProducteInit]', function() {
        that.createProducteInit( this );
    });

    $('body').on('click', '.hamburger', function() {
        $('[data-menu]').toggle();
    });    
           
};

/**
 * Avvia la registrazione alla newsletters
 * @param {type} sender
 * @returns {undefined}
 */
Main.prototype.sendNewsletters = function(sender) {
    var input = $( sender ).closest( '[data-SendNewsletters]' ).find( 'input' );
    
    $.get( "/ajax/sendNewsletters?email="+input.val(), function( response ) {
        var type = 'error';
       
        if ( response == 1 ) {
            var msg   = 'Iscrizione alla newsletters avvenuta con successo';
            var type = 'success';                        
            $( sender ).closest( '[data-SendNewsletters]' ).html( msg ).addClass( type );
            return true;
        }  
        
        if ( response == 0 ) {            
            var msg = 'Questo indirizzo email è già iscritto alla newsletters!';            
        }
        
        if ( response == 2 ) {
            var msg = 'Spiacenti, non è stato possibile iscriverti alla newsletters';       
        }
        
        if ( response == 3 ) {
            var msg = 'Inserisci un indirizzo email valido!';       
        }
        $( sender ).closest( '[data-SendNewsletters]' ).find('div').html( msg ).addClass( type ).show();
    });
};

Main.prototype.createProducteInit = function(sender) {
    var id = $( sender ).attr( 'data-CreateProducteInit' );
    var modelId = $( sender ).attr( 'data-ModelId' );
    $.get( "/admin/insertFakeProduct/"+id+"/"+modelId, function( data ) {
        if( data > 0 ) {
            alert('Creato');
        } else { 
            alert('Problemi');
        }
    });
};

Main.prototype.offProduct = function(sender) {
    var id = $( sender ).attr( 'data-pOff' );
    $.get( "/admin/offProduct?id="+id, function( data ) {
        if( data == 1 ) {
            alert('Eliminato');
        } else {
            alert('Problemi');
        }
    });
};


/*metodo che apre e chiude la login  */
Main.prototype.manageBoxLogin = function(sender) {    
    var that = this;
    if( !this.isOpenLogin ) {

        that.appendJs ( '//connect.facebook.net/it_IT/sdk.js' );        
        that.appendJs ( 'https://apis.google.com/js/api:client.js' );        
        that.appendJs ( '/js/facebook.init.js' );        
        that.appendJs ( '/js/google.init.js' );        

        $.get( "/ajax/getLoginHtml", function( data ) {
            $('body').append(data);
            $ ('[data-widgetLogin], [data-boxLogin]').show();  
            that.isOpenLogin = true;
        });        
    }
    
    if( $('[data-widgetLogin]').is(":hidden") ) {
        $ ('[data-widgetLogin], [data-boxLogin]').show();    
    } else {
        $ ('[data-widgetLogin], [data-boxLogin]').hide();    
    } 
};
 
/**
 * Metodo che appende un file
 * @param {type} file
 * @returns {undefined}
 */
Main.prototype.appendJs = function( file ) {
    var head = document.getElementsByTagName('head')[0];
    var script = document.createElement('script');
    script.defer = true;
    script.async = true;        
    script.src = file;
    head.appendChild(script);
};

/*metodo che apre e chiude la login  */
Main.prototype.boxPaymentsOpen = function(sender) {
    $( sender ).closest( '[data-boxPayments]' ).find( '[data-boxPaymentsItems]' ).show();
    $( sender ).hide();        
};




/**
 * Metodo che avvia il lazy sulle immagini
 * @param {string} container
 * @returns {void}
 */
Main.prototype.lazy = function(container) {
    if (typeof container == 'undefined')
        container = '';

    if (typeof unveil != 'undefined') {
        $(container + " .lazy").unveil(300, function() {
            $(this).load(function() {
                this.style.opacity = 1;
            });
        });
    }
};


Main.prototype.setCookie = function(name, value, millisec) {
    if (millisec) {
        var date = new Date();
        date.setTime(date.getTime() + (millisec));
        var expires = "; expires=" + date.toGMTString();
    }
    else
        var expires = "";
    document.cookie = name + "=" + value + expires + "; path=/";
};


Main.prototype.trackGAClickEvent = function(category, action, opt_label, optValue) {
    if (typeof category == "undefined" || typeof action == "undefined" || typeof opt_label == "undefined") {
        return false;
    }
    if (typeof ga == "undefined") {
        return false;
    }
    if (typeof (ga) != 'undefined' && category != null && action) {
        ga('send', 'event', category, action, opt_label, 4);
        console.info(typeof (ga));
    }
    return true;
};

Main.prototype.getCookie = function(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
};

Main.prototype.unsetCookie = function(name) {
    this.setCookie(name, "", -1);
};


Main.prototype.openDataIntLink = function(url) {
    window.location.href = url;
};

var main = null;
main = new Main();


/**
 * Classe per determinare se un elemento è visibile o no nello schermo
 * @returns {Utils}
 */
function Utils() {}
Utils.prototype = {
    constructor: Utils,
    isElementInView: function (element, fullyInView) {
        var pageTop = $(window).scrollTop();
        var pageBottom = pageTop + $(window).height();
        var elementTop = $(element).offset().top;
        var elementBottom = elementTop + $(element).height();

        if (fullyInView === true) {
            return ((pageTop < elementTop) && (pageBottom > elementBottom));
        } else {
            return ((elementTop <= pageBottom) && (elementBottom >= pageTop));
        }
    }
};

var Utils = new Utils();
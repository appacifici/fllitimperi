coockie = null;
/**
 * Classe per la gestione della homepage
 */
var Coockie = function() {   
    this.initListeners(); 
};


/**
 * Metodo che avvia gli ascoltatori
 */
Coockie.prototype.initListeners = function() {
    var that = this;
    
    this.infoCoockie();
    $( '[data-block-prop]' ).click(function( event ) {
        event.stopPropagation();
    });
    $( '[data-accept-coockie]' ).click(function( event ) {
        that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
        $( '[data-info-coockie]' ).fadeOut();
    });
    
    if( window.location.pathname != "/info/coockie" ) {
        $( '[data-action="urlCopy"], [data-lgt], [data-placelogo], [data-hamburger], a:not([data-block-prop]), img, [data-btn-prev], [data-btn-next]' ).click(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });

        $( '[data-widgetsearchfilterproduct] input' ).keypress(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });
        $( window ).scroll(function() {
            that.setCookie( 'accept-info-coockie',  'conditions_fully_accepted', 3650 );
            $( '[data-info-coockie]' ).fadeOut();
        });
    }
};

/**
 * Apre il banner dell'informatica dei coockie se l'utente non lo ha ancora accettato
 * @returns {undefined}
 */
Coockie.prototype.infoCoockie = function() {
    if( this.getCookie( 'accept-info-coockie' ) != 'conditions_fully_accepted' ) {
        $( 'body' ).append('<div data-info-coockie class="info-coockie">Acquistigiusti.it utilizza cookie, di proprietà e di terze parti.\n\
         Se vuoi saperne di più o negare il consenso a tutti o ad alcuni cookie leggi <a data-block-prop href="/info/coockie">l’informativa cookie</a>.\n\
        Scorrendo la pagina, cliccando questo banner o qualsiasi elemento in pagina acconsenti all\'utilizzo dei coockie. \n\
        <span data-accept-coockie>OK</span>\n\
        </div>');
    }
};

/**
 * Effettua il settaggio di un coockie
 * @param {type} cname
 * @param {type} cvalue
 * @param {type} exdays
 * @returns {undefined}
 */
Coockie.prototype.setCookie = function( cname, cvalue, exdays ) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

/**
 * Effettua il recupero di un coockie per il suo nome
 * @param {type} name
 * @returns {unresolved}
 */
Coockie.prototype.getCookie = function(name) {
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

/**
 * Effettua la cancellazione del coockie
 * @param {type} name
 * @returns {undefined}
 */
Coockie.prototype.unsetCookie = function(name) {
    this.setCookie(name, "", -1);
};

coockie = new Coockie();
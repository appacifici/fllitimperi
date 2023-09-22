

/**
 * Classe per delle notyfy
 */ 
var ClassNotyfy = function( noClose ) {	
    this.type = null;
    this.mex = null;
    this.confirm = null;
    this.cancel = null;
    this.layout = 'top';     
    this.popupNotify = null;
    this.noClose = typeof noClose != 'undefined' ? noClose : true;    
    this.initListeners();
}

/**
 * Metodo che avvia gli ascoltatori sui bottoni
 * @returns {void}
 */
ClassNotyfy.prototype.initListeners = function() {
    var that = this;
    $( '[data-toggle="notyfy"]' ).click( function (){ that.setPatametersNotyfy( this ); });
}

/**
 * Metodo che recupera i parametri necessari alla creazione della notifica dal bottone cliccato
 * @param {object} sender
 * @returns {void}
 */
ClassNotyfy.prototype.setPatametersNotyfy = function( sender ) {
    this.type    = typeof $( sender ).data( 'type' ) != 'undefined' ? $( sender ).data( 'type' ) : null;
    this.mex     = typeof $( sender ).data( 'mex' ) != 'undefined' ? $( sender ).data( 'mex' ) : null;
    this.confirm = typeof $( sender ).data( 'confirm' ) != 'undefined' ? $( sender ).data( 'confirm' ) : null;
    this.cancel  = typeof $( sender ).data( 'cancel' ) != 'undefined' ? $( sender ).data( 'cancel' ) : null;
    this.layout  = typeof $( sender ).data( 'layout' ) != 'undefined' ? $( sender ).data( 'layout' ) : null;
        
    if( this.type == null || this.mex == null )
        return;
    
    this.runNotyfy();
}

/**
 * Metodo che apre una notifica tramite una chiamata js
 * @param {array} parameters
 * @returns {void}
 */
ClassNotyfy.prototype.openNotyfy = function( parameters ) {
    this.type    = typeof parameters['type'] != 'undefined' ?  parameters['type'] : null;
    this.mex     = typeof parameters['mex'] != 'undefined' ?  parameters['mex'] : null;
    this.confirm = typeof parameters['confirm'] != 'undefined' ? parameters['confirm'] : null;
    this.cancel  = typeof parameters['cancel'] != 'undefined' ? parameters['cancel']  : null;
    this.layout  = typeof parameters['layout'] != 'undefined' ? parameters['layout']  : null;
    
    if( this.type == null || this.mex == null )
        return;
    
    this.runNotyfy();
};

/**
 * Metodo che gestisce l'apertura delle notifiche
 * @returns {void}
 */
ClassNotyfy.prototype.runNotyfy = function() {
    var that = this;
    
    if( this.popupNotify !== null ) {
        this.popupNotify.close();   
        setTimeout( function(){ that.open(); }, 1000 );
        setTimeout( function(){ that.popupNotify.close(); }, 5000 );
        return;
    }
    this.open();    
    setTimeout( function(){ that.popupNotify.close(); }, 5000 );
}

/**
 * Metodo che apre le notifiche
 * @returns {void}
 */
ClassNotyfy.prototype.open = function() {
    var that = this;
    this.popupNotify = notyfy({
        text: that.mex,
        type: that.type,
        dismissQueue: true,
        layout: that.layout,
        buttons: ( that.type != 'confirm' ) ? false : [{
            addClass: 'btn btn-success btn-small btn-icon glyphicons ok_2',
            text: '<i></i> Ok',
            onClick: function ( $notyfy ) {
                $notyfy.close();
                if( that.confirm == null )
                    return true;                    
                notyfy({
                    force: true,
                    text: that.confirm,
                    type: 'success',
                    layout: that.layout
                });
            }            
        }, {
            addClass: 'btn btn-danger btn-small btn-icon glyphicons remove_2',
            text: '<i></i> Cancel',
            onClick: function ( $notyfy ) {
                $notyfy.close();
                if( that.cancel == null )
                        return true;
                notyfy({
                    force: true,
                    text: that.cancel,
                    type: 'error',
                    layout: that.layout
                });
            }
        }]
    });    
};

classNotyfy = null;
classNotyfy = new ClassNotyfy();
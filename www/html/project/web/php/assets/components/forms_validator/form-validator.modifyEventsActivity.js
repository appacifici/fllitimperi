formValidatorModifyEventsActivity= null;
$( function() {
    formValidatorModifyEventsActivity = new FormValidatorModifyEventsActivity();
});

/**
 * Classe per delle notyfy
 */ 
var FormValidatorModifyEventsActivity = function() {	
    var that = this;
    this.insertEvents = $( '#insertEvents' );
    this.title = this.insertEvents.find( '#title' );
    this.event = this.insertEvents.find( '#event' );
    this.initDate = this.insertEvents.find( '#initDate' );
    this.endDate = this.insertEvents.find( '#endDate' );
    this.errroEvent = this.insertEvents.find( '#errroEvent' );
    
    $( "#event" ).wysihtml5({
        "font-styles": false,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": false,
        "image": false,
        "color": false,
        "placeholderText": "Inserisci la descrizione di almeno 50 caratteri"
    });
    this.insertEvents.find( '#btnInsertEvent' ).click( function() {
        that.validateFormEvent();
    });
};

/**
 * Metodo che valida il form di inserimento evento di un attività
 * @param {type} idFormLogin
 * @returns {undefined}
 */
FormValidatorModifyEventsActivity.prototype.validateFormEvent = function() {
    if( this.title.val().length < 10 ) {
        this.title.addClass( 'hasError' );
        return false;
    }
    this.title.removeClass( 'hasError' );
    
    if( this.initDate.val() == '') {
        this.initDate.addClass( 'hasError' );
        return false;
    }
    this.initDate.removeClass( 'hasError' );
    
    if( this.endDate.val() == '') {
        this.endDate.addClass( 'hasError' );
        return false;
    }
    this.endDate.removeClass( 'hasError' );
    
    
    if( this.event.val().length < 50 ) {
        this.errroEvent.addClass( 'hasError' );
        return false;
    }
    this.errroEvent.removeClass( 'hasError' );
	this.insertEvents.submit();
};

FormValidatorModifyEventsActivity.prototype.response = function( resp ) {
    var parameters = new Array();   
    parameters['type'] = resp ? 'success' : 'error';
    parameters['layout'] = 'top';
    parameters['mex'] =  resp ? 'Evento inserito correttamente, stai per essere rediretto alla pagina dell\'evento' : 'Attenzione: Si sono verificati problemi nell\'inserire il tuo evento';
    classNotyfy.openNotyfy( parameters );  
    
    if( resp ) {
        setTimeout( function() {
            //location.href = '/profilo';
        });
    }
};
WidgetEditPoll = null;
$(function () {
    widgetEditPoll = new WidgetEditPoll();
});

/**
 * ?resp=1
 * Classe per la gestione del widget
 */
var WidgetEditPoll = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetEditPoll.prototype.initListeners = function () {
    var that = this;
    $( 'body' ).on( 'click', 'div[data-submitPoll="1"]', function( e ) {
        that.savePoll( this, e );
    });
    
    $( 'body' ).on( 'click', '.btn-add', function( e ) {
        that.addAnswer( this, e );
    });
};

/**
 * Metodo che salva i sondaggi
 * @param {type} sender
 * @param {type} e
 * @returns {undefined}
 */
WidgetEditPoll.prototype.savePoll = function ( sender, e ) {
    e.stopPropagation();
    e.preventDefault(); 
    var question = null;
    var answers = new Array();
    question = $( '.widget_EditPoll' ).find( '#form' ).find( '.question' ).val();
    question = question.replace("?", "");
    
    var dataArticleId = $( '.widget_EditPoll' ).find( '#form' ).find( '#dataArticle' ).val();
    dataArticleId = dataArticleId == '' ? '0' : dataArticleId;
    
    $( '.widget_EditPoll' ).find( '#form' ).find( '.answer' ).each( function () {
        if(  $( this ).val() != "" )
            answers.push( $( this ).val() );
    });
    
    var url = window.location.href;
    var id = url.match( /\d+/g );

    if(id == null ) {
        var request = $.ajax ({
            url: "/admin/insertPoll/"+question+"/"+answers+"/"+dataArticleId,
            type: "GET",
            async: true,
            dataType: "json"        
         });
         // Richiesta andata a buon fine
         request.done( function( resp ) {
            $( 'body' ).find( '.fade' ).remove();
            var parameters = new Array();   
            parameters['type'] = !resp.error ? 'success' : 'error';
            parameters['layout'] = 'top';
            parameters['mex'] =  resp.msg;
            classNotyfy.openNotyfy( parameters );

        });
    } else {
        var request = $.ajax ({
            url: "/admin/updatePoll/"+id+"/"+question+"/"+answers+"/"+dataArticleId,
            type: "GET",
            async: true,
            dataType: "json"        
         });
         // Richiesta andata a buon fine
         request.done( function( resp ) {     
//            $( 'body' ).find( '.fade' ).remove();
            bootbox.hideAll();
            var parameters = new Array();   
            parameters['type'] = !resp.error ? 'success' : 'error';
            parameters['layout'] = 'top';
            parameters['mex'] =  resp.msg;
            classNotyfy.openNotyfy( parameters );

        });
    }
};

WidgetEditPoll.prototype.addAnswer = function ( sender, event ) {
    event.stopPropagation();
    event.preventDefault(); 
    var answer = $( '.widget_EditPoll' ).find( '.answer:last' ).closest( '.form-group' ).clone();
    answer.find('.answer').val('');
    var divBtn = $( sender ).closest( '.form-group' );
    answer.insertBefore( divBtn );
};





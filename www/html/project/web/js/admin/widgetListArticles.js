WidgetListArticles = null;
$(function () {
    widgetListArticles = new WidgetListArticles();
});

/**
 * Classe per la gestione del widget
 */
var WidgetListArticles = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetListArticles.prototype.initListeners = function () {
    var that = this;
  var options = {language: 'en',
            format: "dd MM yyyy",
            todayBtn: true,
            autoclose: true,
            clearBtn: true
        };
        
    $( '.datepicker3' ).bdatepicker(
        options        
    ).on( 'changeDate', function(ev) { 
        var date = new Date(ev.date);
        
        var dateMatch = date.getFullYear() +'-'+ ( date.getMonth() +1 )  + '-' + date.getDate();
        
        var that = this;
            setTimeout( function() {
                $( that ).find('input').focus();
                $( that ).find('input').val(dateMatch);
                $( '.datepicker3' ).bdatepicker('hide');
                $( that ).find('input').blur();
            }, 250 
        );
    });
    
    $( 'body' ).on( 'click', '.btnReset', function() {
        that.resetFilterArticles( this );
    });
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-republish]', function() {
        that.confirmRepublishArticle(this);
    });
};

WidgetListArticles.prototype.resetFilterArticles = function ( sender ) {
    event.stopPropagation();
    $('input').val('');
    $('select').val('');
};

WidgetListArticles.prototype.confirmRepublishArticle = function ( sender ) {        
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmRepublishArticle.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    mainAdmin.speakSite( 'Vuoi aggiornare la data di questo articolo?' );
    
    var callback = { 'call': this.republishArticle.bind( this ), 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi aggiornare la data di questo articolo?',
        finalCallback: callback        
    };
    classModals.openModals( params );
};


WidgetListArticles.prototype.republishArticle = function ( sender ) {
    var that = this;
    var id = $(sender).attr('data-republish');

    var request = $.ajax ({
        url: "/admin/updateArticleDate/"+id,
        type: "POST",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        that.readResponseAjax( resp );
    });
};

WidgetListArticles.prototype.readResponseAjax = function ( response ) {
        mainAdmin.speakSite( response.msg );

    var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );
};    
    

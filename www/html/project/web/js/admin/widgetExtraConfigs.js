WidgetExtraConfigManager = null;
$(function () {
    widgetExtraConfigManager = new WidgetExtraConfigManager();
});

/**
 * Classe per la gestione del widget
 */
var WidgetExtraConfigManager = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetExtraConfigManager.prototype.initListeners = function () {
    var that = this;
    
    $( 'body' ).on( 'click', '.extraconfig', function() {
        that.saveExtraConfig(this);
    });
};

/**
 * Metodo che avvia la chiamata Ajax con cui si recuperano e aggiornano gli extraconfig
 */
WidgetExtraConfigManager.prototype.saveExtraConfig = function ( sender ) {

    var id = $(sender).closest('[data-extraconfigid]').attr('data-extraconfigid');
    var value = $(sender).closest('[data-extraconfigid]').find('textarea').val();
    
    
    var request = $.ajax ({
            url: "/admin/updateExtraConfigs/",
            type: "POST",
            async: true,
            dataType: "json",
            data: { 'id': id, 'value': value }
         });
         // Richiesta andata a buon fine
         request.done( function( resp ) {
            var parameters = new Array();   
            parameters['type'] = !resp.error ? 'success' : 'error';
            parameters['layout'] = 'top';
            parameters['mex'] =  resp.msg;
            classNotyfy.openNotyfy( parameters );
        });
};


widgetTopTrademarksSection = null;
$(function () {
    widgetTopTrademarksSection = new WidgetTopTrademarksSection();
});

var WidgetTopTrademarksSection = function () {    
    this.trademarkRow                = $( "[data-item]" );
    this.buttonAddTrademark          = $( "[data-addTrademark]" );
    this.catId                       = $('[data-selectCategory]').val();
    this.subcatId                    = $('[data-selectSubcategory]').val();
    this.typoId                      = $('[data-selectTypology]').val();
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetTopTrademarksSection.prototype.initListeners = function () {
    var that = this;
      
    $( this.trademarkRow ).closest('[data-trademark]').find('.btnDeleteItem').click( function (e) {
        // Metodo che elimina il marchio
        that.confirmDeleteTrademark( this );
    });    
    
    $( this.buttonAddTrademark ).click( function (e) {
        // Metodo che verifica se il marchio che si vuole aggiungere è già presente e, se non presente, lo aggiunge
        that.addTrademark( this );
    });          
    
};

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetTopTrademarksSection.prototype.confirmDeleteTrademark = function ( sender ) { 
    
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmDeleteTrademark.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    var callback = { 'call': this.deleteTrademark, 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi cancellare questo elemento?',
        finalCallback: callback        
    };
    classModals.openModals( params );
    mainAdmin.speakSite( 'Vuoi cancellare questo elemento?' );
};

WidgetTopTrademarksSection.prototype.deleteTrademark = function ( sender ) {
    // Si recupera l'id della squadra da eliminare dal menu
    var id = $( sender ).closest('[data-trademark]').find("[data-item]").attr("data-item");;

    // Parte la richiesta Ajax
    var request = $.ajax ({
        url: "/admin/deleteTopTrademarkSection/"+id,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( !resp.error ) {
            // Viene tolta la visibilità
            $( sender ).closest('[data-trademark]').remove();
        }
        
        var parameters = new Array();   
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
        
    });
};

WidgetTopTrademarksSection.prototype.addTrademark = function ( sender ) {
    
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.addTrademark.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    // Si recupera l'id del marchio selezionato nella Select
    var trademarkId = $( sender ).closest('[data-tableTrademark]').find('[data-selectTrademark]').children(":selected").val();
    //Si recupera l'id della sottocategoria
    var catId       = this.catId;
    //Si recupera l'id della sottocategoria
    var subcatId    = this.subcatId;
    //Si recupera l'id della tipologia
    var typoId      = this.typoId;
    
    // Parte la richiesta Ajax per l'aggiunta del marchio
    console.info(subcatId);
    var request = $.ajax ({
        url: "/admin/addTopTrademarkSection/"+trademarkId+"/"+subcatId+"/"+typoId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {        
        
        var parameters = new Array();
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
        
        if( !resp.error ) {
            setTimeout( function() {
                window.location.href = "/admin/topTrademarkSection?category="+catId+"&subcategory="+subcatId+"&typology="+typoId;
            }, 1500 );
        }
        
    });
};
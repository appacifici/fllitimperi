WidgetListProducts = null;
$(function () {
    widgetListProducts = new WidgetListProducts();
});

/**
 * Classe per la gestione del widget
 */
var WidgetListProducts = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetListProducts.prototype.initListeners = function () {
    var that = this;
  
    
    $( 'body' ).on( 'click', '[data-changeProductsSectionBtn]', function() {
        that.changeProductsSection( this );
    });
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-changeProductsModelBtn]', function() {
        that.changeProductsModelBtn( this );
    });
    
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-getProductInFeedByName] [data-searchBtn]', function() {
        that.getProductInFeedByName( this );
    });
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-getProductInFeedByName] [data-assocProductsModelBtn]', function() {
        that.assocProductsModelBtn( this );
    });
    
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-getProductInKelkoo] [data-searchBtn]', function() {
        that.getProductInKelkoo( this );
    });
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-getProductInKelkoo] [data-assocProductsModelBtn]', function() {
        that.assocProductsKelkooModelBtn( this );
    });
};


/**
 * Avvia la ricerca di prodotti con quel nome di un feed scaricato
 * @param {type} sender
 * @returns {undefined}
 */
WidgetListProducts.prototype.getProductInKelkoo = function ( sender ) {    
    var query = $( sender ).closest( '[data-getProductInKelkoo]' ).find('form').serialize();  
    console.info( query );
    
    $( sender ).hide();
    $( sender ).closest( '[data-getProductInFeedByName]' ).find('.pleasesWait').show();
    
    var request = $.ajax ({
        url: "/admin/getProductInKelkooApi?"+query,
        type: "GET",
        async: true,
        dataType: "json"        
    });
    request.done( function( response ) {     
        console.info(response);
        
        var htmlResp = '';
        $( response ).each( function( i, item ) {
            htmlResp += '<div style="float: left;width: 48%;margin: 0.5%;border: 2px solid #3f51b5;padding: 10px;color: #000;"><input type="checkbox" name="productNumber" value="'+item.number+'"><img style="max-width:150px;margin-left:20px;" src="'+item.image+'"> '+item.name+' # '+item.number+'</div>';
            $( sender ).closest( '[data-getProductInFeedByName]' ).find('[data-screen]').attr( 'affId', item.affId );  
        });        
              
        $( sender ).closest( '[data-getProductInKelkoo]' ).find('[data-screen]').html( htmlResp );        
        $( sender ).show();
        $( sender ).closest( '[data-getProductInFeedByName]' ).find('.pleasesWait').hide();
        
    });
};

/**
 * Associa i prodotti selezionati nella funziona sopra
 * @param {type} sender
 * @returns {undefined}
 */
WidgetListProducts.prototype.assocProductsKelkooModelBtn = function ( sender ) {       
    var query = $( sender ).closest( '[data-getProductInKelkoo]' ).find('form').serialize(); 
    
    var productsNumber = new Array();
    $( sender ).closest( '[data-getProductInKelkoo]' ).find( 'input[name="productNumber"]:checked' ).each(function( key, item ) {
        productsNumber.push( $( item ).val() );
    });
    
    var affId = 22;
    var modelId = $( sender ).closest( '[data-getProductInKelkoo]' ).find('#idModel').val();
    
    var request = $.ajax ({
        url: "/admin/insertProductsKelkooModelBtn/"+affId+"/"+modelId+"?"+query,
        type: "POST",
        data: { 'productsNumber': productsNumber },
        dataType: "json"        
    });
    request.done( function( response ) {     
        alert( 'PRODOTTI ASSOCIATI'+ response.success+' - PRODOTTI NON ASSOCIATI: '+ response.error );
    });
};


/**
 * Avvia la ricerca di prodotti con quel nome di un feed scaricato
 * @param {type} sender
 * @returns {undefined}
 */
WidgetListProducts.prototype.getProductInFeedByName = function ( sender ) {    
    var query = $( sender ).closest( '[data-getProductInFeedByName]' ).find('form').serialize();  
    console.info( query );
    
    $( sender ).hide();
    $( sender ).closest( '[data-getProductInFeedByName]' ).find('.pleasesWait').show();
    
    
    var request = $.ajax ({
        url: "/admin/getProductInFeedByName?"+query,
        type: "GET",
        async: true,
        dataType: "json"        
    });
    request.done( function( response ) {     
        console.info(response);
        
        var htmlResp = '';
        $( response ).each( function( i, item ) {
            htmlResp += '<div style="float: left;width: 48%;margin: 0.5%;background: #3f51b5;padding: 10px;color: #fff;"><input type="checkbox" name="productNumber" value="'+item.number+'"><img style="max-width:150px;margin-left:20px;" src="'+item.image+'"> '+item.name+' # '+item.number+'</div>';
            $( sender ).closest( '[data-getProductInFeedByName]' ).find('[data-screen]').attr( 'affId', item.affId );  
        });        
              
        $( sender ).closest( '[data-getProductInFeedByName]' ).find('[data-screen]').html( htmlResp );        
        $( sender ).show();
        $( sender ).closest( '[data-getProductInFeedByName]' ).find('.pleasesWait').hide();
        
    });
};

/**
 * Associa i prodotti selezionati nella funziona sopra
 * @param {type} sender
 * @returns {undefined}
 */
WidgetListProducts.prototype.assocProductsModelBtn = function ( sender ) {       
    var productsNumber = '';
    $( sender ).closest( '[data-getProductInFeedByName]' ).find( 'input[name="productNumber"]:checked' ).each(function( key, item ) {
        productsNumber += $( item ).val()+',';
    });
    
    var affId = $( sender ).closest( '[data-getProductInFeedByName]' ).find('[data-screen]').attr( 'affId' );
    var modelId = $( sender ).closest( '[data-getProductInFeedByName]' ).find('#idModel').val();
    
    var request = $.ajax ({
        url: "/admin/insertProductInFeedByName/"+affId+"/"+modelId+"/"+productsNumber,
        type: "GET",
        dataType: "json"        
    });
    request.done( function( response ) {     
        alert( 'PRODOTTI ASSOCIATI'+ response.success+' - PRODOTTI NON ASSOCIATI: '+ response.error );
    });
};


/**
 * Metodo che verifica se sono stati selezionati i prodotti da spostare
 * @returns {Boolean}
 */
WidgetListProducts.prototype.checkChecked = function () {
    var count = $( '[data-widgetListProducts] input[name="productId"]:checked' ).length;
    
    if( count == 0 ) {
        var parameters = new Array();   
        parameters['type'] = 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  'Seleziona i prodotti da spostare di';
        classNotyfy.openNotyfy( parameters ); 
        return false;
    }
    return true;
};

WidgetListProducts.prototype.changeProductsSection = function ( sender ) {
    if( !this.checkChecked() )
        return false;
    
    var query = $( sender ).closest( 'form' ).serialize();  
        
    var productsId = '';
    $( '[data-widgetListProducts] input[name="productId"]:checked' ).each(function( key, item ) {
        productsId += $( item ).val()+',';
    });
    
    var request = $.ajax ({
        url: "/admin/changeProductSection?"+query+"&productsId="+productsId,
        type: "GET",
        async: true,
        dataType: "json"        
    });
    request.done( function( response ) {     
        console.info(response);
        var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );    
    });
};

WidgetListProducts.prototype.changeProductsModelBtn = function ( sender ) {
    if( !this.checkChecked() )
        return false;
    
    var query = $( sender ).closest( 'form' ).serialize();    
    
    var productsId = '';
    $( '[data-widgetListProducts] input[name="productId"]:checked' ).each(function( key, item ) {
        productsId += $( item ).val()+',';
    });
    
    var request = $.ajax ({
        url: "/admin/changeProductModel?"+query+"&productsId="+productsId,
        type: "GET",
        dataType: "json"        
    });
    request.done( function( response ) {     
        console.info(response);
        var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );    
    });
};


WidgetListProducts.prototype.resetFilterArticles = function ( sender ) {
    event.stopPropagation();
    $('input').val('');
    $('select').val('');
};

WidgetListProducts.prototype.confirmRepublishArticle = function ( sender ) {        
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


WidgetListProducts.prototype.republishArticle = function ( sender ) {
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

WidgetListProducts.prototype.readResponseAjax = function ( response ) {
        mainAdmin.speakSite( response.msg );

    var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );
};    
    

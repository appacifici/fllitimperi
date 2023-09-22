WidgetLookupSubcategories = null;
$(function () {
    widgetLookupSubcategories = new WidgetLookupSubcategories();
});

/**
 * Classe per la gestione del widget
 */
var WidgetLookupSubcategories = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetLookupSubcategories.prototype.initListeners = function () {
    var that = this;    
    $( '.widget_LookupSubcategories [data-viewProductBtn]' ).click(function() {
        that.getProduct( $( this ) );
    });
    $( '.widget_LookupSubcategories [data-screenProduct]' ).click(function() {
        $( this ).hide();
    });
    $( '.widget_LookupSubcategories [data-loockupBtn]' ).click(function() {
        that.setLookup( $( this ) );
    });
    $( '.widget_LookupSubcategories [data-offLoockupBtn]' ).click(function() {
       that.offLoockup( $( this ) );
    });
    $( '.widget_LookupSubcategories [data-dubbioBtn]' ).click(function() {
       that.dubbioLoockup( $( this ) );
    });
};

/**
 * Avvia il recupero dei prodotti della subcat dell'affiliato
 * @param {type} sender
 * @returns {undefined}
 */
WidgetLookupSubcategories.prototype.setLookup = function ( sender ) {
    var that          = this;
    var affiliationId = $(sender).closest( '[data-affiliationId]' ).attr( 'data-affiliationId' );
    var idSubcatAff   = $(sender).closest( '[data-idSubcatAff]' ).attr( 'data-idSubcatAff' );
    var category      = $(sender).closest( '[data-idSubcatAff]' ).find( '.categoriesSelect option:checked' );
    var subcategory   = $(sender).closest( '[data-idSubcatAff]' ).find( '.subcategoriesSelect option:checked' );
    var typology      = $(sender).closest( '[data-idSubcatAff]' ).find( '.typologiesSelect option:checked' );
    var microSection  = $(sender).closest( '[data-idSubcatAff]' ).find( '.microSectionsSelect option:checked' );
    
    if( affiliationId == 0 || category.val() == 0 || subcategory.val() == 0 ) {
        alert( 'Seleziona le associazioni' );
        return false;
    }    
    
    var urlTypology =  typology.val() != 'undefined' &&  typology.val() != 0 && typology.val() != '' ? '/'+typology.val() : '';
    if( urlTypology == '/undefined' )
        urlTypology = '';
    
    var microSectionId = microSection.val() != '' ? '/'+microSection.val() : '';
    
    var request = $.ajax ({
        url: "/admin/setLoockupSubcategories/"+idSubcatAff+"/"+category.val()+"/"+subcategory.val()+urlTypology+microSectionId+"?affiliationId="+affiliationId,
        type: "POST",
        async: true,
        dataType: "json"        
     });
    request.done( function( response ) {        
        var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );    
        if( response.error == 0 ) {
            $(sender).closest( '[data-idSubcatAff]' ).css( 'background', 'green' );
            setTimeout( function() {
               $(sender).closest( '[data-idSubcatAff]' ).remove(); 
            }, 3000 );            
        }
    });
};


/**
 * Spende un subcat aff
 * @param {type} sender
 * @returns {undefined}
 */
WidgetLookupSubcategories.prototype.offLoockup = function ( sender ) {
    var that = this;
    var id = $(sender).attr('data-offLoockupBtn');

    var request = $.ajax ({
        url: "/admin/offLoockupSubcategorySiteAffiliation/"+id,
        type: "POST",
        async: true,
        dataType: "json"        
     });
     request.done( function( response ) {
        var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );    
        if( response.error == 0 ) {
            $(sender).closest( '[data-idSubcatAff]' ).css( 'background', 'green' );
            setTimeout( function() {
               $(sender).closest( '[data-idSubcatAff]' ).remove(); 
            }, 3000 );            
        }
    });
};

/**
 * Spende un subcat aff
 * @param {type} sender
 * @returns {undefined}
 */
WidgetLookupSubcategories.prototype.dubbioLoockup = function ( sender ) {
    var that = this;
    var id = $(sender).attr('data-dubbioBtn');

    var request = $.ajax ({
        url: "/admin/dubbioLoockupSubcategorySiteAffiliation/"+id,
        type: "POST",
        async: true,
        dataType: "json"        
     });
     request.done( function( response ) {
        var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );    
        if( response.error == 0 ) {
            $(sender).closest( '[data-idSubcatAff]' ).css( 'background', 'green' );
            setTimeout( function() {
               $(sender).closest( '[data-idSubcatAff]' ).remove(); 
            }, 3000 );            
        }
    });
};

/**
 * Avvia il recupero dei prodotti della subcat dell'affiliato
 * @param {type} sender
 * @returns {undefined}
 */
WidgetLookupSubcategories.prototype.getProduct = function ( sender ) {
    var that = this;
    var id = $(sender).attr('data-viewProductBtn');

    var request = $.ajax ({
        url: "/admin/getProductsSubcategorySiteAffiliation/"+id,
        type: "POST",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        that.printProducts( resp, sender );
    });
};

/**
 * Stampa nel boox i prodotti della subcategory site affiliation
 * @param {type} response
 * @param {type} sender
 * @returns {undefined}
 */
WidgetLookupSubcategories.prototype.printProducts = function ( response, sender ) {
    var html = '';
    $( response ).each( function(  index, value ) {        
        html += '<a target="blank" href="'+response[index]['deepLink']+'"><img class="itemProduct" src="'+response[index]['img']+'" ></a>';
    });
    $( sender ).closest('.item' ).find( '[data-screenProduct]' ).html( html );
    $( sender ).closest('.item' ).find( '[data-screenProduct]' ).show();
};    
    

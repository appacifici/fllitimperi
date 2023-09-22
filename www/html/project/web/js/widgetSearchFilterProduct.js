
/**
 * Classe per la gestione dei commenti
 */
var WidgetSearchFilterProduct = function () {
    this.currentItemSuggestion = 0;
    this.widgetSearchFilterProduct = $('[data-widgetSearchFilterProduct]');
    this.searchFilterProductForm = $('[data-widgetSearchFilterProduct]').find( '#searchFilterProductForm');
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetSearchFilterProduct.prototype.initListeners = function () {
    var that = this;       
    $('[data-widgetSearchFilterProduct] [data-submitbtn]' ).click( function() {
        that.sendSearch( this );
    });
    
    $( 'body' ).click(function() {
        setTimeout(function() {
            $( '[data-responseSuggestionModel]').hide();
        },500);
    });
    
    this.enabledSuggestion = true;
    $('[data-widgetSearchFilterProduct] .inputSearchBox').keyup(function (e) {
        if( e.which == 38 || e.which == 40 ) {
            that.selectItemSuggestion( e.which );
        }
        
        if (e.which == 13) {
            that.currentItemSuggestion=0;
            that.sendSearch( this );
            return false;
            
        } else if( e.which != 38 && e.which != 40 )  {
            that.getTimeoutSuggestion( this );
        }
    });    
    
    $('#searchFilterProductForm [data-submitFilters]').click(function() {
        that.getSearchFilters();
    });
    $('#searchFilterProductForm [data-activeFilter]').click( function(){
        var value = $( this ).attr( 'data-activeFilter' ) == 1 ? '' : 1;
        $( this ).attr( 'data-activeFilter', value );
    })
    
    $('[data-sorting]').change( function() {
        that.setOrder();
    });
    
};

WidgetSearchFilterProduct.prototype.getSearchFilters = function ( key ) {
    var str = '?';
    
//    minPrice=10&maxPrice
    var minPrice = $('#searchFilterProductForm #minPrice').val() != '' ? 'minPrice='+$('#searchFilterProductForm #minPrice').val()+'&' : '';
    var maxPrice = $('#searchFilterProductForm #maxPrice').val() != '' ? 'maxPrice='+$('#searchFilterProductForm #maxPrice').val()+'&' : '';
    
    var search = $('#searchFilterProductForm #searchFilter').val() != '' ? 'search='+$('#searchFilterProductForm #searchFilter').val()+'&' : '';
    
    
    
    $('#searchFilterProductForm [data-activeFilter="1"]').each(function() {
       str += $( this ).attr( 'data-field')+'[]='+$( this ).attr( 'data-value')+'&';       
    });
    
    window.location.href = str+minPrice+maxPrice+search; 
};

WidgetSearchFilterProduct.prototype.setOrder = function () {
    var value = $('[data-sorting]').val();
    value = value.toLowerCase();
    
    window.location.href = '?order='+value;
};

/**
 * Metodo che gestisce la selezione delle suggestionb
 * @param {type} key
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.selectItemSuggestion = function ( key ) {
    var tot = $( '[data-responseSuggestionModel] [data-item]' ).length;

    if( key == 40 )
        this.currentItemSuggestion++;
    else
        this.currentItemSuggestion--;    
    
    if( this.currentItemSuggestion > tot )
        this.currentItemSuggestion = 1;
    
    if( this.currentItemSuggestion < 1 )
        this.currentItemSuggestion = tot;
    
    $( '[data-responseSuggestionModel] [data-item]').removeClass('selected');          
    $( '[data-responseSuggestionModel] [data-item="'+this.currentItemSuggestion+'"]').addClass( 'selected' );  
    var currentValue = $( '[data-responseSuggestionModel] [data-item="'+this.currentItemSuggestion+'"]').val();
    
    $( '[data-responseSuggestionModel] .inputSearchBox').val(currentValue);
  
};

/**
 * Metodo che avvia il timeout per la suggestiojn
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.getTimeoutSuggestion = function ( sender ) {
    var that = this;
    
    if( typeof this.suggestionTimeout != 'undefined' )
        clearTimeout( this.suggestionTimeout );
    
    this.suggestionTimeout = setTimeout(function() {
        that.getSuggestion( sender );
    }, 150 );   
}

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.getSuggestion = function ( sender ) {
    
    var urlAjax = "/suggestion/model?search="+$( sender ).val();

    var request = $.ajax ({
        url: urlAjax,
        type: "GET",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {             
        $( '[data-responseSuggestionModel]').html( resp );
        if( resp != '' )
            $( '[data-responseSuggestionModel]').show();
        else 
            $( '[data-responseSuggestionModel]').hide();
    });
     
};


/**
 * Metodo che avvia la ricerca
 * @param {type} sender
 * @returns {undefined}
 */
WidgetSearchFilterProduct.prototype.sendSearch = function ( sender ) {
    if( $( '[data-responseSuggestionModel] [data-item].selected').length == 1 ) {
        var url = $( '[data-responseSuggestionModel] [data-item].selected a').attr( 'href' );
        var target = $( '[data-responseSuggestionModel] [data-item].selected a').attr( 'target' );
        
        if( target == '_blank')
            window.open( url, '_blank');        
        else    
            window.location.href = url;
        return false;
    }
    
    var category = $( sender ).closest( '[data-widgetSearchFilterProduct]' ).find( '#category' ).val();
    var search   = $( sender ).closest( '[data-widgetSearchFilterProduct]' ).find( '#search' ).val();
    
    if( search.length < 2 ) {
        alert( 'Inserisci la parola da ricercare' );
        return false;
    }
    
    if( category == 0 ) {
//        alert('seleziona la categoria');
//        return false;        
    } else {
        category = category;
    }
        
    
    search = search.replace( / /g, '_' );     
    window.location.href = '/aSearch?category='+category+'&search='+search; 
};

var widgetSearchFilterProduct   = null;
widgetSearchFilterProduct       = new WidgetSearchFilterProduct();
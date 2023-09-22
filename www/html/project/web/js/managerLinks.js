
/**
 * Classe per la gestione del widget ImageArticle
 */
var ManagerLinks = function () {    
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
ManagerLinks.prototype.initListeners = function () {
    var that = this;
    
    $( 'body' ).on( 'click', '[data-action="urlCopy"]', function() {
        that.openCopyLink( this );
    });
    
    $( 'body' ).on( 'click', '[data-ln]', function() {
        that.openJsLink( this);
    });
    
    $( 'body' ).on( 'click', '[data-lgt]', function() {
        that.openJsLink( this);
    });
    $( 'body' ).on( 'click', '[data-href]', function() {
        that.dataOpenHref( this);
    });
    $( 'body' ).on( 'click', '[data-modelComparisonPrices] [data-viewMoreProducts]', function() {
        var p = this;
        var block = false;
        $( this ).closest( '[data-modelComparisonPrices]').find( 'table tr[data-ViewMoreProductsItem]').toggle( function() {
            if( !block ) {
                if( $( p ).find( 'span').html() == '+ Mostra più prodotti' )
                    $( p ).find( 'span').html('- Mostra meno prodotti');
                else
                    $( p ).find( 'span').html('+ Mostra più prodotti');
                block = true;
            }
        });
    });
};


ManagerLinks.prototype.viewMoreProducts = function ( sender ) { 
    window.open( $( sender ).attr( 'data-href' ), '_blank');
//    window.location.href =  $( sender ).attr( 'data-href' );
};

ManagerLinks.prototype.dataOpenHref = function ( sender ) { 
    window.open( $( sender ).attr( 'data-href' ), '_blank');
//    window.location.href =  $( sender ).attr( 'data-href' );
};

ManagerLinks.prototype.openJsLink = function ( sender ) {       
    var a = $( sender ).attr( 'data-lgt' ).substr( 5 );
    var b = a.substr( 0, ( a.length - 5 ) ); b;
        
    if( $( sender ).attr( 'data-target' ) == 'blank') {
        window.open( atob( b ), '_blank');
    } else {
        window.location.href = atob( b );    
    }
};

/**
 * Apre il link recuperandolo da un figlio de contenitore padre
 * @param {type} sender
 * @returns {undefined}
 */
ManagerLinks.prototype.openCopyLink = function ( sender ) {
    var url = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'href' );
    var target = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'target' );
    
    if( target == '_blank')
        window.open( url, '_blank');        
    else    
        window.location.href = url;
        
};


managerLinks = null;
managerLinks = new ManagerLinks();

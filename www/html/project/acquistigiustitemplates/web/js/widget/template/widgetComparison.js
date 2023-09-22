/**
 * Classe per la gestione dei commenti
 */
var WidgetComparison = function () {
    var that = this;
    this.initListeners();
    
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetComparison.prototype.initListeners = function () {
    var that = this;       
    
    this.adaptHeaderFooter();   
};

WidgetComparison.prototype.adaptHeaderFooter = function ( sender ) {
    var newWidth = $( '.tecnical-comparison-model').outerWidth();
    $( '.header' ).width( newWidth - 294);
    $( '.widget_BreadCrumbs' ).width( newWidth -294 );
    $( '.structure_Footer' ).width( newWidth );
};

var widgetComparison   = null;
widgetComparison       = new WidgetComparison();
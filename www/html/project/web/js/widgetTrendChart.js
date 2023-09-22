
/**
 * Classe per la gestione dei commenti
 */
var WidgetTrendChart = function () {    
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetTrendChart.prototype.initListeners = function () {
    var that = this;       
    $('body').on('click', '[data-PriceTrend]', function() {
        that.openChartProduct( this );
    });              
};

WidgetTrendChart.prototype.openChartProduct = function ( sender ) {
    $( '#boxOverlay .content' ).append( '<div id="chartTrendProduct" style="width: 800px;"></div>  ');
    
    var sPrices = JSON.parse( $( sender ).attr( 'data-PriceTrend' ) );
    var prices = [['', 'Euro']];
    
    var name = $( sender ).closest( 'article' ).find( 'header h3' ).html().substr( 0, 50 );
        
    $( sPrices ).each( function( index, value ) { 
        prices.push(['', parseInt( value )]);
    });
    
    var data = google.visualization.arrayToDataTable(prices);

    var options = {
      title: 'Andamento Prezzi '+name,
      hAxis: {title: '',  titleTextStyle: {color: '#333'}},
      vAxis: {minValue: 0},
      height: 400,width:800
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chartTrendProduct'));
    chart.draw(data, options);
    $( '#boxOverlay' ).show();
}

var widgetTrendChart   = null;
widgetTrendChart       = new WidgetTrendChart();
/**
 * Classe per la gestione dei moduli del sito
 */
var Modules = function() {
    this.aModules = new Array();    
};

Modules.prototype.add = function ( widget, core, loadType, limit, category, varAttrAjax, affiliation, trademark ) {
    this.aModules[widget] = {'widget':widget, 'core':core, 'loadType':loadType, 'limit':limit, 'category':category, 'varAttrAjax': varAttrAjax, 'affiliation':affiliation, 'trademark':trademark };     
};

/**
 * Ritorna i dati del modulo richiesto
 * @param {type} widget
 * @returns {Array|Boolean}
 */
Modules.prototype.getDataModule = function ( widget ) {
    if( typeof this.aModules[widget] == 'undefined' )
        return false; 
    return this.aModules[widget];
};

/**
 * Recupera il modulo da caricare
 * @param {type} module
 * @returns {undefined}
 */
Modules.prototype.load = function () {
    var that = this;        
    for ( item in this.aModules ) {        
        if( this.aModules[item]['loadType'] == 1 ) { 
            that.getAsync( 
                that.aModules[item]['widget'], 
                that.aModules[item]['core'],
                that.aModules[item]['limit'], 
                that.aModules[item]['category'], 
                that.aModules[item]['varAttrAjax'],
                that.aModules[item]['affiliation'],
                that.aModules[item]['trademark']
            );
        }
    }    
};

/**
 * Recupera il widget in modalita asicrona
 * @param {type} widget
 * @param {type} core
 * @returns {undefined}
 */
Modules.prototype.getAsync = function ( widget, core, limit, category, varAttrAjax, affiliation, trademark ) {
    var that = this;
    var id = idNews;
    
    setTimeout( function() {
        that.getModule( widget, core, id, false, false, limit, category, varAttrAjax, affiliation, trademark );
    }, 100 );
};

/**
 * Metodo che fa il replace con il contenuto del modulo
 * @param {type} module 
 * @returns {undefined}
 */
Modules.prototype.getModule = function ( widget, core, id, paramsExtra, callback, limit, category, varAttrAjax, affiliation, trademark ) {
    var that = this;   

    if( typeof id == 'undefined' )
        id = '';
        
    if( typeof paramsExtra == 'undefined' )
        paramsExtra ='';
        
//    if( widget != 'widget_LiveScoreMatch' )
//        $( '.'+widget ).find( '.widget-body' ).replaceWith( '<div class="text-center"><img widht="64" heidth="64" src="/images/loader.gif"></div>');
//    
    //Determina se bisogna differenziare la url avvinche la versione desktop e la versione mobile sia cachate in modo differente
    var changeUrlForCacheIfIsMobile = '';
    
    $( '['+varAttrAjax+']' ).hide();
    
    var params = "widget="+widget+"&cores="+core+"&limit="+limit+"&category="+category+"&affiliation="+affiliation+"&trademark="+trademark+"&id="+id+paramsExtra+changeUrlForCacheIfIsMobile;
    var request = $.ajax({
        url: ajaxCallPath + "widget?"+params, 
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) {
        //Setta che il widget è gia stato caricato per bloccare la chiamata ajax successivamente
        if( typeof that.aModules[widget] != 'undefined' && widget != 'widget_CommentsMatch' )
            that.aModules[widget]['open'] = id;        
//       

        $( '[dataReplaceWidget="'+varAttrAjax+'"]' ).replaceWith( html );
//       
//        
//        if( typeof callback != 'undefined' ) {
//            if( typeof callback.params != 'undefined' )
//                callback.call( callback.params[0] );
//            else
//                callback.call();
//        }
//                
//        
        
        setTimeout( function() {
            $( '[dataReplaceWidget]' ).show();
        },500);
//        
        
        
        var calls = $( '.'+widget ).attr( 'data-callFunctions' );
        if( typeof calls != 'undefined' && calls == 1 ) {
            that.getCallDataFunctionWidget( calls, params );
        } 
//        else if( typeof calls != 'undefined' ) {
//            alert( calls);
//            switch( calls ) {
//                case 'getFormationsFieldLastMatchTeam':
//                    that.getFormationsFieldLastMatchTeam();
//                break;
//            }
//        }
    });
};

//Modules.prototype.getFormationsFieldLastMatchTeam = function (  ) {
//    alert(lastFeedMatchIdTeam);
//    this.getCallDataFunctionWidget();
//};

/**
 * Lancia la funzione da chiamare settata nel data attribute data-callFunctions del widget appena caricato
 * @param {type} widget
 * @param {type} core
 * @param {type} id
 * @returns {undefined}
 */
Modules.prototype.getCallDataFunctionWidget = function ( call, params ) {
    var that = this;
        
    var request = $.ajax({
        url: ajaxCallPath + "dataWidget?"+params,
        type: "GET",
        async: true,
        dataType: "html"
    });

    request.done( function( html ) { 
        socketClient.eachData( jQuery.parseJSON( html ) );
    });
};

modules = null;
modules = new Modules();

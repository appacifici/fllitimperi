WidgetTestBanner = null;
$(function () {
    widgetTestBanner = new WidgetTestBanner();
});

/**
 * Classe per la gestione del widget
 */
var WidgetTestBanner = function () {
    this.buttonTest            = $( ".buttonTest" );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetTestBanner.prototype.initListeners = function () {
   var that = this;
   var site  = 'https://'+window.location.hostname;
   var lastArticleId = $('.buttonTest').find('[data-article]').attr('data-article'); 
   var categoryName = $('.buttonTest').find('[data-category]').attr('data-category').toLowerCase(); 
   var urlArticle = $('.buttonTest').find('[data-urlArticle]').attr('data-urlArticle'); 

   $('body').on('click', '.buttonTest', function(){
      that.openPopupToTest( this ); 
   });
   $('body').on('click', '#pageSpeedButtonHp', function(){
      that.openIframePageSpeedHomePage( this, site); 
   });
   $('body').on('click', '#pageSpeedButtonDa', function(){
      that.openIframePageSpeedDetailArticle( this, site, urlArticle); 
   });
   $('body').on('click', '#pageSpeedButtonCa', function(){
      that.openIframePageSpeedCategory( this, site, categoryName); 
   });
   $('body').on('click', '#ampButtonDa', function(){
      that.openAmpValidatorDetailArticle( this, site, urlArticle); 
   });
   $('body').on('click', '#newBannerArticle', function(){
      that.openNewBannerArticle( this, site, urlArticle); 
   });
   $('body').on('click', '.bootbox-close-button ', function(){
      that.showButtonAction(); 
   });
   
    $( 'body' ).on( 'click', '[data-checkBanner="1"]', function( e ) {
        that.checkInsertBannerFields( this, e );
        $( '[data-checkBanner="1"]' ).hide();
    });   
    $( 'body' ).on( 'click', '[data-checktest="1"]', function( e ) {
        that.checkTestIsDone( this );
    });   
    
    $( 'body' ).on( 'click', '[data-resetBanner="1"]', function( e ) {
        $('[databuttonconfirmsavebanner]').fadeOut();
        $( '[data-checkBanner="1"]' ).show();
    });
    
    $( 'body' ).on( 'click', '.bootbox-close-button', function( e ) {
        clearTimeout( that.timeoutSection );
        clearTimeout( that.timeoutAmp );
        clearTimeout( that.timeoutView );
    });
    
    $('form').click(function() { 
        $('[databuttonconfirmsavebanner]').fadeOut();
        $( '[data-checkBanner="1"]' ).show();
    });
    $('form').keypress(function() { 
        $('[databuttonconfirmsavebanner]').fadeOut();fg
        $( '[data-checkBanner="1"]' ).show();
    });
    
};

/**
 * Controlla se tutti i test sono stati effettuati 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkTestIsDone = function ( sender ) {
    var hasError = '';
    
    for( check in this.checkTestBanner ) {
        if ( this.checkTestBanner[check] == 0 ) {
            hasError += check+', ';
        }
    }
    if( hasError != '' ) {                
        this.openPopupToTest( sender );
        
        if( $( '#form_screen' ).val() != 'amp' ) {
            this.checkTestBanner['amp']     = 1;
            hasError = hasError.replace( 'amp,', '' );
            $( '#ampButtonDa' ).hide();
        } else if( $( '#form_screen' ).val() == 'amp' ) {
            this.checkTestBanner['view']     = 1;
            hasError = hasError.replace( 'view,', '' );
            $( '#newBannerArticle' ).hide();
        }
        
        var parameters = new Array();   
        parameters['type'] = 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  'Devi effettuare il test di: '+hasError;
        classNotyfy.openNotyfy( parameters );      
        
        switch( $( '#form_route' ).val() ) {
            case 'detailNews':
            case 'detailNewsAmp':
                console.info($( '#form_route' ).val());
                $( '#pageSpeedButtonDa' ).show();
                $( '#pageSpeedButtonCa' ).hide();
                $( '#pageSpeedButtonHp' ).hide();
            break;
            case 'listArticles':
                $( '#pageSpeedButtonDa' ).hide();
                $( '#pageSpeedButtonCa' ).show();
                $( '#pageSpeedButtonHp' ).hide();
            break;
            case 'homepage':
                $( '#pageSpeedButtonDa' ).hide();
                $( '#pageSpeedButtonCa' ).hide();
                $( '#pageSpeedButtonHp' ).show();
            break;
        }
        
    } else {
        widgetManagerInlineForm.pleaseWait( sender );
    }
        
};

/**
 * Avvia la verifica dell'inserimento dei banner
 * @param {type} sender
 * @param {type} e
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkInsertBannerFields = function ( sender, e ) {
    var father              = $( '.widget_EditBanner' );
    this.headerCode         = $( father ).find( '#form_headerCode' );
    this.formCode           = $( father ).find( '#form_code' );
    this.formCallsCode      = $( father ).find( '#form_callsCode' );
    
    this.checkTestBanner            =  new Array();
    this.checkTestBanner['view']    = 0;
    this.checkTestBanner['amp']     = 0;
    this.checkTestBanner['section'] = 0;
    
    this.hasFatalError      = false;
    this.errorsHeaderCode   = new Array();    
    this.errorsCode         = new Array();    
    this.errorsCallsCode    = new Array();    
    this.warningColor       = '#ff6600';
    this.fatalColor         = '#ff0000';
    this.checkHeaderCode();
    this.checkCode();
    this.checkCallsCode();
    
    
    
    if( !this.hasFatalError ) {
        $('[databuttonconfirmsavebanner]').fadeIn();
    } else {
       var parameters = new Array();   
       parameters['type'] = 'error';
       parameters['layout'] = 'top';
       parameters['mex'] =  'Errore Fatale: verifica le risposte in pagina';
       classNotyfy.openNotyfy( parameters );   
    }
};

/**
 * AVVIA LA VERIFICA DEI BANNER INSERITI NELL'HEADER CODE
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkHeaderCode = function (  ) {
    var responseScreen = this.headerCode.closest('.col-sm-10').find('.responseScreen');             
    if( $( responseScreen ).length > 0 )
        $( responseScreen ).html('');
    else
        this.headerCode.closest('.col-sm-10').append('<div class="responseScreen"></div>');   

    var re = /<script([\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/gm;
    var match;
    this.inisHeaderCodeText = this.headerCode.val();
    
    while (codes = re.exec( this.headerCode.val() )) {
        this.errorsHeaderCode[item] = '';
        if( codes[0] != '' ) {            
            var item = codes[0];
            this.errorsHeaderCode[item] = '';
            
            if( !this.checkIsAsync( item ) ) {
                var codeAsync = replaceAll( item, '>', '&gt;' );
                codeAsync = replaceAll( codeAsync, '<', '&lt;' );
                
                var msg = '<div style="color:'+this.warningColor+'">Il  codice non contiene il tag async necessario</div>';        
                this.errorsHeaderCode[codeAsync] = typeof this.errorsHeaderCode[codeAsync] != 'undefined' ? this.errorsHeaderCode[codeAsync]+' '+msg : msg;
            }
            
            if( !this.checkIsLibrary( item ) ) {
                var codeLibrary = replaceAll( item, '>', '&gt;' );
                var codeLibrary = replaceAll( codeLibrary, '<', '&lt;' );
                var msg = '<div style="color:'+this.warningColor+'">Il codice  sembra non essere un libreria</div>';
                this.errorsHeaderCode[codeLibrary] = typeof this.errorsHeaderCode[codeLibrary] != 'undefined' ? this.errorsHeaderCode[codeLibrary]+' '+msg : msg;
            }
                        
            if( !this.checkIsPushCallLibrary( item ) ) {
                var codeCallLibrary = replaceAll( item, '>', '&gt;' );
                var codeCallLibrary = replaceAll( codeCallLibrary, '<', '&lt;' );
                var msg = '<div style="color:'+this.warningColor+'">Il codice sembra essere una chiamata ad una libreria</div>';
                this.errorsHeaderCode[codeCallLibrary] = typeof this.errorsHeaderCode[codeCallLibrary] != 'undefined' ? this.errorsHeaderCode[codeCallLibrary]+' '+msg : msg;
            }
            
        }
        this.inisHeaderCodeText = this.inisHeaderCodeText.replace( codes[0], '');
    }
    
    //Stampa gli errori al video
    for ( code in this.errorsHeaderCode ) {
        if( this.errorsHeaderCode[code] != '' )
            this.headerCode.closest('.col-sm-10').find('.responseScreen').append('<b>'+code+'</b><br>'+this.errorsHeaderCode[code]+'<div class="sep"></div>');
    }
    
    var extraCode = this.inisHeaderCodeText.trim();
    if( extraCode != '' ) {
        this.hasFatalError = true;
        extraCode = replaceAll( extraCode, '>', '&gt;' );
        extraCode = replaceAll( extraCode, '<', '&lt;' );
        
        this.headerCode.closest('.col-sm-10').find('.responseScreen').append('<b>'+extraCode.replace( ';', '<br>').replace( '>', '<br>')+'</b><br><div style="color:'+this.fatalColor+'">Questo codice sembra non essere posizionato correttamente o mancano i tag &lt;script>&lt;/script></div><div class="sep"></div>');    
    }
    
    if( this.headerCode.closest('.col-sm-10').find('.responseScreen').html().trim() == '' )
        this.headerCode.closest('.col-sm-10').find('.responseScreen').remove();
};

/**
 * AVVIA LA VERIFICA DEI CAMPI DEL CODE BANNER
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkCode = function (  ) {
    var responseScreen = this.formCode.closest('.col-sm-10').find('.responseScreen');             
    if( $(responseScreen).length > 0 )
        $( responseScreen ).html('');
    else
        this.formCode.closest('.col-sm-10').append('<div class="responseScreen"></div>');   

//    var re = /<script([\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/gm;
    var re = /<([\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/gm;
    var match;
    this.inisCodeText = this.formCode.val();
    
    while (codes = re.exec( this.formCode.val() )) {        
        this.errorsCode[item] = '';
        
        if( codes[0] != '' ) {            
            var item = codes[0];
            this.errorsCode[item] = '';            
            
            if( this.checkIsLibrary( item ) ) {
                var codeLibrary = replaceAll( item, '>', '&gt;' );
                var codeLibrary = replaceAll( codeLibrary, '<', '&lt;' );
                var msg = '<div style="color:'+this.warningColor+'">Il codice  sembra essere una libreria, sei sicuro che non puoi metterla nel codice header?</div>';
                this.errorsCode[codeLibrary] = typeof this.errorsCode[codeLibrary] != 'undefined' ? this.errorsCode[codeLibrary]+' '+msg : msg;
            }                                   
            
            if( !this.checkIsPlaceCard( item ) ) {
                var codePlaceCard = replaceAll( item, '>', '&gt;' );
                var codePlaceCard = replaceAll( codePlaceCard, '<', '&lt;' );
                var msg = '<div style="color:'+this.warningColor+'">Il codice sembra NON ESSERE un segnaposto per una chiamata</div>';
                this.errorsCode[codePlaceCard] = typeof this.errorsCode[codePlaceCard] != 'undefined' ? this.errorsCode[codePlaceCard]+' '+msg : msg;
            }                                               
        }
        this.inisCodeText = this.inisCodeText.replace( codes[0], '');
    }
        
    //Stampa gli errori al video
    for ( code in this.errorsCode ) {       
        if( this.errorsCode[code] != '' ) {
            this.formCode.closest('.col-sm-10').find('.responseScreen').append('<b>'+code+'</b><br>'+this.errorsCode[code]+'<div class="sep"></div>');
        }
    }
    
    var extraCode = this.inisCodeText.trim();    
    if( extraCode != '' ) {
        this.hasFatalError = true;
        extraCode = replaceAll( extraCode, '>', '&gt;' );
        extraCode = replaceAll( extraCode, '<', '&lt;' );
        
        this.formCode.closest('.col-sm-10').find('.responseScreen').append('<b>'+extraCode.replace( ';', '<br>').replace( '>', '<br>')+'</b><br><div style="color:'+this.fatalColor+'">Questo codice sembra non essere posizionato correttamente o mancano i tag &lt;script>&lt;/script></div><div class="sep"></div>');    
    }
    
    if( this.formCode.closest('.col-sm-10').find('.responseScreen').html().trim() == '' )
        this.formCode.closest('.col-sm-10').find('.responseScreen').remove();
        
};

WidgetTestBanner.prototype.checkCallsCode = function (  ) {
    var responseScreen = this.formCallsCode.closest('.col-sm-10').find('.responseScreen');             
    if( $(responseScreen).length > 0 )
        $( responseScreen ).html('');
    else
        this.formCallsCode.closest('.col-sm-10').append('<div class="responseScreen"></div>');   

//    var re = /<script([\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/gm;
    var re = /<([\s\S]*?)>([\s\S]*?)<\/([\s\S]*?)>/gm;
    var match;
    this.inisCallsCodeText = this.formCallsCode.val();
    while (codes = re.exec( this.formCallsCode.val() )) {        
        this.errorsCallsCode[item] = '';
        
        if( codes[0] != '' ) {            
            var item = codes[0];
            this.errorsCallsCode[item] = ''; 
            
            if( this.checkIsLibrary( item ) ) {
                var codeLibrary = replaceAll( item, '>', '&gt;' );
                var codeLibrary = replaceAll( codeLibrary, '<', '&lt;' );
                this.hasFatalError = true;
                var msg = '<div style="color:'+this.fatalColor+'">Il codice  sembra essere una libreria, non può essere posizionata qui!</div>';
                this.errorsCallsCode[codeLibrary] = typeof this.errorsCallsCode[codeLibrary] != 'undefined' ? this.errorsCallsCode[codeLibrary]+' '+msg : msg;
            }                                   
            
            if( this.checkIsPlaceCard( item ) ) {
                var codePlaceCard = replaceAll( item, '>', '&gt;' );
                var codePlaceCard = replaceAll( codePlaceCard, '<', '&lt;' );
                this.hasFatalError = true;
                var msg = '<div style="color:'+this.fatalColor+'">Il codice sembra ESSERE un segnaposto per una chiamata, va spostato nel campo "CODE"</div>';
                this.errorsCallsCode[codePlaceCard] = typeof this.errorsCallsCode[codePlaceCard] != 'undefined' ? this.errorsCallsCode[codePlaceCard]+' '+msg : msg;
            }      
            if( this.isScript( item ) ) {
                var codePlaceCard = replaceAll( item, '>', '&gt;' );
                var codePlaceCard = replaceAll( codePlaceCard, '<', '&lt;' );
                this.hasFatalError = true;
                var msg = '<div style="color:'+this.fatalColor+'">Non è possibile inseriscre il tag &lt;script>&lt;/script> in questo campo</div>';
                this.errorsCallsCode[codePlaceCard] = typeof this.errorsCallsCode[codePlaceCard] != 'undefined' ? this.errorsCallsCode[codePlaceCard]+' '+msg : msg;
            }                  
        }
        this.inisHeaderCodeText = this.inisHeaderCodeText.replace( codes[0], '');
    }
    
    
    //Stampa gli errori al video
    for ( code in this.errorsCallsCode ) {       
        if( this.errorsCallsCode[code] != '' ) {
            this.formCallsCode.closest('.col-sm-10').find('.responseScreen').append('<b>'+code+'</b><br>'+this.errorsCallsCode[code]+'<div class="sep"></div>');
        }
    }
    
    var extraCode = this.inisCallsCodeText.trim();  
    
    if( this.formCallsCode.closest('.col-sm-10').find('.responseScreen').html().trim() == '' )
        this.formCallsCode.closest('.col-sm-10').find('.responseScreen').remove();
    
    
};

/**
 * METODO CHE CONTROLLA CHE SIA UN ASYNC IL CODICE INSERITO
 * @param {type} code
 * @returns {undefined}
 */
WidgetTestBanner.prototype.isScript = function ( code ) {    
    if( code.indexOf("script") == '-1' ) {
        return false;        
    }    
    return true;
};

/**
 * METODO CHE CONTROLLA CHE SIA UN ASYNC IL CODICE INSERITO
 * @param {type} code
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkIsAsync = function ( code ) {    
    if( code.indexOf("async") == '-1' ) {
        return false;        
    }    
    return true;
};

/**
 * METODO CHE VERIFICA SE SIA UNA LIRERIA QUELLA INSERITA
 * @param {type} code
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkIsLibrary = function ( code ) {    
    if( code.indexOf(".js") == '-1' ) {
        return false;
    }    
    return true;
};

/**
 * METODO CHE VERIFICA SE SIA UNA CHIAMATA AD UNA LIBRERIA QUELLA INSERITA
 * @param {type} code
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkIsPushCallLibrary = function ( code ) {    
    if( code.indexOf(".push") != '-1' && code.indexOf(".js") == '-1' ) {
        return false;
    }    
    return true;
};

/**
 * METODO CHE VERIFICA SE SIA UNA CHIAMATA AD UNA LIBRERIA QUELLA INSERITA
 * @param {type} code
 * @returns {undefined}
 */
WidgetTestBanner.prototype.checkIsPlaceCard = function ( code ) {  
    var re = /<div([\s\S]*?)>([\s\S]*?)<\/div([\s\S]*?)>/gm; 
    var resp = re.exec( code );
    
    console.info(resp);
    
    if( resp != null && resp.length > 0 && resp[1].trim() != ''  ) {
        return true;
    }    
    return false;
};



function escapeRegExp(str) {
  return str.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}
function replaceAll(str, find, replace) {
  return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
}


/************************************************************ PARTE CHE GESTISCE I TEST DI CONTROLLO ***************************************************************
 ********************************************************************************************************************************************************************/

WidgetTestBanner.prototype.openPopupToTest = function ( sender ) {
    $('.button-action').hide();    
    var params = { 
            type: 'custom', 
            title: 'TESTA L\'IMPATTO DEL BANNER SU PAGESPEED',
            callbackModals: '\
            <div class="bannerTestPopUp">\
                    <div class="containerPageSpeedBox">\
                        <span class="pull-right" style="margin-right:20px; margin-bottom:10px">Versione col nuovo banner</span><span class="pull-left" style="margin-bottom:10px">Versione senza il nuovo banner</span>​\
                        <div class="oldBannerVersion" style="margin-top:10px">\
                            <iframe id="iframePageSpeed" class="pull-left" src="" width="48.9%" height="500px" style="border:1px solid #ccc; margin-bottom:15px">\
                            </iframe>\
                        </div>\
                        <div class="newBannerVersion">\
                            <iframe id="iframePageSpeed2" class="pull-left" src="" width="48.9%" height="500px" style="margin-left:16px; border:1px solid #ccc; margin-bottom:15px">\
                            </iframe>\
                        </div>\
                    </div>\
                    <div id="pageSpeedButtonDa" class="buttonDefault pull-right">\
                            <div type="button" class="add">Testa l\'articolo</div>\
                            <i class=" fa  fa-check-circle"></i>\
                    </div>\
                    <div id="pageSpeedButtonCa" class="buttonDefault pull-right">\
                            <div type="button" class="add">Testa la categoria</div>\
                            <i class=" fa  fa-check-circle"></i>\
                    </div>\
                    <div id="pageSpeedButtonHp" class="buttonDefault pull-right">\
                            <div type="button" class="add">Testa l\'homepage</div>\
                            <i class=" fa  fa-check-circle"></i>\
                    </div>\
                    <div id="ampButtonDa" class="buttonDefault center" >\
                            <div type="button" class="add">Verifica AMP</div>\
                            <i class=" fa  fa-check-circle"></i>\
                    </div>\
                    <div id="newBannerArticle" class="buttonDefault center" >\
                            <div type="button" class="add">Come si vede?</div>\
                            <i class=" fa  fa-check-circle"></i>\
                    </div>\
            </div>'
            };
    classModals.openModals( params );
            
    setTimeout( function() {
        $('.modal-dialog').css('width', '90%');
    } , 100 );
};

WidgetTestBanner.prototype.openIframePageSpeedHomePage = function ( sender, site ) {
    var that = this;
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site);
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed2").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site+"?test");    
    this.timeoutSection = setTimeout(function() {
        that.checkTestBanner['section'] = 1;
    }, 5000 );
    
};

WidgetTestBanner.prototype.openIframePageSpeedDetailArticle = function ( sender, site, urlArticle) {
    var that = this;
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site+urlArticle);
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed2").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site+urlArticle+"?test");    
    this.timeoutSection = setTimeout(function() {
        that.checkTestBanner['section'] = 1;
    }, 5000 );
};

WidgetTestBanner.prototype.openIframePageSpeedCategory = function ( sender, site, categoryName) {
    var that = this;
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site+"/"+categoryName+"");
    $(sender).closest('.bannerTestPopUp').find("#iframePageSpeed2").attr("src", "https://developers.google.com/speed/pagespeed/insights/?url="+site+"/"+categoryName+"?test");
    this.timeoutSection = setTimeout(function() {
        that.checkTestBanner['section'] = 1;
    }, 5000 );
};

WidgetTestBanner.prototype.showButtonAction = function() {
    $('.button-action').show();
};

WidgetTestBanner.prototype.openAmpValidatorDetailArticle = function ( sender, site, urlArticle) {
    var that = this;
    window.open("https://search.google.com/test/amp?url="+site+"/amp"+urlArticle+"?test");
    this.timeoutAmp =  setTimeout(function() {
        that.checkTestBanner['amp'] = 1;
    }, 5000 );
};

WidgetTestBanner.prototype.openNewBannerArticle = function ( sender, site, urlArticle) {
    var that = this;
    window.open( site+urlArticle+"?test"+"", "_blank");
    this.timeoutView = setTimeout(function() {
        that.checkTestBanner['view'] = 1;
    }, 5000 );
};

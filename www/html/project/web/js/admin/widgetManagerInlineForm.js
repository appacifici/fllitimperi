widgetManagerInlineForm = null;
$(function () {
    widgetManagerInlineForm = new WidgetManagerInlineForm();
});

/**
 * Classe per la gestione del widget / da dividere e mettere bene
 */
var WidgetManagerInlineForm = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetManagerInlineForm.prototype.initListeners = function () {
    var that = this;
    $( 'body' ).on( 'click', '[data-editInlineForm]', function() {
        that.getModifyInlineForm( this );
    });
    $( 'body' ).on( 'click', '[data-saveInlineForm]', function() {
        that.saveDataInlineForm( this );
    });    
    $( 'body' ).on( 'click', '[data-deleteInlineForm]', function() {
        that.confirmDeleteInlineForm( this );
    });    
    $( 'body' ).on( 'change', '[data-childrens]', function() {
        that.changeSelect( this, true );
    });
    $( 'body' ).on( 'click', '[data-reset="1"]', function( e ) {
        that.confirmResetForm( this, e );
    });
    $( 'body' ).on( 'click', '[data-submit="1"]', function( e ) {
        that.pleaseWait( this, e );
    });
    
    
    this.initCurrentSelect();
    
    if( $( '.has-error' ).length > 0 ) {    
       var parameters = new Array();   
       parameters['type'] = 'error';
       parameters['layout'] = 'top';
       parameters['mex'] =  'Controllare il form';
       classNotyfy.openNotyfy( parameters );
       
        mainAdmin.speakSite( parameters['mex'] );
    
       
    } else if( typeof window.location.search != 'undefined' && window.location.search.indexOf( '?resp=1') != '-1' ) {
       var parameters = new Array();   
       parameters['type'] = 'success';
       parameters['layout'] = 'top';
       parameters['mex'] =  'Salvataggio eseguito con successo';
       classNotyfy.openNotyfy( parameters ); 
       mainAdmin.speakSite( parameters['mex'] );
       window.history.pushState("", 'save', '?resp=0' );
    }
    
    this.changeSelect( $('#form_category' )  );
    
};

/**
 * Apre un messagio di attesa salvataggio
 * @returns {undefined}
 */
WidgetManagerInlineForm.prototype.pleaseWait = function ( sender, e ) {     
    if( widgetLogin.isLogged() != 1 ) {  
        e.stopPropagation();
        e.preventDefault();  
        var callback = { 'call': $( sender ).closest( 'form' )[0], 'params': { '0': 'submit' } };
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }   
    
    var params = { 
        type: 'custom', 
        title: '',
        callbackModals: '\
        <div class="row row-icons widget_PleaseWait">\
            <div class="innerLR">\
                <h5 class="innerAll margin-none border-bottom bg-primary">SALVATAGGIO IN CORSO</h5>\
                <div class="floatL col-md-2 mr10">\
                    <i class="fa fa-gears"></i>\
                </div>\
                <div class="floatL col-md-9" style="margin-top:10px;text-align:center;">\
                    <h4>Attendi il completamente del salvataggio, questo box si chiudera in automatico una volta terminato!</h4>\
                    <img src="/images/loading1.gif" width="100px" />\
                </div>\
            </div>\
        </div>'
    };
    classModals.openModals( params );
    $("div[data-divForm='1']").find('form').submit();  
};


/**
 * Metodo che lancia la conferma del reset
 * @returns {undefined}
 */
WidgetManagerInlineForm.prototype.confirmResetForm = function ( sender, e ) { 
    
    e.stopPropagation();
    e.preventDefault();    

    var callback = { 'call': this.resetForm, 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi resettare questo form?',
        finalCallback: callback        
    };
    mainAdmin.speakSite(  'Vuoi resettare, questo form?' );
    classModals.openModals( params );
};

/**
 * Metodo che lancia il reset del form
 * @returns {undefined}
 */
WidgetManagerInlineForm.prototype.resetForm = function ( sender ) {     
    $("div[data-divForm='1']").find('form')[0].reset();  
    mainAdmin.speakSite( 'Form resettato con successo?' );
};


WidgetManagerInlineForm.prototype.initCurrentSelect = function() {
    var that = this;
//    if( window.location.pathname.indexOf( 'admin/manageArticle' ) != '-1' ) {
//        this.changeSelect( $( '#form_category'), false );
//        setTimeout( function() {
//            that.changeSelect( $( '#form_tournament'), false );
//        }, 5000 );
//    }
};

/**
 * Metodo che gestisce le select a cas
 * @param {type} sender
 * @returns {undefined}
 */
WidgetManagerInlineForm.prototype.changeSelect = function ( sender, emptyVal ) {
    if( typeof $( sender ).attr('data-childrens') == 'undefined' )
        return false;
    
    
    var that = this;
    var childrens = JSON.parse ( $( sender ).attr('data-childrens') );
    
    var keysChildrens = Object.keys(childrens);    
    for( var i = 0; i < keysChildrens.length; i++ ) {  
        var actKey = keysChildrens[i];
        
        var request = $.ajax ({
            url: "/admin/getSelectOptions",
            type: "POST",
            async: false,
            dataType: "json",
            data : { id: $( sender ).val(), 'children': JSON.stringify( childrens[keysChildrens[i]] ) }
         });
         request.done( function( items ) {
            var last =  $( '#form_'+actKey ).select().val();
            
            var keys = Object.keys(items);            
            $('#form_'+actKey).val('');
            $( '#form_'+actKey ).find( 'option' ).hide();           
            that.resetChilderSelect( $( '#form_'+actKey ), emptyVal );
            
            $( '#form_'+actKey ).prepend( '<option value="">Scegli</option>' );
            for( var x = 0; x < keys.length; x++ ) {          
                                
                var selected = '';
                if( typeof last != 'undefined' && last == keys[x] ) {
                    selected = '';
                    $( '#form_'+actKey ).find( '[value="'+keys[x]+'"]' ).attr('selected', selected ).show();       
                } else {
                    $( '#form_'+actKey ).find( '[value="'+keys[x]+'"]' ).removeAttr('selected', selected ).show();       
                }                                     
//                $( '#form_'+actKey ).append( '<option value="'+keys[x]+'">'+items[keys[x]]+'</option>' );
            }

        });
    }
};
        
WidgetManagerInlineForm.prototype.resetChilderSelect = function ( sender, emptyVal ) {
    
    var that = this;
    
    if( typeof $( sender ).attr('data-childrens') == 'undefined' || $( sender ).attr('data-childrens') == null || $( sender ).attr('data-childrens') == '' )
        return false;
    
    var childrens = JSON.parse ( $( sender ).attr('data-childrens') );
    if ( typeof childrens == 'undefined' || childrens == null || childrens == '' )
        return false;
    
    
    var keysChildrens = Object.keys(childrens);    
    for( var i = 0; i < keysChildrens.length; i++ ) {  
         var actKey = keysChildrens[i];
        
        if( emptyVal )
            $('#form_'+actKey).val('');
        
        $( '#form_'+actKey ).find( 'option' ).hide();  
//        console.info($( '#form_'+actKey ).find( 'option' ).length );          
        
        that.resetChilderSelect( $( '#form_'+actKey ) );
        
    }
};


/**
 * Metodo che avvia la creazione dei campi input e gli altri per la creazione del form di modifica inline
 * @param {object} sender
 * @returns {void}
 */
WidgetManagerInlineForm.prototype.getModifyInlineForm = function ( sender ) { 
    if( widgetLogin.isLogged() != 1 ) {    
        var callback = { 'call': this.getModifyInlineForm.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    $( sender ).closest("[data-id]").find("[data-saveInlineForm]").toggleClass("hidden btn-sm");
    $( sender ).closest("[data-id]").find("[data-editInlineForm]").toggleClass("hidden btn-sm");
    
    // Si recuperano tutti i campi del form dell'utente
    var fields = $( sender ).closest("[data-createForm]").find("[data-modify]");
   
    // Vengono ciclati i vari campi
    $( fields ).each( function() {
        switch ( $(this).attr("data-modify") ) {
            // Se il data-modify è un input viene creato un campo input
            case "input":
                var type = typeof $(this).attr('data-typeField') != 'undefined' ? $(this).attr('data-typeField') : 'text';
                var input = $( '<input type="'+type+'" value="'+$(this).html()+'" name="'+$(this).attr('data-field')+'">' );
                $( this ).html(input);  
            break;
            // Se il data-modify è una select viene creato un campo select
            case "select":                
                // Si recupera l'array di tutte le opzioni possibili della select
                var arr = JSON.parse( $(this).attr('data-store') );
                // Si crea la select
                var sel = $('<select>');
                // Si cicla l'array delle opzioni 
                for ( var item in arr ) {                                       
                    var selected = '';                      
                    // Si creano le opzioni con i vari valori dell'array
                    var input = ($("<option>").attr('value',item).text(arr[item]));
                    // Quando il value della option corrisponde al valore presente nell'array, viene valorizzato l'attributo selected con 'selected'
                    if( $(this).attr('data-value') == item )
                        input.attr( 'selected', 'selected' );
                    // Alla select viene appeso il valore dell'input selezionato
                    sel.append( input );
                };
                // Si modifica il contenuto della select
                $( this ).html( sel ); 
            break;        
        }
    });
};

/**
 * Metodo che recupera i dati cambiati nel inline form e avvia la chiamata ajax per il salvataggio delle modifiche
 * @param {object} sender
 * @returns {void}
 */
WidgetManagerInlineForm.prototype.saveDataInlineForm = function ( sender ) {    
    var that = this;
    
    if( widgetLogin.isLogged() != 1 ) {    
        var callback = { 'call': this.saveDataInlineForm.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    // Viene cambiata la visibilità al bottone: quando si clicca 'salva' si mostra il bottone per la modifica
    $( sender ).closest("[data-id]").find("[data-saveInlineForm]").toggleClass("hidden btn-sm");
    $( sender ).closest("[data-id]").find("[data-editInlineForm]").toggleClass("hidden btn-sm");
    
    var formData = new Array();
    
    // Si recuperano i vari campi del form
    var fields = $( sender ).closest("[data-createForm]").find("[data-modify]");
    // Ciclo che itera i vari campi presenti nel form
    $( fields ).each( function() {
        switch ( $(this).attr("data-modify") ) {
            // Se il data-modify è un input viene recuperato il suo value e stampato
            case "input":
                var newValue = $( this ).find('input').val();
                // Si stampa il nuovo valore settato
                $( this ).html(newValue);  
                
                formData.push( { 'name' : $(this).attr("data-field"), 'value' : newValue } );                
            break;
            // Se il data-modify è una seleect viene recuperato il suo value e stampato
            case "select":  
                // Si creano le opzioni con i vari valori dell'array
                var arr = JSON.parse( $(this).attr('data-store') );
                // Si cicla l'array e si recupera
                for ( var item in arr ) {
                    var selected = '';                      
                    // Quando il value della option corrisponde al valore presente nell'array, viene valorizzato l'attributo selected con 'selected'
                    if( $(this).attr('data-value') == item ) {
                        // Recupero il nuovo valore inserito                        
                        var newSelectedValue = $( this ).find('select').val();
                        formData.push( { 'name' : $(this).attr("data-field"), 'value' : newSelectedValue } );
                                                
                        // Stampo il nuovo valore inserito
                        $( this ).html( arr[newSelectedValue] );
                        $( this ).closest("[data-modify]").attr("data-value", newSelectedValue);
                    }       
                }
            break;      
        }
    });
    
    // Recupero l'id riferito al Form 
    var id = $( sender ).closest("[data-createForm]").attr("data-id");
    // Recupero la action riferita al form
    var action = $( sender ).closest("[data-createForm]").attr("data-createForm");
    var entity = $( sender ).closest( "[data-createForm]" ).attr( "data-entity" );    
    
    // All'array dei campi ottenuto dal CustomSerializeArray aggiungo due campi chiave/valore
    formData.push( { 'name' : 'id', 'value' : id } );
    formData.push( { 'name' : 'action', 'value' : action } );
    formData.push( {'name' : 'entity', 'value': entity } );
    
//    console.dir(formData);
    
    var request = $.ajax ({
        url: "/admin/saveInlineForm",
        type: "POST",
        async: true,
        dataType: "json",
        data: formData
     });
     request.done( function( resp ) {
        that.readResponseAjax( resp );
    });
};

WidgetManagerInlineForm.prototype.confirmDeleteInlineForm = function ( sender ) {        
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmDeleteInlineForm.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
     
    mainAdmin.speakSite( 'Vuoi cancellare questo elemento?' );
    
    var callback = { 'call': this.deleteInlineForm.bind( this ), 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi cancellare questo elemento?',
        finalCallback: callback        
    };
    classModals.openModals( params );
};
/**
 * Metodo che rimuove un elemento
 * @param {type} sender
 * @returns {Boolean}
 */
WidgetManagerInlineForm.prototype.deleteInlineForm = function ( sender ) {
    var that = this;
    
    $( sender ).closest("table").find('.footable-detail-show').remove();        
    $( sender ).closest(".footable-row-detail").remove();            
    $( sender ).closest("[data-createForm]").remove();        
    
    var id          = $( sender ).closest( "[data-createForm]" ).attr( "data-id" );    
    var entity      = $( sender ).closest( "[data-createForm]" ).attr( "data-entity" );    
    
    var formData  = [];
    formData.push( {'name' : 'id', 'value': id } );
    formData.push( {'name' : 'entity', 'value': entity } );
       
    var request = $.ajax ({
        url: "/admin/deleteItemEntity",
        type: "POST",
        async: true,
        dataType: "json",
        data: formData
     });
     request.done( function( resp ) {
        that.readResponseAjax( resp );
    });

// Si recuperano tutti i campi del form dell'utente
    
};

WidgetManagerInlineForm.prototype.readResponseAjax = function ( response ) { 
    mainAdmin.speakSite( response.msg );
    
    var parameters = new Array();   
    parameters['type'] = response.error == 0 ? 'success' : 'error';
    parameters['layout'] = 'top';
    parameters['mex'] =  response.msg;
    classNotyfy.openNotyfy( parameters );
};    

widgetManagerMenus = null;
$(function () {
    widgetManagerMenus = new WidgetManagerMenus();
});

/**
 * Classe per la gestione del widget / da dividere e mettere bene
 */
var WidgetManagerMenus = function () {    
    this.buttonMenu                 = $( ".buttonMenu" );
    this.categoryRow                = $( "[data-item]" );
    this.buttonAddCategory          = $( ".buttonAddCategory" );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetManagerMenus.prototype.initListeners = function () {
    var that = this;
        
    // Ascoltatore sul bottone che salva l'ordine delle categorie
    $( this.buttonMenu ).click( function (e) {
        // Metodo che fa partire la chiamata Ajax che restituisce il nuovo ordine delle categorie 
        that.confirmOrderCategory( this );
    });    
    // Ascoltatore sul bottone che salva l'ordine 
    $( this.categoryRow ).closest('.itemMenu').find('.btnDeleteItem').click( function (e) {
        // Metodo che elimina la categoria dell'elenco delle categorie del menu
        that.confirmDeleteCategory( this );
    });    
    
    // Ascoltatore sul bottone che aggiunge una categoria al menu
    $( this.buttonAddCategory ).click( function (e) {
        // Metodo che verifica se la categoria che si vuole aggiungere è già presente nel menu e, se non presente, la aggiunge
        that.addCategory( this );
    });       
    
    // Ascoltatore sul bottone che aggiunge un utente alla lista users
    $( this.buttonAddUser ).click( function (e) {
        // Metodo che fa il serialize del form relativo al nuovo user e fa partire la chiamata Ajax
        that.addUser( this );
    });       
    
};

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetManagerMenus.prototype.confirmOrderCategory = function ( sender ) { 
    
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmOrderCategory.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    var callback = { 'call': this.orderCategory, 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'vuoi salvare questo nuovo ordine di menu?',
        finalCallback: callback        
    };
    classModals.openModals( params );
    mainAdmin.speakSite( 'vuoi salvare questo nuovo ordine di menu?' );
};

// Metodo che ordina le categorie nell'admin
WidgetManagerMenus.prototype.orderCategory = function ( sender ) {
    
    var orderMenu = '';
    // Vengono ciclate tutte le categorie appartenenti il menu 
    var order = $(sender).closest('.menuOrder').find('[data-item]').each( function ( ) {
        // Si crea la stringa che contiene tutti i {data-item} in ordine
        orderMenu += $( this ).attr("data-item")+',';
    });
        // Viene eliminato l'ultima virgola, refuso del ciclo each
    var ids = orderMenu.slice(0,-1);
        // Parte la richiesta ajax che restituisce il nuovo ordine delle categorie
    var request = $.ajax ({
        url: "/admin/updateOrderMenu/"+ids,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     // Richiesta andata a buon fine
     request.done( function( resp ) {     
         
        var parameters = new Array();   
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
         
    });
};

/**
 * 
 * @param {type} sender
 * @returns {undefined}
 */
WidgetManagerMenus.prototype.confirmDeleteCategory = function ( sender ) { 
    
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmDeleteCategory.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    var callback = { 'call': this.deleteCategory, 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi cancellare questo elemento?',
        finalCallback: callback        
    };
    classModals.openModals( params );
    mainAdmin.speakSite( 'Vuoi cancellare questo elemento?' );
};

WidgetManagerMenus.prototype.deleteCategory = function ( sender ) {
    // Si recupera l'id della squadra da eliminare dal menu
    var id = $( sender ).closest('.itemMenu').find("[data-item]").attr("data-item");;
    // Parte la richiesta Ajax
    var request = $.ajax ({
        url: "/admin/deleteItemMenu/"+id,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( !resp.error ) {
            // Viene tolta la visibilità della voce di menu
            $( sender ).closest('.itemMenu').remove();
        }
        
        var parameters = new Array();   
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
        
    });
};

WidgetManagerMenus.prototype.addCategory = function ( sender ) {
    
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.addCategory.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    // Si recupera l'id della categoria selezionata nella Select
    var id          = $( sender ).closest('.menuOrder').find('.searchCategory').children(":selected").val();
    // Viene recuperato il nome del'entità della voce di menu da aggiungere
    var entity      = $( sender ).closest('.menuOrder').find('.searchCategory').children(":selected").attr("data-entity");
    // Si recupera la tipologia di menu in cui si vuole aggiungere una categoria
    var menuType    = $( sender ).closest('[data-type]').attr("data-type");
    // Parte la richiesta Ajax per l'aggiunta della categoria al menu: vengono passati i valori di MenuType e Id
    
    console.info(entity);
    var request = $.ajax ({
        url: "/admin/addItem/"+menuType+"/"+entity+"/"+id,
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
                window.location.href = "/admin/manageMenu";
            }, 1500 );
        }
        
    });
};


WidgetManagerMenus.prototype.addUser = function ( sender ) {
    // Vengono recuperati i dati del form dell'utente tramite il serialize
    var data = $( sender ).closest(".newUser").find( '#formAddUser' ).serialize();
    // Parte la chiamata Ajax che tramite il metodo GET trasferisce i dati del form per l'inserimento nella tabella Users
    var request = $.ajax ({
        url: "/admin/addUser/GET?"+data,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( resp.error ) {
            alert(resp.msg);
        } else {
            alert(resp.msg);
        }
    });
};


/**
 * bootbox.js v4.1.0
 *
 * http://bootboxjs.com/license.txt
 */
window.bootbox=window.bootbox||function a(b,c){"use strict";function d(a){var b=r[p.locale];return b?b[a]:r.en[a]}function e(a,c,d){a.preventDefault();var e=b.isFunction(d)&&d(a)===!1;e||c.modal("hide")}function f(a){var b,c=0;for(b in a)c++;return c}function g(a,c){var d=0;b.each(a,function(a,b){c(a,b,d++)})}function h(a){var c,d;if("object"!=typeof a)throw new Error("Please supply an object of options");if(!a.message)throw new Error("Please specify a message");return a=b.extend({},p,a),a.buttons||(a.buttons={}),a.backdrop=a.backdrop?"static":!1,c=a.buttons,d=f(c),g(c,function(a,e,f){if(b.isFunction(e)&&(e=c[a]={callback:e}),"object"!==b.type(e))throw new Error("button with key "+a+" must be an object");e.label||(e.label=a),e.className||(e.className=2>=d&&f===d-1?"btn-primary":"btn-default")}),a}function i(a,b){var c=a.length,d={};if(1>c||c>2)throw new Error("Invalid argument length");return 2===c||"string"==typeof a[0]?(d[b[0]]=a[0],d[b[1]]=a[1]):d=a[0],d}function j(a,c,d){return b.extend(!0,{},a,i(c,d))}function k(a,b,c,d){var e={className:"bootbox-"+a,buttons:l.apply(null,b)};return m(j(e,d,c),b)}function l(){for(var a={},b=0,c=arguments.length;c>b;b++){var e=arguments[b],f=e.toLowerCase(),g=e.toUpperCase();a[f]={label:d(g)}}return a}function m(a,b){var d={};return g(b,function(a,b){d[b]=!0}),g(a.buttons,function(a){if(d[a]===c)throw new Error("button key "+a+" is not allowed (options are "+b.join("\n")+")")}),a}var n={dialog:"<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",header:"<div class='modal-header'><h4 class='modal-title'></h4></div>",footer:"<div class='modal-footer'></div>",closeButton:"<button type='button' class='bootbox-close-button close'>&times;</button>",form:"<form class='bootbox-form'></form>",inputs:{text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>"}},o=b("body"),p={locale:"en",backdrop:!0,animate:!0,className:null,closeButton:!0,show:!0},q={};q.alert=function(){var a;if(a=k("alert",["ok"],["message","callback"],arguments),a.callback&&!b.isFunction(a.callback))throw new Error("alert requires callback property to be a function when provided");return a.buttons.ok.callback=a.onEscape=function(){return b.isFunction(a.callback)?a.callback():!0},q.dialog(a)},q.confirm=function(){var a;if(a=k("confirm",["cancel","confirm"],["message","callback"],arguments),a.buttons.cancel.callback=a.onEscape=function(){return a.callback(!1)},a.buttons.confirm.callback=function(){return a.callback(!0)},!b.isFunction(a.callback))throw new Error("confirm requires a callback");return q.dialog(a)},q.prompt=function(){var a,d,e,f,h,i,k;if(f=b(n.form),d={className:"bootbox-prompt",buttons:l("cancel","confirm"),value:"",inputType:"text"},a=m(j(d,arguments,["title","callback"]),["cancel","confirm"]),i=a.show===c?!0:a.show,a.message=f,a.buttons.cancel.callback=a.onEscape=function(){return a.callback(null)},a.buttons.confirm.callback=function(){var c;switch(a.inputType){case"text":case"email":case"select":c=h.val();break;case"checkbox":var d=h.find("input:checked");c=[],g(d,function(a,d){c.push(b(d).val())})}return a.callback(c)},a.show=!1,!a.title)throw new Error("prompt requires a title");if(!b.isFunction(a.callback))throw new Error("prompt requires a callback");if(!n.inputs[a.inputType])throw new Error("invalid prompt type");switch(h=b(n.inputs[a.inputType]),a.inputType){case"text":case"email":h.val(a.value);break;case"select":var o={};if(k=a.inputOptions||[],!k.length)throw new Error("prompt with select requires options");g(k,function(a,d){var e=h;if(d.value===c||d.text===c)throw new Error("given options in wrong format");d.group&&(o[d.group]||(o[d.group]=b("<optgroup/>").attr("label",d.group)),e=o[d.group]),e.append("<option value='"+d.value+"'>"+d.text+"</option>")}),g(o,function(a,b){h.append(b)}),h.val(a.value);break;case"checkbox":var p=b.isArray(a.value)?a.value:[a.value];if(k=a.inputOptions||[],!k.length)throw new Error("prompt with checkbox requires options");if(!k[0].value||!k[0].text)throw new Error("given options in wrong format");h=b("<div/>"),g(k,function(c,d){var e=b(n.inputs[a.inputType]);e.find("input").attr("value",d.value),e.find("label").append(d.text),g(p,function(a,b){b===d.value&&e.find("input").prop("checked",!0)}),h.append(e)})}return a.placeholder&&h.attr("placeholder",a.placeholder),f.append(h),f.on("submit",function(a){a.preventDefault(),e.find(".btn-primary").click()}),e=q.dialog(a),e.off("shown.bs.modal"),e.on("shown.bs.modal",function(){h.focus()}),i===!0&&e.modal("show"),e},q.dialog=function(a){a=h(a);var c=b(n.dialog),d=c.find(".modal-body"),f=a.buttons,i="",j={onEscape:a.onEscape};if(g(f,function(a,b){i+="<button data-bb-handler='"+a+"' type='button' class='btn "+b.className+"'>"+b.label+"</button>",j[a]=b.callback}),d.find(".bootbox-body").html(a.message),a.animate===!0&&c.addClass("fade"),a.className&&c.addClass(a.className),a.title&&d.before(n.header),a.closeButton){var k=b(n.closeButton);a.title?c.find(".modal-header").prepend(k):k.css("margin-top","-10px").prependTo(d)}return a.title&&c.find(".modal-title").html(a.title),i.length&&(d.after(n.footer),c.find(".modal-footer").html(i)),c.on("hidden.bs.modal",function(a){a.target===this&&c.remove()}),c.on("shown.bs.modal",function(){c.find(".btn-primary:first").focus()}),c.on("escape.close.bb",function(a){j.onEscape&&e(a,c,j.onEscape)}),c.on("click",".modal-footer button",function(a){var d=b(this).data("bb-handler");e(a,c,j[d])}),c.on("click",".bootbox-close-button",function(a){e(a,c,j.onEscape)}),c.on("keyup",function(a){27===a.which&&c.trigger("escape.close.bb")}),o.append(c),c.modal({backdrop:a.backdrop,keyboard:!1,show:!1}),a.show&&c.modal("show"),c},q.setDefaults=function(){var a={};2===arguments.length?a[arguments[0]]=arguments[1]:a=arguments[0],b.extend(p,a)},q.hideAll=function(){b(".bootbox").modal("hide")};var r={br:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Sim"},da:{OK:"OK",CANCEL:"Annuller",CONFIRM:"Accepter"},de:{OK:"OK",CANCEL:"Abbrechen",CONFIRM:"Akzeptieren"},en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},es:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Aceptar"},fi:{OK:"OK",CANCEL:"Peruuta",CONFIRM:"OK"},fr:{OK:"OK",CANCEL:"Annuler",CONFIRM:"D'accord"},it:{OK:"OK",CANCEL:"Annulla",CONFIRM:"Conferma"},nl:{OK:"OK",CANCEL:"Annuleren",CONFIRM:"Accepteren"},no:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},pl:{OK:"OK",CANCEL:"Anuluj",CONFIRM:"Potwierdź"},ru:{OK:"OK",CANCEL:"Отмена",CONFIRM:"Применить"},zh_CN:{OK:"OK",CANCEL:"取消",CONFIRM:"确认"},zh_TW:{OK:"OK",CANCEL:"取消",CONFIRM:"確認"}};return q.init=function(c){window.bootbox=a(c||b)},q}(window.jQuery);
     
$('body').keyup(function(e) { 
    if (e.keyCode == 27)
        bootbox.hideAll()
});  
;
jQuery.fn.extend({
    customSerialize: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serialize();
    },
    customSerializeArray: function() {
      var form =  '<form>'+$(this).html()+'</form>';
      return $( form ).serializeArray();
    }
});

//window.location.href = "http://m.alebrunch-chedonna.it/app_dev.php/news/3/care_mamme_lavoratrici_ecco_10_trucchi_per_organizzare_la_casa"
;

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
    $( 'body' ).on( 'click', '[lgt]', function() {
        that.openJsLink( this);
    });
};

ManagerLinks.prototype.openJsLink = function ( sender ) {    
    
    var a = $( sender ).attr( 'lgt' ).substr( 5 );
    var b = a.substr( 0, ( a.length - 5 ) ); b;
    
    if( $( sender ).attr( 'target' ) == '_blank')
        window.open( atob( b ), '_blank');
    else
        window.location.href = atob( b );    
};

/**
 * Apre il link recuperandolo da un figlio de contenitore padre
 * @param {type} sender
 * @returns {undefined}
 */
ManagerLinks.prototype.openCopyLink = function ( sender ) {
    window.location.href = $( sender ).closest( '[data-urlCopyFather]' ).find( '[data-urlCopy]' ).attr( 'href' );
};


managerLinks = null;
managerLinks = new ManagerLinks();

;
/*!
 * Bootstrap v3.3.7 (http://getbootstrap.com)
 * Copyright 2011-2017 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */

/*!
 * Generated using the Bootstrap Customizer (http://getbootstrap.com/customize/?id=8aee7f2f3ef7d035c87fdca479c4f279)
 * Config saved to config.json and https://gist.github.com/8aee7f2f3ef7d035c87fdca479c4f279
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1||e[0]>3)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")}(jQuery),+function(t){"use strict";function e(e,i){return this.each(function(){var s=t(this),n=s.data("bs.modal"),r=t.extend({},o.DEFAULTS,s.data(),"object"==typeof e&&e);n||s.data("bs.modal",n=new o(this,r)),"string"==typeof e?n[e](i):r.show&&n.show(i)})}var o=function(e,o){this.options=o,this.$body=t(document.body),this.$element=t(e),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,t.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};o.VERSION="3.3.7",o.TRANSITION_DURATION=300,o.BACKDROP_TRANSITION_DURATION=150,o.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},o.prototype.toggle=function(t){return this.isShown?this.hide():this.show(t)},o.prototype.show=function(e){var i=this,s=t.Event("show.bs.modal",{relatedTarget:e});this.$element.trigger(s),this.isShown||s.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',t.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){i.$element.one("mouseup.dismiss.bs.modal",function(e){t(e.target).is(i.$element)&&(i.ignoreBackdropClick=!0)})}),this.backdrop(function(){var s=t.support.transition&&i.$element.hasClass("fade");i.$element.parent().length||i.$element.appendTo(i.$body),i.$element.show().scrollTop(0),i.adjustDialog(),s&&i.$element[0].offsetWidth,i.$element.addClass("in"),i.enforceFocus();var n=t.Event("shown.bs.modal",{relatedTarget:e});s?i.$dialog.one("bsTransitionEnd",function(){i.$element.trigger("focus").trigger(n)}).emulateTransitionEnd(o.TRANSITION_DURATION):i.$element.trigger("focus").trigger(n)}))},o.prototype.hide=function(e){e&&e.preventDefault(),e=t.Event("hide.bs.modal"),this.$element.trigger(e),this.isShown&&!e.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),t(document).off("focusin.bs.modal"),this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),t.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",t.proxy(this.hideModal,this)).emulateTransitionEnd(o.TRANSITION_DURATION):this.hideModal())},o.prototype.enforceFocus=function(){t(document).off("focusin.bs.modal").on("focusin.bs.modal",t.proxy(function(t){document===t.target||this.$element[0]===t.target||this.$element.has(t.target).length||this.$element.trigger("focus")},this))},o.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",t.proxy(function(t){27==t.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},o.prototype.resize=function(){this.isShown?t(window).on("resize.bs.modal",t.proxy(this.handleUpdate,this)):t(window).off("resize.bs.modal")},o.prototype.hideModal=function(){var t=this;this.$element.hide(),this.backdrop(function(){t.$body.removeClass("modal-open"),t.resetAdjustments(),t.resetScrollbar(),t.$element.trigger("hidden.bs.modal")})},o.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},o.prototype.backdrop=function(e){var i=this,s=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var n=t.support.transition&&s;if(this.$backdrop=t(document.createElement("div")).addClass("modal-backdrop "+s).appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",t.proxy(function(t){return this.ignoreBackdropClick?void(this.ignoreBackdropClick=!1):void(t.target===t.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))},this)),n&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!e)return;n?this.$backdrop.one("bsTransitionEnd",e).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION):e()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var r=function(){i.removeBackdrop(),e&&e()};t.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",r).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION):r()}else e&&e()},o.prototype.handleUpdate=function(){this.adjustDialog()},o.prototype.adjustDialog=function(){var t=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&t?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!t?this.scrollbarWidth:""})},o.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},o.prototype.checkScrollbar=function(){var t=window.innerWidth;if(!t){var e=document.documentElement.getBoundingClientRect();t=e.right-Math.abs(e.left)}this.bodyIsOverflowing=document.body.clientWidth<t,this.scrollbarWidth=this.measureScrollbar()},o.prototype.setScrollbar=function(){var t=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",t+this.scrollbarWidth)},o.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)},o.prototype.measureScrollbar=function(){var t=document.createElement("div");t.className="modal-scrollbar-measure",this.$body.append(t);var e=t.offsetWidth-t.clientWidth;return this.$body[0].removeChild(t),e};var i=t.fn.modal;t.fn.modal=e,t.fn.modal.Constructor=o,t.fn.modal.noConflict=function(){return t.fn.modal=i,this},t(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(o){var i=t(this),s=i.attr("href"),n=t(i.attr("data-target")||s&&s.replace(/.*(?=#[^\s]+$)/,"")),r=n.data("bs.modal")?"toggle":t.extend({remote:!/#/.test(s)&&s},n.data(),i.data());i.is("a")&&o.preventDefault(),n.one("show.bs.modal",function(t){t.isDefaultPrevented()||n.one("hidden.bs.modal",function(){i.is(":visible")&&i.trigger("focus")})}),e.call(n,r,this)})}(jQuery)
;

/**
 * Classe per delle ClassModals
 */ 
var ClassModals = function() {	
    this.title = null;
    this.message = null;
    this.type = null;
    this.confirm = null;
    this.gritter = null;
    this.gritterConfirm = null;
    this.gritterNotConfirm = null;
    this.grittersResponse = null;
    this.grittersDismissed = null;
    this.callbackModals = null;
    this.prompt = null;
    this.buttons = null;
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori sui bottoni
 * @returns {void}
 */
ClassModals.prototype.initListeners = function() {
    var that = this;
    $( '[data-toggle="modals"]' ).click( function (){ that.setPatametersModals( this ); });
};

/**
 * Metodo che apre una notifica tramite una chiamata js
 * @param {array} parameters
 * @returns {void}
 */
ClassModals.prototype.openModals = function( parameters ) {
    this.type   = typeof parameters['type'] != 'undefined' ?  parameters['type'] : null;
    this.title   = typeof parameters['title'] != 'undefined' ?  parameters['title'] : null;
    this.message   = typeof parameters['message'] != 'undefined' ?  parameters['message'] : null;
    this.confirm   = typeof parameters['confirm'] != 'undefined' ?  parameters['confirm'] : null;
    this.gritters   = typeof parameters['gritters'] != 'undefined' ?  parameters['gritters'] : null;
    this.grittersConfirm   = typeof parameters['grittersConfirm'] != 'undefined' ?  parameters['grittersConfirm'] : null;
    this.grittersNotConfirm   = typeof parameters['grittersNotConfirm'] != 'undefined' ?  parameters['grittersNotConfirm'] : null;
    this.grittersResponse   = typeof parameters['grittersResponse'] != 'undefined' ?  parameters['grittersResponse'] : null;
    this.grittersDismissed   = typeof parameters['grittersDismissed'] != 'undefined' ?  parameters['grittersDismissed'] : null;
    this.callbackModals   = typeof parameters['callbackModals'] != 'undefined' ?  parameters['callbackModals'] : null;
    this.finalCallback  = typeof parameters['finalCallback'] != 'undefined' ?  parameters['finalCallback'] : null;
    this.prompt   = typeof parameters['prompt'] != 'undefined' ?  parameters['prompt'] : null;
    this.buttons   = typeof parameters['buttons'] != 'undefined' ?  parameters['buttons'] : null;      
    
    if( this.type == null )
        return;
    
    switch( this.type ) {
        case 'alert':
            this.modalsAlert();
        break;
        case 'confirm':
            this.modalsConfirm();
        break;
        case 'prompt':
            this.modalsPrompt();
        break;
        case 'custom':
            this.modalsCustom();
        break;
    }
    
};

/**
 * Metodo che apre il Modals alert
 * @returns {undefined}
 */
ClassModals.prototype.modalsAlert = function() {
    var that = this;
    bootbox.alert( this.title, function( result ) {
        if( that.gritters != null )    
            that.addGritters( that.gritters );
        
        if( that.callbackModals != null )
            that.callbackModals();
        
    });
};
//Example
//var modals = {
//    type : 'alert',
//    title : 'ciao a tutti',                            
//    gritters: {
//        0:{ title: 'prova1', text:'prova2' }
//    }
//}
//classModals.openModals( modals );


/**
 * Metodo che aggiunge un modals di conferma
 * @returns {Boolean}
 */
ClassModals.prototype.modalsConfirm = function() {
    var that = this;
    
    if( this.confirm == null )
        return false;
    
    bootbox.confirm( this.confirm, function( result ) {
        if( result ) {
            if( that.finalCallback != null )
                that.runFinalCallback();
            
            if( that.callbackModals != null )
                that.callbackModals();
                
            if( that.grittersConfirm != null ) {                
                that.addGritters( that.grittersConfirm );
            }
        } else {
            if( that.grittersNotConfirm != null )    
                that.addGritters( that.grittersNotConfirm );
        }        
    });
};
//Example:
//var modals = {
//    type : 'confirm',
//    confirm : 'Confermi la cancellazione',                            
//    grittersConfirm: {
//        0:{ title: 'Hai confermato la cancellazione', text:'la foto è stata rimossa' }
//    },
//    grittersNotConfirm: {
//        0:{ title: 'Non hai confermato la cancellazione', text:'la foto non è stata rimossa' }
//    },
//    callbackConfirm: function(){alert('ha confermato')}
//}
//classModals.openModals( modals );


/**
 * Metodo che aggiunge un modals di conferma
 * @returns {Boolean}
 */
ClassModals.prototype.modalsPrompt = function() {
    var that = this;
    if( this.prompt == null )
        return false;
    
    bootbox.prompt( this.prompt, function(result) {                
        if (result === null) {                                             
            if( that.grittersDismissed != null )    
                that.addGritters( that.grittersDismissed );                            
        } else {
            if( that.grittersResponse != null ) {
                if( that.callbackModals != null )
                    that.callbackModals( result );
                that.addGritters( that.grittersResponse, result );
            }                          
        }
    });
};

ClassModals.prototype.modalsCustom = function( gritters, result ) {
    var that = this;
    bootbox.dialog({        
        title: this.title,
        message: this.callbackModals
    });    
    
    setTimeout(function() {
        that.runFinalCallback();
    }, 1000);
    
};

ClassModals.prototype.runFinalCallback = function( gritters, result ) {    
    if( this.finalCallback != null ) {
        if( typeof this.finalCallback != 'undefined' ) {
            if( typeof this.finalCallback.params != 'undefined' ) {                
                this.finalCallback.call( this.finalCallback.params[0] );
            } else {
                this.finalCallback.call();
            }
        }
    }
};

//Metodo che aggiunge un gritter
ClassModals.prototype.addGritters = function( gritters, result ) {
    var res = typeof result != 'undefined' ? result : '';
    
    $.each( gritters, function( key, value ) {
        var title = typeof value['title'] != 'undefined' ? value['title'] : '';
        var text = typeof value['text'] != 'undefined' ? value['text'] : '';
        
        $.gritter.add({
            title: title,
            text: text+' '+res
        });
    });    
};


//$(function()
//{
//
//
//	$('#modals-bootbox-custom').click(function()
//	{
//		bootbox.dialog({
//		  	message: "I am a custom dialog",
//		  	title: "Custom title",
//		  	buttons: {
//		    	success: {
//		      		label: "Success!",
//		      		className: "btn-success",
//		      		callback: function() {
//		        		$.gritter.add({
//							title: 'Callback!',
//							text: "Great success"
//						});
//		      		}
//		    	},
//			    danger: {
//			      	label: "Danger!",
//			      	className: "btn-danger",
//			      	callback: function() {
//			        	$.gritter.add({
//							title: 'Callback!',
//							text: "Uh oh, look out!"
//						});
//			      	}
//			    },
//			    main: {
//			      	label: "Click ME!",
//			      	className: "btn-primary",
//			      	callback: function() {
//			        	$.gritter.add({
//							title: 'Callback!',
//							text: "Primary button!"
//						});
//			      	}
//			    }
//			}
//		});
//	});
//});
classModals = null;
classModals = new ClassModals()
;
var Core = null;

;
(function ($) {
    "use strict";

    $.fn.exists = function () {
        return this.length > 0;
    };

    var $template_var = $('body').attr('class'),
            $color_primary = '#ffdc11',
            $main_nav = $('.main-nav'),
            $post_fitRows = $('.post-grid--fitRows'),
            $post_masonry = $('.post-grid--masonry'),
            $post_masonry_filter = $('.post-grid--masonry-filter'),
            $slick_featured_slider = $('.posts--slider-featured'),
            $slick_featured_carousel = $('.featured-carousel'),
            $slick_video_carousel = $('.video-carousel'),
            $slick_team_roster = $('.team-roster--slider'),
            $slick_awards = $('.awards--slider'),
            $slick_player_info = $('.player-info'),
            $slick_product = $('.product__slider'),
            $slick_product_soccer = $('.product__slider-soccer'),
            $slick_team_roster_card = $('.team-roster--card-slider'),
            $slick_team_roster_case = $('.team-roster--case-slider'),
            $slick_hero_slider = $('.hero-slider'),
            $content_filter = $('.content-filter'),
            $marquee = $('.marquee')
            ;

    if ($template_var == 'template-soccer') {
        $color_primary = '#1892ed';
    } else if ($template_var == 'template-football') {
        $color_primary = '#f92552';
    }

    Core = {

        initialize: function () {
            var that = this;
            this.headerNav();//menu dx
            this.SlickCarousel();//carosello piccolo
            this.InitSearch();

            setTimeout(function () {
                that.isotope();
            }, 100);
            setTimeout(function () {
                that.InitHeroSlider();//carosello Grande
            }, 5000);

        },

        InitSearch: function () {
            $('.searchArticlesIcon').click(
                    function (event) {
                        $('.formSearchArticles').toggle();
                        event.preventDefault();
                        event.stopPropagation();
                    }
            );
            $('.searchArticlesInput, .searchArticleButton, .formSearchArticles select').click(
                    function (event) {
//                event.preventDefault();
                        event.stopPropagation();
                    }
            );


            $('body').click(
                    function () {
                        if ($('.formSearchArticles').css('display') == 'block')
                            $('.formSearchArticles').toggle();
                    }
            );
        },

        headerNav: function () {
            if ($main_nav.exists()) {

                var $top_nav = $('.nav-account'),
                        $top_nav_li = $('.nav-account > li'),
                        $social = $('.social-links--main-nav'),
                        $info_nav_li = $('.info-block--header > li'),
                        $wrapper = $('.site-wrapper'),
                        $nav_list = $('.main-nav__list'),
                        $nav_list_li = $('.main-nav__list > li'),
                        $toggle_btn = $('#header-mobile__toggle'),
                        $pushy_btn = $('.pushy-panel__toggle');

                if (isMobile) {
                    // Clone Search Form
                    var $header_search_form = $('.header-search-form').clone();
                    $('#header-mobile').append($header_search_form);

                    // Clone Shopping Cart to Mobile Menu
                    var $shop_cart = $('.info-block__item--shopping-cart > .info-block__link-wrapper').clone();
                    $shop_cart.appendTo($nav_list).wrap('<li class="main-nav__item--shopping-cart"></li>');

                    // Clone Top Bar menu to Main Menu
                    if ($top_nav.exists()) {
                        var children = $top_nav.children().clone();
                        $nav_list.append(children);
                    }

                    // Clone Header Logo to Mobile Menu
                    var $logo_mobile = $('.header-mobile__logo').clone();
                    $nav_list.prepend($logo_mobile);
                    $logo_mobile.prepend('<span class="main-nav__back"></span>');

                    // Clone Header Info to Mobile Menu
                    var header_info1 = $('.info-block__item--contact-primary').clone();
                    var header_info2 = $('.info-block__item--contact-secondary').clone();
                    $nav_list.append(header_info1).append(header_info2);

                    // Clone Social Links to Main Menu
                    if ($social.exists()) {
                        var social_li = $social.children().clone();
                        var social_li_new = social_li.contents().unwrap();
                        social_li_new.appendTo($nav_list).wrapAll('<li class="main-nav__item--social-links"></li>');
                    }

                    // Add arrow and class if Top Bar menu ite has submenu
                    $top_nav_li.has('ul').addClass('has-children');

                    // Add arrow and class if Info Header Nav has submenu
                    $info_nav_li.has('ul').addClass('has-children');

                    // Mobile Menu Toggle
                    $toggle_btn.on('click', function () {
                        $wrapper.toggleClass('site-wrapper--has-overlay');
                    });

                    $('.site-overlay, .main-nav__back').on('click', function () {
                        $wrapper.toggleClass('site-wrapper--has-overlay');
                    });
                }

                // Pushy Panel Toggle
                $pushy_btn.on('click', function (e) {
                    e.preventDefault();
                    $wrapper.toggleClass('site-wrapper--has-overlay-pushy');
                });

                $('.site-overlay, .pushy-panel__back-btn').on('click', function (e) {
                    e.preventDefault();
                    $wrapper.removeClass('site-wrapper--has-overlay-pushy site-wrapper--has-overlay');
                });

                // Add toggle button and class if menu has submenu
                $nav_list_li.has('.main-nav__sub').addClass('has-children').prepend('<span class="main-nav__toggle"></span>');
                $nav_list_li.has('.main-nav__megamenu').addClass('has-children').prepend('<span class="main-nav__toggle"></span>');

                $('.main-nav__toggle').on('click', function () {
                    $(this).toggleClass('main-nav__toggle--rotate')
                            .parent().siblings().children().removeClass('main-nav__toggle--rotate');

                    $(".main-nav__sub, .main-nav__megamenu").not($(this).siblings('.main-nav__sub, .main-nav__megamenu')).slideUp('normal');
                    $(this).siblings('.main-nav__sub').slideToggle('normal');
                    $(this).siblings('.main-nav__megamenu').slideToggle('normal');
                });

                // Add toggle button and class if submenu has sub-submenu
                $('.main-nav__list > li > ul > li').has('.main-nav__sub-2').addClass('has-children').prepend('<span class="main-nav__toggle-2"></span>');
                $('.main-nav__list > li > ul > li > ul > li').has('.main-nav__sub-3').addClass('has-children').prepend('<span class="main-nav__toggle-2"></span>');

                $('.main-nav__toggle-2').on('click', function () {
                    $(this).toggleClass('main-nav__toggle--rotate');
                    $(this).siblings('.main-nav__sub-2').slideToggle('normal');
                    $(this).siblings('.main-nav__sub-3').slideToggle('normal');
                });

                // Mobile Search
                $('#header-mobile__search-icon').on('click', function () {
                    $(this).toggleClass('header-mobile__search-icon--close');
                    $('.header-mobile').toggleClass('header-mobile--expanded');
                });
            }
        },

        isotope: function () {

            if ($post_masonry.exists() && !isMobile) {
                var $masonry = $post_masonry.imagesLoaded(function () {
                    // init Isotope after all images have loaded
                    $masonry.isotope({
                        itemSelector: '.post-grid__item',
                        layoutMode: 'masonry',
                        percentPosition: false,

                        masonry: {
                            columnWidth: '.post-grid__item'
                        }
                    });
                    $('.widget_PostGrid .col-sm-4').css('paddingLeft', '10px');

                });
            }

            if ($post_masonry_filter.exists()) {
                var $masonry_grid = $post_masonry_filter.imagesLoaded(function () {

                    var $filter = $('.js-category-filter');

                    // init Isotope after all images have loaded
                    $masonry_grid.isotope({
                        filter: '*',
                        itemSelector: '.post-grid__item',
                        layoutMode: 'masonry',
                        masonry: {
                            columnWidth: '.post-grid__item'
                        }
                    });

                    // filter items on button click
                    $filter.on('click', 'button', function () {
                        var filterValue = $(this).attr('data-filter');
                        $filter.find('button').removeClass('category-filter__link--active');
                        $(this).addClass('category-filter__link--active');
                        $masonry_grid.isotope({
                            filter: filterValue
                        });
                    });
                });
            }

        },

        SlickCarousel: function () {


            // Featured News Slider
            if ($slick_featured_slider.exists()) {

                $slick_featured_slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false
                            }
                        }
                    ]
                });
            }




        },

        InitHeroSlider: function () {
            // Hero Slider
            if ($slick_hero_slider.exists()) {

                $slick_hero_slider.slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    fade: true,
                    autoplay: true,
                    centerMode: true,
                    autoplaySpeed: 5000,
                    asNavFor: '.hero-slider-thumbs',

                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                fade: false,
                            }
                        }
                    ]
                });
                $('.hero-slider-thumbs').slick({
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    asNavFor: $slick_hero_slider,
                    focusOnSelect: true,
                });
            }
            ;
        },

        ResetHeroSlider: function () {

        },

        ContentFilter: function () {

            if ($content_filter.exists()) {
                $('.content-filter__toggle').on('click', function (e) {
                    e.preventDefault();
                    $(this).toggleClass('content-filter__toggle--active');
                    $('.content-filter__list').toggleClass('content-filter__list--expanded');
                });
            }

        }

    };

})(jQuery);


function initIsoTop() {
    Core.initialize();
}

initIsoTop()
;
main = null;
/**
 * Classe per la gestione della homepage
 */ 
var Main = function() {   
    this.initListeners();        
};

/**
 * Metodo che avvia gli ascoltatori
 */
Main.prototype.initListeners = function() {
    var that = this;
        
    if( getReserverMsg == 1 ) {
        var params = { 
            type: 'custom', 
            title: 'Benvenuto su IlDemolitore.it' ,
            callbackModals: '\
            <div class="containerMsg">\
                <div class="containerMsg">\
                    <div>\
                        <label>Siamo spiacenti, ma la sezione da te scelta è accessibile solo agli utenti registratri!</label>\
                    </div>\
                </div>\
                    <div class="containerForm">\
                    <form id="formLogin" class="login-form" data-formLogin>\
                        <div class="form__row">\
                            <div>\
                                <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">\
                            </div>\
                            <div>\
                                <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">\
                            </div>\
                            <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>\
                            <div class="form__row form__row--m-login">\
                                <div>\
                                    <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">\
                                </div>\
                                <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>\
                            </div>\
                        </div>\
                    </form>\
                </div>\
                <div>\
                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">\
                </div>\
                <div>\
                    <input class="googleLogin button button--fill button--big" data-GoogleLogin type="submit" value="Accedi con Google">\
                </div>\
            </div>'
            };
        classModals.openModals( params );    
    }
    if( getReserverMsg == 2 ) {
        var params = { 
            type: 'custom', 
            title: 'Benvenuto su IlDemolitore.it' ,
            callbackModals: '\
            <div class="containerMsg">\
                <div class="containerMsg">\
                    <div>\
                        Siamo spiacenti, ma la sezione da te scelta è accessibile solo agli utenti autorizzati dal Demolitore!\
                    </div>\
                    <br>\
                    <br>\
                    <div class="containerEmail">\
                        <div>Contatta Il Demolitore a questa email <label class="demoMail"> '+ demoEmail +'</label></div>\
                    </div>\
                </div>\
            </div>'
            };
        classModals.openModals( params );    
    }
//    this.trackGAClickEvent( 'totalViews', versionSite, page );
}; 


/**
 * Metodo che traccia gli eventi su analytics
 */
Main.prototype.trackGAClickEvent = function ( category, action, opt_label, optValue ) {
	if ( typeof category == "undefined" || typeof action == "undefined" || typeof opt_label == "undefined" ) {
		return false;
	}
    
	if ( typeof ga == "undefined" ) {
		return false;
	}
    

	if ( typeof( ga ) != 'undefined' && category != null && action ) {
        ga('send', 'event', category, action, opt_label, 4);
        console.info( typeof( ga )  );
	}
	return true;
};


/**
 * Metodo che avvia il lazy sulle immagini
 * @param {string} container
 * @returns {void}
 */
Main.prototype.lazy = function ( container ) {
    if( typeof container == 'undefined' )
        container = '';
    
    if( typeof unveil != 'undefined' ) {
        $( container + " .lazy" ).unveil( 300, function() {
            $( this ).load( function() {
                this.style.opacity = 1;
            });
        });
    }
};

Main.prototype.appDownload = function (sender, type) {
    
    var millisec = 24*60*60*1000;
    if (type == 'close') {
        $(sender).closest(".widget_TopAppDownload").slideUp('slow');    
        this.setCookie("appDownload", 1, millisec);
    } else  {
        var uagent = navigator.userAgent.toLowerCase();
        this.setCookie("appDownload", 1, millisec);
        
        if (uagent.search( "iphone" ) > -1) {   
            window.location.href = encodeURI(urlIosStore);

        } else if (uagent.search( "android" ) > -1) {  
            window.location.href = urlPlayStore;
        }  
    }
};


Main.prototype.setCookie = function ( name,value,millisec ) {
    if (millisec) {
        var date = new Date();
        date.setTime(date.getTime()+(millisec));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
};

Main.prototype.getCookie = function (name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
};

Main.prototype.unsetCookie = function (name) {
    this.setCookie(name,"",-1);
};


Main.prototype.openDataIntLink = function (url) {
    window.location.href = url;
};


/**
 * Controlla se il dispositivo è un mobile, e se l'utente rispre il broswer che era andato in standby ricarica la pagina per
 * prendere gli aggiornamento che sono passati mentre ilmobile era in blocco
 * @param {type} $
 * @returns {undefined}
 */
(function($){$.winFocus||($.extend({winFocus:function(){var a=!0,b=[];$(document).data("winFocus")||$(document).data("winFocus",$.winFocus.init());for(x in arguments)"object"==typeof arguments[x]?(arguments[x].blur&&$.winFocus.methods.blur.push(arguments[x].blur),arguments[x].focus&&$.winFocus.methods.focus.push(arguments[x].focus),arguments[x].blurFocus&&$.winFocus.methods.blurFocus.push(arguments[x].blurFocus),arguments[x].initRun&&(a=arguments[x].initRun)):"function"==typeof arguments[x]?b.push(arguments[x]):
"boolean"==typeof arguments[x]&&(a=arguments[x]);b&&(1==b.length?$.winFocus.methods.blurFocus.push(b[0]):($.winFocus.methods.blur.push(b[0]),$.winFocus.methods.focus.push(b[1])));if(a)$.winFocus.methods.onChange()}}),$.winFocus.init=function(){$.winFocus.props.hidden in document?document.addEventListener("visibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="mozHidden")in document?document.addEventListener("mozvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden=
"webkitHidden")in document?document.addEventListener("webkitvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="msHidden")in document?document.addEventListener("msvisibilitychange",$.winFocus.methods.onChange):($.winFocus.props.hidden="onfocusin")in document?document.onfocusin=document.onfocusout=$.winFocus.methods.onChange:window.onpageshow=window.onpagehide=window.onfocus=window.onblur=$.winFocus.methods.onChange;return $.winFocus},$.winFocus.methods={blurFocus:[],blur:[],focus:[],
exeCB:function(a){$.winFocus.methods.blurFocus&&$.each($.winFocus.methods.blurFocus,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a,!a.hidden])});a.hidden&&$.winFocus.methods.blur&&$.each($.winFocus.methods.blur,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a])});!a.hidden&&$.winFocus.methods.focus&&$.each($.winFocus.methods.focus,function(b,c){"function"==typeof this&&this.apply($.winFocus,[a])})},onChange:function(a){var b={focus:!1,focusin:!1,pageshow:!1,blur:!0,
focusout:!0,pagehide:!0};if(a=a||window.event)a.hidden=a.type in b?b[a.type]:document[$.winFocus.props.hidden],$(window).data("visible",!a.hidden),$.winFocus.methods.exeCB(a);else try{$.winFocus.methods.onChange.call(document,new Event("visibilitychange"))}catch(c){}}},$.winFocus.props={hidden:"hidden"});})(jQuery);

$(function() {    
    if ( /Mobi/.test( navigator.userAgent ) ) {
	$.winFocus( function( event, isVisible ) {		
            if( isVisible == true ) {
//                window.location.reload(1);
//                window.location.href = window.location.href;
            }		
            
	}, false );   
    }
});

var main = null;
main = new Main();

;

/**
 * Classe per la gestione della homepage
 */
var WidgetArticle = function () {
    var that = this;
    this.initListeners();
    
        if( typeof SpeechSynthesisUtterance == 'function' ) {
        var msg = new SpeechSynthesisUtterance();
        var voices = window.speechSynthesis.getVoices();
        
        msg.voice = voices[21]; // Note: some voices don't support altering params
        msg.voiceURI = 'native';
        msg.volume = 0.5; // 0 to 1
        msg.rate = 10; // 0.1 to 10
        msg.pitch = 0; //0 to 2
        msg.text = 'buongiorno a tutti totti a smesso di giocare a pallone';
        msg.lang = 'it-IT';                             
    }
    
    speechSynthesis.cancel();
    $( '#speakNews #play' ).click( function() {
        that.speakSite( $( '.widget_Article #contentArticleBody').html() );
        $( '#speakNews #play' ).hide();
        $( '#speakNews #pause' ).show();
    });
    $( '#speakNews #pause' ).click( function() {
        $( '#speakNews #pause' ).hide();
        $( '#speakNews #resume' ).show();
        speechSynthesis.pause();
    });
    $( '#speakNews #resume' ).click( function() {
        $( '#speakNews #resume' ).hide();
        $( '#speakNews #pause' ).show();
        speechSynthesis.resume();
    });
};

WidgetArticle.prototype.parseHtmlEntities = function ( str ) {
    return str.replace(/&#([0-9]{1,3});/gi, function(match, numStr) {
        var num = parseInt(numStr, 10);
        return String.fromCharCode(num);
    });
};

WidgetArticle.prototype.speakSite = function ( speak ) {
    speechSynthesis.cancel();
    
    speak = speak.toLowerCase();
    
    speak = this.parseHtmlEntities(  speak.replace( /<.*?>/g, '' ));
    speak = speak
            .replace( '&agrave', 'à' )
            .replace( '&eacute', 'é' )
            .replace( '&egrave', 'è' )
            .replace( '&igrave', 'ì' )
            .replace( '&ograve', 'ò' )
            .replace( '&ugrave', 'ù' )
            .replace( 'clicca qui per continuare a leggere', '' )
            .replace( '-', ',' )
            .replace( '/', ',' )
            .replace( '?', '?,' )
            .replace(/&nbsp;/gi,'')
            .replace(/\./g,',')
            .replace(/\//g,',')
            .replace(/\-/g,',');


    if( typeof SpeechSynthesisUtterance == 'function' ) {
       
        setTimeout( function() {
             var msg = new SpeechSynthesisUtterance();
            var voices = window.speechSynthesis.getVoices();
            msg.voice =  voices.filter(function(voice) { return voice.name == 'Luca'; })[0];

//            msg.voice = voices[21]; // Note: some voices don't support altering params
            msg.voiceURI = 'native';
            msg.volume = 0.5; // 0 to 1
            msg.rate = 10; // 0.1 to 10
            msg.pitch = 0; //0 to 2
            msg.text = speak;
            msg.lang = 'it-IT';       
            speechSynthesis.speak(msg);
            speechSynthesis.resume();
        },1000 );
    }
}

WidgetArticle.prototype.addLike = function ( ) {
    // Recupero il numero di Like
    var likes = $('[data-like]').attr('data-like');
    // Recupero l'id dell'articolo
    var articleId = $('[data-id]').attr('data-id');
    
    if (likes == '')
        likes = 0;
    
    var request = $.ajax ({
            url: "/ajax/addLike/"+articleId+"/"+likes,
            type: "GET",
            async: true,
            dataType: "json"        
         });
         // Richiesta andata a buon fine
         request.done( function( resp ) {
             if ( resp = 1 ) {
                 likes = parseInt(likes) + 1;
                 $('.meta__item--likes').find('div').text(likes);
                 $('[data-like]').attr('data-like', likes);
             }
        });
};
    
/**
 * Metodo che avvia gli ascoltatori
 */
WidgetArticle.prototype.initListeners = function () {
    var that = this;       
    
    $('#form_save' ).closest('.form-group').remove();
    
    $( 'body' ).on( 'click', '[data-like]', function ( e ) {
        that.addLike();
    });
};

var widgetArticle   = null;
widgetArticle       = new WidgetArticle();

;
/**
 * Classe per la gestione dei commenti
 */
var WidgetComment = function () {
    var that = this;
    this.initListeners();
};

/**
 * Metodo che gestisce l'inserimento del commento e la consecutiva stampa in pagina
 */
WidgetComment.prototype.addComment = function ( ) {
    // Recupero l'id dell'articolo
    var articleId = $('[data-id]').attr('data-id');
    var text = $('[data-msg="1"]').val();
    
    var request = $.ajax ({
            url: "/ajax/addComment/"+articleId+"/"+text,
            type: "GET",
            async: true,
            dataType: "html"        
         });
         request.done( function( resp ) {
            if ( $('[data-msg="1"]').hasClass('redBorder') )
                $('[data-msg="1"]').removeClass('redBorder');
             
            $('[data-msg="1"]').val('');
            if ( resp != 0 ) {
                var totComment = $('.widget_Comment').find('.post-comments').find('span').text();
                if ( totComment != "" ) {
                    $('.widget_Comment').find('.post-comments').find('span').text(parseInt(totComment)+1);
                    
                    $('.widget_Comment').find('.post-comments').removeClass('tot_0');
                    $('.widget_Comment').find('.post-comments').addClass('tot_1');
                }
                $( '.comments' ).prepend( resp );
            }
        });
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetComment.prototype.initListeners = function () {
    var that = this;       
    
    // al click faccio partire il flusso per i commenti
    $( 'body' ).on( 'click', '[data-submitcomment="1"]', function ( e ) {
        if ( $('[data-msg="1"]').val() == "" ) {
            $('[data-msg="1"]').addClass('redBorder');
            return false;
        }
        
        if (widgetUser.isLogged() != 1) {
            widgetUser.openPopupLogin();
        } else {
            if( $('[data-msg="1"]').hasClass('redBorder') )
                $('[data-msg="1"]').removeClass('redBorder');
            
            that.addComment();
        }
        
    });
};

var widgetComment   = null;
widgetComment       = new WidgetComment()
;

/**
 * Classe per la gestione del widget ImageArticle
 */
var MobileSlider = function () {    
    this.index = 1;
    this.totalLi = $( '[dataMobileSlider="1"] li' ).length;
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
MobileSlider.prototype.initListeners = function () {
    var that = this;    
    $( 'body' ).on( 'click', '[dataMobileSlider="1"] [data-btn="arrowL"]', function() {
        clearInterval( that.interval );
        that.changeSlider('-');
        that.initInterval();
    });
    $( 'body' ).on( 'click', '[dataMobileSlider="1"] [data-btn="arrowR"]', function() {
        clearInterval( that.interval );
        that.changeSlider('+');
        that.initInterval();
    });
      
    this.initInterval();
};

MobileSlider.prototype.initInterval = function () {
    var that = this;
    this.interval = setInterval( function() {
        that.changeSlider();
    }, 5000 );
};

MobileSlider.prototype.changeSlider = function ( type ) {
    $( '[dataMobileSlider="1"] li' ).hide();
    
    if( typeof type == 'undefined' || type == '+' ) {
        this.index = this.index+1 > this.totalLi ? 1 : this.index+1;
    } else {
        this.index = this.index-1 <= 0 ? this.totalLi : this.index-1;
    }
    $( '[dataMobileSlider="1"] li:nth-child('+this.index+')' ).show();
};


mobileSlider = null;
mobileSlider = new MobileSlider();

;
/**
 * notyfy - Yet another jQuery Notification Plugin v
 * 
 * Based on the original notyfy plugin: https://needim.github.com/notyfy/
 *
 * Examples and Documentation - http://craga89.github.com/notyfy/
 *
 * Licensed under the MIT licenses:
 * http://www.opensource.org/licenses/mit-license.php
 *
 **/
(function($) {

	function NotyfyObject(options) {
		var self = this;

		$.extend(self, {
			container: $('#notyfy_container_'+options.layout),
			closed: false,
			shown: false,

			_triggerEvent: function(type, args) {
				var callback = $.Event('notyfy'+type);
				self.wrapper.trigger(callback, [self].concat(args || []));
				return !callback.isDefaultPrevented();
			},

			_generateID: function() {
				var id; do{
					id = 'notyfy_' + (new Date().getTime() * Math.floor(Math.random() * 1000000)); 
				}
				while(document.getElementById(id));
				return id;
			},

			init: function() {
				var adjuster;

				// Mix in the passed in options with the default options
				self.options = $.extend({}, $.notyfy.defaults, { id: self._generateID() }, options);

				// Generate notyfy container ifneeded
				if(!self.container.length) {
					// Use custom container ifprovided
					if(options.custom) {
						self.container = options.custom.addClass('notyfy_container_inline');
					}

					// Otherwise create one using jQuery
					else {
						self.container = $('<ul />', {
							'id': 'notyfy_container_'+self.options.layout,
							'class': 'notyfy_container'
						})
						.appendTo(self.options.custom || document.body);
					}

					// Apply any layout adjuters on window resize
					if((adjuster = $.notyfy.layouts[self.options.layout])) {
						$(window).bind('resize.'+self.options.id, function(event) {
							adjuster.call(self.container);
						})
						.triggerHandler('resize.'+self.options.id);
					}

					// Add new class
					self.container.addClass('i-am-new');
				}

				// Not needed? Remove new class
				else { self.container.removeClass('i-am-new'); }

				// Build the notyfy dom initial structure
				self._build();

				return self;
			}, 

		 	_build: function() {
				// Generate notyfy bar
				var bar = $('<div />', {
					'id': self.options.id,
					'class': "notyfy_bar"
				})
				.append(self.options.template)
				.find('.notyfy_text')
				.html(self.options.text).end();

				// Generate notyfy container
				self.wrapper = $('<li />', {
					'class': ['notyfy_wrapper', 'notyfy_'+self.options.type].join(' ')
				}).hide().append(bar);

				// Apply theme class
				if(self.options.theme) { self.wrapper.addClass('notyfytheme_'+self.options.theme); }

				// Set buttons ifavailable
				if(self.options.buttons) {
					self.options.closeWith = [];
					self.options.timeout = false;

					self.buttons = $('<div/>', {
						'class': 'notyfy_buttons'
					})
					.appendTo( $('.notyfy_bar', self.wrapper) )
					.append(
						$.map(self.options.buttons, function(button, i) {
							return $('<button/>', {
								'class': button.addClass || 'gray',
								'html': button.text,
								'click': function() {
									if($.isFunction(button.onClick)) {
										button.onClick.call( $(this), self );
									}
								}
							})[0]
						})
					);
				}

				// Attach events
				$.each(self.options.events, function(event, callback) {
					if($.isFunction(callback)) {
						self.wrapper.bind('notyfy'+event, callback);
					}
				})

				// For easy access
				self.message = self.wrapper.find('.notyfy_message');
				self.closeButton = self.wrapper.find('.notyfy_close');

				// store notyfy for api
				$.notyfy.store[self.options.id] = self;
			},

			show: function(event) {
				// Append the container
				self.wrapper.appendTo(self.container);

				// Add close handlers to notyfy/buttons
				if($.inArray('click', self.options.closeWith) > -1) {
					self.wrapper.css('cursor', 'pointer').one('click', self.close);
				}
				if($.inArray('hover', self.options.closeWith) > -1) {
					self.wrapper.one('mouseenter', self.close);
				}
				if($.inArray('button', self.options.closeWith) > -1) {
					self.closeButton.one('click', self.close);
				}
				if($.inArray('button', self.options.closeWith) == -1) {
					self.closeButton.remove();
				}

				// Trigger show event
				self._triggerEvent('show');

				// After-animation methods
				function after() {
					self._triggerEvent('shown');
					self.shown = true;
				}

				// If an animation method was passed, use it and queue after()
				if($.isFunction(self.options.showEffect)) {
					self.wrapper.clearQueue().stop();
					self.options.showEffect.call(self, self.wrapper);
					self.wrapper.queue(after);
				}

				// Otherwise just invoke show() and after()
				else { self.wrapper.show(); after(); }

				// If notyfy is have a timeout option
				if(self.options.timeout) {
					clearTimeout(self._delay);
					self._delay = setTimeout(function() {
						self.close();
					}, parseInt(self.options.timeout, 10));
				}

				return self;

			},

			close: function(event) {
				if(self.closed) return;

				// If we are still waiting in the queue just delete from queue
				if(!self.shown) {
					$.notyfy.queue = $.map($.notyfy.queue, function(n ,i) {
						if(n.options.id != self.options.id) {
							return n;
						}
					});
					return;
				}

				// Add closing class
				self.wrapper.addClass('i-am-closing-now');

				// Trigger hide event
				self._triggerEvent('hide');

				function after() {
					// Trigger hidden event
					self._triggerEvent('hidden');

					// Modal Cleaning
					if(self.options.modal) { renderer.hideModalFor(self); }

					// Layout Cleaning
					renderer.setLayoutCountFor(self, -1);
					if(renderer.getLayoutCountFor(self) == 0) { self.wrapper.remove(); }

					// Make sure self.wrapper has not been removed before attempting to remove it
					if(typeof self.wrapper !== 'undefined' && self.wrapper !== null) {
						self.wrapper.remove();
						self.wrapper = null;
						self.closed = true;
					}

					// Delete notyfy reference from store
					delete $.notyfy.store[self.options.id]; 

					// Queue render
					if(!self.options.dismissQueue) {
						$.notyfy.ontap = true;
						renderer.render();
					}
				}

				// If an animation method was passed, use it and queue after()
				if($.isFunction(self.options.hideEffect)) {
					self.wrapper.clearQueue().stop();
					self.options.hideEffect.call(self, self.wrapper);
					self.wrapper.queue(after);
				}

				// Otherwise just invoke show() and after()
				else { self.wrapper.hide(); after(); }

			},

			setText: function(text) {
				if(!self.closed) {
					self.options.text = text;
					self.wrapper.find('.notyfy_text').html(text);
				}
				return self;
			},

			setType: function(type) {
				if(!self.closed) {
					self.options.type = type;
				}
				return self;
			}
		});

		self.init();
	};

	var renderer = $.notyfyRenderer = {
		_modal: $('<div/>', {
			'id': 'notyfy_modal', 
			'data': { 'notyfy_modal_count': 0 } 
		}),
		_modals: 0,

		init: function(options) {
			// Create new Noty
			var notyfy = new NotyfyObject(options);

			// Add it to the frontback of the queue depending on options
			$.notyfy.queue[notyfy.options.force ? 'unshift' : 'push'](notyfy);

			// Render the notyfy
			renderer.render();

			return notyfy;
		},

		render: function() {
			var instance = $.notyfy.queue[0];

			if($.type(instance) === 'object') {
				if(instance.options.dismissQueue) {
					renderer.show($.notyfy.queue.shift());
				} else {
					if($.notyfy.ontap) {
						renderer.show($.notyfy.queue.shift());
						$.notyfy.ontap = false;
					}
				}
			}

			// Queue is over
			else { $.notyfy.ontap = true; }
		},

		show: function(notyfy) {
			if(notyfy.options.modal) {
				renderer.createModalFor(notyfy);
				renderer.setModalCount(+1);
			}

			renderer.setLayoutCountFor(notyfy, +1);

			notyfy.show();
		},

		createModalFor: function(notyfy) {
			if(!renderer._modal[0].parentNode) {
				renderer._modal.prependTo(document.body).fadeIn('fast');
			}
		},

		hideModalFor: function(notyfy) {
			renderer.setModalCount(-1);

			if(renderer.getModalCount() == 0) {
				renderer._modal.fadeOut('fast', function() {
					renderer._modal.detach();
				});
			}
		},

		getLayoutCountFor: function(notyfy) {
			return notyfy.container.data('notyfy_layout_count') || 0;
		},

		setLayoutCountFor: function(notyfy, arg) {
			return notyfy.container.data('notyfy_layout_count', renderer.getLayoutCountFor(notyfy) + arg);
		},

		getModalCount: function() { return renderer._modals; },
		setModalCount: function(arg) { return (renderer._modals += arg); }
	};

	var win = $(window);

	$.notyfy = {
		ontap: true,
		queue: [],
		store: {},
		layouts: {
			center: function() {
				this[0].style.top = (win.height() / 2 - this.outerHeight() / 2) + 'px';
				this[0].style.left = (win.width() / 2 - this.outerWidth() / 2) + 'px';
			},
			centerLeft: function() {
				this[0].style.top = (win.height() / 2 - this.outerHeight() / 2) + 'px';
			},
			centerRight: function() {
				this[0].style.top = (win.height() / 2 - this.outerHeight() / 2) + 'px';
			},
			topCenter: function() {
				this[0].style.left = (win.width() / 2 - this.outerWidth() / 2) + 'px';
			},
			bottomCenter: function() {
				this[0].style.left = (win.width() / 2 - this.outerWidth() / 2) + 'px';
			}
		},

		get: function(id) {
			return $.notyfy.store.hasOwnProperty(id) ? $.notyfy.store[id] : false;
		},

		close: function(id) {
			return $.notyfy.get(id) ? $.notyfy.get(id).close() : false;
		},

		setText: function(id, text) {
			return $.notyfy.get(id) ? $.notyfy.get(id).setText(text) : false;
		},

		setType: function(id, type) {
			return $.notyfy.get(id) ? $.notyfy.get(id).setType(type) : false;
		},

		clearQueue: function() {
			$.notyfy.queue = [];
		},

		closeAll: function() {
			$.notyfy.clearQueue();
			$.each($.notyfy.store, function(id, notyfy) {
				notyfy.close();
			});
		},

		consumeAlert: function(options) {
			window.alert = function(text) {
				if(options) {
					options.text = text;
				}
				else {
					options = { text: text };
				}
				renderer.init(options);
			};
		},

		stopConsumeAlert: function() {
			delete window.alert;
		},

		defaults: {
			layout: 'top',
			theme: false,
			type: 'alert',
			text: '',
			dismissQueue: true,
			template: '<div class="notyfy_message notifySuccess"><span class="notyfy_text"></span><div class="notyfy_close"></div></div>',
			showEffect:  function(bar) { bar.animate({ height: 'toggle' }, 500, 'swing'); },
			hideEffect:  function(bar) { bar.animate({ height: 'toggle' }, 500, 'swing'); },
			timeout: false,
			force: false,
			modal: false,
			buttons: false,
			closeWith: ['click'],
			events: {
				show: null,
				hide: null,
				shown: null,
				hidden: null
			}
		}
	};

	// Helper method
	window.notyfy = function(options) {
		return renderer.init(options);
	}

	// This is for custom container
	$.fn.notyfy = function(options) {
		options.custom = $(this);
		return renderer.init(options);
	};

})(jQuery);

;


/**
 * Classe per delle notyfy
 */ 
var ClassNotyfy = function( noClose ) {	
    this.type = null;
    this.mex = null;
    this.confirm = null;
    this.cancel = null;
    this.layout = 'top';     
    this.popupNotify = null;
    this.noClose = typeof noClose != 'undefined' ? noClose : true;    
    this.initListeners();
}

/**
 * Metodo che avvia gli ascoltatori sui bottoni
 * @returns {void}
 */
ClassNotyfy.prototype.initListeners = function() {
    var that = this;
    $( '[data-toggle="notyfy"]' ).click( function (){ that.setPatametersNotyfy( this ); });
}

/**
 * Metodo che recupera i parametri necessari alla creazione della notifica dal bottone cliccato
 * @param {object} sender
 * @returns {void}
 */
ClassNotyfy.prototype.setPatametersNotyfy = function( sender ) {
    this.type    = typeof $( sender ).data( 'type' ) != 'undefined' ? $( sender ).data( 'type' ) : null;
    this.mex     = typeof $( sender ).data( 'mex' ) != 'undefined' ? $( sender ).data( 'mex' ) : null;
    this.confirm = typeof $( sender ).data( 'confirm' ) != 'undefined' ? $( sender ).data( 'confirm' ) : null;
    this.cancel  = typeof $( sender ).data( 'cancel' ) != 'undefined' ? $( sender ).data( 'cancel' ) : null;
    this.layout  = typeof $( sender ).data( 'layout' ) != 'undefined' ? $( sender ).data( 'layout' ) : null;
        
    if( this.type == null || this.mex == null )
        return;
    
    this.runNotyfy();
}

/**
 * Metodo che apre una notifica tramite una chiamata js
 * @param {array} parameters
 * @returns {void}
 */
ClassNotyfy.prototype.openNotyfy = function( parameters ) {
    this.type    = typeof parameters['type'] != 'undefined' ?  parameters['type'] : null;
    this.mex     = typeof parameters['mex'] != 'undefined' ?  parameters['mex'] : null;
    this.confirm = typeof parameters['confirm'] != 'undefined' ? parameters['confirm'] : null;
    this.cancel  = typeof parameters['cancel'] != 'undefined' ? parameters['cancel']  : null;
    this.layout  = typeof parameters['layout'] != 'undefined' ? parameters['layout']  : null;
    
    if( this.type == null || this.mex == null )
        return;
    
    this.runNotyfy();
};

/**
 * Metodo che gestisce l'apertura delle notifiche
 * @returns {void}
 */
ClassNotyfy.prototype.runNotyfy = function() {
    var that = this;
    
    if( this.popupNotify !== null ) {
        this.popupNotify.close();   
        setTimeout( function(){ that.open(); }, 1000 );
        setTimeout( function(){ that.popupNotify.close(); }, 5000 );
        return;
    }
    this.open();    
    setTimeout( function(){ that.popupNotify.close(); }, 5000 );
}

/**
 * Metodo che apre le notifiche
 * @returns {void}
 */
ClassNotyfy.prototype.open = function() {
    var that = this;
    this.popupNotify = notyfy({
        text: that.mex,
        type: that.type,
        dismissQueue: true,
        layout: that.layout,
        buttons: ( that.type != 'confirm' ) ? false : [{
            addClass: 'btn btn-success btn-small btn-icon glyphicons ok_2',
            text: '<i></i> Ok',
            onClick: function ( $notyfy ) {
                $notyfy.close();
                if( that.confirm == null )
                    return true;                    
                notyfy({
                    force: true,
                    text: that.confirm,
                    type: 'success',
                    layout: that.layout
                });
            }            
        }, {
            addClass: 'btn btn-danger btn-small btn-icon glyphicons remove_2',
            text: '<i></i> Cancel',
            onClick: function ( $notyfy ) {
                $notyfy.close();
                if( that.cancel == null )
                        return true;
                notyfy({
                    force: true,
                    text: that.cancel,
                    type: 'error',
                    layout: that.layout
                });
            }
        }]
    });    
};

classNotyfy = null;
classNotyfy = new ClassNotyfy()
;
/**
 * Classe per la gestione dei moduli del sito
 */
var Modules = function() {
    this.aModules = new Array();    
};

Modules.prototype.add = function ( widget, core, loadType, limit, category, varAttrAjax ) {
    this.aModules[widget] = {'widget':widget, 'core':core, 'loadType':loadType, 'limit':limit, 'category':category, 'varAttrAjax': varAttrAjax };     
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
            that.getAsync( that.aModules[item]['widget'], that.aModules[item]['core'], that.aModules[item]['limit'], that.aModules[item]['category'], that.aModules[item]['varAttrAjax'] );
        }
    }    
};

/**
 * Recupera il widget in modalita asicrona
 * @param {type} widget
 * @param {type} core
 * @returns {undefined}
 */
Modules.prototype.getAsync = function ( widget, core, limit, category, varAttrAjax ) {
    var that = this;
    var id = idNews;
    
    setTimeout( function() {
        that.getModule( widget, core, id, false, false, limit, category, varAttrAjax );
    }, 100 );
};

/**
 * Metodo che fa il replace con il contenuto del modulo
 * @param {type} module 
 * @returns {undefined}
 */
Modules.prototype.getModule = function ( widget, core, id, paramsExtra, callback, limit, category, varAttrAjax ) {
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
    
    var params = "widget="+widget+"&cores="+core+"&limit="+limit+"&category="+category+"&id="+id+paramsExtra+changeUrlForCacheIfIsMobile;
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

;
/**
 * Classe per la gestione del widget dei sondaggi
 */
var WidgetPoll = function () {
    this.widget            = $( ".widget_Poll" );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetPoll.prototype.initListeners = function () {
    if (window.location.pathname == '/all/list/polls')
            $('[data-pollLabel]').hide();
    
    var that = this;
    $( 'body' ).on( 'click', '[data-votePoll]', function ( e ) {
        that.votePoll( this );
    });
    
    $( 'body' ).on( 'click', '[data-resultPoll]', function ( e ) {
        that.resultPoll( this );
    });
    
    if( window.location.search != '' ) {
        var params = window.location.search.substring(1);
        var pollId = params.split('=');
        
        if( pollId[0] == 'idPoll' )
            this.openPopUpPoll( pollId[1] );
    }
    
    setTimeout( function() {
        Core.isotope();
    },500 );
};

/*
 * Metodo che mostra il risultato del sondaggio
 */
WidgetPoll.prototype.resultPoll = function ( sender, e ) {
    var that = this;
    var pollId = $(sender).attr('data-pollId');
    var key = "res";
    console.info(pollId);
    
    var request = $.ajax ({
        url: "/ajax/poll/"+pollId+"/"+key,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) { 
        $('[data-id='+ pollId +']').closest('div').replaceWith( resp );
         var poll = $('.modal-dialog').find( '.question' ).attr('data-id');
        
         if(typeof poll != 'undefined')
            $('.modal-dialog').find('[data-pollContainer]').replaceWith( resp );

        $('[data-id='+ pollId +']').closest('table').find('[data-resultPoll]').hide();
        $('[data-id='+ pollId +']').closest('.widget_Poll').find('[data-pollLabel]').hide();
    });
};


/*
 * Metodo che salva il sondaggio
 */
WidgetPoll.prototype.votePoll = function ( sender ) {
    var that = this;
    var pollId = $( sender ).attr('data-pollId');
    var key = null;
    
    $( '.check' ).each( function () {
        if (this.checked) {
            key = $( this ).attr('data-key');
        }
    });
    
    if( key == null ) {
        key = 'popUp';
    }
    
    var request = $.ajax ({
        url: "/ajax/poll/"+pollId+"/"+key,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) { 
        $('[data-id='+ pollId +']').closest('div').replaceWith( resp );
        var poll = $('.modal-dialog').find( '.question' ).attr('data-id');
        
        if(typeof poll != 'undefined')
            $('.modal-dialog').find('.pollContainer').replaceWith( resp );
        
        if( key != 'popUp' )
            $('[data-id='+ pollId +']').closest('table').find('.btn').hide();
        $('[data-id='+ pollId +']').closest('.widget_Poll').find('.pollLabel').hide();
    });
};

/*
 * Metodo che apre il popup del sondaggio
 */
WidgetPoll.prototype.openPopUpPoll = function ( pollId ) {
    var key = "popUp";
    
    var request = $.ajax ({
        url: "/ajax/poll/"+pollId+"/"+key,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) { 
        var params = { 
            type: 'custom', 
            title: '' ,
            callbackModals: '\
            <div class="pollContainer">'
                + resp +
            '</div>'
            };
        classModals.openModals( params );
        
        $('.modal-dialog .modal-body').css('margin-bottom', '0');
    });
};

widgetPoll = null;
$(function () {
    WidgetPoll = new WidgetPoll();
});


;
var gapi=window.gapi=window.gapi||{};gapi._bs=new Date().getTime();(function(){var k=this;var l=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^[\s\xa0]+|[\s\xa0]+$/g,"")},m=function(a,b){return a<b?-1:a>b?1:0};var n;a:{var p=k.navigator;if(p){var r=p.userAgent;if(r){n=r;break a}}n=""};var ba=function(a,b){var c=aa;Object.prototype.hasOwnProperty.call(c,a)||(c[a]=b(a))};var ca=-1!=n.indexOf("Opera"),v=-1!=n.indexOf("Trident")||-1!=n.indexOf("MSIE"),da=-1!=n.indexOf("Edge"),w=-1!=n.indexOf("Gecko")&&!(-1!=n.toLowerCase().indexOf("webkit")&&-1==n.indexOf("Edge"))&&!(-1!=n.indexOf("Trident")||-1!=n.indexOf("MSIE"))&&-1==n.indexOf("Edge"),ea=-1!=n.toLowerCase().indexOf("webkit")&&-1==n.indexOf("Edge"),y=function(){var a=k.document;return a?a.documentMode:void 0},z;
a:{var C="",D=function(){var a=n;if(w)return/rv:([^\);]+)(\)|;)/.exec(a);if(da)return/Edge\/([\d\.]+)/.exec(a);if(v)return/\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/.exec(a);if(ea)return/WebKit\/(\S+)/.exec(a);if(ca)return/(?:Version)[ \/]?(\S+)/.exec(a)}();D&&(C=D?D[1]:"");if(v){var E=y();if(null!=E&&E>parseFloat(C)){z=String(E);break a}}z=C}
var F=z,aa={},H=function(a){ba(a,function(){for(var b=0,c=l(String(F)).split("."),d=l(String(a)).split("."),e=Math.max(c.length,d.length),f=0;0==b&&f<e;f++){var h=c[f]||"",g=d[f]||"";do{h=/(\d*)(\D*)(.*)/.exec(h)||["","","",""];g=/(\d*)(\D*)(.*)/.exec(g)||["","","",""];if(0==h[0].length&&0==g[0].length)break;b=m(0==h[1].length?0:parseInt(h[1],10),0==g[1].length?0:parseInt(g[1],10))||m(0==h[2].length,0==g[2].length)||m(h[2],g[2]);h=h[3];g=g[3]}while(0==b)}return 0<=b})},fa;var ha=k.document;
fa=ha&&v?y()||("CSS1Compat"==ha.compatMode?parseInt(F,10):5):void 0;var I;if(!(I=!w&&!v)){var J;if(J=v)J=9<=Number(fa);I=J}I||w&&H("1.9.1");v&&H("9");/*
 gapi.loader.OBJECT_CREATE_TEST_OVERRIDE &&*/
var K=window,L=document,ia=K.location,ja=function(){},ka=/\[native code\]/,M=function(a,b,c){return a[b]=a[b]||c},la=function(a){a=a.sort();for(var b=[],c=void 0,d=0;d<a.length;d++){var e=a[d];e!=c&&b.push(e);c=e}return b},N=function(){var a;if((a=Object.create)&&ka.test(a))a=a(null);else{a={};for(var b in a)a[b]=void 0}return a},O=M(K,"gapi",{});var P;P=M(K,"___jsl",N());M(P,"I",0);M(P,"hel",10);var ma=function(){var a=ia.href;if(P.dpo)var b=P.h;else{b=P.h;var c=/([#].*&|[#])jsh=([^&#]*)/g,d=/([?#].*&|[?#])jsh=([^&#]*)/g;if(a=a&&(c.exec(a)||d.exec(a)))try{b=decodeURIComponent(a[2])}catch(e){}}return b},na=function(a){var b=M(P,"PQ",[]);P.PQ=[];var c=b.length;if(0===c)a();else for(var d=0,e=function(){++d===c&&a()},f=0;f<c;f++)b[f](e)},Q=function(a){return M(M(P,"H",N()),a,N())};var R=M(P,"perf",N()),oa=M(R,"g",N()),pa=M(R,"i",N());M(R,"r",[]);N();N();var U=function(a,b,c){var d=R.r;"function"===typeof d?d(a,b,c):d.push([a,b,c])},V=function(a,b,c){b&&0<b.length&&(b=ra(b),c&&0<c.length&&(b+="___"+ra(c)),28<b.length&&(b=b.substr(0,28)+(b.length-28)),c=b,b=M(pa,"_p",N()),M(b,c,N())[a]=(new Date).getTime(),U(a,"_p",c))},ra=function(a){return a.join("__").replace(/\./g,"_").replace(/\-/g,"_").replace(/,/g,"_")};var sa=N(),W=[],X=function(a){throw Error("Bad hint"+(a?": "+a:""));};W.push(["jsl",function(a){for(var b in a)if(Object.prototype.hasOwnProperty.call(a,b)){var c=a[b];"object"==typeof c?P[b]=M(P,b,[]).concat(c):M(P,b,c)}if(b=a.u)a=M(P,"us",[]),a.push(b),(b=/^https:(.*)$/.exec(b))&&a.push("http:"+b[1])}]);var ta=/^(\/[a-zA-Z0-9_\-]+)+$/,ua=[/\/amp\//,/\/amp$/,/^\/amp$/],va=/^[a-zA-Z0-9\-_\.,!]+$/,wa=/^gapi\.loaded_[0-9]+$/,xa=/^[a-zA-Z0-9,._-]+$/,Ba=function(a,b,c,d){var e=a.split(";"),f=e.shift(),h=sa[f],g=null;h?g=h(e,b,c,d):X("no hint processor for: "+f);g||X("failed to generate load url");b=g;c=b.match(ya);(d=b.match(za))&&1===d.length&&Aa.test(b)&&c&&1===c.length||X("failed sanity: "+a);return g},Ea=function(a,b,c,d){a=Ca(a);wa.test(c)||X("invalid_callback");b=Da(b);d=d&&d.length?Da(d):null;var e=
function(a){return encodeURIComponent(a).replace(/%2C/g,",")};return[encodeURIComponent(a.g).replace(/%2C/g,",").replace(/%2F/g,"/"),"/k=",e(a.version),"/m=",e(b),d?"/exm="+e(d):"","/rt=j/sv=1/d=1/ed=1",a.a?"/am="+e(a.a):"",a.c?"/rs="+e(a.c):"",a.f?"/t="+e(a.f):"","/cb=",e(c)].join("")},Ca=function(a){"/"!==a.charAt(0)&&X("relative path");for(var b=a.substring(1).split("/"),c=[];b.length;){a=b.shift();if(!a.length||0==a.indexOf("."))X("empty/relative directory");else if(0<a.indexOf("=")){b.unshift(a);
break}c.push(a)}a={};for(var d=0,e=b.length;d<e;++d){var f=b[d].split("="),h=decodeURIComponent(f[0]),g=decodeURIComponent(f[1]);2==f.length&&h&&g&&(a[h]=a[h]||g)}b="/"+c.join("/");ta.test(b)||X("invalid_prefix");c=0;for(d=ua.length;c<d;++c)ua[c].test(b)&&X("invalid_prefix");c=Y(a,"k",!0);d=Y(a,"am");e=Y(a,"rs");a=Y(a,"t");return{g:b,version:c,a:d,c:e,f:a}},Da=function(a){for(var b=[],c=0,d=a.length;c<d;++c){var e=a[c].replace(/\./g,"_").replace(/-/g,"_");xa.test(e)&&b.push(e)}return b.join(",")},
Y=function(a,b,c){a=a[b];!a&&c&&X("missing: "+b);if(a){if(va.test(a))return a;X("invalid: "+b)}return null},Aa=/^https?:\/\/[a-z0-9_.-]+\.google(rs)?\.com(:\d+)?\/[a-zA-Z0-9_.,!=\-\/]+$/,za=/\/cb=/g,ya=/\/\//g,Fa=function(){var a=ma();if(!a)throw Error("Bad hint");return a};sa.m=function(a,b,c,d){(a=a[0])||X("missing_hint");return"https://apis.google.com"+Ea(a,b,c,d)};var Z=decodeURI("%73cript"),Ga=/^[-+_0-9\/A-Za-z]+={0,2}$/,Ha=function(a,b){for(var c=[],d=0;d<a.length;++d){var e=a[d],f;if(f=e){a:{for(f=0;f<b.length;f++)if(b[f]===e)break a;f=-1}f=0>f}f&&c.push(e)}return c},Ia=function(){var a=P.nonce;if(void 0!==a)return a&&a===String(a)&&a.match(Ga)?a:P.nonce=null;var b=M(P,"us",[]);if(!b||!b.length)return P.nonce=null;for(var c=L.getElementsByTagName(Z),d=0,e=c.length;d<e;++d){var f=c[d];if(f.src&&(a=String(f.nonce||f.getAttribute("nonce")||"")||null)){for(var h=
0,g=b.length;h<g&&b[h]!==f.src;++h);if(h!==g&&a&&a===String(a)&&a.match(Ga))return P.nonce=a}}return null},Ka=function(a){if("loading"!=L.readyState)Ja(a);else{var b=Ia(),c="";null!==b&&(c=' nonce="'+b+'"');L.write("<"+Z+' src="'+encodeURI(a)+'"'+c+"></"+Z+">")}},Ja=function(a){var b=L.createElement(Z);b.setAttribute("src",a);a=Ia();null!==a&&b.setAttribute("nonce",a);b.async="true";(a=L.getElementsByTagName(Z)[0])?a.parentNode.insertBefore(b,a):(L.head||L.body||L.documentElement).appendChild(b)},
La=function(a,b){var c=b&&b._c;if(c)for(var d=0;d<W.length;d++){var e=W[d][0],f=W[d][1];f&&Object.prototype.hasOwnProperty.call(c,e)&&f(c[e],a,b)}},Na=function(a,b,c){Ma(function(){var c=b===ma()?M(O,"_",N()):N();c=M(Q(b),"_",c);a(c)},c)},Pa=function(a,b){var c=b||{};"function"==typeof b&&(c={},c.callback=b);La(a,c);b=a?a.split(":"):[];var d=c.h||Fa(),e=M(P,"ah",N());if(e["::"]&&b.length){a=[];for(var f=null;f=b.shift();){var h=f.split(".");h=e[f]||e[h[1]&&"ns:"+h[0]||""]||d;var g=a.length&&a[a.length-
1]||null,x=g;g&&g.hint==h||(x={hint:h,b:[]},a.push(x));x.b.push(f)}var A=a.length;if(1<A){var B=c.callback;B&&(c.callback=function(){0==--A&&B()})}for(;b=a.shift();)Oa(b.b,c,b.hint)}else Oa(b||[],c,d)},Oa=function(a,b,c){a=la(a)||[];var d=b.callback,e=b.config,f=b.timeout,h=b.ontimeout,g=b.onerror,x=void 0;"function"==typeof g&&(x=g);var A=null,B=!1;if(f&&!h||!f&&h)throw"Timeout requires both the timeout parameter and ontimeout parameter to be set";g=M(Q(c),"r",[]).sort();var S=M(Q(c),"L",[]).sort(),
G=[].concat(g),qa=function(a,b){if(B)return 0;K.clearTimeout(A);S.push.apply(S,q);var d=((O||{}).config||{}).update;d?d(e):e&&M(P,"cu",[]).push(e);if(b){V("me0",a,G);try{Na(b,c,x)}finally{V("me1",a,G)}}return 1};0<f&&(A=K.setTimeout(function(){B=!0;h()},f));var q=Ha(a,S);if(q.length){q=Ha(a,g);var t=M(P,"CP",[]),u=t.length;t[u]=function(a){if(!a)return 0;V("ml1",q,G);var b=function(b){t[u]=null;qa(q,a)&&na(function(){d&&d();b()})},c=function(){var a=t[u+1];a&&a()};0<u&&t[u-1]?t[u]=function(){b(c)}:
b(c)};if(q.length){var T="loaded_"+P.I++;O[T]=function(a){t[u](a);O[T]=null};a=Ba(c,q,"gapi."+T,g);g.push.apply(g,q);V("ml0",q,G);b.sync||K.___gapisync?Ka(a):Ja(a)}else t[u](ja)}else qa(q)&&d&&d()};var Ma=function(a,b){if(P.hee&&0<P.hel)try{return a()}catch(c){b&&b(c),P.hel--,Pa("debug_error",function(){try{window.___jsl.hefn(c)}catch(d){throw c;}})}else try{return a()}catch(c){throw b&&b(c),c;}};O.load=function(a,b){return Ma(function(){return Pa(a,b)})};oa.bs0=window.gapi._bs||(new Date).getTime();U("bs0");oa.bs1=(new Date).getTime();U("bs1");delete window.gapi._bs;}).call(this);
gapi.load("client",{callback:window["gapi_onload"],_c:{"jsl":{"ci":{"deviceType":"desktop","oauth-flow":{"authUrl":"https://accounts.google.com/o/oauth2/auth","proxyUrl":"https://accounts.google.com/o/oauth2/postmessageRelay","disableOpt":true,"idpIframeUrl":"https://accounts.google.com/o/oauth2/iframe","usegapi":false},"debug":{"reportExceptionRate":0.05,"forceIm":false,"rethrowException":false,"host":"https://apis.google.com"},"enableMultilogin":true,"googleapis.config":{"auth":{"useFirstPartyAuthV2":false}},"isPlusUser":false,"inline":{"css":1},"disableRealtimeCallback":false,"drive_share":{"skipInitCommand":true},"csi":{"rate":0.01},"client":{"cors":false},"isLoggedIn":false,"signInDeprecation":{"rate":0.0},"include_granted_scopes":true,"llang":"en","iframes":{"ytsubscribe":{"url":"https://www.youtube.com/subscribe_embed?usegapi\u003d1"},"plus_share":{"params":{"url":""},"url":":socialhost:/:session_prefix::se:_/+1/sharebutton?plusShare\u003dtrue\u0026usegapi\u003d1"},":source:":"3p","playemm":{"url":"https://play.google.com/work/embedded/search?usegapi\u003d1\u0026usegapi\u003d1"},"partnersbadge":{"url":"https://www.gstatic.com/partners/badge/templates/badge.html?usegapi\u003d1"},"dataconnector":{"url":"https://dataconnector.corp.google.com/:session_prefix:ui/widgetview?usegapi\u003d1"},"shortlists":{"url":""},"plus_followers":{"params":{"url":""},"url":":socialhost:/_/im/_/widget/render/plus/followers?usegapi\u003d1"},"post":{"params":{"url":""},"url":":socialhost:/:session_prefix::im_prefix:_/widget/render/post?usegapi\u003d1"},"signin":{"params":{"url":""},"url":":socialhost:/:session_prefix:_/widget/render/signin?usegapi\u003d1","methods":["onauth"]},"donation":{"url":"https://onetoday.google.com/home/donationWidget?usegapi\u003d1"},"plusone":{"params":{"count":"","size":"","url":""},"url":":socialhost:/:session_prefix::se:_/+1/fastbutton?usegapi\u003d1"},":im_socialhost:":"https://plus.googleapis.com","backdrop":{"url":"https://clients3.google.com/cast/chromecast/home/widget/backdrop?usegapi\u003d1"},"visibility":{"params":{"url":""},"url":":socialhost:/:session_prefix:_/widget/render/visibility?usegapi\u003d1"},"additnow":{"url":"https://apis.google.com/additnow/additnow.html?usegapi\u003d1","methods":["launchurl"]},":signuphost:":"https://plus.google.com","community":{"url":":ctx_socialhost:/:session_prefix::im_prefix:_/widget/render/community?usegapi\u003d1"},"plus":{"url":":socialhost:/:session_prefix:_/widget/render/badge?usegapi\u003d1"},"commentcount":{"url":":socialhost:/:session_prefix:_/widget/render/commentcount?usegapi\u003d1"},"zoomableimage":{"url":"https://ssl.gstatic.com/microscope/embed/"},"appfinder":{"url":"https://gsuite.google.com/:session_prefix:marketplace/appfinder?usegapi\u003d1"},"person":{"url":":socialhost:/:session_prefix:_/widget/render/person?usegapi\u003d1"},"savetodrive":{"url":"https://drive.google.com/savetodrivebutton?usegapi\u003d1","methods":["save"]},"page":{"url":":socialhost:/:session_prefix:_/widget/render/page?usegapi\u003d1"},"card":{"url":":socialhost:/:session_prefix:_/hovercard/card"},"youtube":{"params":{"location":["search","hash"]},"url":":socialhost:/:session_prefix:_/widget/render/youtube?usegapi\u003d1","methods":["scroll","openwindow"]},"plus_circle":{"params":{"url":""},"url":":socialhost:/:session_prefix::se:_/widget/plus/circle?usegapi\u003d1"},"rbr_s":{"params":{"url":""},"url":":socialhost:/:session_prefix::se:_/widget/render/recobarsimplescroller"},"udc_webconsentflow":{"params":{"url":""},"url":"https://myaccount.google.com/webconsent?usegapi\u003d1"},"savetoandroidpay":{"url":"https://androidpay.google.com/a/widget/save"},"blogger":{"params":{"location":["search","hash"]},"url":":socialhost:/:session_prefix:_/widget/render/blogger?usegapi\u003d1","methods":["scroll","openwindow"]},"evwidget":{"params":{"url":""},"url":":socialhost:/:session_prefix:_/events/widget?usegapi\u003d1"},"surveyoptin":{"url":"https://www.google.com/shopping/customerreviews/optin?usegapi\u003d1"},":socialhost:":"https://apis.google.com","hangout":{"url":"https://talkgadget.google.com/:session_prefix:talkgadget/_/widget"},":gplus_url:":"https://plus.google.com","rbr_i":{"params":{"url":""},"url":":socialhost:/:session_prefix::se:_/widget/render/recobarinvitation"},"share":{"url":":socialhost:/:session_prefix::im_prefix:_/widget/render/share?usegapi\u003d1"},"comments":{"params":{"location":["search","hash"]},"url":":socialhost:/:session_prefix:_/widget/render/comments?usegapi\u003d1","methods":["scroll","openwindow"]},"autocomplete":{"params":{"url":""},"url":":socialhost:/:session_prefix:_/widget/render/autocomplete"},"ratingbadge":{"url":"https://www.google.com/shopping/customerreviews/badge?usegapi\u003d1"},"appcirclepicker":{"url":":socialhost:/:session_prefix:_/widget/render/appcirclepicker"},"follow":{"url":":socialhost:/:session_prefix:_/widget/render/follow?usegapi\u003d1"},"sharetoclassroom":{"url":"https://www.gstatic.com/classroom/sharewidget/widget_stable.html?usegapi\u003d1"},"ytshare":{"params":{"url":""},"url":":socialhost:/:session_prefix:_/widget/render/ytshare?usegapi\u003d1"},"family_creation":{"params":{"url":""},"url":"https://families.google.com/webcreation?usegapi\u003d1\u0026usegapi\u003d1"},"configurator":{"url":":socialhost:/:session_prefix:_/plusbuttonconfigurator?usegapi\u003d1"},"savetowallet":{"url":"https://androidpay.google.com/a/widget/save"}}},"h":"m;/_/scs/apps-static/_/js/k\u003doz.gapi.en_US.XKTeUOz12q0.O/m\u003d__features__/am\u003dAQ/rt\u003dj/d\u003d1/rs\u003dAGLTcCP4sqCpsMFrnkAS1D-fz9HyKnFPQg","u":"https://apis.google.com/js/api:client.js","hee":true,"fp":"72e95bd75c488a34193ed2f7983a8b4f60354666","dpo":false},"fp":"72e95bd75c488a34193ed2f7983a8b4f60354666","annotation":["interactivepost","recobar","signin2","autocomplete","profile"],"bimodal":["signin","share"]}})
;




/**
 * Classe per la gestione degli utenti
 */ 
var Facebook = function() {
    var that = this;
    this.authResponse = null;
    this.facebookLogin = $( '.facebookLogin' );
    
    window.fbAsyncInit = function() {
        FB.init({
          appId      : facebookAppId,
          cookie     : true,  // enable cookies to allow the server to access 
                              // the session
          xfbml      : true,  // parse social plugins on this page
          version    : 'v2.2' // use version 2.2
        });
//        FB.getLoginStatus(function(response) {
//          that.statusChangeCallback(response);
//        });
    };
    this.initListeners();
};

/**
 * Metodo che avvia gli scoltatori
 */
Facebook.prototype.initListeners = function() {
    var that = this;
    $( 'body' ).on( 'click', '.facebookLogin', function() {       
//        users.logout( false );
//        utility.trackGAClickEvent( 'Login', 'Facebook', 'Landing' );
        that.login();
    });
};

/**
 * @returns {undefined}
 * https://developers.facebook.com/docs/facebook-login/permissions/v1.0#reference-extended
 */
Facebook.prototype.login = function() {
    var that = this;    
    FB.login(function(){
            FB.getLoginStatus(function(response) {
                that.checkUserLoginStatus( response );
            });
        }, { scope: facebookScope }
    );       
};

/**
 * This is called with the results from from FB.getLoginStatus()
 * @param {type} response
 * @returns {undefined}
 */
Facebook.prototype.checkUserLoginStatus = function ( response ) {
    var that = this;
    this.authResponse = response.authResponse;
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
//      utility.trackGAClickEvent( 'Login', 'Facebook', 'Connesso a Facebook' );
      var images = this.getImageProfileUser();
      var email = this.getUserInfo();
      setTimeout( function(){that.connectUserFromFacebook()}, 500 );
    }     
};

/**
 * Metodo che recupera l'immagine del profilo dell'utente
 * @returns {undefined}
 */
Facebook.prototype.getImageProfileUser = function (  ) {
    var that = this;
    FB.api(
        "/me/picture", {
            "redirect": false, 
            "height": 500,
            "width": 500,
            "type": "normal"
        },
        function ( response ) {
          if ( response && !response.error ) {
            that.imageProfile = response;
          }
        }
    );
};
/**
 * Metodo che recupera il profilo dell'utente
 * @returns {undefined}
 */
Facebook.prototype.getUserInfo = function (  ) {
    var that = this;    
    FB.api('/me', {fields: 'email, age_range'}, function(response) {
        that.email = response.email;
        that.age   = response.age_range.min;
    });
};

/**
 * Metodo che connette l'utente a calciomercato.it tramite facebook.com
 * @returns {undefined}
 */
Facebook.prototype.connectUserFromFacebook = function () {
    var that = this;
    FB.api( '/me', function( response ) {
        response.picture = that.imageProfile['data']['url'];
        response.email   = that.email;
        response.age     = that.age;
        var request = $.ajax({
            url: "/ajax/sendRegistration/externalUserSocial",
            type: "GET",
            async: false,
            dataType: "html",
            data: {
                action : 'Facebook',
                authResponse : JSON.stringify( that.authResponse ),
                userFb : JSON.stringify( response )
            }
        });
        request.done( function( resp ) {  
            if (resp == 1 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Benvenuto' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Login Effettuato con Successo!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
                 setTimeout(function() {
                    bootbox.hideAll();       
                }, 1000);
                $( '[data-login]' ).hide();
                $( '[data-logout]' ).show();
                
            } else if (resp == 0 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Benvenuto' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Errore Durante il Login!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
                $( '[data-login]' ).show();
                $( '[data-logout]' ).hide();
            } else if (resp == 2 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Benvenuto' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Email già presente!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
                $( '[data-login]' ).show();
                $( '[data-logout]' ).hide();
            } else if (resp == 5 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Benvenuto' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Non è stato possibile effettuare la registrazione, in quanto il tuo account non ha accesso pubblico alla tua email!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
                $( '[data-login]' ).show();
                $( '[data-logout]' ).hide();
            }
        });        
    });
};

function checkLoginState() {
    FB.getLoginStatus(function(response) {
      facebook.statusChangeCallback(response);
    });
}

// Load the SDK asynchronously
function loadLibraryFb(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js";
  fjs.parentNode.insertBefore(js, fjs);
};

loadLibraryFb(document, 'script', 'facebook-jssdk');

var facebook = null;
facebook = new Facebook()
;
var clientId = googleClientId;
var apiKey = googleApiKey;
var scopes = googleScopes;


function handleAuthResult( authResult ) { google.handleAuthResult( authResult ); }
function makeApiCall() { google.makeApiCall(); }

/**
 * Classe per la gestione delle comunicazioni con google
 */ 
var Google = function( clientId, apiKey, scopes ) {
    var that = this;
    
    this.clientId = clientId;
    this.apiKey   = apiKey;
    this.scopes   = scopes;   
    this.authResponse = null;
    
    this.googleLogin = $( '[data-GoogleLogin]' );
    this.init();
};

/**
 * Metodo che avvia gli scoltatori
 */
Google.prototype.init = function() {
    var that = this;
    $( 'body' ).on( 'click', '[data-GoogleLogin]', function() {   
//        users.logout( false );
//        utility.trackGAClickEvent( 'Login', 'Google', 'Landing' );
        
        gapi.client.setApiKey( that.apiKey );
//        window.setTimeout( that.checkAuth, 1 );
        gapi.auth.authorize({
            client_id: that.clientId, 
            scope: that.scopes, 
            immediate: false
        }, that.handleAuthResult );
            
    });
};

/**
 * Metodo che effettua il login tramite google plus
 * @returns {undefined}
 */
Google.prototype.login = function() {
    // Step 2: Reference the API key
    var that = this;
    gapi.client.setApiKey( that.apiKey );
    window.setTimeout( that.checkAuth, 1 );    
};

/**
 * Metodo che effettua la richiesta oAuth per il login di google plus
 * @returns {undefined}
 */
Google.prototype.checkAuth = function() {
    var that = this;
    gapi.auth.authorize({
        client_id: that.clientId, 
        scope: that.scopes, 
        immediate: false
    }, that.handleAuthResult );
};

/**
 * Metodo che analizza la risposta della richiesta oAuth
 * @param {type} authResult
 * @returns {undefined}
 */
Google.prototype.handleAuthResult = function( authResult ) {
    var authorizeButton = $('#authorize-button');
    if (authResult && !authResult.error) {
      $( authorizeButton ).css( 'visibility ', 'hidden');
      gapi.auth.setToken( authResult ); 
      this.makeApiCall();
      
       if (authResult && !authResult.error) {
        $.get("https://www.google.com/m8/feeds/contacts/default/full?alt=json&access_token=" + authResult.access_token + "&max-results=700&v=3.0",
          function(response){
             ;
          });
        }
      
    } else {
      authorizeButton.style.visibility = '';
      authorizeButton.onclick = this.handleAuthClick;
    }
};

/**
 * Metodo che effettua la richiesta oAuth per il login di google plus
 * @returns {undefined}
 */
Google.prototype.handleAuthClick = function() {  
    var that = this;
    gapi.auth.authorize({
        client_id: clientId, 
        scope: scopes, 
        immediate: false
    }, that.handleAuthResult );
};

/**
 * Metodo che sfrutta le api gapi per recuperare i dati dell'utente loggato con google  plus
 * @returns {undefined}
 */
Google.prototype.makeApiCall = function() {
    var that = this;   
//    utility.trackGAClickEvent( 'Login', 'Google', 'Connesso a google' );
    gapi.client.load('oauth2', 'v2', function() {
        var request = gapi.client.oauth2.userinfo.get();
        request.execute( that.connectUserFromGoogle );
    });    
};

Google.prototype.connectUserFromGoogle = function ( response ) {
    var that = this; 
    var request = $.ajax({
        url: "/ajax/sendRegistration/externalUserSocial",
        type: "GET",
        async: false,
        dataType: "html",
        data: {
            action : 'Google',
            access_token : gapi.auth.getToken().access_token,
            userGoogle : JSON.stringify( response )
        }
    });
    request.done( function( resp ) {
        if (resp == 1 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Benvenuto su Calciomercato.it' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Login Effettuato con Successo!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
                 setTimeout(function() {
                    bootbox.hideAll();       
                }, 1000);
            } else if (resp == 0 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Calciomercato.it' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Errore Durante il Login!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
            } else if (resp == 2 ) {
                widgetComment.addComment();
                var params = { 
                    type: 'custom', 
                    title: 'Calciomercato.it' ,
                    callbackModals: '\
                    <div class="containerMsg">\
                        <div class="containerMsg">\
                            <div>\
                                <label>Email già presente!</label>\
                            </div>\
                        </div>\
                    </div>'
                    };
                classModals.openModals( params );
            }
    });        
};

/**
 * Metodo che avvia il recupero dei contatti di un utente
 * @param {type} callback
 * @returns {undefined}
 */
Google.prototype.getUserFriendsContacts = function( callback ) {
	gapi.client.setApiKey( apiKey );	// app api-wide client api key
	//this.getGoogleContactEmails( callback );
        
    var that = this;
    gapi.auth.authorize({
        client_id: clientId, 
        scope: 'https://www.google.com/m8/feeds', 
        immediate: false
    }, function( authResult ) {
       if ( authResult && !authResult.error ) {
            that.getGoogleContactEmails( callback );
        } else {
            that.getUserFriendsContacts( callback );
        } 
    }); 
};

/**
 * Metodo che recupera i contatti di un utente tramite le gapi di google
 * @param {type} callback
 * @returns {undefined}
 */
Google.prototype.getGoogleContactEmails = function( callback ) {
  var oauth_clientKey = clientId; // replace with your oauth client api key
	var firstTry = true;
    
	function connect(immediate, callback){
	    var config = {
	        'client_id': oauth_clientKey,
	        'scope': 'https://www.google.com/m8/feeds',
	        'immediate': immediate
	    };        
	    gapi.auth.authorize( config, function () {
			var authParams = gapi.auth.getToken();            
	        $.ajax({
	            url: 'https://www.google.com/m8/feeds/contacts/default/full?max-results=10000',
	            dataType: 'jsonp',
	            type: "GET",
	            data: authParams,
	            success: function( data ) {                    
	                var parser = new DOMParser();
	 				xmlDoc = parser.parseFromString( data, "text/xml" );
	 				var entries = xmlDoc.getElementsByTagName( 'feed' )[0].getElementsByTagName( 'entry' );
	 				var contacts = [];
	 				for ( var i = 0; i < entries.length; i++ ){
                        var name = entries[i].getElementsByTagName( 'title' )[0].innerHTML;                        
                        if( typeof entries[i].getElementsByTagName( 'gd:email' )[0] != 'undefined' ) {
                            var email = $( entries[i].getElementsByTagName( 'gd:email' )[0] ).attr( 'address' );
                            contacts.push( { name: name, email: email } );
                        } else {
                            var emails = entries[i].getElementsByTagName( 'email' );
                            for ( var j = 0; j < emails.length; j++ ) {
                              var email = emails[j].attributes.getNamedItem( 'address' ).value;
                              contacts.push( { name: name, email: email } );
                            }
                        }                                                    
	 				}
	 				callback( contacts );
	            }
	        });
	    });
	}
	connect( true, callback );
}

var google = null;
google = new Google( clientId, apiKey, scopes )
;

/**
 * Classe per la gestione dei commenti
 */
var WidgetUser = function () {
    this.initListeners();
};


/**
 * Metodo che avvia gli ascoltatori
 */
WidgetUser.prototype.initListeners = function () {
    var that = this;       
    
    // al click faccio partire il flusso per aprire la chat
    $( 'body' ).on( 'click', '[data-login], [data-openChat]', function ( e ) {     
        if (that.isLogged() != 1) {
            that.openPopupLogin();
        } else {
            if( $('[data-msg="1"]').hasClass('redBorder') )
                $('[data-msg="1"]').removeClass('redBorder');
        }
    });
    
    $('body').on( 'click', '[data-logout]', function(e) {
        if (that.isLogged() == 1) {
           that.userLogout();
        }
    });
    
    $('#form_save' ).closest('.form-group').remove();

    // al click recupero tutti i team e apro il popup della registrazione
    $( 'body' ).on( 'click', '[data-register="1"]', function ( e ) {
        bootbox.hideAll();
        that.retrieveTeam();
    });
    
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-forgotPwd="1"]', function ( e ) {
        bootbox.hideAll();
        that.openPopupForgotPwd();
    });
   
    // al click apro il popup per il reset della password
    $( 'body' ).on( 'click', '[data-resetPwd="1"]', function ( e ) {
        var pwd = $('#resetPwd').val();
        var confirmPwd = $('#confirmPwd').val();
        if ( pwd != confirmPwd) {
            e.stopPropagation();
            e.preventDefault(); 
            var params = { 
              type: 'custom', 
              title: 'Calciomercato.it' ,
              callbackModals: '\
              <div class="containerMsg">\
                  <div class="containerMsg">\
                      <div>\
                          <label>Le due password devono coincidere</label>\
                      </div>\
                  </div>\
              </div>'
              };
          classModals.openModals( params );
        }
    });
    
    // al click mando la mail per il reset della password
    $( 'body' ).on( 'click', '[data-sendMail="1"]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
        bootbox.hideAll();
        that.forgotPwd( this );
    });
    
    // al click parte il flusso per la registrazione
    $( 'body' ).on( 'click', '[data-addUser="1"]', function ( e ) {
        that.sendRegistration( this );       
    });
    
    // al click parte il flusso per il login
    $( 'body' ).on( 'click', '[data-defaultLogin]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();    
        that.sendLogin( this );
    }); 
    
    // al click parte il flusso per il login
    $( 'body' ).on( 'click', '[data-FbLogin]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
    }); 
    
    // al click parte il flusso per il login
    $( 'body' ).on( 'click', '[data-GoogleLogin]', function ( e ) {
        e.stopPropagation();
        e.preventDefault();
    }); 
};


/**
 * Metodo che controlla se l'utente è loggato
 */
WidgetUser.prototype.isLogged = function ( sender ) {
    var isLogged = 0;
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Logged",
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         isLogged = resp;
     });
     
     return isLogged;
};

/**
 * Metodo che gestisce il login
 */
WidgetUser.prototype.sendLogin = function ( sender ) {

    var that = this; 
    var login = 0;
    var data = $( sender ).closest( '[data-formLogin]' ).serialize();
    
    if ( $('#loginEmail').val() == "" || $('#loginPassword').val() == "") {
        $('#loginEmail').closest('div').prepend('<div class="loginError">Inserire i dati corretti</div>');
        $('#loginEmail').addClass('redBorder');
        $('#loginPassword').addClass('redBorder');
        return false;
    }
    
    var request = $.ajax ({
        url: "/ajax/externalUser/Login?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( resp ) {
        login = resp;
        if (resp == 1 ) {
            var params = { 
                type: 'custom', 
                title: 'Benvenuto su IlDemolitore.it' ,
                callbackModals: '\
                <div class="containerMsg">\
                    <div class="containerMsg">\
                        <div>\
                            <label>Login Effettuato con Successo!</label>\
                        </div>\
                    </div>\
                </div>'
                };
            classModals.openModals( params );
             setTimeout(function() {
                bootbox.hideAll();       
            }, 1000);
            
            $( '[data-login]' ).hide();
            $( '[data-logout]' ).show(); 
        }

        if (resp == 0 ) {
            var params = { 
                type: 'custom', 
                title: 'Benvenuto su IlDemolitore.it' ,
                callbackModals: '\
                <div class="containerMsg">\
                    <div class="containerMsg">\
                        <div>\
                            <label>Errore Durante il Login!</label>\
                        </div>\
                    </div>\
                </div>'
                };
            classModals.openModals( params );
            $( '[data-login]' ).show();
            $( '[data-logout]' ).hide();
        }
    });
    
    return login;
};

/**
 * Metodo che gestisce la registrazione dell'utente
 */
WidgetUser.prototype.sendRegistration = function ( sender ) {
    var that = this;
    var error = 0;
    var data = $( sender ).closest( '[data-formRegistration]' ).serialize();
    
    if ( error > 0 ) {
        return false;
    }
        
    var request = $.ajax ({
        url: "/ajax/sendRegistration/externalUser?"+data,
        type: "POST",
        async: true,
        dataType: "html"        
    });
    request.done( function( response ) {
        var type = 'error';
        
        if ( response == 1 ) {
            var msg = 'Registrazione avvenuta con successo';
            var type = 'success';
            
            
        }  
        
        if ( response == 0 ) {            
            var msg = 'Errore durante la Registrazione. Riprova!';            
        }
        
        if ( response == 2 ) {
            var msg = 'Errore durante la Registrazione. Indirizzo Mail già presente!'       
        }
        
        var parameters = new Array();   
        parameters['type'] = type;
        parameters['layout'] = 'top';
        parameters['mex'] =  msg;
        classNotyfy.openNotyfy( parameters );      
        
        if ( response == 1 ) {
            setTimeout(function() {
                bootbox.hideAll();    
                window.location.href = '/';
            }, 1500);
        }
        
    });
};

/**
 * Metodo che apre il popUp per il login
 */
WidgetUser.prototype.openPopupLogin = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'ACCEDI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formLogin" class="login-form" data-formLogin>\
                    <div class="form__row">\
                        <div>\
                            <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">\
                        </div>\
                        <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">\
                            </div>\
                            <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>\
                        </div>\
                    </div>\
                </form>\
                <div>\
                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">\
                </div>\
            </div>'
            };
    classModals.openModals( params );
    //
    //<div>\
    //    <input class="googleLogin button button--fill button--big" data-GoogleLogin type="submit" value="Accedi con Google">\
    //</div>\
};

/**
 * Metodo che apre il popUp per il reset della Pwd
 */
WidgetUser.prototype.openPopupForgotPwd = function ( ) { 
    var params = { 
            type: 'custom', 
            title: 'RESETTA PASSWORD' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formForgotPwd" class="reset-form" data-formForgotPwd>\
                    <div class="form__row">\
                        <div>\
                            <input id="resetEmail" class="form__input-text form__input-text--m-top" type="email" name="resetEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input id="button-reset" class="button button--fill button--big" type="submit" data-sendMail="1" value="Invia Mail">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
};

/**
 * Metodo che apre il popUp per la registrazione
 */
WidgetUser.prototype.openPopupRegistration = function ( teams ) {
    var option = '';
    var optionAge = '';
    
    if ( teams != null ) {
        $( teams ).each( function() {
            option+= '<option value="'+ this.id +'">'+this.name+'</option>';
        });
    }
    
    for( var x = 6; x < 100; x++ ) {
        optionAge+= '<option value="'+ x +'">'+x+'</option>';
    };
    
    var params = { 
            type: 'custom', 
            title: 'REGISTRATI' ,
            callbackModals: '\
            <div class="containerForm">\
                <form id="formRegistration" onSubmit="return false" class="registration-form" data-formRegistration>\
                    <div class="form__row">\
                        <div>\
                            <input id="registrationName" type="text" name="registrationName" placeholder="Nome" required>\
                        </div>\
                        <div>\
                            <input id="registrationSurname" type="text" name="registrationSurname" placeholder="Cognome" value="">\
                        </div>\
                        <div>\
                            <input id="registrationEmail" type="email" name="registrationEmail" placeholder="E-mail" value="">\
                        </div>\
                        <div>\
                            <input id="registrationPassword" type="password" name="registrationPassword" placeholder="Password" value="">\
                        </div>\
                        <div>\
                            <select id="registrationAge" class="selectIsTeam"  name="registrationAge">\
                            '+ optionAge +'\
                            </select>\
                        </div>\
                        <div>\
                            <input id="registrationCity" type="hidden" name="registrationCity" placeholder="Città" value="">\
                        </div>\
                        <div>\
                            <input id="registrationTeam" class="selectIsTeam" name="registrationTeam" value="0" type="hidden">\
                        </div>\
                        <div class="form__row form__row--m-login">\
                            <div>\
                                <input type="submit" id="button-registration" data-addUser="1" class="button button--fill button--big" value="Registrati">\
                            </div>\
                        </div>\
                    </div>\
                </form>\
            </div>'
            };
    classModals.openModals( params );
    $('.containerForm').closest('.modal-content').css('height', '600px');
};

/**
 * Metodo che riprende tutti i team per la scelta della sqadra per la registrazione
 */
WidgetUser.prototype.retrieveTeam = function () {
    var that = this;
    var request = $.ajax ({
            url: "/ajax/retrieve/team",
            type: "GET",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null )
                that.openPopupRegistration(resp);             
        });
        return false;
};

/**
 * Metodo che permette il reset della pwd
 */
WidgetUser.prototype.forgotPwd = function ( sender ) {
    var that = this;
    var data = $( sender ).closest( '[data-formForgotPwd]' ).serialize();
    
    var request = $.ajax ({
            url: "/ajax/forgot/password?"+data,
            type: "POST",
            async: true,
            dataType: "json"        
         });
         request.done( function( resp ) {
             if ( resp != null ) {
                  var params = { 
                        type: 'custom', 
                        title: 'Calciomercato.it' ,
                        callbackModals: '\
                        <div class="containerMsg">\
                            <div class="containerMsg">\
                                <div>\
                                    <label>Ti abbiamo inviato una mail al tuo indirizzo</label>\
                                </div>\
                            </div>\
                        </div>'
                        };
                    classModals.openModals( params );        
            }
        });
        return false;
};

WidgetUser.prototype.userLogout = function ( sender ) {    
    
    var request = $.ajax ({
        url: "/logoutExternalUser",
        type: "POST",
        async: true,
        dataType: "html"        
        });
        request.done( function( resp ) {
            if (resp != false ) {
                window.location.href = '/';
            } else {
                return false;
            }

        });
        
    };

var widgetUser   = null;
widgetUser       = new WidgetUser()
;

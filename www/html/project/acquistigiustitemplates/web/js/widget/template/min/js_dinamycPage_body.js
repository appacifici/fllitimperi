var ManagerLinks=function(){this.initListeners()};
ManagerLinks.prototype.initListeners=function(){var a=this;$("body").on("click",'[data-action="urlCopy"]',function(){a.openCopyLink(this)});$("body").on("click","[data-ln]",function(){a.openJsLink(this)});$("body").on("click","[data-lgt]",function(){a.openJsLink(this)});$("body").on("click","[data-href]",function(){a.dataOpenHref(this)});$("body").on("click","[data-modelComparisonPrices] [data-viewMoreProducts]",function(){var a=this,c=!1;$(this).closest("[data-modelComparisonPrices]").find("table tr[data-ViewMoreProductsItem]").toggle(function(){c||("+ Mostra pi\u00f9 prodotti"==
$(a).find("span").html()?$(a).find("span").html("- Mostra meno prodotti"):$(a).find("span").html("+ Mostra pi\u00f9 prodotti"),c=!0)})})};ManagerLinks.prototype.viewMoreProducts=function(a){window.open($(a).attr("data-href"),"_blank")};ManagerLinks.prototype.dataOpenHref=function(a){window.open($(a).attr("data-href"),"_blank")};
ManagerLinks.prototype.openJsLink=function(a){var b=$(a).attr("data-lgt").substr(5),b=b.substr(0,b.length-5);b;"blank"==$(a).attr("data-target")?window.open(atob(b),"_blank"):window.location.href=atob(b)};ManagerLinks.prototype.openCopyLink=function(a){var b=$(a).closest("[data-urlCopyFather]").find("[data-urlCopy]").attr("href");"_blank"==$(a).closest("[data-urlCopyFather]").find("[data-urlCopy]").attr("target")?window.open(b,"_blank"):window.location.href=b};managerLinks=null;managerLinks=new ManagerLinks;
var main=null,Main=function(){this.charLoader=this.isOpenLogin=!1;this.initListeners()};
Main.prototype.initListeners=function(){var a=this;$("body").on("click","[data-widgetOpenLogin], [data-widgetCloseLogin]",function(){a.manageBoxLogin()});$("#openSearch").click(function(){$(this).closest(".header").toggleClass("open");$(this).closest(".header").find(".btnSearch").toggle()});$("#micro-section-header span").click(function(){$(this).toggleClass("auto")});$("body").on("click","[data-boxPaymentsOpen]",function(){a.boxPaymentsOpen(this)});$("body").on("click","[data-closeoverlay]",function(){$("#boxOverlay").hide()});
$("body").on("click","[data-pOff]",function(){a.offProduct(this)});$("body").on("click","[data-CreateProducteInit]",function(){a.createProducteInit(this)});$("body").on("click","[data-SendNewsletters] span.newslettersIcon",function(){a.sendNewsletters(this)});$("body").on("click","[data-expandTecnical]",function(){$(".widget-model-detail .tecnical-info").toggleClass("closed");$(".widget-model-detail .tecnical-info").hasClass("closed")?$("[data-expandTecnical]").html("+ Leggi tutto"):$("[data-expandTecnical]").html("- Leggi meno")});
$("body").on("click","[data-thumbYouTube]",function(){$(this).html('<iframe width="100%" height="300px" src="https://www.youtube.com/embed/'+$(this).attr("data-thumbYouTube")+'?autoplay=1" allowfullscreen></iframe>')});null!=this.getCookie("externalUserCode")&&($("[data-widgetOpenLogin] .btnLogin").removeClass("btnLogin").addClass("btnLogout"),$("[data-widgetOpenLogin] .btnLogout").html("Logout"),$("[data-widgetOpenLogin]").removeAttr("data-widgetOpenLogin"),$(".buttonsHeader .user").click(function(){window.location.href=
"/extUser/logout"}))};
Main.prototype.sendNewsletters=function(a){var b=$(a).closest("[data-SendNewsletters]").find("input");$.get("/ajax/sendNewsletters?email="+b.val(),function(b){var d="error";if(1==b){var e="Iscrizione alla newsletters avvenuta con successo",d="success";$(a).closest("[data-SendNewsletters]").html(e).addClass(d);return!0}0==b&&(e="Questo indirizzo email \u00e8 gi\u00e0 iscritto alla newsletters!");2==b&&(e="Spiacenti, non \u00e8 stato possibile iscriverti alla newsletters");3==b&&(e="Inserisci un indirizzo email valido!");
$(a).closest("[data-SendNewsletters]").find("div").html(e).addClass(d).show()})};Main.prototype.createProducteInit=function(a){var b=$(a).attr("data-CreateProducteInit");a=$(a).attr("data-ModelId");$.get("/admin/insertFakeProduct/"+b+"/"+a,function(a){0<a?alert("Creato"):alert("Problemi")})};Main.prototype.offProduct=function(a){a=$(a).attr("data-pOff");$.get("/admin/offProduct?id="+a,function(a){1==a?alert("Eliminato"):alert("Problemi")})};
Main.prototype.manageBoxLogin=function(a){var b=this;this.isOpenLogin||(b.appendJs("//connect.facebook.net/it_IT/sdk.js"),b.appendJs("https://apis.google.com/js/api:client.js"),b.appendJs("/js/facebook.init.js"),b.appendJs("/js/google.init.js"),$.get("/ajax/getLoginHtml",function(a){$("body").append(a);$("[data-widgetLogin], [data-boxLogin]").show();b.isOpenLogin=!0}));$("[data-widgetLogin]").is(":hidden")?$("[data-widgetLogin], [data-boxLogin]").show():$("[data-widgetLogin], [data-boxLogin]").hide()};
Main.prototype.appendJs=function(a){var b=document.getElementsByTagName("head")[0],c=document.createElement("script");c.defer=!0;c.async=!0;c.src=a;b.appendChild(c)};Main.prototype.boxPaymentsOpen=function(a){$(a).closest("[data-boxPayments]").find("[data-boxPaymentsItems]").show();$(a).hide()};Main.prototype.lazy=function(a){"undefined"==typeof a&&(a="");"undefined"!=typeof unveil&&$(a+" .lazy").unveil(300,function(){$(this).load(function(){this.style.opacity=1})})};
Main.prototype.setCookie=function(a,b,c){if(c){var d=new Date;d.setTime(d.getTime()+c);c="; expires="+d.toGMTString()}else c="";document.cookie=a+"="+b+c+"; path=/"};Main.prototype.trackGAClickEvent=function(a,b,c,d){if("undefined"==typeof a||"undefined"==typeof b||"undefined"==typeof c||"undefined"==typeof ga)return!1;"undefined"!=typeof ga&&null!=a&&b&&(ga("send","event",a,b,c,4),console.info(typeof ga));return!0};
Main.prototype.getCookie=function(a){a+="=";for(var b=document.cookie.split(";"),c=0;c<b.length;c++){for(var d=b[c];" "==d.charAt(0);)d=d.substring(1,d.length);if(0==d.indexOf(a))return d.substring(a.length,d.length)}return null};Main.prototype.unsetCookie=function(a){this.setCookie(a,"",-1)};Main.prototype.openDataIntLink=function(a){window.location.href=a};var main=null,main=new Main;function Utils(){}
Utils.prototype={constructor:Utils,isElementInView:function(a,b){var c=$(window).scrollTop(),d=c+$(window).height(),e=$(a).offset().top,f=e+$(a).height();return!0===b?c<e&&d>f:e<=d&&f>=c}};var Utils=new Utils,WidgetSearchFilterProduct=function(){this.currentItemSuggestion=0;this.widgetSearchFilterProduct=$("[data-widgetSearchFilterProduct]");this.searchFilterProductForm=$("[data-widgetSearchFilterProduct]").find("#searchFilterProductForm");this.initListeners()};
WidgetSearchFilterProduct.prototype.initListeners=function(){var a=this;$("[data-widgetSearchFilterProduct] [data-submitbtn]").click(function(){a.sendSearch(this)});$("body").click(function(){setTimeout(function(){$("[data-responseSuggestionModel]").hide()},500)});this.enabledSuggestion=!0;$("[data-widgetSearchFilterProduct] .inputSearchBox").keyup(function(b){38!=b.which&&40!=b.which||a.selectItemSuggestion(b.which);if(13==b.which)return a.currentItemSuggestion=0,a.sendSearch(this),!1;38!=b.which&&
40!=b.which&&a.getTimeoutSuggestion(this)});$("#searchFilterProductForm [data-submitFilters]").click(function(){a.getSearchFilters()});$("#searchFilterProductForm [data-activeFilter]").click(function(){var a=1==$(this).attr("data-activeFilter")?"":1;$(this).attr("data-activeFilter",a)});$("[data-sorting]").change(function(){a.setOrder()})};
WidgetSearchFilterProduct.prototype.getSearchFilters=function(a){var b="?";a=""!=$("#searchFilterProductForm #minPrice").val()?"minPrice="+$("#searchFilterProductForm #minPrice").val()+"&":"";var c=""!=$("#searchFilterProductForm #maxPrice").val()?"maxPrice="+$("#searchFilterProductForm #maxPrice").val()+"&":"",d=""!=$("#searchFilterProductForm #searchFilter").val()?"search="+$("#searchFilterProductForm #searchFilter").val()+"&":"";$('#searchFilterProductForm [data-activeFilter="1"]').each(function(){b+=
$(this).attr("data-field")+"[]="+$(this).attr("data-value")+"&"});window.location.href=b+a+c+d};WidgetSearchFilterProduct.prototype.setOrder=function(){var a=$("[data-sorting]").val(),a=a.toLowerCase();window.location.href="?order="+a};
WidgetSearchFilterProduct.prototype.selectItemSuggestion=function(a){var b=$("[data-responseSuggestionModel] [data-item]").length;40==a?this.currentItemSuggestion++:this.currentItemSuggestion--;this.currentItemSuggestion>b&&(this.currentItemSuggestion=1);1>this.currentItemSuggestion&&(this.currentItemSuggestion=b);$("[data-responseSuggestionModel] [data-item]").removeClass("selected");$('[data-responseSuggestionModel] [data-item="'+this.currentItemSuggestion+'"]').addClass("selected");a=$('[data-responseSuggestionModel] [data-item="'+
this.currentItemSuggestion+'"]').val();$("[data-responseSuggestionModel] .inputSearchBox").val(a)};WidgetSearchFilterProduct.prototype.getTimeoutSuggestion=function(a){var b=this;"undefined"!=typeof this.suggestionTimeout&&clearTimeout(this.suggestionTimeout);this.suggestionTimeout=setTimeout(function(){b.getSuggestion(a)},150)};
WidgetSearchFilterProduct.prototype.getSuggestion=function(a){a="/suggestion/model?search="+$(a).val();$.ajax({url:a,type:"GET",async:!0,dataType:"html"}).done(function(a){$("[data-responseSuggestionModel]").html(a);""!=a?$("[data-responseSuggestionModel]").show():$("[data-responseSuggestionModel]").hide()})};
WidgetSearchFilterProduct.prototype.sendSearch=function(a){if(1==$("[data-responseSuggestionModel] [data-item].selected").length){var b=$("[data-responseSuggestionModel] [data-item].selected a").attr("href");"_blank"==$("[data-responseSuggestionModel] [data-item].selected a").attr("target")?window.open(b,"_blank"):window.location.href=b;return!1}b=$(a).closest("[data-widgetSearchFilterProduct]").find("#category").val();a=$(a).closest("[data-widgetSearchFilterProduct]").find("#search").val();if(2>
a.length)return alert("Inserisci la parola da ricercare"),!1;a=a.replace(/ /g,"_");window.location.href="/aSearch?category="+b+"&search="+a};var widgetSearchFilterProduct=null,widgetSearchFilterProduct=new WidgetSearchFilterProduct;coockie=null;var Coockie=function(){this.initListeners()};
Coockie.prototype.initListeners=function(){var a=this;this.infoCoockie();$("[data-block-prop]").click(function(a){a.stopPropagation()});$("[data-accept-coockie]").click(function(b){a.setCookie("accept-info-coockie","conditions_fully_accepted",3650);$("[data-info-coockie]").fadeOut()});"/info/coockie"!=window.location.pathname&&($('[data-action="urlCopy"], [data-lgt], [data-placelogo], [data-hamburger], a:not([data-block-prop]), img, [data-btn-prev], [data-btn-next]').click(function(){a.setCookie("accept-info-coockie",
"conditions_fully_accepted",3650);$("[data-info-coockie]").fadeOut()}),$("[data-widgetsearchfilterproduct] input").keypress(function(){a.setCookie("accept-info-coockie","conditions_fully_accepted",3650);$("[data-info-coockie]").fadeOut()}),$(window).scroll(function(){a.setCookie("accept-info-coockie","conditions_fully_accepted",3650);$("[data-info-coockie]").fadeOut()}))};Coockie.prototype.infoCoockie=function(){"conditions_fully_accepted"!=this.getCookie("accept-info-coockie")&&$("body").append('<div data-info-coockie class="info-coockie">Acquistigiusti.it utilizza cookie, di propriet\u00e0 e di terze parti.\n         Se vuoi saperne di pi\u00f9 o negare il consenso a tutti o ad alcuni cookie leggi <a data-block-prop href="/info/coockie">l\u2019informativa cookie</a>.\n        Scorrendo la pagina, cliccando questo banner o qualsiasi elemento in pagina acconsenti all\'utilizzo dei coockie. \n        <span data-accept-coockie>OK</span>\n        </div>')};
Coockie.prototype.setCookie=function(a,b,c){var d=new Date;d.setTime(d.getTime()+864E5*c);c="expires="+d.toUTCString();document.cookie=a+"="+b+";"+c+";path=/"};Coockie.prototype.getCookie=function(a){a+="=";for(var b=document.cookie.split(";"),c=0;c<b.length;c++){for(var d=b[c];" "==d.charAt(0);)d=d.substring(1,d.length);if(0==d.indexOf(a))return d.substring(a.length,d.length)}return null};Coockie.prototype.unsetCookie=function(a){this.setCookie(a,"",-1)};coockie=new Coockie;
var Modules=function(){this.aModules=[]};Modules.prototype.add=function(a,b,c,d,e,f,h,g){this.aModules[a]={widget:a,core:b,loadType:c,limit:d,category:e,varAttrAjax:f,affiliation:h,trademark:g}};Modules.prototype.getDataModule=function(a){return"undefined"==typeof this.aModules[a]?!1:this.aModules[a]};
Modules.prototype.load=function(){for(item in this.aModules)1==this.aModules[item].loadType&&this.getAsync(this.aModules[item].widget,this.aModules[item].core,this.aModules[item].limit,this.aModules[item].category,this.aModules[item].varAttrAjax,this.aModules[item].affiliation,this.aModules[item].trademark)};Modules.prototype.getAsync=function(a,b,c,d,e,f,h){var g=this,k=idNews;setTimeout(function(){g.getModule(a,b,k,!1,!1,c,d,e,f,h)},100)};
Modules.prototype.getModule=function(a,b,c,d,e,f,h,g,k,n){var l=this;"undefined"==typeof c&&(c="");"undefined"==typeof d&&(d="");$("["+g+"]").hide();var m="widget="+a+"&cores="+b+"&limit="+f+"&category="+h+"&affiliation="+k+"&trademark="+n+"&id="+c+d+"";$.ajax({url:ajaxCallPath+"widget?"+m,type:"GET",async:!0,dataType:"html"}).done(function(b){"undefined"!=typeof l.aModules[a]&&"widget_CommentsMatch"!=a&&(l.aModules[a].open=c);$('[dataReplaceWidget="'+g+'"]').replaceWith(b);setTimeout(function(){$("[dataReplaceWidget]").show()},
500);b=$("."+a).attr("data-callFunctions");"undefined"!=typeof b&&1==b&&l.getCallDataFunctionWidget(b,m)})};Modules.prototype.getCallDataFunctionWidget=function(a,b){$.ajax({url:ajaxCallPath+"dataWidget?"+b,type:"GET",async:!0,dataType:"html"}).done(function(a){socketClient.eachData(jQuery.parseJSON(a))})};modules=null;modules=new Modules;var WidgetMenu=function(){this.initListeners();$("[data-placeLogo]").html('<img src="'+$(".homeLogo img").attr("src")+'">')};
WidgetMenu.prototype.initListeners=function(){var a=this;$("[data-hamburger]").click(function(){$("[data-hamburger]").toggleClass("hamburgerOpen");$("[data-menu]").toggle();$("[data-menu]").is(":visible")?($("[data-op]").css("opacity","0.1"),$("[data-placeLogo]").css("visibility","hidden"),a.blockScroll()):($("[data-op]").css("opacity","1"),a.blockScroll(),$("[data-placeLogo]").css("visibility","visible"))});$("[data-menu] [data-cat]").click(function(){a.hamburger(this)});$("[data-placeLogo]").click(function(){window.location.href=
"/"});if(1E3>=$(window).width())$("[data-menu] [data-cat]").on("click",function(){$(".widget-menu").animate({scrollTop:$(this).offset().top-100},1E3);return!1})};WidgetMenu.prototype.blockScroll=function(a){10<=$(window).width()?$("[data-menu]").is(":visible")?($("[data-op]").css("opacity","0.1"),$("html, body").css({overflow:"hidden",height:"100%"})):($("[data-op]").css("opacity","1"),$("html, body").css({overflow:"auto",height:"auto"})):$("html, body").css({overflow:"auto",height:"auto"})};
WidgetMenu.prototype.hamburger=function(a){a=$(a).attr("data-cat");var b=!1;1E3>=$(window).width()&&($('[data-menu] [data-subMenuCat="'+a+'"]').is(":visible")?($('[data-menu] [data-subMenuCat="'+a+'"]').hide(),b=!0):$('[data-menu] [data-subMenuCat="'+a+'"]').show());$("[data-menu] [data-subMenuCat]").hide();b||($('[data-menu] [data-subMenuCat="'+a+'"]').is(":visible")?$('[data-menu] [data-subMenuCat="'+a+'"]').hide():$('[data-menu] [data-subMenuCat="'+a+'"]').show())};
var widgetModel=null,widgetModel=new WidgetMenu,WidgetUser=function(){this.initListeners()};
WidgetUser.prototype.initListeners=function(){var a=this;$("body").on("click","[data-logout]",function(b){1==a.isLogged()&&a.userLogout()});$("body").on("click",'[data-forgotPwd="1"]',function(b){bootbox.hideAll();a.openPopupForgotPwd()});$("body").on("click",'[data-resetPwd="1"]',function(a){var c=$("#resetPwd").val(),d=$("#confirmPwd").val();c!=d&&(a.stopPropagation(),a.preventDefault(),classModals.openModals({type:"custom",title:"Offerteprezzi.it",callbackModals:'              <div class="containerMsg">                  <div class="containerMsg">                      <div>                          <label>Le due password devono coincidere</label>                      </div>                  </div>              </div>'}))});
$("body").on("click",'[data-sendMail="1"]',function(b){b.stopPropagation();b.preventDefault();bootbox.hideAll();a.forgotPwd(this)});$("body").on("click","[data-defaultRegister]",function(b){a.sendRegistration(this)});$("body").on("click","[data-defaultLogin]",function(b){b.stopPropagation();b.preventDefault();a.sendLogin(this)})};WidgetUser.prototype.isLogged=function(a){var b=0;$.ajax({url:"/ajax/externalUser/Logged",type:"GET",async:!1,dataType:"html"}).done(function(a){b=a});return b};
WidgetUser.prototype.sendLogin=function(a){var b=0,c=$(a).closest("[data-formLogin]").serialize(),d=$(a).closest("[data-formLogin]").find("#email");if(""==$(a).closest("[data-formLogin]").find("#password").val()||""==d.val())return $("[data-boxLogin] [data-boxRespUser]").addClass("error"),$("[data-boxLogin] [data-boxRespUser]").html("Inserisci email e password"),$("[data-boxLogin] [data-boxRespUser]").show(),setTimeout(function(){$("[data-boxLogin] [data-boxRespUser]").hide();$("[data-boxLogin] [data-boxRespUser]").removeClass("error")},
5E3),!1;$.ajax({url:"/ajax/externalUser/Login?"+c,type:"POST",async:!0,dataType:"html"}).done(function(a){b=a;var c=[];c.type=0!=a?"success":"error";c.layout="top";c.mex=0!=a?"Login Effettuato con successo":"Login errato";$("[data-boxLogin] [data-boxRespUser]").addClass(c.type);$("[data-boxLogin] [data-boxRespUser]").html(c.mex);$("[data-boxLogin] [data-boxRespUser]").show();setTimeout(function(){$("[data-boxLogin] [data-boxRespUser]").hide();$("[data-boxLogin] [data-boxRespUser]").removeClass(c.type);
0!=a&&($("[data-widgetLogin], [data-boxLogin]").toggle(),window.location.href="/")},3E3)});return b};
WidgetUser.prototype.sendRegistration=function(a){var b=$(a).closest("[data-formRegistration]").serialize(),c=$(a).closest("[data-formRegistration]").find("#email2"),d=$(a).closest("[data-formRegistration]").find("#password2");a=$(a).closest("[data-formRegistration]").find("#privacy");if(""==d.val()||""==c.val()||!a.is(":checked"))return $("[data-boxLogin] [data-boxRespUser]").addClass("error"),$("[data-boxLogin] [data-boxRespUser]").html("Inserisci email password, e consenso informativa privacy"),$("[data-boxLogin] [data-boxRespUser]").show(),
setTimeout(function(){$("[data-boxLogin] [data-boxRespUser]").hide();$("[data-boxLogin] [data-boxRespUser]").removeClass("error")},5E3),!1;$.ajax({url:"/ajax/sendRegistration/externalUser?"+b,type:"POST",async:!0,dataType:"html"}).done(function(a){var b="error";if(1==a)var c="Registrazione avvenuta con successo",b="success";0==a&&(c="Errore durante la Registrazione. Riprova!");2==a&&(c="Errore durante la Registrazione. Indirizzo Mail gi\u00e0 presente!");3==a&&(c="Inserisci un indirizzo email valido!");
var d=[];d.type=b;d.layout="top";d.mex=c;$("[data-boxLogin] [data-boxRespUser]").addClass(d.type);$("[data-boxLogin] [data-boxRespUser]").html(d.mex);$("[data-boxLogin] [data-boxRespUser]").show();setTimeout(function(){$("[data-boxLogin] [data-boxRespUser]").hide();$("[data-boxLogin] [data-boxRespUser]").removeClass(d.type);1==resp&&(window.location.href="/")},3E3)})};WidgetUser.prototype.openPopupLogin=function(){classModals.openModals({type:"custom",title:"ACCEDI",callbackModals:'            <div class="containerForm">                <form id="formLogin" class="login-form" data-formLogin>                    <div class="form__row">                        <div>                            <input id="loginEmail" class="form__input-text form__input-text--m-top" type="email" name="loginEmail" placeholder="E-mail" value="">                        </div>                        <div>                            <input id="loginPassword" class="form__input-text form__input-text--m-top" type="password" name="loginPassword" placeholder="Password" value="">                        </div>                        <label class="lblForgotPwd" data-forgotPwd="1" >Hai dimenticato la password?</label>                        <div class="form__row form__row--m-login">                            <div>                                <input id="button-login" class="button button--fill button--big" type="submit" data-defaultLogin value="Accedi">                            </div>                            <label class="lblRegister" data-register="1" >Non sei ancora registrato?</label>                        </div>                    </div>                </form>                <div>                    <input class="facebookLogin button button--fill button--big" data-FbLogin type="submit" value="Accedi con Fb">                </div>            </div>'})};
WidgetUser.prototype.openPopupForgotPwd=function(){classModals.openModals({type:"custom",title:"RESETTA PASSWORD",callbackModals:'            <div class="containerForm">                <form id="formForgotPwd" class="reset-form" data-formForgotPwd>                    <div class="form__row">                        <div>                            <input id="resetEmail" class="form__input-text form__input-text--m-top" type="email" name="resetEmail" placeholder="E-mail" value="">                        </div>                        <div class="form__row form__row--m-login">                            <div>                                <input id="button-reset" class="button button--fill button--big" type="submit" data-sendMail="1" value="Invia Mail">                            </div>                        </div>                    </div>                </form>            </div>'})};
WidgetUser.prototype.openPopupRegistration=function(a){var b="";null!=a&&$(a).each(function(){});for(a=6;100>a;a++)b+='<option value="'+a+'">'+a+"</option>";classModals.openModals({type:"custom",title:"REGISTRATI",callbackModals:'            <div class="containerForm">                <form id="formRegistration" onSubmit="return false" class="registration-form" data-formRegistration>                    <div class="form__row">                        <div>                            <input id="registrationName" type="text" name="registrationName" placeholder="Nome" required>                        </div>                        <div>                            <input id="registrationSurname" type="text" name="registrationSurname" placeholder="Cognome" value="">                        </div>                        <div>                            <input id="registrationEmail" type="email" name="registrationEmail" placeholder="E-mail" value="">                        </div>                        <div>                            <input id="registrationPassword" type="password" name="registrationPassword" placeholder="Password" value="">                        </div>                        <div>                            <select id="registrationAge" class="selectIsTeam"  name="registrationAge">                            '+
b+'                            </select>                        </div>                        <div>                            <input id="registrationCity" type="hidden" name="registrationCity" placeholder="Citt\u00e0" value="">                        </div>                        <div>                            <input id="registrationTeam" class="selectIsTeam" name="registrationTeam" value="0" type="hidden">                        </div>                        <div class="form__row form__row--m-login">                            <div>                                <input type="submit" id="button-registration" data-addUser="1" class="button button--fill button--big" value="Registrati">                            </div>                        </div>                    </div>                </form>            </div>'});
$(".containerForm").closest(".modal-content").css("height","600px")};WidgetUser.prototype.retrieveTeam=function(){var a=this;$.ajax({url:"/ajax/retrieve/team",type:"GET",async:!0,dataType:"json"}).done(function(b){null!=b&&a.openPopupRegistration(b)});return!1};
WidgetUser.prototype.forgotPwd=function(a){a=$(a).closest("[data-formForgotPwd]").serialize();$.ajax({url:"/ajax/forgot/password?"+a,type:"POST",async:!0,dataType:"json"}).done(function(a){null!=a&&classModals.openModals({type:"custom",title:"Calciomercato.it",callbackModals:'                        <div class="containerMsg">                            <div class="containerMsg">                                <div>                                    <label>Ti abbiamo inviato una mail al tuo indirizzo</label>                                </div>                            </div>                        </div>'})});
return!1};WidgetUser.prototype.userLogout=function(a){$.ajax({url:"/logoutExternalUser",type:"POST",async:!0,dataType:"html"}).done(function(a){if(0!=a)window.location.href="/";else return!1})};var widgetUser=null,widgetUser=new WidgetUser;

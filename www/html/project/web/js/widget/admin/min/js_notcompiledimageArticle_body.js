/*!
 * Bootstrap v3.1.1 (http://getbootstrap.com)
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one(a.support.transition.end,function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b()})}(jQuery),+function(a){"use strict";var b='[data-dismiss="alert"]',c=function(c){a(c).on("click",b,this.close)};c.prototype.close=function(b){function c(){f.trigger("closed.bs.alert").remove()}var d=a(this),e=d.attr("data-target");e||(e=d.attr("href"),e=e&&e.replace(/.*(?=#[^\s]*$)/,""));var f=a(e);b&&b.preventDefault(),f.length||(f=d.hasClass("alert")?d:d.parent()),f.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(f.removeClass("in"),a.support.transition&&f.hasClass("fade")?f.one(a.support.transition.end,c).emulateTransitionEnd(150):c())};var d=a.fn.alert;a.fn.alert=function(b){return this.each(function(){var d=a(this),e=d.data("bs.alert");e||d.data("bs.alert",e=new c(this)),"string"==typeof b&&e[b].call(d)})},a.fn.alert.Constructor=c,a.fn.alert.noConflict=function(){return a.fn.alert=d,this},a(document).on("click.bs.alert.data-api",b,c.prototype.close)}(jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.isLoading=!1};b.DEFAULTS={loadingText:"loading..."},b.prototype.setState=function(b){var c="disabled",d=this.$element,e=d.is("input")?"val":"html",f=d.data();b+="Text",f.resetText||d.data("resetText",d[e]()),d[e](f[b]||this.options[b]),setTimeout(a.proxy(function(){"loadingText"==b?(this.isLoading=!0,d.addClass(c).attr(c,c)):this.isLoading&&(this.isLoading=!1,d.removeClass(c).removeAttr(c))},this),0)},b.prototype.toggle=function(){var a=!0,b=this.$element.closest('[data-toggle="buttons"]');if(b.length){var c=this.$element.find("input");"radio"==c.prop("type")&&(c.prop("checked")&&this.$element.hasClass("active")?a=!1:b.find(".active").removeClass("active")),a&&c.prop("checked",!this.$element.hasClass("active")).trigger("change")}a&&this.$element.toggleClass("active")};var c=a.fn.button;a.fn.button=function(c){return this.each(function(){var d=a(this),e=d.data("bs.button"),f="object"==typeof c&&c;e||d.data("bs.button",e=new b(this,f)),"toggle"==c?e.toggle():c&&e.setState(c)})},a.fn.button.Constructor=b,a.fn.button.noConflict=function(){return a.fn.button=c,this},a(document).on("click.bs.button.data-api","[data-toggle^=button]",function(b){var c=a(b.target);c.hasClass("btn")||(c=c.closest(".btn")),c.button("toggle"),b.preventDefault()})}(jQuery),+function(a){"use strict";var b=function(b,c){this.$element=a(b),this.$indicators=this.$element.find(".carousel-indicators"),this.options=c,this.paused=this.sliding=this.interval=this.$active=this.$items=null,"hover"==this.options.pause&&this.$element.on("mouseenter",a.proxy(this.pause,this)).on("mouseleave",a.proxy(this.cycle,this))};b.DEFAULTS={interval:5e3,pause:"hover",wrap:!0},b.prototype.cycle=function(b){return b||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(a.proxy(this.next,this),this.options.interval)),this},b.prototype.getActiveIndex=function(){return this.$active=this.$element.find(".item.active"),this.$items=this.$active.parent().children(),this.$items.index(this.$active)},b.prototype.to=function(b){var c=this,d=this.getActiveIndex();return b>this.$items.length-1||0>b?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){c.to(b)}):d==b?this.pause().cycle():this.slide(b>d?"next":"prev",a(this.$items[b]))},b.prototype.pause=function(b){return b||(this.paused=!0),this.$element.find(".next, .prev").length&&a.support.transition&&(this.$element.trigger(a.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},b.prototype.next=function(){return this.sliding?void 0:this.slide("next")},b.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")},b.prototype.slide=function(b,c){var d=this.$element.find(".item.active"),e=c||d[b](),f=this.interval,g="next"==b?"left":"right",h="next"==b?"first":"last",i=this;if(!e.length){if(!this.options.wrap)return;e=this.$element.find(".item")[h]()}if(e.hasClass("active"))return this.sliding=!1;var j=a.Event("slide.bs.carousel",{relatedTarget:e[0],direction:g});return this.$element.trigger(j),j.isDefaultPrevented()?void 0:(this.sliding=!0,f&&this.pause(),this.$indicators.length&&(this.$indicators.find(".active").removeClass("active"),this.$element.one("slid.bs.carousel",function(){var b=a(i.$indicators.children()[i.getActiveIndex()]);b&&b.addClass("active")})),a.support.transition&&this.$element.hasClass("slide")?(e.addClass(b),e[0].offsetWidth,d.addClass(g),e.addClass(g),d.one(a.support.transition.end,function(){e.removeClass([b,g].join(" ")).addClass("active"),d.removeClass(["active",g].join(" ")),i.sliding=!1,setTimeout(function(){i.$element.trigger("slid.bs.carousel")},0)}).emulateTransitionEnd(1e3*d.css("transition-duration").slice(0,-1))):(d.removeClass("active"),e.addClass("active"),this.sliding=!1,this.$element.trigger("slid.bs.carousel")),f&&this.cycle(),this)};var c=a.fn.carousel;a.fn.carousel=function(c){return this.each(function(){var d=a(this),e=d.data("bs.carousel"),f=a.extend({},b.DEFAULTS,d.data(),"object"==typeof c&&c),g="string"==typeof c?c:f.slide;e||d.data("bs.carousel",e=new b(this,f)),"number"==typeof c?e.to(c):g?e[g]():f.interval&&e.pause().cycle()})},a.fn.carousel.Constructor=b,a.fn.carousel.noConflict=function(){return a.fn.carousel=c,this},a(document).on("click.bs.carousel.data-api","[data-slide], [data-slide-to]",function(b){var c,d=a(this),e=a(d.attr("data-target")||(c=d.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,"")),f=a.extend({},e.data(),d.data()),g=d.attr("data-slide-to");g&&(f.interval=!1),e.carousel(f),(g=d.attr("data-slide-to"))&&e.data("bs.carousel").to(g),b.preventDefault()}),a(window).on("load",function(){a('[data-ride="carousel"]').each(function(){var b=a(this);b.carousel(b.data())})})}(jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.transitioning=null,this.options.parent&&(this.$parent=a(this.options.parent)),this.options.toggle&&this.toggle()};b.DEFAULTS={toggle:!0},b.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},b.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b=a.Event("show.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.$parent&&this.$parent.find("> .panel > .in");if(c&&c.length){var d=c.data("bs.collapse");if(d&&d.transitioning)return;c.collapse("hide"),d||c.data("bs.collapse",null)}var e=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[e](0),this.transitioning=1;var f=function(){this.$element.removeClass("collapsing").addClass("collapse in")[e]("auto"),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return f.call(this);var g=a.camelCase(["scroll",e].join("-"));this.$element.one(a.support.transition.end,a.proxy(f,this)).emulateTransitionEnd(350)[e](this.$element[0][g])}}},b.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse").removeClass("in"),this.transitioning=1;var d=function(){this.transitioning=0,this.$element.trigger("hidden.bs.collapse").removeClass("collapsing").addClass("collapse")};return a.support.transition?void this.$element[c](0).one(a.support.transition.end,a.proxy(d,this)).emulateTransitionEnd(350):d.call(this)}}},b.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()};var c=a.fn.collapse;a.fn.collapse=function(c){return this.each(function(){var d=a(this),e=d.data("bs.collapse"),f=a.extend({},b.DEFAULTS,d.data(),"object"==typeof c&&c);!e&&f.toggle&&"show"==c&&(c=!c),e||d.data("bs.collapse",e=new b(this,f)),"string"==typeof c&&e[c]()})},a.fn.collapse.Constructor=b,a.fn.collapse.noConflict=function(){return a.fn.collapse=c,this},a(document).on("click.bs.collapse.data-api","[data-toggle=collapse]",function(b){var c,d=a(this),e=d.attr("data-target")||b.preventDefault()||(c=d.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,""),f=a(e),g=f.data("bs.collapse"),h=g?"toggle":d.data(),i=d.attr("data-parent"),j=i&&a(i);g&&g.transitioning||(j&&j.find('[data-toggle=collapse][data-parent="'+i+'"]').not(d).addClass("collapsed"),d[f.hasClass("in")?"addClass":"removeClass"]("collapsed")),f.collapse(h)})}(jQuery),+function(a){"use strict";function b(b){a(d).remove(),a(e).each(function(){var d=c(a(this)),e={relatedTarget:this};d.hasClass("open")&&(d.trigger(b=a.Event("hide.bs.dropdown",e)),b.isDefaultPrevented()||d.removeClass("open").trigger("hidden.bs.dropdown",e))})}function c(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}var d=".dropdown-backdrop",e="[data-toggle=dropdown]",f=function(b){a(b).on("click.bs.dropdown",this.toggle)};f.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=c(e),g=f.hasClass("open");if(b(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click",b);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;f.toggleClass("open").trigger("shown.bs.dropdown",h),e.focus()}return!1}},f.prototype.keydown=function(b){if(/(38|40|27)/.test(b.keyCode)){var d=a(this);if(b.preventDefault(),b.stopPropagation(),!d.is(".disabled, :disabled")){var f=c(d),g=f.hasClass("open");if(!g||g&&27==b.keyCode)return 27==b.which&&f.find(e).focus(),d.click();var h=" li:not(.divider):visible a",i=f.find("[role=menu]"+h+", [role=listbox]"+h);if(i.length){var j=i.index(i.filter(":focus"));38==b.keyCode&&j>0&&j--,40==b.keyCode&&j<i.length-1&&j++,~j||(j=0),i.eq(j).focus()}}}};var g=a.fn.dropdown;a.fn.dropdown=function(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new f(this)),"string"==typeof b&&d[b].call(c)})},a.fn.dropdown.Constructor=f,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=g,this},a(document).on("click.bs.dropdown.data-api",b).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",e,f.prototype.toggle).on("keydown.bs.dropdown.data-api",e+", [role=menu], [role=listbox]",f.prototype.keydown)}(jQuery),+function(a){"use strict";var b=function(b,c){this.options=c,this.$element=a(b),this.$backdrop=this.isShown=null,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};b.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},b.prototype.toggle=function(a){return this[this.isShown?"hide":"show"](a)},b.prototype.show=function(b){var c=this,d=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(d),this.isShown||d.isDefaultPrevented()||(this.isShown=!0,this.escape(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.backdrop(function(){var d=a.support.transition&&c.$element.hasClass("fade");c.$element.parent().length||c.$element.appendTo(document.body),c.$element.show().scrollTop(0),d&&c.$element[0].offsetWidth,c.$element.addClass("in").attr("aria-hidden",!1),c.enforceFocus();var e=a.Event("shown.bs.modal",{relatedTarget:b});d?c.$element.find(".modal-dialog").one(a.support.transition.end,function(){c.$element.focus().trigger(e)}).emulateTransitionEnd(300):c.$element.focus().trigger(e)}))},b.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one(a.support.transition.end,a.proxy(this.hideModal,this)).emulateTransitionEnd(300):this.hideModal())},b.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.focus()},this))},b.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keyup.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keyup.dismiss.bs.modal")},b.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.removeBackdrop(),a.$element.trigger("hidden.bs.modal")})},b.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},b.prototype.backdrop=function(b){var c=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var d=a.support.transition&&c;if(this.$backdrop=a('<div class="modal-backdrop '+c+'" />').appendTo(document.body),this.$element.on("click.dismiss.bs.modal",a.proxy(function(a){a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),d&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;d?this.$backdrop.one(a.support.transition.end,b).emulateTransitionEnd(150):b()}else!this.isShown&&this.$backdrop?(this.$backdrop.removeClass("in"),a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one(a.support.transition.end,b).emulateTransitionEnd(150):b()):b&&b()};var c=a.fn.modal;a.fn.modal=function(c,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},b.DEFAULTS,e.data(),"object"==typeof c&&c);f||e.data("bs.modal",f=new b(this,g)),"string"==typeof c?f[c](d):g.show&&f.show(d)})},a.fn.modal.Constructor=b,a.fn.modal.noConflict=function(){return a.fn.modal=c,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(b){var c=a(this),d=c.attr("href"),e=a(c.attr("data-target")||d&&d.replace(/.*(?=#[^\s]+$)/,"")),f=e.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(d)&&d},e.data(),c.data());c.is("a")&&b.preventDefault(),e.modal(f,this).one("hide",function(){c.is(":visible")&&c.focus()})}),a(document).on("show.bs.modal",".modal",function(){a(document.body).addClass("modal-open")}).on("hidden.bs.modal",".modal",function(){a(document.body).removeClass("modal-open")})}(jQuery),+function(a){"use strict";var b=function(a,b){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",a,b)};b.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1},b.prototype.init=function(b,c,d){this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d);for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},b.prototype.getDefaults=function(){return b.DEFAULTS},b.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},b.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},b.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show()},b.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type);return clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()},b.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){if(this.$element.trigger(b),b.isDefaultPrevented())return;var c=this,d=this.tip();this.setContent(),this.options.animation&&d.addClass("fade");var e="function"==typeof this.options.placement?this.options.placement.call(this,d[0],this.$element[0]):this.options.placement,f=/\s?auto?\s?/i,g=f.test(e);g&&(e=e.replace(f,"")||"top"),d.detach().css({top:0,left:0,display:"block"}).addClass(e),this.options.container?d.appendTo(this.options.container):d.insertAfter(this.$element);var h=this.getPosition(),i=d[0].offsetWidth,j=d[0].offsetHeight;if(g){var k=this.$element.parent(),l=e,m=document.documentElement.scrollTop||document.body.scrollTop,n="body"==this.options.container?window.innerWidth:k.outerWidth(),o="body"==this.options.container?window.innerHeight:k.outerHeight(),p="body"==this.options.container?0:k.offset().left;e="bottom"==e&&h.top+h.height+j-m>o?"top":"top"==e&&h.top-m-j<0?"bottom":"right"==e&&h.right+i>n?"left":"left"==e&&h.left-i<p?"right":e,d.removeClass(l).addClass(e)}var q=this.getCalculatedOffset(e,h,i,j);this.applyPlacement(q,e),this.hoverState=null;var r=function(){c.$element.trigger("shown.bs."+c.type)};a.support.transition&&this.$tip.hasClass("fade")?d.one(a.support.transition.end,r).emulateTransitionEnd(150):r()}},b.prototype.applyPlacement=function(b,c){var d,e=this.tip(),f=e[0].offsetWidth,g=e[0].offsetHeight,h=parseInt(e.css("margin-top"),10),i=parseInt(e.css("margin-left"),10);isNaN(h)&&(h=0),isNaN(i)&&(i=0),b.top=b.top+h,b.left=b.left+i,a.offset.setOffset(e[0],a.extend({using:function(a){e.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),e.addClass("in");var j=e[0].offsetWidth,k=e[0].offsetHeight;if("top"==c&&k!=g&&(d=!0,b.top=b.top+g-k),/bottom|top/.test(c)){var l=0;b.left<0&&(l=-2*b.left,b.left=0,e.offset(b),j=e[0].offsetWidth,k=e[0].offsetHeight),this.replaceArrow(l-f+j,j,"left")}else this.replaceArrow(k-g,k,"top");d&&e.offset(b)},b.prototype.replaceArrow=function(a,b,c){this.arrow().css(c,a?50*(1-a/b)+"%":"")},b.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},b.prototype.hide=function(){function b(){"in"!=c.hoverState&&d.detach(),c.$element.trigger("hidden.bs."+c.type)}var c=this,d=this.tip(),e=a.Event("hide.bs."+this.type);return this.$element.trigger(e),e.isDefaultPrevented()?void 0:(d.removeClass("in"),a.support.transition&&this.$tip.hasClass("fade")?d.one(a.support.transition.end,b).emulateTransitionEnd(150):b(),this.hoverState=null,this)},b.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},b.prototype.hasContent=function(){return this.getTitle()},b.prototype.getPosition=function(){var b=this.$element[0];return a.extend({},"function"==typeof b.getBoundingClientRect?b.getBoundingClientRect():{width:b.offsetWidth,height:b.offsetHeight},this.$element.offset())},b.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},b.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},b.prototype.tip=function(){return this.$tip=this.$tip||a(this.options.template)},b.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},b.prototype.validate=function(){this.$element[0].parentNode||(this.hide(),this.$element=null,this.options=null)},b.prototype.enable=function(){this.enabled=!0},b.prototype.disable=function(){this.enabled=!1},b.prototype.toggleEnabled=function(){this.enabled=!this.enabled},b.prototype.toggle=function(b){var c=b?a(b.currentTarget)[this.type](this.getDelegateOptions()).data("bs."+this.type):this;c.tip().hasClass("in")?c.leave(c):c.enter(c)},b.prototype.destroy=function(){clearTimeout(this.timeout),this.hide().$element.off("."+this.type).removeData("bs."+this.type)};var c=a.fn.tooltip;a.fn.tooltip=function(c){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof c&&c;(e||"destroy"!=c)&&(e||d.data("bs.tooltip",e=new b(this,f)),"string"==typeof c&&e[c]())})},a.fn.tooltip.Constructor=b,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=c,this}}(jQuery),+function(a){"use strict";var b=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");b.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),b.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),b.prototype.constructor=b,b.prototype.getDefaults=function(){return b.DEFAULTS},b.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content")[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},b.prototype.hasContent=function(){return this.getTitle()||this.getContent()},b.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},b.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},b.prototype.tip=function(){return this.$tip||(this.$tip=a(this.options.template)),this.$tip};var c=a.fn.popover;a.fn.popover=function(c){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof c&&c;(e||"destroy"!=c)&&(e||d.data("bs.popover",e=new b(this,f)),"string"==typeof c&&e[c]())})},a.fn.popover.Constructor=b,a.fn.popover.noConflict=function(){return a.fn.popover=c,this}}(jQuery),+function(a){"use strict";function b(c,d){var e,f=a.proxy(this.process,this);this.$element=a(a(c).is("body")?window:c),this.$body=a("body"),this.$scrollElement=this.$element.on("scroll.bs.scroll-spy.data-api",f),this.options=a.extend({},b.DEFAULTS,d),this.selector=(this.options.target||(e=a(c).attr("href"))&&e.replace(/.*(?=#[^\s]+$)/,"")||"")+" .nav li > a",this.offsets=a([]),this.targets=a([]),this.activeTarget=null,this.refresh(),this.process()}b.DEFAULTS={offset:10},b.prototype.refresh=function(){var b=this.$element[0]==window?"offset":"position";this.offsets=a([]),this.targets=a([]);{var c=this;this.$body.find(this.selector).map(function(){var d=a(this),e=d.data("target")||d.attr("href"),f=/^#./.test(e)&&a(e);return f&&f.length&&f.is(":visible")&&[[f[b]().top+(!a.isWindow(c.$scrollElement.get(0))&&c.$scrollElement.scrollTop()),e]]||null}).sort(function(a,b){return a[0]-b[0]}).each(function(){c.offsets.push(this[0]),c.targets.push(this[1])})}},b.prototype.process=function(){var a,b=this.$scrollElement.scrollTop()+this.options.offset,c=this.$scrollElement[0].scrollHeight||this.$body[0].scrollHeight,d=c-this.$scrollElement.height(),e=this.offsets,f=this.targets,g=this.activeTarget;if(b>=d)return g!=(a=f.last()[0])&&this.activate(a);if(g&&b<=e[0])return g!=(a=f[0])&&this.activate(a);for(a=e.length;a--;)g!=f[a]&&b>=e[a]&&(!e[a+1]||b<=e[a+1])&&this.activate(f[a])},b.prototype.activate=function(b){this.activeTarget=b,a(this.selector).parentsUntil(this.options.target,".active").removeClass("active");var c=this.selector+'[data-target="'+b+'"],'+this.selector+'[href="'+b+'"]',d=a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length&&(d=d.closest("li.dropdown").addClass("active")),d.trigger("activate.bs.scrollspy")};var c=a.fn.scrollspy;a.fn.scrollspy=function(c){return this.each(function(){var d=a(this),e=d.data("bs.scrollspy"),f="object"==typeof c&&c;e||d.data("bs.scrollspy",e=new b(this,f)),"string"==typeof c&&e[c]()})},a.fn.scrollspy.Constructor=b,a.fn.scrollspy.noConflict=function(){return a.fn.scrollspy=c,this},a(window).on("load",function(){a('[data-spy="scroll"]').each(function(){var b=a(this);b.scrollspy(b.data())})})}(jQuery),+function(a){"use strict";var b=function(b){this.element=a(b)};b.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a")[0],f=a.Event("show.bs.tab",{relatedTarget:e});if(b.trigger(f),!f.isDefaultPrevented()){var g=a(d);this.activate(b.parent("li"),c),this.activate(g,g.parent(),function(){b.trigger({type:"shown.bs.tab",relatedTarget:e})})}}},b.prototype.activate=function(b,c,d){function e(){f.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"),b.addClass("active"),g?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu")&&b.closest("li.dropdown").addClass("active"),d&&d()}var f=c.find("> .active"),g=d&&a.support.transition&&f.hasClass("fade");g?f.one(a.support.transition.end,e).emulateTransitionEnd(150):e(),f.removeClass("in")};var c=a.fn.tab;a.fn.tab=function(c){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new b(this)),"string"==typeof c&&e[c]()})},a.fn.tab.Constructor=b,a.fn.tab.noConflict=function(){return a.fn.tab=c,this},a(document).on("click.bs.tab.data-api",'[data-toggle="tab"], [data-toggle="pill"]',function(b){b.preventDefault(),a(this).tab("show")})}(jQuery),+function(a){"use strict";var b=function(c,d){this.options=a.extend({},b.DEFAULTS,d),this.$window=a(window).on("scroll.bs.affix.data-api",a.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",a.proxy(this.checkPositionWithEventLoop,this)),this.$element=a(c),this.affixed=this.unpin=this.pinnedOffset=null,this.checkPosition()};b.RESET="affix affix-top affix-bottom",b.DEFAULTS={offset:0},b.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(b.RESET).addClass("affix");var a=this.$window.scrollTop(),c=this.$element.offset();return this.pinnedOffset=c.top-a},b.prototype.checkPositionWithEventLoop=function(){setTimeout(a.proxy(this.checkPosition,this),1)},b.prototype.checkPosition=function(){if(this.$element.is(":visible")){var c=a(document).height(),d=this.$window.scrollTop(),e=this.$element.offset(),f=this.options.offset,g=f.top,h=f.bottom;"top"==this.affixed&&(e.top+=d),"object"!=typeof f&&(h=g=f),"function"==typeof g&&(g=f.top(this.$element)),"function"==typeof h&&(h=f.bottom(this.$element));var i=null!=this.unpin&&d+this.unpin<=e.top?!1:null!=h&&e.top+this.$element.height()>=c-h?"bottom":null!=g&&g>=d?"top":!1;if(this.affixed!==i){this.unpin&&this.$element.css("top","");var j="affix"+(i?"-"+i:""),k=a.Event(j+".bs.affix");this.$element.trigger(k),k.isDefaultPrevented()||(this.affixed=i,this.unpin="bottom"==i?this.getPinnedOffset():null,this.$element.removeClass(b.RESET).addClass(j).trigger(a.Event(j.replace("affix","affixed"))),"bottom"==i&&this.$element.offset({top:c-h-this.$element.height()}))}}};var c=a.fn.affix;a.fn.affix=function(c){return this.each(function(){var d=a(this),e=d.data("bs.affix"),f="object"==typeof c&&c;e||d.data("bs.affix",e=new b(this,f)),"string"==typeof c&&e[c]()})},a.fn.affix.Constructor=b,a.fn.affix.noConflict=function(){return a.fn.affix=c,this},a(window).on("load",function(){a('[data-spy="affix"]').each(function(){var b=a(this),c=b.data();c.offset=c.offset||{},c.offsetBottom&&(c.offset.bottom=c.offsetBottom),c.offsetTop&&(c.offset.top=c.offsetTop),b.affix(c)})})}(jQuery)
;
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
classModals = null;
$( function() {
    classModals = new ClassModals();
});

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
//})
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
classNotyfy = null;
$( function() {
    classNotyfy = new ClassNotyfy();
});

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
}
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
})
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
};

ManagerLinks.prototype.openJsLink = function ( sender ) {
//    target = "_blank" todo
    window.location.href = $( sender ).attr( 'data-ln' );
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
/**
 * Classe per la gestione dei moduli del sito
 */
var Modules = function() {
    this.aModules = new Array();    
};

Modules.prototype.add = function ( widget, core, loadType ) {
    this.aModules[widget] = {'widget':widget, 'core':core, 'loadType':loadType};     
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
            that.getAsync( that.aModules[item]['widget'], that.aModules[item]['core'] );
        }
    }    
};

/**
 * Recupera il widget in modalita asicrona
 * @param {type} widget
 * @param {type} core
 * @returns {undefined}
 */
Modules.prototype.getAsync = function ( widget, core ) {
    var that = this;
    var id = null;
    //widget == 'widgetFbPage' ||
    var interval = widget == 'widget_Highlights' ||  widget == 'widgetAdsGoogle' ? 5000 : 2000;
    if(widget == 'widget_FormationsFieldLastMatchTeam') {
        id = feedTeamId;
    }
    setTimeout( function() {
        that.getModule( widget, core, id );
    }, interval );
};

/**
 * Metodo che fa il replace con il contenuto del modulo
 * @param {type} module 
 * @returns {undefined}
 */
Modules.prototype.getModule = function ( widget, core, id, paramsExtra, callback ) {
    var that = this;   

    if( typeof id == 'undefined' )
        id = '';
        
    if( typeof paramsExtra == 'undefined' )
        paramsExtra ='';
        
    if( widget != 'widget_LiveScoreMatch' )
        $( '.'+widget ).find( '.widget-body' ).replaceWith( '<div class="text-center"><img widht="64" heidth="64" src="/images/loader.gif"></div>');
    
    //Determina se bisogna differenziare la url avvinche la versione desktop e la versione mobile sia cachate in modo differente
    var changeUrlForCacheIfIsMobile = '';
    if( widget == 'widget_FormationsFieldAndTable' && isMobile )
        changeUrlForCacheIfIsMobile = '&isMobile=1';
    
    var params = "widget="+widget+"&cores="+core+"&id="+id+paramsExtra+changeUrlForCacheIfIsMobile;
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
        
        //se il widget è widget_TableLiveScoreHome sta recuperando una o piu partite da appendere al widget padre delle partite e vado in modalità append
        if( widget == 'widget_TableLiveScoreHome' ) {
//            var label = '<h5 class="innerAll margin-none border-bottom bg-primary" id="labelOtherMatch"> Altre partite </h5>';
            var label = '';
            $( '.widget_LiveScoreHome .tab-content #matches' ).append( label+html );
        } else {
            $( '.'+widget ).replaceWith( html );
        }
        
        if( typeof callback != 'undefined' ) {
            if( typeof callback.params != 'undefined' )
                callback.call( callback.params[0] );
            else
                callback.call();
        }
                
        //Se il modulo è widget_CommentsMatch
        if( widget == 'widget_CommentsMatch' ) {
            FB.XFBML.parse();
        }
        
        $( '.'+widget ).hide();
        setTimeout( function() {
//            $( '.'+widget ).slideDown( 'slow' );
            $( '.'+widget ).show();
        },150);
        
        
        
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
main = null;
$( function() {
    main = new Main();
});

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
    createCookie(name,"",-1);
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


;
mainAdmin = null;
$(function () {
    mainAdmin = new MainAdmin();
});

/**
 * Classe per la gestione della homepage
 */
var MainAdmin = function () {
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

};

MainAdmin.prototype.parseHtmlEntities = function ( str ) {
    return str.replace(/&#([0-9]{1,3});/gi, function(match, numStr) {
        var num = parseInt(numStr, 10);
        return String.fromCharCode(num);
    });
};

MainAdmin.prototype.speakSite = function ( speak ) {
    if( this.speakEnabled != 1 )
        return false;
    
    if( typeof speak == 'undefined' )
        return false;
    
    speak = speak.toLowerCase();
    speak = this.parseHtmlEntities(  speak.replace( /<.*?>/g, '' ));
    speak = speak.replace( '.', ',' ).replace( '&agrave', 'à' ).replace( '&eacute', 'é' ).replace( '&egrave', 'è' ).replace( '&igrave', 'ì' ).replace( '&ograve', 'ò' ).replace( '&ugrave', 'ù' );

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
        },1000 );
    }
}
    
/**
 * Metodo che avvia gli ascoltatori
 */
MainAdmin.prototype.initListeners = function () {
    var that = this;
    
    
    $('body').on( 'click', '.copyClipboard', function () {        
        that.copyToClipboard(this);
    });    
    
    $('body').on( 'click', '.footable', function () {        
        $('.footable-row-detail .copyClipboard').unbind();
        $('.footable-row-detail .copyClipboard').click(function () {
//            that.copyToClipboard(this);
        });
    });    
    
    $('.fa-reorder').click(function () {
        that.toggleMenu();
    });
    $('.fa-table').click(function () {
        that.iconeMenu();
    });
    $('body').on('click', '#toTop, .toTop', function () {

        // Al click sull'icona, torno ad inizio pagina con movenza fluida
        
            $("html,body").animate({scrollTop: 0}, 500, function () {});
        
//        that.scroolTop();
    });
    this.hoverForm();
    
//    $("div[data-submit='1']").click(function() {
//        $("div[data-divForm='1']").find('form').submit();
//    });
    
//    $("div[data-reset='1']").click(function() {
//        $("div[data-divForm='1']").find('form')[0].reset();
//        mainAdmin.speakSite( 'Form resettato con successo?' );
//    });
    
    
    $('#form_save' ).closest('.form-group').remove();

    $( '[data-speak]').click(function() {
        that.setSpeak( this );
    });
    this.initSpeak();
    
};


MainAdmin.prototype.initSpeak = function ( ) {
    this.speakEnabled = localStorage.getItem("speak");
    
    if(  this.speakEnabled == 0 || this.speakEnabled == '' ) {
        $( '[data-speak]').attr( 'class', 'fa fa-volume-off' );
        
    } else if( this.speakEnabled == null || this.speakEnabled == 1 ) {
        $( '[data-speak]').attr( 'class', 'fa fa-volume-up' );
    }
};

MainAdmin.prototype.setSpeak = function ( sender ) {
    this.speakEnabled = localStorage.getItem("speak");    
    
    if( this.speakEnabled == null ) {
        this.speakEnabled = 0;
        localStorage.setItem("speak", 0);
        $( sender ).attr( 'class', 'fa fa-volume-off' );
        
    } else if( this.speakEnabled == 0 ) {
        this.speakEnabled = 1;
        localStorage.setItem("speak", 1);
        $( sender ).attr( 'class', 'fa fa-volume-up' );
        
    } else if( this.speakEnabled == 1 ) {
        this.speakEnabled = 0;
        localStorage.setItem("speak", 0);
        $( sender ).attr( 'class', 'fa fa-volume-off' );
    }
        
};

MainAdmin.prototype.copyToClipboard = function (sender) {
    var aux = document.createElement("input");    
    aux.setAttribute("value", $(sender).closest('[data-urlArticle], .footable-row-detail-value ').find('.url').html());
    document.body.appendChild(aux);
    aux.select();
    document.execCommand("copy");
    document.body.removeChild(aux);

    var parameters = new Array();
    parameters['type'] = 'success';
    parameters['layout'] = 'top';
    parameters['mex'] = 'Copiato sulla tua clipboard';
    classNotyfy.openNotyfy(parameters);

};
MainAdmin.prototype.hoverForm = function () {

    $(this).closest('.form-group').find('label').hide();
    $('input,select,textarea').on('blur', function () {
        $(this).closest('.form-group').removeClass('active');
        if ($(this).val() == '') {
            $(this).closest('.form-group').find('label').removeClass('active');
            $(this).closest('.form-group').find('label').removeClass('colorLabelFormForce');
        } else {
            $(this).closest('.form-group').find('label').addClass('colorLabelFormForce');
        }
    });
    $('input,select,textarea').on('focus', function () {
        $( this ).closest( '.form-group' ).removeClass('has-error');
        $( this ).closest( '.form-group' ).find('.help-block' ).remove();
        $(this).closest('.form-group').addClass('active');
        $(this).closest('.form-group').find('label').addClass('active');
        $(this).closest('.form-group').find('label').removeClass('colorLabelFormForce');
    });


    $('input,select,textarea').each(function () {
        if ($(this).val() != '') {
            $(this).closest('.form-group').find('label').addClass('colorLabelFormForce').addClass('active');
        }
        $(this).closest('.form-group').find('label').show();
    });

};
MainAdmin.prototype.toggleMenu = function () {
    $(".structure_LeftColumn").toggleClass('closeMenu');
    $(".button-action").toggleClass('closeMenu');
    $(".structure_RightColumn").toggleClass('closeMenu');

};
MainAdmin.prototype.iconeMenu = function () {
    $(".structure_LeftColumn").toggleClass('iconeMenu');
    $(".button-action").toggleClass('iconeMenu');
    $(".structure_RightColumn").toggleClass('iconeMenu');
};

MainAdmin.prototype.scroolTop = function () {
    var that = this;



    // Intercetto lo scroll di pagina

    $(window).scroll(function () {
        // Se l'evento scroll si verifica, mostro l'icona (invisibile) con effetto dissolvenza
        if ($("#toTop").is(":hidden")) {
            $("#toTop").fadeIn(500);
        }
        // Se si verifica il ritorno ad inizio pagina, nascondo l'icona con effetto dissolvenza
//        if ($("body").scrollTop() == 0 && !$("#toTop").is(":hidden")){
//            $("#toTop").fadeOut(500);
//        }
    });
};

;
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

;
WidgetLogin = null;
$(function () {
    widgetLogin = new WidgetLogin();
});

/**
 * Classe per la gestione del widget
 */
var WidgetLogin = function () {
    this.formLogin = $( '#formLogin' );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetLogin.prototype.initListeners = function () {
    var that = this;
    $( this.formLogin ).find( 'button' ).click( function (e) {
        that.sendLogin( this );
    }); 
    
};

WidgetLogin.prototype.isLogged = function ( sender ) {
    var isLogged = 0;
    
    var request = $.ajax ({
        url: "/admin/userLogged",
        type: "GET",
        async: false,
        dataType: "html"        
     });
     request.done( function( resp ) {
         isLogged = resp;
     });
     return isLogged;
};

WidgetLogin.prototype.sendLogin = function ( sender ) {
     var data = $( sender ).closest( '#formLogin' ).serialize();
        
     var request = $.ajax ({
        url: "/admin/login?"+data,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) {
         
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        classNotyfy.openNotyfy( parameters ); 
        if( resp != 0 ) {
            setTimeout( function() {
                window.location.href = '/admin/listArticles';
            }, 1500 ); 
        } 
     });
};

WidgetLogin.prototype.openLoginPopup = function ( sender, callback ) {
    var data = $( sender ).serialize();
    
    var request = $.ajax ({
        url: "/admin/login?"+data,
        type: "GET",
        async: true,
        dataType: "html"        
     });
     request.done( function( resp ) {
         
        var parameters = new Array();   
        parameters['type'] = resp != 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] = resp != 0 ? 'Login Effettuato con successo' : 'Login errato';
        classNotyfy.openNotyfy( parameters ); 
              
        if (resp == 1 ) {
            
            bootbox.hideAll();
            console.dir(  callback );
            
            
            
            if( typeof callback != 'undefined' ) {
            if( typeof callback.params != 'undefined' ) {    
                if( callback.params[0] == 'submit' )
                    callback.call.submit();
                else
                    callback.call( callback.params[0] );
            } else {
                callback.call();
            }
        }
//            if( $( sender ).attr( 'data-type' ) == 'sendForm' )
//                $( sender ).closest( 'form' )[0].submit();
//            else return true;
        }
            
     });
};

/**
 * Metodo che recupera il box del login
 * @param {type} idFormLogin
 * @param {type} reload
 * @param {type} callback
 * @returns {undefined}
 */
WidgetLogin.prototype.getLoginBox = function( callback ) {
    var that = this;
    
    console.dir(callback);
    var params = { 
        type: 'custom', 
        title: 'LOGIN',
        callbackModals: '\
        <div class="innerAll" style="overflow: hidden;">\
            <div class="innerLR">\
                <form class="form-horizontal" id="loginPopup" method="get" autocomplete="off" onsubmit="return false;">\
                    <input type="hidden">\
                    <div class="form-group">\
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>\
                        <div class="col-sm-10">\
                            <input type="text" id="email" name="username" class="form-control" id="inputEmail3" placeholder="Email">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>\
                        <div class="col-sm-10">\
                            <input type="password" type="text" id="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">\
                        </div>\
                    </div>\
                    <div class="form-group">\
                        <div class="col-sm-offset-2 col-sm-10">\
                            <button type="button" class="btn btn-primary pull-right btnPopup">Login</button>\
                        </div>\
                    </div>\
                </form>\
            </div>\
        </div>'
    };
    classModals.openModals( params );
    
    $( '.btnPopup').unbind();
    
    $( '.btnPopup').click( function( e ) {
        
        e.stopPropagation();
        e.preventDefault();    
        that.openLoginPopup( $('#loginPopup'), callback  );
    });
}
;
widgetImageArticle = null;
$(function () {
    widgetImageArticle = new WidgetImageArticle();
});

/**
 * Classe per la gestione del widget ImageArticle
 */
var WidgetImageArticle = function () {
    this.widget                 = $( ".widget_ImageArticle" );
    this.widgetBody             = $( ".widget-body" );
    this.tabManageArticle       = $( '.tabManageArticle' );
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetImageArticle.prototype.initListeners = function () {
    var that = this;
    this.page = 2;
    this.lastScroll = 0;
    this.lastResetLimit = false;
    
    this.scroll( 300 );

    // Ascoltatore sull' immagine della galleria
    $( 'body' ).on( 'click', '.widget-body img', function (e) {
        if ( $( this ).hasClass( 'priority' ) )
            $( this ).removeClass( 'priority' );
        
        $( this ).toggleClass( 'selected' ); 
    });
    
    // Ascoltatore sull'immagine del popup per selezionare l'immagine primaria
    $( 'body' ).on( 'click', '.priorityImgBox img', function (e) {
        $( '.priorityImgBox img' ).removeClass('selectPriorityImg');
        $( this ).toggleClass( 'selectPriorityImg' ); 
    });
    
    // Ascoltatore sul bottone per l'associazione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-joinImg="1"]', function (e) {
        that.joinImgArticle();
        $( '.imgArticle').find('.selected' ).removeClass('selected');
    });
    
    // Ascoltatore sul bottone per la scelta dell'immagine prioritaria
    $( 'body' ).on( 'click', 'div[data-primary="1"]', function (e) {
        $( '.imgArticle').find('.selected' ).removeClass('selected');
        var imgs = '';
        $('.imgArticle').find('img').each(function(){
            imgs += this.outerHTML;
        });
        
        that.openPopup(imgs);
    });
    
    // Ascoltatore sul bottone per l'associazione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-btnPrimary="1"]', function (e) {
        that.setPriority();
    });
    
    // Ascoltatore sul bottone per la rimozione dell'immagine all'articolo
    $( 'body' ).on( 'click', 'div[data-removeImg="1"]', function (e) {
        that.removeImgArticle();
        $( '.imgArticle').find('.selected' ).removeClass('selected');
    });
    
    
    $( 'div[data-resetSearch="1"]' ).click(function() {
        $( '.searchImgArticle').find('input').val('');
    });
    
    $( 'div[data-search="1"]').click(function() {
        that.lastScroll = 0;
        that.getImagesScroll( true );
    });
};

/**
 * Gestisce lo scroll completo della pagina e richiama le nuove immagini con ajax
 * @param {type} tollerance
 * @returns {undefined}
 */
WidgetImageArticle.prototype.scroll = function ( tollerance ) {
    var that = this;    
    var tollerance = typeof tollerance != 'undefined' ? tollerance : 300;
        
    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        
//        console.info( ( $(window).scrollTop() + $(window).height() + tollerance ) +' > '+ $(document).height() +' && '+ $(document).height() +' != '+ that.lastScroll );        
        if( ( $(window).scrollTop() + $(window).height() + tollerance > $(document).height() ) && $(document).height() != that.lastScroll ) {                     
            that.lastScroll = $(document).height();
            
            $(that.widget).find('.plaseWait').css('visibility', 'visible');
            that.getImagesScroll( false );                                              
        }
    });
};

/**
 * Avvia la chiamata ajax per il recupero immagini
 * @param {type} $search
 * @returns {undefined}
 */
WidgetImageArticle.prototype.getImagesScroll = function ( resetLimit ) {
    var that = this;    
    
    var articleId = $( this.widget ).attr('data-article');
    var search = $( '.searchImgArticle' ).find( 'input' ).val() ;
    if( resetLimit ) {
        $( '.gallery').html('');
        that.page = 1;
    }
    
    this.lastResetLimit = resetLimit;
    
    var request = $.ajax ({
        url: "/admin/getInfiniteScroller/page="+that.page+"?articleId="+articleId+"&keywords="+search+"&resetLimit="+resetLimit,
        type: "GET",
        async: true,
        dataType: "html"        
     });
    request.done( function( resp ) {
        $( 'body' ).find( '.plaseWait').css( 'visibility', 'hidden');
        if( resp == '' )
            return;
        
        $( 'body' ).find( '.gallery').append( resp );
//        initGridalicious( '.widget', 'gridaliciousInfiniteScroll'+that.page );
        that.page++;
    });  
};

/**
 * Metodo che associale le immagini selezionate ad un articolo
 * @returns {undefined}
 */
WidgetImageArticle.prototype.joinImgArticle = function () {   
    var that = this;
    var articleId = $( this.widget ).attr('data-article');    
    var ids = '';
    // Recupero l'id di tutte le immagini selezionate
    $('.gallery img.selected').each(function(){
        ids += $( this ).attr('data-id') +',';
    });
    //Elimino la virgola dopo l'ultimo id
    ids = ids.substr( 0, ids.length -1 );    
    
    if( ids == '' )
        return false;    
    
    //Parte la chiamata ajax che aggiunge le img selezionate
    var request = $.ajax ({
        url: "/admin/addImageArticle/"+ids+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        var response = false;
        if( typeof resp.success != 'undefined' && resp.success.length > 0 ) {
            resp.success.forEach(function(item){
                $('.priority').removeAttr('data-priority');
                $('.priority').removeClass('priority');
                
                var clone = $( '.widget_ImageArticle .contentPriorityImage:last' ).clone();       
                $( clone ).find( 'img' ).attr( 'src', '/imagesArticleMedium/'+item.img ).attr( 'data-id', item.imgId );

                $('body').find('.widget_ImageArticle .imgArticle').prepend( clone );

                $('.widget_ImageArticle .contentPriorityImage div' ).addClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).find('img').removeClass('hide');
                $('.widget_ImageArticle .imgArticle').find('img[data-id='+item.imgId+']').closest('.contentPriorityImage' ).removeClass('hide');
                
               
            });
            response = true;
        }
        
        
        var parameters = new Array();   
        parameters['mex'] = response? 'Immagini associate correttamente' : 'Immagini già associate';
        parameters['layout'] = 'top';
        parameters['type'] =  response  ? 'success' : 'error';
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( parameters['mex'] );
        
        $('.gallery').find('.selected').removeClass('selected');
        
        
        // Se le immagini selezionate sono più di una apre una dialog per far saelezionare l'immagine prioritaria
        if ( typeof resp.success != 'undefined' && resp.success.length > 1 ) {
            var imgs = '';
            
            $('.imgArticle').find('img').each(function(){
                imgs += this.outerHTML;
            });
            
            that.openPopup(imgs);            
        }
    });
};

/**
 * Metodo che rimuove le immagini da un articolo
 * @returns {undefined}
 */
WidgetImageArticle.prototype.removeImgArticle = function () {
    var that = this;
    var parameters = new Array();
    this.prioprity = false;
    
    var img = $( '.imgArticle' ).find( 'img' ).size();
    
    if (img < 2) {
        parameters['mex'] = 'Non è possibile rimuovere la foto! Inserire prima l\'immagine sostitutiva' ;
        parameters['layout'] = 'top';
        parameters['type'] = 'error';
        classNotyfy.openNotyfy( parameters );
        return false;
    }
    
    var articleId = $( this.widget ).attr('data-article');
    
    var ids = '';
    // Recupero l'id di tutte le immagini selezionate
    $('.imgArticle img.selected').each(function(){            
        if($( this ).attr('data-priority') == 1 ) {
            parameters['mex'] = 'Si sta provando a rimuovere l\'immagine prioritaria. Selezionane prima un\' altra!' ;
            parameters['layout'] = 'top';
            parameters['type'] = 'error';
            classNotyfy.openNotyfy( parameters );
            $( this ).addClass('priority');
            return false;
        } else {
            ids += $( this ).attr('data-id') +',';
        }
    });
    
    //Elimino la virgola dopo l'ultimo id
    ids = ids.substr( 0, ids.length -1 );
        
    if( ids == '' )
        return false;
    
    
    //Parte la chiamata ajax che elimina le img selezionate
    var request = $.ajax ({
        url: "/admin/removeImageArticle/"+ids+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        if( resp.error ) {
            
        } else {
            if( resp.ids.length > 1 ) {
                resp.ids.forEach(function(item, index){ 
                    $('.imgArticle img[data-id='+item+']').remove();
                });
            } else {
                $('.imgArticle img[data-id='+resp.ids+']').remove();
            }
//            window.location.href = "/admin/manageArticle/"+articleId;
        }
        
        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( resp.msg );
    });
};

// Funzione che permette l'upload dell'immagine con l'iFrame come target
WidgetImageArticle.prototype.readResponseTargetIframe = function ( response, src, id ) { 
    var parameters = new Array();
    parameters['layout'] = 'top';
    
    if( response == 1 ) {
        parameters['type'] = 'success';
        parameters['mex'] = 'Immagine inserita correttamente';
        $('#myFormUploadImg')[0].reset();
        
        var clone = $( '.widget_ImageArticle .cloneImage' ).clone();
        
        $( clone ).find( 'img' ).attr( 'src', '/imagesArticleMedium/'+src ).attr( 'data-id', id );
        
//        $('body').find('.widget_ImageArticle .imgArticle').append('<img src="/imagesArticleMedium/'+src+'" data-id="'+id+'" alt="photo" />');
        
        console.info('eccomi');
        $('body').find('.widget_ImageArticle .imgArticle').prepend( clone );
        
        $('.widget_ImageArticle .contentPriorityImage div' ).addClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).removeClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).find('img').removeClass('hide');
        $('.widget_ImageArticle .imgArticle').find('img[data-id='+id+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
        
        
    } else if ( response == 2 ) {
        parameters['type'] = 'error';
        parameters['mex'] = 'Compilare tutti i campi';
    } else {
        parameters['type'] = 'error';
        parameters['mex'] = 'Errore durante il caricamento dell\'Immagine';
    }
    
    mainAdmin.speakSite( parameters['mex'] );
    classNotyfy.openNotyfy( parameters );    
    
};  

/**
 * Metodo che setta l'immagine prioritaria
 * @returns {undefined}
 */
WidgetImageArticle.prototype.setPriority = function () {
    var articleId = $( this.widget ).attr('data-article');
    var parameters = new Array();
    var id = null;
    $('.priorityImgBox img.selectPriorityImg').each(function(){
        id = $( this ).attr('data-id') +',';
    });
    
    if( id == null )
        return false;
    
    var request = $.ajax ({
        url: "/admin/setPriorityImageArticle/"+id+"/"+articleId,
        type: "GET",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
         var priorityId = null;
        if( typeof resp.success != 'undefined' )
            priorityId = resp.success.priorityId;
        
        bootbox.hideAll();
        
        
        if ( priorityId != null ) {
            $('.priority').removeAttr('data-priority');
            $('.priority').removeClass('priority');
            
            $('.imgArticle').find('img[data-id='+priorityId+']').addClass('priority');
            $('.imgArticle').find('img[data-id='+priorityId+']').attr('data-priority', 1);
            
            $('.contentPriorityImage div' ).addClass('hide');
            $('.imgArticle').find('img[data-id='+priorityId+']').closest('.contentPriorityImage' ).find('div').removeClass('hide');
        }

        parameters['type'] = !resp.error ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  resp.success.msg;
        classNotyfy.openNotyfy( parameters );
        mainAdmin.speakSite( parameters['mex'] );
    });
};

// Funzione che permette l'upload dell'immagine con l'iFrame come target
WidgetImageArticle.prototype.openPopup = function ( imgs ) { 
    var params = { 
            type: 'custom', 
            title: 'SCEGLI LA FOTO PRIMARIA' ,
            callbackModals: '\
            <div class="galleryPriority">\
                <div class="priorityImgBox">\
                    <div class="preview">'+ imgs + '</div>\
                    <div class="form-group">\
                        <div class="buttonDefault pull-right" data-btnPrimary="1">\
                            <div type="button" class="add" data-joinPrimary="1">Scegli Foto Prioritaria</div>\
                            <i class=" fa  fa-check-circle"></i>\
                        </div>\
                    </div>\
                </div>\
            </div>'
            };
    classModals.openModals( params );
            
    setTimeout( function() {
        $('.modal-dialog').css('width', '95%');
    } , 100 );
}
;

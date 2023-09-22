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
/*!
 * FooTable - Awesome Responsive Tables
 * Version : 2.0.1
 * http://fooplugins.com/plugins/footable-jquery/
 *
 * Requires jQuery - http://jquery.com/
 *
 * Copyright 2013 Steven Usher & Brad Vincent
 * Released under the MIT license
 * You are free to use FooTable in commercial projects as long as this copyright header is left intact.
 *
 * Date: 31 Aug 2013
 */
(function(e,t){function a(){var e=this;e.id=null,e.busy=!1,e.start=function(t,a){e.busy||(e.stop(),e.id=setTimeout(function(){t(),e.id=null,e.busy=!1},a),e.busy=!0)},e.stop=function(){null!==e.id&&(clearTimeout(e.id),e.id=null,e.busy=!1)}}function o(o,i,n){var r=this;r.id=n,r.table=o,r.options=i,r.breakpoints=[],r.breakpointNames="",r.columns={},r.plugins=t.footable.plugins.load(r);var l=r.options,d=l.classes,s=l.events,u=l.triggers,f=0;return r.timers={resize:new a,register:function(e){return r.timers[e]=new a,r.timers[e]}},r.init=function(){var a=e(t),o=e(r.table);if(t.footable.plugins.init(r),o.hasClass(d.loaded))return r.raise(s.alreadyInitialized),undefined;r.raise(s.initializing),o.addClass(d.loading),o.find(l.columnDataSelector).each(function(){var e=r.getColumnData(this);r.columns[e.index]=e});for(var i in l.breakpoints)r.breakpoints.push({name:i,width:l.breakpoints[i]}),r.breakpointNames+=i+" ";r.breakpoints.sort(function(e,t){return e.width-t.width}),o.bind(u.initialize,function(){o.removeData("footable_info"),o.data("breakpoint",""),o.trigger(u.resize),o.removeClass(d.loading),o.addClass(d.loaded).addClass(d.main),r.raise(s.initialized)}).bind(u.redraw,function(){r.redraw()}).bind(u.resize,function(){r.resize()}).bind(u.expandFirstRow,function(){o.find(l.toggleSelector).first().not("."+d.detailShow).trigger(u.toggleRow)}),o.trigger(u.initialize),a.bind("resize.footable",function(){r.timers.resize.stop(),r.timers.resize.start(function(){r.raise(u.resize)},l.delay)})},r.addRowToggle=function(){if(l.addRowToggle){var t=e(r.table),a=!1;t.find("span."+d.toggle).remove();for(var o in r.columns){var i=r.columns[o];if(i.toggle){a=!0;var n="> tbody > tr:not(."+d.detail+",."+d.disabled+") > td:nth-child("+(parseInt(i.index,10)+1)+")";return t.find(n).not("."+d.detailCell).prepend(e("<span />").addClass(d.toggle)),undefined}}a||t.find("> tbody > tr:not(."+d.detail+",."+d.disabled+") > td:first-child").not("."+d.detailCell).prepend(e("<span />").addClass(d.toggle))}},r.setColumnClasses=function(){$table=e(r.table);for(var t in r.columns){var a=r.columns[t];if(null!==a.className){var o="",i=!0;e.each(a.matches,function(e,t){i||(o+=", "),o+="> tbody > tr:not(."+d.detail+") > td:nth-child("+(parseInt(t,10)+1)+")",i=!1}),$table.find(o).not("."+d.detailCell).addClass(a.className)}}},r.bindToggleSelectors=function(){var t=e(r.table);r.hasAnyBreakpointColumn()&&(t.find(l.toggleSelector).unbind(u.toggleRow).bind(u.toggleRow,function(){var t=e(this).is("tr")?e(this):e(this).parents("tr:first");r.toggleDetail(t.get(0))}),t.find(l.toggleSelector).unbind("click.footable").bind("click.footable",function(a){t.is(".breakpoint")&&e(a.target).is("td,."+d.toggle)&&e(this).trigger(u.toggleRow)}))},r.parse=function(e,t){var a=l.parsers[t.type]||l.parsers.alpha;return a(e)},r.getColumnData=function(t){var a=e(t),o=a.data("hide"),i=a.index();o=o||"",o=jQuery.map(o.split(","),function(e){return jQuery.trim(e)});var n={index:i,hide:{},type:a.data("type")||"alpha",name:a.data("name")||e.trim(a.text()),ignore:a.data("ignore")||!1,toggle:a.data("toggle")||!1,className:a.data("class")||null,matches:[],names:{},group:a.data("group")||null,groupName:null};if(null!==n.group){var d=e(r.table).find('> thead > tr.footable-group-row > th[data-group="'+n.group+'"], > thead > tr.footable-group-row > td[data-group="'+n.group+'"]').first();n.groupName=r.parse(d,{type:"alpha"})}var u=parseInt(a.prev().attr("colspan")||0,10);f+=u>1?u-1:0;var p=parseInt(a.attr("colspan")||0,10),c=n.index+f;if(p>1){var g=a.data("names");g=g||"",g=g.split(",");for(var h=0;p>h;h++)n.matches.push(h+c),g.length>h&&(n.names[h+c]=g[h])}else n.matches.push(c);n.hide["default"]="all"===a.data("hide")||e.inArray("default",o)>=0;var b=!1;for(var m in l.breakpoints)n.hide[m]="all"===a.data("hide")||e.inArray(m,o)>=0,b=b||n.hide[m];n.hasBreakpoint=b;var v=r.raise(s.columnData,{column:{data:n,th:t}});return v.column.data},r.getViewportWidth=function(){return window.innerWidth||(document.body?document.body.offsetWidth:0)},r.calculateWidth=function(e,t){return jQuery.isFunction(l.calculateWidthOverride)?l.calculateWidthOverride(e,t):(t.viewportWidth<t.width&&(t.width=t.viewportWidth),t.parentWidth<t.width&&(t.width=t.parentWidth),t)},r.hasBreakpointColumn=function(e){for(var t in r.columns)if(r.columns[t].hide[e]){if(r.columns[t].ignore)continue;return!0}return!1},r.hasAnyBreakpointColumn=function(){for(var e in r.columns)if(r.columns[e].hasBreakpoint)return!0;return!1},r.resize=function(){var t=e(r.table);if(t.is(":visible")&&r.hasAnyBreakpointColumn()){var a={width:t.width(),viewportWidth:r.getViewportWidth(),parentWidth:t.parent().width()};a=r.calculateWidth(t,a);var o=t.data("footable_info");if(t.data("footable_info",a),r.raise(s.resizing,{old:o,info:a}),!o||o&&o.width&&o.width!==a.width){for(var i,n=null,l=0;r.breakpoints.length>l;l++)if(i=r.breakpoints[l],i&&i.width&&a.width<=i.width){n=i;break}var d=null===n?"default":n.name,f=r.hasBreakpointColumn(d),p=t.data("breakpoint");t.data("breakpoint",d).removeClass("default breakpoint").removeClass(r.breakpointNames).addClass(d+(f?" breakpoint":"")),d!==p&&(t.trigger(u.redraw),r.raise(s.breakpoint,{breakpoint:d,info:a}))}r.raise(s.resized,{old:o,info:a})}},r.redraw=function(){r.addRowToggle(),r.bindToggleSelectors(),r.setColumnClasses();var t=e(r.table),a=t.data("breakpoint"),o=r.hasBreakpointColumn(a);t.find("> tbody > tr:not(."+d.detail+")").data("detail_created",!1).end().find("> thead > tr:last-child > th").each(function(){var o=r.columns[e(this).index()],i="",n=!0;e.each(o.matches,function(e,t){n||(i+=", ");var a=t+1;i+="> tbody > tr:not(."+d.detail+") > td:nth-child("+a+")",i+=", > tfoot > tr:not(."+d.detail+") > td:nth-child("+a+")",i+=", > colgroup > col:nth-child("+a+")",n=!1}),i+=', > thead > tr[data-group-row="true"] > th[data-group="'+o.group+'"]';var l=t.find(i).add(this);if(o.hide[a]===!1?l.show():l.hide(),1===t.find("> thead > tr.footable-group-row").length){var s=t.find('> thead > tr:last-child > th[data-group="'+o.group+'"]:visible, > thead > tr:last-child > th[data-group="'+o.group+'"]:visible'),u=t.find('> thead > tr.footable-group-row > th[data-group="'+o.group+'"], > thead > tr.footable-group-row > td[data-group="'+o.group+'"]'),f=0;e.each(s,function(){f+=parseInt(e(this).attr("colspan")||1,10)}),f>0?u.attr("colspan",f).show():u.hide()}}).end().find("> tbody > tr."+d.detailShow).each(function(){r.createOrUpdateDetailRow(this)}),t.find("> tbody > tr."+d.detailShow+":visible").each(function(){var t=e(this).next();t.hasClass(d.detail)&&(o?t.show():t.hide())}),t.find("> thead > tr > th.footable-last-column, > tbody > tr > td.footable-last-column").removeClass("footable-last-column"),t.find("> thead > tr > th.footable-first-column, > tbody > tr > td.footable-first-column").removeClass("footable-first-column"),t.find("> thead > tr, > tbody > tr").find("> th:visible:last, > td:visible:last").addClass("footable-last-column").end().find("> th:visible:first, > td:visible:first").addClass("footable-first-column"),r.raise(s.redrawn)},r.toggleDetail=function(t){var a=t.jquery?t:e(t),o=a.next();a.hasClass(d.detailShow)?(a.removeClass(d.detailShow),o.hasClass(d.detail)&&o.hide(),r.raise(s.rowCollapsed,{row:a[0]})):(r.createOrUpdateDetailRow(a[0]),a.addClass(d.detailShow),a.next().show(),r.raise(s.rowExpanded,{row:a[0]}))},r.removeRow=function(t){var a=t.jquery?t:e(t);a.hasClass(d.detail)&&(a=a.prev());var o=a.next();a.data("detail_created")===!0&&o.remove(),a.remove(),r.raise(s.rowRemoved)},r.appendRow=function(t){var a=t.jquery?t:e(t);e(r.table).find("tbody").append(a),r.redraw()},r.getColumnFromTdIndex=function(t){var a=null;for(var o in r.columns)if(e.inArray(t,r.columns[o].matches)>=0){a=r.columns[o];break}return a},r.createOrUpdateDetailRow=function(t){var a,o=e(t),i=o.next(),n=[];if(o.data("detail_created")===!0)return!0;if(o.is(":hidden"))return!1;if(r.raise(s.rowDetailUpdating,{row:o,detail:i}),o.find("> td:hidden").each(function(){var t=e(this).index(),a=r.getColumnFromTdIndex(t),o=a.name;return a.ignore===!0?!0:(t in a.names&&(o=a.names[t]),n.push({name:o,value:r.parse(this,a),display:e.trim(e(this).html()),group:a.group,groupName:a.groupName}),!0)}),0===n.length)return!1;var u=o.find("> td:visible").length,f=i.hasClass(d.detail);return f||(i=e('<tr class="'+d.detail+'"><td class="'+d.detailCell+'"><div class="'+d.detailInner+'"></div></td></tr>'),o.after(i)),i.find("> td:first").attr("colspan",u),a=i.find("."+d.detailInner).empty(),l.createDetail(a,n,l.createGroupedDetail,l.detailSeparator,d),o.data("detail_created",!0),r.raise(s.rowDetailUpdated,{row:o,detail:i}),!f},r.raise=function(t,a){r.options.debug===!0&&e.isFunction(r.options.log)&&r.options.log(t,"event"),a=a||{};var o={ft:r};e.extend(!0,o,a);var i=e.Event(t,o);return i.ft||e.extend(!0,i,o),e(r.table).trigger(i),i},r.init(),r}t.footable={options:{delay:100,breakpoints:{phone:480,tablet:1024},parsers:{alpha:function(t){return e(t).data("value")||e.trim(e(t).text())},numeric:function(t){var a=e(t).data("value")||e(t).text().replace(/[^0-9.\-]/g,"");return a=parseFloat(a),isNaN(a)&&(a=0),a}},addRowToggle:!0,calculateWidthOverride:null,toggleSelector:" > tbody > tr:not(.footable-row-detail)",columnDataSelector:"> thead > tr:last-child > th, > thead > tr:last-child > td",detailSeparator:":",createGroupedDetail:function(e){for(var t={_none:{name:null,data:[]}},a=0;e.length>a;a++){var o=e[a].group;null!==o?(o in t||(t[o]={name:e[a].groupName||e[a].group,data:[]}),t[o].data.push(e[a])):t._none.data.push(e[a])}return t},createDetail:function(e,t,a,o,i){var n=a(t);for(var r in n)if(0!==n[r].data.length){"_none"!==r&&e.append('<div class="'+i.detailInnerGroup+'">'+n[r].name+"</div>");for(var l=0;n[r].data.length>l;l++){var d=n[r].data[l].name?o:"";e.append('<div class="'+i.detailInnerRow+'"><div class="'+i.detailInnerName+'">'+n[r].data[l].name+d+'</div><div class="'+i.detailInnerValue+'">'+n[r].data[l].display+"</div></div>")}}},classes:{main:"footable",loading:"footable-loading",loaded:"footable-loaded",toggle:"footable-toggle",disabled:"footable-disabled",detail:"footable-row-detail",detailCell:"footable-row-detail-cell",detailInner:"footable-row-detail-inner",detailInnerRow:"footable-row-detail-row",detailInnerGroup:"footable-row-detail-group",detailInnerName:"footable-row-detail-name",detailInnerValue:"footable-row-detail-value",detailShow:"footable-detail-show"},triggers:{initialize:"footable_initialize",resize:"footable_resize",redraw:"footable_redraw",toggleRow:"footable_toggle_row",expandFirstRow:"footable_expand_first_row"},events:{alreadyInitialized:"footable_already_initialized",initializing:"footable_initializing",initialized:"footable_initialized",resizing:"footable_resizing",resized:"footable_resized",redrawn:"footable_redrawn",breakpoint:"footable_breakpoint",columnData:"footable_column_data",rowDetailUpdating:"footable_row_detail_updating",rowDetailUpdated:"footable_row_detail_updated",rowCollapsed:"footable_row_collapsed",rowExpanded:"footable_row_expanded",rowRemoved:"footable_row_removed"},debug:!1,log:null},version:{major:0,minor:5,toString:function(){return t.footable.version.major+"."+t.footable.version.minor},parse:function(e){return version=/(\d+)\.?(\d+)?\.?(\d+)?/.exec(e),{major:parseInt(version[1],10)||0,minor:parseInt(version[2],10)||0,patch:parseInt(version[3],10)||0}}},plugins:{_validate:function(a){if(!e.isFunction(a))return t.footable.options.debug===!0&&console.error('Validation failed, expected type "function", received type "{0}".',typeof a),!1;var o=new a;return"string"!=typeof o.name?(t.footable.options.debug===!0&&console.error('Validation failed, plugin does not implement a string property called "name".',o),!1):e.isFunction(o.init)?(t.footable.options.debug===!0&&console.log('Validation succeeded for plugin "'+o.name+'".',o),!0):(t.footable.options.debug===!0&&console.error('Validation failed, plugin "'+o.name+'" does not implement a function called "init".',o),!1)},registered:[],register:function(a,o){t.footable.plugins._validate(a)&&(t.footable.plugins.registered.push(a),"object"==typeof o&&e.extend(!0,t.footable.options,o))},load:function(e){var a,o,i=[];for(o=0;t.footable.plugins.registered.length>o;o++)try{a=t.footable.plugins.registered[o],i.push(new a(e))}catch(n){t.footable.options.debug===!0&&console.error(n)}return i},init:function(e){for(var a=0;e.plugins.length>a;a++)try{e.plugins[a].init(e)}catch(o){t.footable.options.debug===!0&&console.error(o)}}}};var i=0;e.fn.footable=function(a){a=a||{};var n=e.extend(!0,{},t.footable.options,a);return this.each(function(){i++;var t=new o(this,n,i);e(this).data("footable",t)})}})(jQuery,window)
;
$(function()
{
	/* FooTable */
	if ($('.footable').length)
		$('.footable').footable();
})
;
/* =========================================================
 * bootstrap-datepicker.js
 * http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Copyright 2012 Stefan Petre
 * Improvements by Andrew Rowls
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

(function( $ ) {

	var $window = $(window);

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());
	}


	// Picker object

	var Datepicker = function(element, options) {
		var that = this;

		this._process_options(options);

		this.element = $(element);
		this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.input-group-addon, .btn-group-addon') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if(this.component && this.component.length === 0)
			this.component = false;

		this.picker = $(DPGlobal.template);
		this._buildEvents();
		this._attachEvents();

		if(this.isInline) {
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		} else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
			this.picker.find('.prev i, .next i')
						.toggleClass('icon-arrow-left icon-arrow-right');
		}


		this.viewMode = this.o.startView;

		if (this.o.calendarWeeks)
			this.picker.find('tfoot th.today')
						.attr('colspan', function(i, val){
							return parseInt(val) + 1;
						});

		this._allow_update = false;

		this.setStartDate(this._o.startDate);
		this.setEndDate(this._o.endDate);
		this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

		this.fillDow();
		this.fillMonths();

		this._allow_update = true;

		this.update();
		this.showMode();

		if(this.isInline) {
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]) {
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			switch(o.startView){
				case 2:
				case 'decade':
					o.startView = 2;
					break;
				case 1:
				case 'year':
					o.startView = 1;
					break;
				default:
					o.startView = 0;
			}

			switch (o.minViewMode) {
				case 1:
				case 'months':
					o.minViewMode = 1;
					break;
				case 2:
				case 'years':
					o.minViewMode = 2;
					break;
				default:
					o.minViewMode = 0;
			}

			o.startView = Math.max(o.startView, o.minViewMode);

			o.weekStart %= 7;
			o.weekEnd = ((o.weekStart + 6) % 7);

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity) {
				if (!!o.startDate) {
					if (o.startDate instanceof Date)
						o.startDate = this._local_to_utc(this._zero_time(o.startDate));
					else
						o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
				} else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity) {
				if (!!o.endDate) {
					if (o.endDate instanceof Date)
						o.endDate = this._local_to_utc(this._zero_time(o.endDate));
					else
						o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
				} else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
			if (!$.isArray(o.daysOfWeekDisabled))
				o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
			o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function (d) {
				return parseInt(d, 10);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
				_plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function(word){
				return (/^auto|left|right|top|bottom$/).test(word);
			});
			o.orientation = {x: 'auto', y: 'auto'};
			if (!_plc || _plc === 'auto')
				; // no action
			else if (plc.length === 1){
				switch(plc[0]){
					case 'top':
					case 'bottom':
						o.orientation.y = plc[0];
						break;
					case 'left':
					case 'right':
						o.orientation.x = plc[0];
						break;
				}
			}
			else {
				_plc = $.grep(plc, function(word){
					return (/^left|right$/).test(word);
				});
				o.orientation.x = _plc[0] || 'auto';

				_plc = $.grep(plc, function(word){
					return (/^top|bottom$/).test(word);
				});
				o.orientation.y = _plc[0] || 'auto';
			}
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.on(ev);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev; i<evs.length; i++){
				el = evs[i][0];
				ev = evs[i][1];
				el.off(ev);
			}
		},
		_buildEvents: function(){
			if (this.isInput) { // single input
				this._events = [
					[this.element, {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput){ // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(this.update, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			else if (this.element.is('div')) {  // inline datepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					'mousedown touchstart': $.proxy(function (e) {
						// Clicked outside the datepicker, hide it
						if (!(
							this.element.is(e.target) ||
							this.element.find(e.target).length ||
							this.picker.is(e.target) ||
							this.picker.find(e.target).length
						)) {
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.date,
				local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				format: $.proxy(function(altformat){
					var format = altformat || this.o.format;
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(e) {
			if (!this.isInline)
				this.picker.appendTo('body');
			this.picker.show();
			this.height = this.component ? this.component.outerHeight() : this.element.outerHeight();
			this.place();
			this._attachSecondaryEvents();
			if (e) {
				e.preventDefault();
			}
			this._trigger('show');
		},

		hide: function(e){
			if(this.isInline) return;
			if (!this.picker.is(':visible')) return;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.viewMode = this.o.startView;
			this.showMode();

			if (
				this.o.forceParse &&
				(
					this.isInput && this.element.val() ||
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this._trigger('hide');
		},

		remove: function() {
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput) {
				delete this.element.data().date;
			}
		},

		_utc_to_local: function(utc){
			return new Date(utc.getTime() + (utc.getTimezoneOffset()*60000));
		},
		_local_to_utc: function(local){
			return new Date(local.getTime() - (local.getTimezoneOffset()*60000));
		},
		_zero_time: function(local){
			return new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function(utc){
			return new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
		},

		getDate: function() {
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function() {
			return this.date;
		},

		setDate: function(d) {
			this.setUTCDate(this._local_to_utc(d));
		},

		setUTCDate: function(d) {
			this.date = d;
			this.setValue();
		},

		setValue: function() {
			var formatted = this.getFormattedDate();
			if (!this.isInput) {
				if (this.component){
					this.element.find('input').val(formatted).change();
				}
			} else {
				this.element.val(formatted).change();
			}
		},

		getFormattedDate: function(format) {
			if (format === undefined)
				format = this.o.format;
			return DPGlobal.formatDate(this.date, format, this.o.language);
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
						if(this.isInline) return;
			var calendarWidth = this.picker.outerWidth(),
				calendarHeight = this.picker.outerHeight(),
				visualPadding = 10,
				windowWidth = $window.width(),
				windowHeight = $window.height(),
				scrollTop = $window.scrollTop();

			var zIndex = parseInt(this.element.parents().filter(function() {
							return $(this).css('z-index') != 'auto';
						}).first().css('z-index'))+10;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left,
				top = offset.top;

			this.picker.removeClass(
				'datepicker-orient-top datepicker-orient-bottom '+
				'datepicker-orient-right datepicker-orient-left'
			);

			if (this.o.orientation.x !== 'auto') {
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right')
					left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
				// Default to left
				this.picker.addClass('datepicker-orient-left');
				if (offset.left < 0)
					left -= offset.left - visualPadding;
				else if (offset.left + calendarWidth > windowWidth)
					left = windowWidth - calendarWidth - visualPadding;
			}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
				top_overflow, bottom_overflow;
			if (yorient === 'auto') {
				top_overflow = -scrollTop + offset.top - calendarHeight;
				bottom_overflow = scrollTop + windowHeight - (offset.top + height + calendarHeight);
				if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
					yorient = 'top';
				else
					yorient = 'bottom';
			}
			this.picker.addClass('datepicker-orient-' + yorient);
			if (yorient === 'top')
				top += height;
			else
				top -= calendarHeight + parseInt(this.picker.css('padding-top'));

			this.picker.css({
				top: top,
				left: left,
				zIndex: zIndex
			});
		},

		_allow_update: true,
		update: function(){
			if (!this._allow_update) return;

			var oldDate = new Date(this.date),
				date, fromArgs = false;
			if(arguments && arguments.length && (typeof arguments[0] === 'string' || arguments[0] instanceof Date)) {
				date = arguments[0];
				if (date instanceof Date)
					date = this._local_to_utc(date);
				fromArgs = true;
			} else {
				date = this.isInput ? this.element.val() : this.element.data('date') || this.element.find('input').val();
				delete this.element.data().date;
			}

			this.date = DPGlobal.parseDate(date, this.o.format, this.o.language);

			if (fromArgs) {
				// setting date by clicking
				this.setValue();
			} else if (date) {
				// setting date by typing
				if (oldDate.getTime() !== this.date.getTime())
					this._trigger('changeDate');
			} else {
				// clearing date
				this._trigger('clearDate');
			}

			if (this.date < this.o.startDate) {
				this.viewDate = new Date(this.o.startDate);
				this.date = new Date(this.o.startDate);
			} else if (this.date > this.o.endDate) {
				this.viewDate = new Date(this.o.endDate);
				this.date = new Date(this.o.endDate);
			} else {
				this.viewDate = new Date(this.date);
				this.date = new Date(this.date);
			}
			this.fill();
		},

		fillDow: function(){
			var dowCnt = this.o.weekStart,
			html = '<tr>';
			if(this.o.calendarWeeks){
				var cell = '<th class="cw">&nbsp;</th>';
				html += cell;
				this.picker.find('.datepicker-days thead tr:first-child').prepend(cell);
			}
			while (dowCnt < this.o.weekStart + 7) {
				html += '<th class="dow">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '',
			i = 0;
			while (i < 12) {
				html += '<span class="month">'+dates[this.o.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function(range){
			if (!range || !range.length)
				delete this.range;
			else
				this.range = $.map(range, function(d){ return d.valueOf(); });
			this.fill();
		},

		getClassNames: function(date){
			var cls = [],
				year = this.viewDate.getUTCFullYear(),
				month = this.viewDate.getUTCMonth(),
				currentDate = this.date.valueOf(),
				today = new Date();
			if (date.getUTCFullYear() < year || (date.getUTCFullYear() == year && date.getUTCMonth() < month)) {
				cls.push('old');
			} else if (date.getUTCFullYear() > year || (date.getUTCFullYear() == year && date.getUTCMonth() > month)) {
				cls.push('new');
			}
			// Compare internal UTC date with local today, not UTC today
			if (this.o.todayHighlight &&
				date.getUTCFullYear() == today.getFullYear() &&
				date.getUTCMonth() == today.getMonth() &&
				date.getUTCDate() == today.getDate()) {
				cls.push('today');
			}
			if (date.valueOf() == currentDate) {
				cls.push('active');
			}
			if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
				$.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1) {
				cls.push('disabled');
			}
			if (this.range){
				if (date > this.range[0] && date < this.range[this.range.length-1]){
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) != -1){
					cls.push('selected');
				}
			}
			return cls;
		},

		fill: function() {
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				currentDate = this.date && this.date.valueOf(),
				tooltip;
			this.picker.find('.datepicker-days thead th.datepicker-switch')
						.text(dates[this.o.language].months[month]+' '+year);
			this.picker.find('tfoot th.today')
						.text(dates[this.o.language].today)
						.toggle(this.o.todayBtn !== false);
			this.picker.find('tfoot th.clear')
						.text(dates[this.o.language].clear)
						.toggle(this.o.clearBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month-1, 28,0,0,0,0),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while(prevMonth.valueOf() < nextMonth) {
				if (prevMonth.getUTCDay() == this.o.weekStart) {
					html.push('<tr>');
					if(this.o.calendarWeeks){
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
							// Start of current week: based on weekstart/current date
							ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
							// Thursday of this week
							th = new Date(+ws + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
							// First Thursday of year, year from thursday
							yth = new Date(+(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay())%7*864e5),
							// Calendar week: ms between thursdays, div ms per day, div 7 days
							calWeek =  (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">'+ calWeek +'</td>');

					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				if (this.o.beforeShowDay !== $.noop){
					var before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
					if (before === undefined)
						before = {};
					else if (typeof(before) === 'boolean')
						before = {enabled: before};
					else if (typeof(before) === 'string')
						before = {classes: before};
					if (before.enabled === false)
						clsName.push('disabled');
					if (before.classes)
						clsName = clsName.concat(before.classes.split(/\s+/));
					if (before.tooltip)
						tooltip = before.tooltip;
				}

				clsName = $.unique(clsName);
				html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + '>'+prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() == this.o.weekEnd) {
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));
			var currentYear = this.date && this.date.getUTCFullYear();

			var months = this.picker.find('.datepicker-months')
						.find('th:eq(1)')
							.text(year)
							.end()
						.find('span').removeClass('active');
			if (currentYear && currentYear == year) {
				months.eq(this.date.getUTCMonth()).addClass('active');
			}
			if (year < startYear || year > endYear) {
				months.addClass('disabled');
			}
			if (year == startYear) {
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year == endYear) {
				months.slice(endMonth+1).addClass('disabled');
			}

			html = '';
			year = parseInt(year/10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years')
								.find('th:eq(1)')
									.text(year + '-' + (year + 9))
									.end()
								.find('td');
			year -= 1;
			for (var i = -1; i < 11; i++) {
				html += '<span class="year'+(i == -1 ? ' old' : i == 10 ? ' new' : '')+(currentYear == year ? ' active' : '')+(year < startYear || year > endYear ? ' disabled' : '')+'">'+year+'</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		updateNavArrows: function() {
			if (!this._allow_update) return;

			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth();
			switch (this.viewMode) {
				case 0:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
				case 2:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()) {
						this.picker.find('.prev').css({visibility: 'hidden'});
					} else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()) {
						this.picker.find('.next').css({visibility: 'hidden'});
					} else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		click: function(e) {
			e.preventDefault();
			var target = $(e.target).closest('span, td, th');
			if (target.length == 1) {
				switch(target[0].nodeName.toLowerCase()) {
					case 'th':
						switch(target[0].className) {
							case 'datepicker-switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className == 'prev' ? -1 : 1);
								switch(this.viewMode){
									case 0:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										this._trigger('changeMonth', this.viewDate);
										break;
									case 1:
									case 2:
										this.viewDate = this.moveYear(this.viewDate, dir);
										if (this.viewMode === 1)
											this._trigger('changeYear', this.viewDate);
										break;
								}
								this.fill();
								break;
							case 'today':
								var date = new Date();
								date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

								this.showMode(-2);
								var which = this.o.todayBtn == 'linked' ? null : 'view';
								this._setDate(date, which);
								break;
							case 'clear':
								var element;
								if (this.isInput)
									element = this.element;
								else if (this.component)
									element = this.element.find('input');
								if (element)
									element.val("").change();
								this._trigger('changeDate');
								this.update();
								if (this.o.autoclose)
									this.hide();
								break;
						}
						break;
					case 'span':
						if (!target.is('.disabled')) {
							this.viewDate.setUTCDate(1);
							if (target.is('.month')) {
								var day = 1;
								var month = target.parent().find('span').index(target);
								var year = this.viewDate.getUTCFullYear();
								this.viewDate.setUTCMonth(month);
								this._trigger('changeMonth', this.viewDate);
								if (this.o.minViewMode === 1) {
									this._setDate(UTCDate(year, month, day,0,0,0,0));
								}
							} else {
								var year = parseInt(target.text(), 10)||0;
								var day = 1;
								var month = 0;
								this.viewDate.setUTCFullYear(year);
								this._trigger('changeYear', this.viewDate);
								if (this.o.minViewMode === 2) {
									this._setDate(UTCDate(year, month, day,0,0,0,0));
								}
							}
							this.showMode(-1);
							this.fill();
						}
						break;
					case 'td':
						if (target.is('.day') && !target.is('.disabled')){
							var day = parseInt(target.text(), 10)||1;
							var year = this.viewDate.getUTCFullYear(),
								month = this.viewDate.getUTCMonth();
							if (target.is('.old')) {
								if (month === 0) {
									month = 11;
									year -= 1;
								} else {
									month -= 1;
								}
							} else if (target.is('.new')) {
								if (month == 11) {
									month = 0;
									year += 1;
								} else {
									month += 1;
								}
							}
							this._setDate(UTCDate(year, month, day,0,0,0,0));
						}
						break;
				}
			}
		},

		_setDate: function(date, which){
			if (!which || which == 'date')
				this.date = new Date(date);
			if (!which || which  == 'view')
				this.viewDate = new Date(date);
			this.fill();
			this.setValue();
			this._trigger('changeDate');
			var element;
			if (this.isInput) {
				element = this.element;
			} else if (this.component){
				element = this.element.find('input');
			}
			if (element) {
				element.change();
			}
			if (this.o.autoclose && (!which || which == 'date')) {
				this.hide();
			}
		},

		moveMonth: function(date, dir){
			if (!dir) return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag == 1){
				test = dir == -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){ return new_date.getUTCMonth() == month; }
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){ return new_date.getUTCMonth() != new_month; };
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				if (new_month < 0 || new_month > 11)
					new_month = (new_month + 12) % 12;
			} else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i<mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){ return new_month != new_date.getUTCMonth(); };
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		dateWithinRange: function(date){
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function(e){
			if (this.picker.is(':not(:visible)')){
				if (e.keyCode == 27) // allow escape to hide and re-show picker
					this.show();
				return;
			}
			var dateChanged = false,
				dir, day, month,
				newDate, newViewDate;
			switch(e.keyCode){
				case 27: // escape
					this.hide();
					e.preventDefault();
					break;
				case 37: // left
				case 39: // right
					if (!this.o.keyboardNavigation) break;
					dir = e.keyCode == 37 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
						this._trigger('changeYear', this.viewDate);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
						this._trigger('changeMonth', this.viewDate);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 38: // up
				case 40: // down
					if (!this.o.keyboardNavigation) break;
					dir = e.keyCode == 38 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.date, dir);
						newViewDate = this.moveYear(this.viewDate, dir);
						this._trigger('changeYear', this.viewDate);
					} else if (e.shiftKey){
						newDate = this.moveMonth(this.date, dir);
						newViewDate = this.moveMonth(this.viewDate, dir);
						this._trigger('changeMonth', this.viewDate);
					} else {
						newDate = new Date(this.date);
						newDate.setUTCDate(this.date.getUTCDate() + dir * 7);
						newViewDate = new Date(this.viewDate);
						newViewDate.setUTCDate(this.viewDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newDate)){
						this.date = newDate;
						this.viewDate = newViewDate;
						this.setValue();
						this.update();
						e.preventDefault();
						dateChanged = true;
					}
					break;
				case 13: // enter
					this.hide();
					e.preventDefault();
					break;
				case 9: // tab
					this.hide();
					break;
			}
			if (dateChanged){
				this._trigger('changeDate');
				var element;
				if (this.isInput) {
					element = this.element;
				} else if (this.component){
					element = this.element.find('input');
				}
				if (element) {
					element.change();
				}
			}
		},

		showMode: function(dir) {
			if (dir) {
				this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
			}
			/*
				vitalets: fixing bug of very special conditions:
				jquery 1.7.1 + webkit + show inline datepicker in bootstrap popover.
				Method show() does not set display css correctly and datepicker is not shown.
				Changed to .css('display', 'block') solve the problem.
				See https://github.com/vitalets/x-editable/issues/37

				In jquery 1.7.2+ everything works fine.
			*/
			//this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).show();
			this.picker.find('>div').hide().filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName).css('display', 'block');
			this.updateNavArrows();
		}
	};

	var DateRangePicker = function(element, options){
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){ return i.jquery ? i[0] : i; });
		delete options.inputs;

		$(this.inputs)
			.datepicker(options)
			.bind('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){ return $(i).data('datepicker'); });
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){ return i.date; });
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){ return d.valueOf(); });
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		dateUpdated: function(e){
			var dp = $(e.target).data('datepicker'),
				new_date = dp.getUTCDate(),
				i = $.inArray(e.target, this.inputs),
				l = this.inputs.length;
			if (i == -1) return;

			if (new_date < this.dates[i]){
				// Date being moved earlier/left
				while (i>=0 && new_date < this.dates[i]){
					this.pickers[i--].setUTCDate(new_date);
				}
			}
			else if (new_date > this.dates[i]){
				// Date being moved later/right
				while (i<l && new_date > this.dates[i]){
					this.pickers[i++].setUTCDate(new_date);
				}
			}
			this.updateDates();
		},
		remove: function(){
			$.map(this.pickers, function(p){ p.remove(); });
			delete this.element.data().datepicker;
		}
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])'),
			prefix = new RegExp('^' + prefix.toLowerCase());
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, function(_,a){ return a.toLowerCase(); });
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]) {
			lang = lang.split('-')[0]
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	$.fn.datepicker = function ( option ) {
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return,
			this_return;
		this.each(function () {
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option == 'object' && option;
			if (!data) {
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.is('.input-daterange') || opts.inputs){
					var ropts = {
						inputs: opts.inputs || $this.find('input').toArray()
					};
					$this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
				}
				else{
					$this.data('datepicker', (data = new Datepicker(this, opts)));
				}
			}
			if (typeof option == 'string' && typeof data[option] == 'function') {
				internal_return = data[option].apply(data, args);
				if (internal_return !== undefined)
					return false;
			}
		});
		if (internal_return !== undefined)
			return internal_return;
		else
			return this;
	};

	var defaults = $.fn.datepicker.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		daysOfWeekDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear"
		}
	};

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function (year) {
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
		},
		getDaysInMonth: function (year, month) {
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language) {
			if (date instanceof Date) return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)) {
				var part_re = /([\-+]\d+)([dmwy])/,
					parts = date.match(/([\-+]\d+)([dmwy])/g),
					part, dir;
				date = new Date();
				for (var i=0; i<parts.length; i++) {
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch(part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			var parts = date && date.match(this.nonpunctuation) || [],
				date = new Date(),
				parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){ return d.setUTCFullYear(v); },
					yy: function(d,v){ return d.setUTCFullYear(2000+v); },
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v<0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() != v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){ return d.setUTCDate(v); }
				},
				val, filtered, part;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length != fparts.length) {
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			if (parts.length == fparts.length) {
				for (var i=0, cnt = fparts.length; i < cnt; i++) {
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)) {
						switch(part) {
							case 'MM':
								filtered = $(dates[language].months).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(function(){
									var m = this.slice(0, parts[i].length),
										p = parts[i].slice(0, m.length);
									return m == p;
								});
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				for (var i=0, _date, s; i<setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			var date = [],
				seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++) {
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev">&laquo;</th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next">&raquo;</th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};


	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker')) return;
			e.preventDefault();
			// component click requires us to explicitly show it
			$this.datepicker('show');
		}
	);
	// $(function(){
	// 	$('[data-provide="datepicker-inline"]').datepicker();
	// });

}( window.jQuery ));

;
if (typeof $.fn.bdatepicker == 'undefined')
	$.fn.bdatepicker = $.fn.datepicker.noConflict();



;(function($){
        $.fn.bdatepicker.defaults.format = "mm/dd/yyyy";
	$.fn.bdatepicker.dates['it'] = {
		days: ["Domenica", "Lunedì", "Martedì", "Mercoledì", "Giovedì", "Venerdì", "Sabato", "Domenica"],
		daysShort: ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"],
		daysMin: ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa", "Do"],
		months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
		monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
		today: "Oggi",
		weekStart: 1,
		format: "dd/mm/yyyy"
	};
}(jQuery));

$(function()
{
    	/* DatePicker */
	// default
	$(".datepicker1").bdatepicker({
            
                language: 'it',
		//format: 'dd MM yyyy',
		startDate: '-0d',
        todayBtn: true 
	});

	// component
	$('.datepicker2').bdatepicker({
            language: 'it',
		format: "dd MM yyyy",
		startDate: "2013-02-14"
	});

	// advanced
	$('.datetimepicker4').bdatepicker({
		format: "dd MM yyyy - hh:ii",
        autoclose: true,
        todayBtn: true,
        startDate: "2013-02-14 10:00",
        minuteStep: 10
	});
	
	// meridian
	$('.datetimepicker5').bdatepicker({
		format: "dd MM yyyy - HH:ii P",
	    showMeridian: true,
	    autoclose: true,
	    startDate: "2013-02-14 10:00",
	    todayBtn: true
	});

	// other
	if ($('.datepicker').length) $(".datepicker").bdatepicker({ showOtherMonths:true });
	if ($('.datepicker-inline').length) $('#datepicker-inline').bdatepicker({ inline: true, showOtherMonths:true });

})
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
WidgetListArticles = null;
$(function () {
    widgetListArticles = new WidgetListArticles();
});

/**
 * Classe per la gestione del widget
 */
var WidgetListArticles = function () {
    this.initListeners();
};

/**
 * Metodo che avvia gli ascoltatori
 */
WidgetListArticles.prototype.initListeners = function () {
    var that = this;
  var options = {language: 'en',
            format: "dd MM yyyy",
            todayBtn: true,
            autoclose: true,
            clearBtn: true
        };
        
    $( '.datepicker3' ).bdatepicker(
        options        
    ).on( 'changeDate', function(ev) { 
        var date = new Date(ev.date);
        
        var dateMatch = date.getFullYear() +'-'+ ( date.getMonth() +1 )  + '-' + date.getDate();
        
        var that = this;
            setTimeout( function() {
                $( that ).find('input').focus();
                $( that ).find('input').val(dateMatch);
                $( '.datepicker3' ).bdatepicker('hide');
                $( that ).find('input').blur();
            }, 250 
        );
    });
    
    $( 'body' ).on( 'click', '.btnReset', function() {
        that.resetFilterArticles( this );
    });
    //sul click del bottone con l'attributo republish si scatena la funzione che fa partire la chiamata ajax
    $('body').on('click', '[data-republish]', function() {
        that.confirmRepublishArticle(this);
    });
};

WidgetListArticles.prototype.resetFilterArticles = function ( sender ) {
    event.stopPropagation();
    $('input').val('');
    $('select').val('');
};

WidgetListArticles.prototype.confirmRepublishArticle = function ( sender ) {        
    if( widgetLogin.isLogged() != 1 ) {          
        var callback = { 'call': this.confirmRepublishArticle.bind( this ), 'params': { '0': sender } };        
        bootbox.hideAll();
        widgetLogin.getLoginBox( callback );
        return false;
    }
    
    mainAdmin.speakSite( 'Vuoi aggiornare la data di questo articolo?' );
    
    var callback = { 'call': this.republishArticle.bind( this ), 'params': { 0 : sender} };    
    var params = { 
        type: 'confirm', 
        confirm: 'Vuoi aggiornare la data di questo articolo?',
        finalCallback: callback        
    };
    classModals.openModals( params );
};


WidgetListArticles.prototype.republishArticle = function ( sender ) {
    var that = this;
    var id = $(sender).attr('data-republish');

    var request = $.ajax ({
        url: "/admin/updateArticleDate/"+id,
        type: "POST",
        async: true,
        dataType: "json"        
     });
     request.done( function( resp ) {
        that.readResponseAjax( resp );
    });
};

WidgetListArticles.prototype.readResponseAjax = function ( response ) {
        mainAdmin.speakSite( response.msg );

    var parameters = new Array();   
        parameters['type'] = response.error == 0 ? 'success' : 'error';
        parameters['layout'] = 'top';
        parameters['mex'] =  response.msg;
        classNotyfy.openNotyfy( parameters );
};    
    

;
